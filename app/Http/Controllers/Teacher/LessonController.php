<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Services\Academic\ClassSchedule;

class LessonController extends Controller
{
    public function __construct(private ClassSchedule $schedule)
    {
    }

    public function index()
    {
        $teacher = auth('teacher')->user();
        $lessons = $teacher->lessons()
            ->with(['subject:id,name', 'level:id,name', 'classroom:id,name', 'branch:id,name'])
            ->withCount(['students', 'sessions'])
            ->orderByDesc('is_active')->orderBy('weekday')->orderBy('start_time')
            ->get();

        $nextByLesson = $lessons->mapWithKeys(fn ($l) => [$l->id => $this->schedule->next(collect([$l]))]);

        return view('teacher.lessons.index', compact('lessons', 'nextByLesson'));
    }

    public function show(Lesson $lesson)
    {
        $this->authorizeLesson($lesson);

        $lesson->load(['subject', 'level', 'classroom', 'branch',
            'students' => fn ($q) => $q->with('level:id,name')->orderBy('first_name')]);
        $lesson->loadCount('students');

        $now      = $this->schedule->now();
        $next     = $this->schedule->next(collect([$lesson]));
        $sessions = $lesson->sessions()->withCount('records')->paginate(10);

        // the most recent class that has started (today or earlier) – quick "submit report" button
        $last = $this->schedule->between(collect([$lesson]), $now->subDays(21), $now)
            ->filter(fn ($o) => $o->start->lte($now))->last();

        // resources for this lesson's level + subject that the teacher is allowed to see
        $resources = ($lesson->level_id && $lesson->subject_id)
            ? \App\Models\LearningResource::visibleTo(auth('teacher')->user())
                ->whereHas('levels', fn ($q) => $q->whereKey($lesson->level_id))
                ->whereHas('subjects', fn ($q) => $q->whereKey($lesson->subject_id))
                ->latest()->take(6)->get()
            : collect();

        return view('teacher.lessons.show', compact('lesson', 'next', 'sessions', 'last', 'now', 'resources'));
    }

    private function authorizeLesson(Lesson $lesson): void
    {
        abort_unless($lesson->teacher_id === auth('teacher')->id(), 404);
    }
}
