<?php

namespace App\Services\Academic;

use App\Models\Lesson;
use App\Models\LessonSession;
use Carbon\CarbonImmutable;

/** One concrete class: a lesson on a specific date (start/end in the academic timezone). */
class ClassOccurrence
{
    public ?LessonSession $session = null;

    public function __construct(
        public readonly Lesson $lesson,
        public readonly CarbonImmutable $start,
        public readonly CarbonImmutable $end,
    ) {
    }

    public function date(): string
    {
        return $this->start->toDateString();
    }

    public function key(): string
    {
        return $this->lesson->id . '|' . $this->date();
    }

    public function state(CarbonImmutable $now): string
    {
        return match (true) {
            $now->lt($this->start) => 'upcoming',
            $now->lt($this->end)   => 'live',
            default                => 'finished',
        };
    }

    public function reported(): bool
    {
        return $this->session !== null;
    }
}
