<?php

namespace App\Services\Academic;

use App\Models\Lesson;
use App\Models\LessonSession;
use App\Models\Teacher;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

/**
 * Turns weekly lessons (weekday + start time + date range) into real dated classes,
 * and answers: what is live now, what's today, what's next, which reports are missing.
 */
class ClassSchedule
{
    public function timezone(): string
    {
        return config('academic.timezone', config('app.timezone'));
    }

    public function now(): CarbonImmutable
    {
        return CarbonImmutable::now($this->timezone());
    }

    /** Active lessons of a teacher (with what the panel needs) */
    public function lessonsFor(Teacher $teacher): Collection
    {
        return $teacher->lessons()
            ->where('is_active', true)
            ->with(['subject:id,name', 'level:id,name', 'classroom:id,name', 'branch:id,name'])
            ->withCount('students')
            ->orderBy('weekday')->orderBy('start_time')
            ->get();
    }

    /** All classes of the given lessons between two dates (inclusive), sorted by start time. */
    public function between(Collection $lessons, CarbonImmutable $from, CarbonImmutable $to): Collection
    {
        $out = collect();
        $tz  = $this->timezone();

        for ($day = $from->startOfDay(); $day->lte($to); $day = $day->addDay()) {
            $date = $day->toDateString();
            foreach ($lessons as $lesson) {
                if (Lesson::toCarbonDay($lesson->weekday) !== $day->dayOfWeek || ! $this->runsOn($lesson, $date)) {
                    continue;
                }
                $out->push(new ClassOccurrence(
                    $lesson,
                    CarbonImmutable::parse("{$date} {$lesson->start_time}", $tz),
                    CarbonImmutable::parse("{$date} {$lesson->end_time}", $tz),
                ));
            }
        }

        return $out->sortBy(fn (ClassOccurrence $o) => $o->start->timestamp)->values();
    }

    /** Is there a class of this lesson on this date? (weekday + date range + active) */
    public function runsOn(Lesson $lesson, string $date): bool
    {
        $d = CarbonImmutable::parse($date, $this->timezone());

        return $lesson->is_active
            && Lesson::toCarbonDay($lesson->weekday) === $d->dayOfWeek
            && $date >= $lesson->start_date->toDateString()
            && (! $lesson->end_date || $date <= $lesson->end_date->toDateString());
    }

    public function occurrence(Lesson $lesson, string $date): ?ClassOccurrence
    {
        if (! $this->runsOn($lesson, $date)) {
            return null;
        }

        return new ClassOccurrence(
            $lesson,
            CarbonImmutable::parse("{$date} {$lesson->start_time}", $this->timezone()),
            CarbonImmutable::parse("{$date} {$lesson->end_time}", $this->timezone()),
        );
    }

    /** Attach already-submitted reports to the occurrences */
    public function withReports(Collection $occurrences): Collection
    {
        if ($occurrences->isEmpty()) {
            return $occurrences;
        }

        $sessions = LessonSession::query()
            ->whereIn('lesson_id', $occurrences->map(fn ($o) => $o->lesson->id)->unique())
            ->whereBetween('session_date', [$occurrences->first()->date(), $occurrences->last()->date()])
            ->withCount('records')
            ->get()
            ->keyBy(fn ($s) => $s->lesson_id . '|' . $s->session_date->toDateString());

        return $occurrences->each(fn (ClassOccurrence $o) => $o->session = $sessions->get($o->key()));
    }

    /** Next class that hasn't started yet (looks up to 6 weeks ahead) */
    public function next(Collection $lessons): ?ClassOccurrence
    {
        $now = $this->now();

        return $this->between($lessons, $now, $now->addWeeks(6))
            ->first(fn (ClassOccurrence $o) => $o->start->gt($now));
    }

    public function live(Collection $lessons): Collection
    {
        $now = $this->now();

        return $this->between($lessons, $now, $now)->filter(fn ($o) => $o->state($now) === 'live')->values();
    }

    /** Finished classes in the last N days that have no report yet */
    public function pendingReports(Collection $lessons, ?int $days = null): Collection
    {
        $now  = $this->now();
        $days = $days ?? config('academic.pending_report_days', 14);

        return $this->withReports($this->between($lessons, $now->subDays($days), $now))
            ->filter(fn (ClassOccurrence $o) => $o->state($now) === 'finished' && ! $o->reported())
            ->sortByDesc(fn ($o) => $o->start->timestamp)
            ->values();
    }
}
