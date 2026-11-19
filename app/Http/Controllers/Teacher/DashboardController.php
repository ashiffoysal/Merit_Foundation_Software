<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\LessonSession;
use App\Services\Academic\ClassSchedule;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke(ClassSchedule $schedule)
    {
        $teacher = auth('teacher')->user();
        $lessons = $schedule->lessonsFor($teacher);
        $now     = $schedule->now();

        $today    = $schedule->withReports($schedule->between($lessons, $now, $now));
        $live     = $today->filter(fn ($o) => $o->state($now) === 'live')->values();
        $next     = $schedule->next($lessons);
        $upcoming = $schedule->between($lessons, $now->addDay(), $now->addDays(7));
        $pending  = $schedule->pendingReports($lessons);
        $week     = $schedule->between($lessons, $now->startOfWeek(\Carbon\CarbonInterface::SATURDAY), $now->startOfWeek(\Carbon\CarbonInterface::SATURDAY)->addDays(6));

        $studentCount = DB::table('lesson_students')->whereIn('lesson_id', $lessons->pluck('id'))->distinct()->count('student_id');

        $recent = LessonSession::with('lesson:id,name')->withCount('records')
            ->where('teacher_id', $teacher->id)
            ->latest('session_date')->take(5)->get();

        $resourceCount = \App\Models\LearningResource::visibleTo($teacher)->count();
        $newResources  = \App\Models\LearningResource::visibleTo($teacher)->where('created_at', '>=', now()->subDays(14))->latest()->take(3)->get();

        return view('teacher.dashboard', compact('resourceCount', 'newResources', 'teacher', 'lessons', 'now', 'today', 'live', 'next', 'upcoming', 'pending', 'week', 'studentCount', 'recent'));
    }
}
