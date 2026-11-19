<?php

namespace App\Http\Controllers\Backend\Academic;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\Academic\Concerns\RespondsToAjax;
use App\Http\Requests\Academic\LessonRequest;
use App\Models\Branch;
use App\Models\Classroom;
use App\Models\Lesson;
use App\Models\Level;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Services\Academic\LessonScheduler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
    use RespondsToAjax;

    public function __construct(private LessonScheduler $scheduler)
    {
    }

    public function index(Request $request)
    {
        $lessons = $this->filtered($request)
            ->with(['teacher:id,first_name,last_name', 'subject:id,name', 'level:id,name', 'classroom:id,name', 'branch:id,name'])
            ->withCount('students')
            ->orderBy('weekday')->orderBy('start_time')
            ->paginate(20)->withQueryString();

        return $this->listing($request, 'backend.academic.lessons.index', 'backend.academic.lessons._table',
            ['lessons' => $lessons] + $this->filterLists());
    }

    /** Weekly timetable: Saturday → Friday columns */
    public function timetable(Request $request)
    {
        $request->merge(['active' => $request->input('active', 'yes')]);

        $lessons = $this->filtered($request)
            ->with(['teacher:id,first_name,last_name', 'subject:id,name', 'classroom:id,name', 'branch:id,name'])
            ->withCount('students')
            ->orderBy('start_time')
            ->get()
            ->groupBy('weekday');

        return $this->listing($request, 'backend.academic.lessons.timetable', 'backend.academic.lessons._timetable_grid',
            ['lessonsByDay' => $lessons] + $this->filterLists());
    }

    public function create(Request $request)
    {
        $lesson = new Lesson([
            'is_active' => true, 'is_one_to_one' => false, 'gender' => 'mixed', 'capacity' => 10,
            'duration_minutes' => 60, 'start_date' => now(), 'weekday' => $request->integer('weekday', 0),
            'teacher_id' => $request->teacher_id,
        ]);

        return view('backend.academic.lessons.form', ['lesson' => $lesson] + $this->formLists($lesson));
    }

    public function store(LessonRequest $request)
    {
        $lesson = DB::transaction(fn () => Lesson::create($this->payload($request)));

        return $this->done($request, 'Lesson created successfully.', route('admin.lessons.show', $lesson));
    }

    public function show(Lesson $lesson)
    {
        $lesson->load(['teacher', 'subject', 'level', 'classroom.branch', 'branch',
            'students' => fn ($q) => $q->with(['parents:id,first_name,last_name,phone', 'level:id,name'])->orderBy('first_name')]);
        $lesson->loadCount('students');
        $sessions = $lesson->sessions()->with('teacher:id,first_name,last_name')->withCount('records')
            ->withCount(['records as present_count' => fn ($q) => $q->whereIn('attendance', ['present', 'late'])])
            ->take(20)->get();

        return view('backend.academic.lessons.show', compact('lesson', 'sessions'));
    }

    public function edit(Lesson $lesson)
    {
        return view('backend.academic.lessons.form', ['lesson' => $lesson] + $this->formLists($lesson));
    }

    public function update(LessonRequest $request, Lesson $lesson)
    {
        DB::transaction(fn () => $lesson->update($this->payload($request)));

        return $this->done($request, 'Lesson updated successfully.', route('admin.lessons.show', $lesson));
    }

    public function destroy(Request $request, Lesson $lesson)
    {

        DB::transaction(function () use ($lesson) {
            $lesson->students()->detach();
            $lesson->delete();
        });

        return $this->done($request, 'Lesson deleted.', route('admin.lessons.index'));
    }

    /** AJAX live check used by the lesson form before saving */
    public function availability(Request $request)
    {
        $slot = $request->validate([
            'weekday'          => 'required|integer|between:0,6',
            'start_time'       => 'required|date_format:H:i',
            'duration_minutes' => 'required|integer|min:1|max:480',
            'start_date'       => 'required|date',
            'end_date'         => 'nullable|date',
            'teacher_id'       => 'nullable|integer',
            'classroom_id'     => 'nullable|integer',
            'ignore'           => 'nullable|integer',
        ]);

        $fmt = fn ($c) => $c->map(fn ($l) => ['id' => $l->id, 'name' => $l->name, 'when' => "{$l->weekday_name} {$l->time_range}"])->values();

        return response()->json([
            'end_time'  => substr(LessonScheduler::endTime(LessonScheduler::normaliseTime($slot['start_time']), $slot['duration_minutes']), 0, 5),
            'teacher'   => $fmt($this->scheduler->teacherConflicts($slot, $slot['ignore'] ?? null)),
            'classroom' => $fmt($this->scheduler->classroomConflicts($slot, $slot['ignore'] ?? null)),
        ]);
    }

    /** A class report submitted by the teacher */
    public function report(\App\Models\LessonSession $session)
    {
        $session->load(['lesson', 'teacher', 'level', 'subject', 'records.student']);

        return view('backend.academic.lessons.report', compact('session'));
    }

    // ───────────────────────── enrolment

    public function enroll(Request $request, Lesson $lesson)
    {
        $data = $request->validate(['student_id' => 'required|integer|exists:students,id,deleted_at,NULL']);

        return DB::transaction(function () use ($request, $lesson, $data) {
            // lock the lesson row so two admins can't fill the last seat at the same time
            $lesson = Lesson::whereKey($lesson->id)->lockForUpdate()->first();
            $student = Student::findOrFail($data['student_id']);

            if ($lesson->students()->whereKey($student->id)->exists()) {
                return $this->fail($request, "{$student->full_name} is already enrolled in this lesson.");
            }
            if (! $student->is_active) {
                return $this->fail($request, "{$student->full_name} is not active.");
            }
            if ($lesson->students()->count() >= $lesson->capacity) {
                return $this->fail($request, $lesson->is_one_to_one
                    ? 'This is a one-to-one lesson and already has a student.'
                    : "Lesson is full ({$lesson->capacity} seats).");
            }
            if ($lesson->gender === 'boys' && $student->gender === 'female' || $lesson->gender === 'girls' && $student->gender === 'male') {
                return $this->fail($request, 'This lesson is for ' . strtolower(Lesson::GENDERS[$lesson->gender]) . ' only.');
            }
            // student can't be in two lessons at the same time
            $clash = $this->scheduler->overlapping([
                'weekday' => $lesson->weekday, 'start_time' => $lesson->start_time, 'duration_minutes' => $lesson->duration_minutes,
                'start_date' => $lesson->start_date->toDateString(), 'end_date' => $lesson->end_date?->toDateString(),
            ], $lesson->id)->whereHas('students', fn ($q) => $q->whereKey($student->id))->get();
            if ($clash->isNotEmpty()) {
                return $this->fail($request, "{$student->full_name} already has a lesson at this time: " . LessonScheduler::describe($clash) . '.');
            }

            $lesson->students()->attach($student->id, ['enrolled_at' => now()->toDateString()]);
            $student->histories()->create([
                'event' => 'enrolled', 'description' => "Enrolled in {$lesson->name} ({$lesson->weekday_name} {$lesson->time_range})",
                'admin_id' => auth('admin')->id(),
            ]);

            return $this->done($request, "{$student->full_name} enrolled.", route('admin.lessons.show', $lesson));
        });
    }

    public function unenroll(Request $request, Lesson $lesson, Student $student)
    {

        $lesson->students()->detach($student->id);
        $student->histories()->create([
            'event' => 'unenrolled', 'description' => "Removed from {$lesson->name}", 'admin_id' => auth('admin')->id(),
        ]);

        return $this->done($request, "{$student->full_name} removed from the lesson.", route('admin.lessons.show', $lesson));
    }

    // ───────────────────────── helpers

    private function payload(LessonRequest $request): array
    {
        $data = $request->validated();
        $data['start_time'] = LessonScheduler::normaliseTime($data['start_time']);
        $data['end_time']   = LessonScheduler::endTime($data['start_time'], (int) $data['duration_minutes']);

        // a classroom implies its branch
        if (empty($data['branch_id']) && ! empty($data['classroom_id'])) {
            $data['branch_id'] = Classroom::whereKey($data['classroom_id'])->value('branch_id');
        }

        return $data;
    }

    private function filtered(Request $request)
    {
        return Lesson::query()
            ->when($request->search, fn ($q, $s) => $q->where('name', 'like', '%' . addcslashes($s, '%_') . '%'))
            ->when($request->teacher_id, fn ($q, $v) => $q->where('teacher_id', $v))
            ->when($request->branch_id, fn ($q, $v) => $q->where('branch_id', $v))
            ->when($request->subject_id, fn ($q, $v) => $q->where('subject_id', $v))
            ->when($request->level_id, fn ($q, $v) => $q->where('level_id', $v))
            ->when($request->classroom_id, fn ($q, $v) => $q->where('classroom_id', $v))
            ->when($request->filled('weekday'), fn ($q) => $q->where('weekday', $request->integer('weekday')))
            ->when($request->filled('type'), fn ($q) => $q->where('is_one_to_one', $request->type === 'one_to_one'))
            ->when($request->filled('active'), fn ($q) => $q->where('is_active', $request->active === 'yes'));
    }

    private function filterLists(): array
    {
        return [
            'teachers'   => Teacher::orderBy('first_name')->get(['id', 'first_name', 'last_name']),
            'branches'   => Branch::ordered()->get(['id', 'name']),
            'subjects'   => Subject::ordered()->get(['id', 'name']),
            'levels'     => Level::ordered()->get(['id', 'name']),
            'classrooms' => Classroom::with('branch:id,name')->ordered()->get(),
        ];
    }

    private function formLists(Lesson $lesson): array
    {
        return [
            'teachers'   => Teacher::where(fn ($q) => $q->where('is_active', true)->orWhere('id', $lesson->teacher_id))
                ->orderBy('first_name')->get(['id', 'first_name', 'last_name', 'hourly_rate', 'branch_id']),
            'branches'   => Branch::options($lesson->branch_id),
            'subjects'   => Subject::options($lesson->subject_id),
            'levels'     => Level::options($lesson->level_id),
            'classrooms' => Classroom::options($lesson->classroom_id)->load('branch:id,name'),
        ];
    }
}
