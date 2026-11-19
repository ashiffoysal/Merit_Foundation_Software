<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\ClassReportRequest;
use App\Models\Lesson;
use App\Models\LessonSession;
use App\Services\Academic\ClassSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/** Class notes + attendance + per-student progress, submitted by the teacher for one class (lesson + date). */
class ReportController extends Controller
{
    public function __construct(private ClassSchedule $schedule, private \App\Services\Academic\ReportEditPolicy $policy)
    {
    }

    public function index(Request $request)
    {
        $teacher  = auth('teacher')->user();
        $sessions = LessonSession::with(['lesson:id,name,weekday', 'subject:id,name', 'level:id,name'])
            ->withCount('records')
            ->withCount(['records as present_count' => fn ($q) => $q->whereIn('attendance', ['present', 'late'])])
            ->where('teacher_id', $teacher->id)
            ->when($request->lesson_id, fn ($q, $v) => $q->where('lesson_id', $v))
            ->when($request->completion_status, fn ($q, $v) => $q->where('completion_status', $v))
            ->when($request->date('from'), fn ($q, $v) => $q->whereDate('session_date', '>=', $v))
            ->when($request->date('to'), fn ($q, $v) => $q->whereDate('session_date', '<=', $v))
            ->latest('session_date')->paginate(15)->withQueryString();

        $lessons = $teacher->lessons()->orderBy('name')->get(['id', 'name']);
        $pending = $this->schedule->pendingReports($this->schedule->lessonsFor($teacher));

        $policy = $this->policy;

        return view('teacher.reports.index', compact('sessions', 'lessons', 'pending', 'policy'));
    }

    /** GET teacher/lessons/{lesson}/report/{date} — create or edit */
    public function edit(Lesson $lesson, string $date)
    {
        $occurrence = $this->occurrenceOrFail($lesson, $date);

        $session = LessonSession::with('records')->where('lesson_id', $lesson->id)->whereDate('session_date', $date)->first();
        if ($session && ! $this->policy->teacherCanEdit($session)) {
            return redirect()->route('teacher.reports.show', $session)->with('warning', $this->policy->explain($session));
        }
        $records = $session?->records->keyBy('student_id') ?? collect();

        // currently enrolled students + anyone already in the saved report (e.g. left since)
        $students = $lesson->students()->with('level:id,name')->orderBy('first_name')->get();
        if ($records->isNotEmpty()) {
            $extra = \App\Models\Student::withTrashed()->whereIn('id', $records->keys()->diff($students->pluck('id')))->get();
            $students = $students->concat($extra);
        }

        $lesson->loadMissing(['level:id,name', 'subject:id,name']);
        $editNote = $session ? $this->policy->explain($session) : null;

        return view('teacher.reports.form', compact('lesson', 'occurrence', 'session', 'records', 'students', 'editNote'));
    }

    public function update(ClassReportRequest $request, Lesson $lesson, string $date)
    {
        $occurrence = $this->occurrenceOrFail($lesson, $date);
        $data       = $request->validated();

        $existing = LessonSession::where('lesson_id', $lesson->id)->whereDate('session_date', $date)->first();
        if ($existing && ! $this->policy->teacherCanEdit($existing)) {
            return response()->json(['message' => $this->policy->explain($existing)], 403);
        }

        $allowed = $lesson->students()->pluck('students.id')
            ->merge(LessonSession::where('lesson_id', $lesson->id)->whereDate('session_date', $date)->first()?->records()->pluck('student_id') ?? [])
            ->map(fn ($id) => (int) $id)->unique();
        $sent = collect(array_keys($data['students'] ?? []))->map(fn ($id) => (int) $id);
        if ($sent->diff($allowed)->isNotEmpty()) {
            return response()->json(['message' => 'The report contains a student who is not in this class.'], 422);
        }

        $session = DB::transaction(function () use ($lesson, $date, $data, $occurrence) {
            $session = LessonSession::where('lesson_id', $lesson->id)->whereDate('session_date', $date)->lockForUpdate()->first()
                ?? new LessonSession(['lesson_id' => $lesson->id, 'session_date' => $date]);
            $session->fill([
                'teacher_id' => auth('teacher')->id(),
                'starts_at'  => $occurrence->start->format('H:i:s'),
                'ends_at'    => $occurrence->end->format('H:i:s'),
                'level_id'          => $lesson->level_id,     // snapshot for filtering
                'subject_id'        => $lesson->subject_id,
                'status'            => $data['status'],
                'completion_status' => $data['completion_status'],
                'topic'             => $data['topic'] ?? null,
                'topics_covered'    => $data['topics_covered'] ?? null,
                'notes'             => $data['notes'] ?? null,
                'homework'          => $data['homework'] ?? null,
            ]);
            $session->submitted_at ??= now();
            $session->save();

            if ($data['status'] === 'cancelled') {
                $session->records()->delete();

                return $session;
            }

            foreach ($data['students'] ?? [] as $studentId => $row) {
                $away = in_array($row['attendance'], ['absent', 'excused'], true);
                $session->records()->updateOrCreate(['student_id' => $studentId], [
                    'attendance'    => $row['attendance'],
                    'progress'      => $away ? null : ($row['progress'] ?? null),
                    'understanding' => $away ? null : ($row['understanding'] ?? null),
                    'score'         => $away ? null : ($row['score'] ?? null),
                    'homework_done' => array_key_exists('homework_done', $row) ? (bool) $row['homework_done'] : null,
                    'challenges'    => $row['challenges'] ?? null,
                    'comment'       => $row['comment'] ?? null,
                ]);
            }

            return $session;
        });

        $msg = $session->wasRecentlyCreated ? 'Class report submitted.' : 'Class report updated.';

        return $request->expectsJson()
            ? response()->json(['message' => $msg, 'redirect' => route('teacher.reports.show', $session)])
            : redirect()->route('teacher.reports.show', $session)->with('success', $msg);
    }

    public function show(LessonSession $session)
    {
        abort_unless($session->lesson && $session->lesson->teacher_id === auth('teacher')->id(), 404);
        $session->load(['lesson', 'level', 'subject', 'records.student']);
        $canEdit  = $this->policy->teacherCanEdit($session);
        $editNote = $this->policy->explain($session);

        return view('teacher.reports.show', compact('session', 'canEdit', 'editNote'));
    }

    /** The date must be a real class of this lesson, taught by this teacher, and not in the future. */
    private function occurrenceOrFail(Lesson $lesson, string $date)
    {
        abort_unless($lesson->teacher_id === auth('teacher')->id(), 404);
        abort_unless(preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) && strtotime($date), 404);

        $occurrence = $this->schedule->occurrence($lesson, $date);
        abort_if(! $occurrence, 404, 'There is no class on this date.');
        abort_if($date > $this->schedule->now()->toDateString(), 403, 'You can only report a class on or after its date.');

        return $occurrence;
    }
}
