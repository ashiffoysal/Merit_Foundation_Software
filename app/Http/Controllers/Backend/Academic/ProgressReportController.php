<?php

namespace App\Http\Controllers\Backend\Academic;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\Academic\Concerns\RespondsToAjax;
use App\Models\LessonSession;
use App\Models\LessonSessionStudent;
use App\Models\Level;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/** Admin: every lesson progress report (one row per student per class), with filters and monitoring. */
class ProgressReportController extends Controller
{
    use RespondsToAjax;

    /** "needs support" rules, looked at over the selected period (default: last 30 days) */
    public const SUPPORT_RULES = [
        'weak_reports' => 2,   // ≥ 2 reports with progress "needs improvement" or understanding "poor"
        'low_average'  => 5,   // average score below 5/10 (with ≥ 2 scores)
        'absences'     => 3,   // ≥ 3 absences
    ];

    public function index(Request $request)
    {
        $rows = $this->filtered($request)
            ->with(['student:id,first_name,last_name', 'session' => fn ($q) => $q->with(['lesson:id,name', 'teacher:id,first_name,last_name', 'level:id,name', 'subject:id,name'])])
            ->orderByDesc('lesson_sessions.session_date')->orderByDesc('lesson_session_students.id')
            ->paginate(25)->withQueryString();

        if ($request->ajax()) {
            return view('backend.academic.progress._table', compact('rows'));
        }

        // class-level completion stats (sessions, not student rows)
        $sessions = $this->filteredSessions($request)->selectRaw('completion_status, count(*) as n')->groupBy('completion_status')->pluck('n', 'completion_status');
        $totalSessions = $sessions->sum();

        // select() (not selectRaw) replaces the "lesson_session_students.*" column list – MySQL's ONLY_FULL_GROUP_BY
        // rejects mixing plain columns with aggregates
        $agg = $this->filtered($request)->select(\Illuminate\Support\Facades\DB::raw("
                count(*) as reports,
                avg(lesson_session_students.score) as avg_score,
                sum(case when lesson_session_students.attendance in ('present','late') then 1 else 0 end) as attended"))->toBase()->first();

        return view('backend.academic.progress.index', [
            'rows'          => $rows,
            'stats'         => [
                'sessions'   => $totalSessions,
                'completion' => $sessions,
                'reports'    => (int) $agg->reports,
                'avg_score'  => $agg->avg_score !== null ? round($agg->avg_score, 1) : null,
                'attendance' => $agg->reports ? (int) round($agg->attended / $agg->reports * 100) : null,
            ],
            'support'       => $this->needingSupport($request),
            'teachers'      => Teacher::withTrashed()->orderBy('first_name')->get(['id', 'first_name', 'last_name']),
            'levels'        => Level::ordered()->get(['id', 'name']),
            'subjects'      => Subject::ordered()->get(['id', 'name']),
            'studentOption' => $request->student_id ? Student::withTrashed()->find($request->student_id) : null,
        ]);
    }

    /** Admin decides whether the teacher may edit one report: allow | lock | default */
    public function editAccess(Request $request, LessonSession $session)
    {
        $data = $request->validate(['edit_override' => 'required|in:allow,lock,default']);
        $session->update(['edit_override' => $data['edit_override'] === 'default' ? null : $data['edit_override']]);

        $msg = ['allow' => 'Teacher can now edit this report.', 'lock' => 'Report locked.', 'default' => 'Report follows the normal edit rule.'][$data['edit_override']];

        return $this->done($request, $msg, route('admin.lessons.report', $session));
    }

    // ───────────────────────── helpers

    private function dateRange(Request $request): array
    {
        $from = $request->date('from');
        $to   = $request->date('to');

        return [$from?->toDateString(), $to?->toDateString()];
    }

    private function applySessionFilters($q, Request $request, string $t = 'lesson_sessions')
    {
        [$from, $to] = $this->dateRange($request);

        return $q
            ->when($request->teacher_id, fn ($q, $v) => $q->where("{$t}.teacher_id", $v))
            ->when($request->level_id, fn ($q, $v) => $q->where("{$t}.level_id", $v))
            ->when($request->subject_id, fn ($q, $v) => $q->where("{$t}.subject_id", $v))
            ->when($request->completion_status, fn ($q, $v) => $q->where("{$t}.completion_status", $v))
            ->when($from, fn ($q, $v) => $q->whereDate("{$t}.session_date", '>=', $v))
            ->when($to, fn ($q, $v) => $q->whereDate("{$t}.session_date", '<=', $v));
    }

    private function filtered(Request $request)
    {
        $q = LessonSessionStudent::query()
            ->join('lesson_sessions', 'lesson_sessions.id', '=', 'lesson_session_students.lesson_session_id')
            ->select('lesson_session_students.*');

        return $this->applySessionFilters($q, $request)
            ->when($request->student_id, fn ($q, $v) => $q->where('lesson_session_students.student_id', $v))
            ->when($request->progress, fn ($q, $v) => $q->where('lesson_session_students.progress', $v))
            ->when($request->attendance, fn ($q, $v) => $q->where('lesson_session_students.attendance', $v));
    }

    private function filteredSessions(Request $request)
    {
        return $this->applySessionFilters(LessonSession::query(), $request)
            ->when($request->student_id, fn ($q, $v) => $q->whereHas('records', fn ($r) => $r->where('student_id', $v)));
    }

    /** Students who may need extra support in the selected period */
    private function needingSupport(Request $request)
    {
        [$from, $to] = $this->dateRange($request);
        $from ??= Carbon::now()->subDays(30)->toDateString();

        $r = self::SUPPORT_RULES;
        $q = LessonSessionStudent::query()
            ->join('lesson_sessions', 'lesson_sessions.id', '=', 'lesson_session_students.lesson_session_id')
            ->selectRaw("lesson_session_students.student_id,
                count(*) as reports,
                sum(case when lesson_session_students.progress = 'needs_improvement' or lesson_session_students.understanding = 'poor' then 1 else 0 end) as weak,
                sum(case when lesson_session_students.attendance = 'absent' then 1 else 0 end) as absences,
                avg(lesson_session_students.score) as avg_score,
                count(lesson_session_students.score) as scored")
            ->groupBy('lesson_session_students.student_id');

        $this->applySessionFilters($q, new Request(array_merge($request->only(['teacher_id', 'level_id', 'subject_id']), ['from' => $from, 'to' => $to])));

        $flagged = $q->get()->map(function ($row) use ($r) {
            $reasons = [];
            if ($row->weak >= $r['weak_reports']) {
                $reasons[] = "{$row->weak} weak report(s)";
            }
            if ($row->scored >= 2 && $row->avg_score < $r['low_average']) {
                $reasons[] = 'avg score ' . round($row->avg_score, 1) . '/10';
            }
            if ($row->absences >= $r['absences']) {
                $reasons[] = "{$row->absences} absence(s)";
            }
            $row->reasons = $reasons;

            return $row;
        })->filter(fn ($row) => $row->reasons)->values();

        $students = Student::withTrashed()->whereIn('id', $flagged->pluck('student_id'))->get(['id', 'first_name', 'last_name'])->keyBy('id');

        return $flagged->map(fn ($row) => (object) ['student' => $students[$row->student_id] ?? null, 'reasons' => $row->reasons, 'reports' => $row->reports])
            ->filter(fn ($x) => $x->student)
            ->sortByDesc(fn ($x) => count($x->reasons))->values()
            ->each(fn ($x) => $x->since = $from);
    }
}
