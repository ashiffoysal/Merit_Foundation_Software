<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use SoftDeletes;

    /** Week starts on Saturday, as requested. Stored as 0..6 */
    public const WEEKDAYS = [0 => 'Saturday', 1 => 'Sunday', 2 => 'Monday', 3 => 'Tuesday', 4 => 'Wednesday', 5 => 'Thursday', 6 => 'Friday'];

    public const GENDERS = ['boys' => 'Boys', 'girls' => 'Girls', 'mixed' => 'Mixed'];

    protected $fillable = [
        'name', 'branch_id', 'subject_id', 'level_id', 'teacher_id', 'classroom_id',
        'weekday', 'start_time', 'duration_minutes', 'end_time', 'capacity', 'start_date', 'end_date',
        'gender', 'teacher_hourly_rate', 'hourly_rate', 'is_active', 'is_one_to_one',
    ];

    protected function casts(): array
    {
        return [
            'weekday'             => 'integer',
            'duration_minutes'    => 'integer',
            'capacity'            => 'integer',
            'start_date'          => 'date',
            'end_date'            => 'date',
            'teacher_hourly_rate' => 'decimal:2',
            'hourly_rate'         => 'decimal:2',
            'is_active'           => 'boolean',
            'is_one_to_one'       => 'boolean',
        ];
    }

    // ── relations
    public function branch()    { return $this->belongsTo(Branch::class); }
    public function subject()   { return $this->belongsTo(Subject::class); }
    public function level()     { return $this->belongsTo(Level::class); }
    public function teacher()   { return $this->belongsTo(Teacher::class)->withTrashed(); }
    public function classroom() { return $this->belongsTo(Classroom::class); }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'lesson_students')->withPivot('enrolled_at')->withTimestamps();
    }

    // ── computed
    public function getWeekdayNameAttribute(): string
    {
        return self::WEEKDAYS[$this->weekday] ?? '—';
    }

    public function getTimeRangeAttribute(): string
    {
        return substr($this->start_time, 0, 5) . ' – ' . substr($this->end_time, 0, 5);
    }

    /** Teacher pay for one session = hourly rate × hours */
    public function getTeacherPayPerSessionAttribute(): float
    {
        return round((float) $this->teacher_hourly_rate * $this->duration_minutes / 60, 2);
    }

    /** Student fee for one session */
    public function getFeePerSessionAttribute(): float
    {
        return round((float) $this->hourly_rate * $this->duration_minutes / 60, 2);
    }

    /** Number of sessions between start_date and end_date (null when the lesson is open-ended) */
    public function getSessionsCountAttribute(): ?int
    {
        return $this->end_date ? self::countSessions($this->start_date, $this->end_date, $this->weekday) : null;
    }

    public function getTeacherPayTotalAttribute(): ?float
    {
        $n = $this->sessions_count;
        return $n === null ? null : round($n * $this->teacher_pay_per_session, 2);
    }

    public function getSeatsLeftAttribute(): int
    {
        $enrolled = $this->students_count ?? $this->students()->count();
        return max($this->capacity - $enrolled, 0);
    }

    /** Our weekday index (Sat = 0) → Carbon's dayOfWeek (Sun = 0) */
    public static function toCarbonDay(int $weekday): int
    {
        return ($weekday + 6) % 7;
    }

    public static function countSessions($from, $to, int $weekday): int
    {
        $from = Carbon::parse($from)->startOfDay();
        $to   = Carbon::parse($to)->startOfDay();
        if ($to->lt($from)) {
            return 0;
        }
        $target = self::toCarbonDay($weekday);
        $first  = $from->copy();
        while ($first->dayOfWeek !== $target) {
            $first->addDay();
        }
        return $first->gt($to) ? 0 : intdiv($first->diffInDays($to), 7) + 1;
    }

    public function sessions()
    {
        return $this->hasMany(LessonSession::class)->orderByDesc('session_date');
    }
}
