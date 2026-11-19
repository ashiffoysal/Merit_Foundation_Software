<?php

namespace App\Http\Controllers\Backend\Academic;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\Academic\Concerns\RespondsToAjax;
use App\Http\Requests\Academic\StudentRequest;
use App\Models\Branch;
use App\Models\Guardian;
use App\Models\Level;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentStatus;
use App\Models\YearGroup;
use App\Services\Academic\HistoryRecorder;
use App\Services\Academic\SecureFileStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    use RespondsToAjax;

    /** request keys that are not plain student columns */
    private const FILE_FIELDS = ['photo', 'parent_ids', 'primary_parent_id', 'branch_ids'];

    public function __construct(private SecureFileStore $files, private HistoryRecorder $history)
    {
    }

    public function index(Request $request)
    {
        $students = Student::query()
            ->with(['parents:id,first_name,last_name,phone', 'branches:id,name', 'level:id,name', 'yearGroup:id,name', 'status'])
            ->withCount('lessons')
            ->when($request->search, fn ($q, $s) => $this->searchWords($q, $s, ['first_name', 'last_name'],
                fn ($q, $like) => $q->orWhereHas('parents', fn ($p) => $p->where('first_name', 'like', $like)
                    ->orWhere('last_name', 'like', $like)->orWhere('phone', 'like', $like)->orWhere('email', 'like', $like))))
            ->when($request->branch_id, fn ($q, $v) => $q->whereHas('branches', fn ($b) => $b->whereKey($v)))
            ->when($request->level_id, fn ($q, $v) => $q->where('level_id', $v))
            ->when($request->school_id, fn ($q, $v) => $q->where('school_id', $v))
            ->when($request->year_group_id, fn ($q, $v) => $q->where('year_group_id', $v))
            ->when($request->student_status_id, fn ($q, $v) => $q->where('student_status_id', $v))
            ->when($request->filled('active'), fn ($q) => $q->where('is_active', $request->active === 'yes'))
            ->when($request->boolean('fee_delayed'), fn ($q) => $q->where('is_fee_delayed', true))
            ->orderBy('first_name')->orderBy('last_name')
            ->paginate(15)->withQueryString();

        return $this->listing($request, 'backend.academic.students.index', 'backend.academic.students._table', [
            'students' => $students,
        ] + $this->lookups());
    }

    public function create(Request $request)
    {
        $student = new Student(['student_status_id' => StudentStatus::where('name', 'Onboarding')->value('id')]);
        $student->setRelation('parents', $request->parent_id ? Guardian::whereKey($request->parent_id)->get() : collect());
        $student->setRelation('branches', collect());

        return view('backend.academic.students.form', ['student' => $student] + $this->lookups($student));
    }

    public function store(StudentRequest $request)
    {
        $student = DB::transaction(function () use ($request) {
            $student = Student::create($request->safe()->except(self::FILE_FIELDS));
            $student->branches()->sync($request->input('branch_ids', []));
            $this->syncParents($student, $request);
            $this->savePhoto($request, $student);

            $this->history->student($student, 'registered', 'Student registered', $this->snapshot($student->refresh()));

            return $student;
        });

        return $this->done($request, 'Student created successfully.', route('admin.students.show', $student));
    }

    public function show(Student $student)
    {
        $student->load(['parents', 'branches', 'level', 'school', 'yearGroup', 'status', 'histories.admin:id,name',
            'lessons' => fn ($q) => $q->with(['teacher:id,first_name,last_name', 'subject:id,name', 'classroom:id,name'])->orderBy('weekday')->orderBy('start_time')]);

        $reports = $student->progressReports()
            ->with(['session' => fn ($q) => $q->with(['lesson:id,name', 'teacher:id,first_name,last_name'])])
            ->join('lesson_sessions', 'lesson_sessions.id', '=', 'lesson_session_students.lesson_session_id')
            ->orderByDesc('lesson_sessions.session_date')
            ->select('lesson_session_students.*')
            ->take(30)->get();

        return view('backend.academic.students.show', compact('student', 'reports'));
    }

    public function edit(Student $student)
    {
        $student->load(['parents', 'branches:id']);

        return view('backend.academic.students.form', ['student' => $student] + $this->lookups($student));
    }

    public function update(StudentRequest $request, Student $student)
    {
        DB::transaction(function () use ($request, $student) {
            $before = $this->snapshot($student);

            $data = $request->safe()->except(self::FILE_FIELDS);
            if ($request->boolean('remove_photo') && $student->photo_path) {
                $this->files->delete($student->photo_path);
                $data['photo_path'] = null;
            }
            $student->update($data);
            $student->branches()->sync($request->input('branch_ids', []));
            $this->syncParents($student, $request);
            $this->savePhoto($request, $student);

            $this->history->studentUpdated($student, $before, $this->snapshot($student->refresh()));
        });

        return $this->done($request, 'Student updated successfully.', route('admin.students.show', $student));
    }

    public function destroy(Request $request, Student $student)
    {

        DB::transaction(function () use ($student) {
            $this->history->student($student, 'deleted', 'Student record deleted');
            $student->lessons()->detach(); // free their seats
            $student->delete();
        });

        return $this->done($request, 'Student deleted.', route('admin.students.index'));
    }

    public function photo(Student $student)
    {
        abort_unless($student->photo_path, 404);

        return $this->files->respond($student->photo_path, null, true);
    }

    // ───────────────────────── helpers

    private function lookups(?Student $s = null): array
    {
        return [
            'branches'   => Branch::options($s?->branches->pluck('id')->all()),
            'levels'     => Level::options($s?->level_id),
            'schools'    => School::options($s?->school_id),
            'yearGroups' => YearGroup::options($s?->year_group_id),
            'statuses'   => StudentStatus::options($s?->student_status_id),
        ];
    }

    private function syncParents(Student $student, Request $request): void
    {
        $primary = $request->input('primary_parent_id') ?: ($request->input('parent_ids')[0] ?? null);
        $sync = [];
        foreach ($request->input('parent_ids', []) as $id) {
            $sync[$id] = ['is_primary' => (string) $id === (string) $primary];
        }
        $student->parents()->sync($sync);
    }

    private function savePhoto(Request $request, Student $student): void
    {
        if ($request->hasFile('photo')) {
            $old  = $student->photo_path;
            $meta = $this->files->store($request->file('photo'), "students/{$student->id}/photo");
            $student->forceFill(['photo_path' => $meta['path']])->save();
            $this->files->delete($old);
        }
    }

    /** Human readable values used for the registration history diff */
    private function snapshot(Student $s): array
    {
        $s->loadMissing(['level', 'school', 'yearGroup', 'status']);
        $s->load(['branches:id,name', 'parents:id,first_name,last_name']);

        return [
            'name'               => $s->full_name,
            'date_of_birth'      => $s->date_of_birth,
            'gender'             => $s->gender,
            'level'              => $s->level?->name,
            'school'             => $s->school?->name,
            'year_group'         => $s->yearGroup?->name,
            'branches'           => $s->branches->pluck('name')->sort()->implode(', ') ?: null,
            'parents'            => $s->parents->map->full_name->sort()->implode(', ') ?: null,
            'registration_fee'   => $s->registration_fee,
            'refundable_deposit' => $s->refundable_deposit,
            'hourly_fee'         => $s->hourly_fee,
            'assessment_date'    => $s->assessment_date,
            'assessment_time'    => $s->assessment_time_short,
            'status'             => $s->status?->name,
            'childcare'          => $s->childcare,
            'is_fee_delayed'     => $s->is_fee_delayed,
            'due_date_extended'  => $s->due_date_extended,
            'is_active'          => $s->is_active,
        ];
    }
}
