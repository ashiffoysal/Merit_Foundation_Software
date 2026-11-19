<?php

namespace App\Http\Controllers\Backend\Academic;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\Academic\Concerns\RespondsToAjax;
use App\Http\Requests\Academic\TeacherRequest;
use App\Models\Branch;
use App\Models\Level;
use App\Models\Subject;
use App\Models\Teacher;
use App\Services\Academic\HistoryRecorder;
use App\Services\Academic\SecureFileStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    use RespondsToAjax;

    public function __construct(private SecureFileStore $files, private HistoryRecorder $history)
    {
    }

    public function index(Request $request)
    {
        $teachers = Teacher::query()
            ->with(['branch:id,name', 'subjects:id,name'])
            ->withCount('lessons')
            ->when($request->search, fn ($q, $s) => $this->searchWords($q, $s, ['first_name', 'last_name', 'email', 'phone']))
            ->when($request->branch_id, fn ($q, $v) => $q->where('branch_id', $v))
            ->when($request->subject_id, fn ($q, $v) => $q->whereHas('subjects', fn ($q) => $q->whereKey($v)))
            ->when($request->status, fn ($q, $v) => match ($v) {
                'active'   => $q->where('is_active', true)->whereNull('resignation_date'),
                'inactive' => $q->where('is_active', false),
                'resigned' => $q->whereNotNull('resignation_date'),
                default    => $q,
            })
            ->when($request->filled('dbs'), fn ($q) => $q->where('has_dbs', $request->dbs === 'yes'))
            ->orderBy('first_name')->orderBy('last_name')
            ->paginate(15)->withQueryString();

        return $this->listing($request, 'backend.academic.teachers.index', 'backend.academic.teachers._table', [
            'teachers' => $teachers,
            'branches' => Branch::ordered()->get(['id', 'name']),
            'subjects' => Subject::ordered()->get(['id', 'name']),
        ]);
    }

    public function create()
    {
        return view('backend.academic.teachers.form', $this->formData(new Teacher(['is_active' => true, 'has_dbs' => false])));
    }

    public function store(TeacherRequest $request)
    {
        $data = $request->safe()->except(['photo', 'proof_of_address', 'proof_of_id', 'subject_ids', 'level_ids', 'password', 'password_confirmation']);

        $generated = null;
        $password  = $request->input('password');
        if (! $password) {
            $generated = $password = Str::password(12, symbols: false);
        }

        $teacher = DB::transaction(function () use ($request, $data, $password) {
            $teacher = Teacher::create($data + ['password' => $password, 'hourly_rate' => $data['hourly_rate'] ?? 0]);
            $teacher->subjects()->sync($request->input('subject_ids', []));
            $teacher->levels()->sync($request->input('level_ids', []));
            $this->saveUploads($request, $teacher);
            $this->history->teacherCreated($teacher->load('branch'));

            return $teacher;
        });

        return $this->done($request, 'Teacher added successfully.', route('admin.teachers.show', $teacher),
            $generated ? ['generated_password' => $generated] : []);
    }

    public function show(Teacher $teacher)
    {
        $teacher->load(['branch', 'subjects', 'levels', 'documents', 'histories.admin:id,name']);
        $lessons = $teacher->lessons()->with(['subject:id,name', 'classroom:id,name', 'branch:id,name'])
            ->withCount('students')->orderBy('weekday')->orderBy('start_time')->get();

        $weeklyMinutes = $lessons->where('is_active', true)->sum('duration_minutes');
        $weeklyPay     = $lessons->where('is_active', true)->sum(fn ($l) => $l->teacher_pay_per_session);

        return view('backend.academic.teachers.show', compact('teacher', 'lessons', 'weeklyMinutes', 'weeklyPay'));
    }

    public function edit(Teacher $teacher)
    {
        return view('backend.academic.teachers.form', $this->formData($teacher->load(['subjects:id', 'levels:id', 'documents'])));
    }

    public function update(TeacherRequest $request, Teacher $teacher)
    {
        $data = $request->safe()->except(['photo', 'proof_of_address', 'proof_of_id', 'subject_ids', 'level_ids', 'password', 'password_confirmation']);

        DB::transaction(function () use ($request, $teacher, $data) {
            $before       = $teacher->only(['job_title', 'hourly_rate', 'joining_date', 'resignation_date', 'is_active', 'has_dbs']);
            $branchBefore = $teacher->branch?->name;

            if ($request->filled('password')) {
                $data['password'] = $request->input('password'); // hashed by the model cast
            }
            if ($request->boolean('remove_photo') && $teacher->photo_path) {
                $this->files->delete($teacher->photo_path);
                $data['photo_path'] = null;
            }
            $data['hourly_rate'] = $data['hourly_rate'] ?? 0;

            $teacher->update($data);
            $teacher->subjects()->sync($request->input('subject_ids', []));
            $teacher->levels()->sync($request->input('level_ids', []));
            $this->saveUploads($request, $teacher);

            $this->history->teacherUpdated($teacher->refresh()->load('branch'), $before, $branchBefore);
        });

        return $this->done($request, 'Teacher updated successfully.', route('admin.teachers.show', $teacher));
    }

    public function destroy(Request $request, Teacher $teacher)
    {

        $count = $teacher->lessons()->count();
        if ($count > 0) {
            return $this->fail($request, "This teacher is assigned to {$count} lesson(s). Re-assign or delete those lessons first.");
        }

        $teacher->delete(); // soft delete – documents and history are kept

        return $this->done($request, 'Teacher deleted.', route('admin.teachers.index'));
    }

    public function photo(Teacher $teacher)
    {
        abort_unless($teacher->photo_path, 404);

        return $this->files->respond($teacher->photo_path, null, true);
    }

    // ───────────────────────── helpers

    private function formData(Teacher $teacher): array
    {
        return [
            'teacher'  => $teacher,
            'branches' => Branch::options($teacher->branch_id),
            'subjects' => Subject::options($teacher->subjects->pluck('id')->all()),
            'levels'   => Level::options($teacher->levels->pluck('id')->all()),
        ];
    }

    private function saveUploads(Request $request, Teacher $teacher): void
    {
        if ($request->hasFile('photo')) {
            $old  = $teacher->photo_path;
            $meta = $this->files->store($request->file('photo'), "teachers/{$teacher->id}/photo");
            $teacher->forceFill(['photo_path' => $meta['path']])->save();
            $this->files->delete($old);
        }

        foreach (['proof_of_address', 'proof_of_id'] as $type) {
            if ($request->hasFile($type)) {
                $meta = $this->files->store($request->file($type), "teachers/{$teacher->id}/documents");
                $teacher->documents()->create($meta + [
                    'type'        => $type,
                    'title'       => Teacher::DOCUMENT_TYPES[$type],
                    'uploaded_by' => auth('admin')->id(),
                ]);
            }
        }
    }
}
