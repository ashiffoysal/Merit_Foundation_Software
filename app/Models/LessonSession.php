<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonSession extends Model
{
    public const STATUSES = ['held' => 'Held', 'cancelled' => 'Cancelled'];

    public const COMPLETION = [
        'completed'           => 'Completed',
        'partially_completed' => 'Partially completed',
        'not_completed'       => 'Not completed',
    ];

    public const COMPLETION_COLORS = ['completed' => 'success', 'partially_completed' => 'warning', 'not_completed' => 'secondary'];

    protected $fillable = ['lesson_id', 'teacher_id', 'level_id', 'subject_id', 'session_date', 'starts_at', 'ends_at', 'status',
        'completion_status', 'topic', 'topics_covered', 'notes', 'homework', 'submitted_at', 'edit_override'];

    protected $casts = [
        'session_date' => 'date',
        'submitted_at' => 'datetime',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class)->withTrashed();
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class)->withTrashed();
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function records()
    {
        return $this->hasMany(LessonSessionStudent::class);
    }

    public function getTimeRangeAttribute(): string
    {
        return substr($this->starts_at, 0, 5) . ' – ' . substr($this->ends_at, 0, 5);
    }

    /** "8/10 present" style summary */
    public function getAttendanceSummaryAttribute(): string
    {
        $records = $this->relationLoaded('records') ? $this->records : $this->records()->get();
        $here = $records->whereIn('attendance', ['present', 'late'])->count();

        return "{$here}/{$records->count()}";
    }
}
