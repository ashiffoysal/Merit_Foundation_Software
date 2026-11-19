<?php

namespace App\Services\Academic;

use App\Models\Lesson;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class LessonScheduler
{
    public static function normaliseTime(string $time): string
    {
        return Carbon::createFromFormat(strlen($time) > 5 ? 'H:i:s' : 'H:i', $time)->format('H:i:s');
    }

    public static function endTime(string $start, int $minutes): string
    {
        $end = Carbon::createFromFormat('H:i:s', self::normaliseTime($start))->addMinutes($minutes);

        // lessons must finish on the same day
        return $end->isSameDay(Carbon::createFromFormat('H:i:s', self::normaliseTime($start)))
            ? $end->format('H:i:s')
            : '23:59:59';
    }

    /**
     * Active lessons on the same weekday whose time AND date range overlap the given slot.
     * Overlap rule: startA < endB AND endA > startB.
     */
    public function overlapping(array $slot, ?int $ignoreId = null): \Illuminate\Database\Eloquent\Builder
    {
        $start = self::normaliseTime($slot['start_time']);
        $end   = self::endTime($start, (int) $slot['duration_minutes']);
        $from  = $slot['start_date'];
        $to    = $slot['end_date'] ?? null;

        return Lesson::query()
            ->where('is_active', true)
            ->where('weekday', (int) $slot['weekday'])
            ->where('start_time', '<', $end)
            ->where('end_time', '>', $start)
            // date ranges overlap (null end_date = open-ended)
            ->where(fn ($q) => $q->whereNull('end_date')->orWhereDate('end_date', '>=', $from))
            ->when($to, fn ($q) => $q->whereDate('start_date', '<=', $to))
            ->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId));
    }

    public function teacherConflicts(array $slot, ?int $ignoreId = null): Collection
    {
        if (empty($slot['teacher_id'])) {
            return collect();
        }
        return $this->overlapping($slot, $ignoreId)->where('teacher_id', $slot['teacher_id'])->get();
    }

    public function classroomConflicts(array $slot, ?int $ignoreId = null): Collection
    {
        if (empty($slot['classroom_id'])) {
            return collect();
        }
        return $this->overlapping($slot, $ignoreId)->where('classroom_id', $slot['classroom_id'])->get();
    }

    public static function describe(Collection $lessons): string
    {
        return $lessons->map(fn (Lesson $l) => "“{$l->name}” ({$l->weekday_name} {$l->time_range})")->implode(', ');
    }
}
