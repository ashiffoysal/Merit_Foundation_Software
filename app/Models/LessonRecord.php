<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonRecord extends Model
{
    public const STATUSES = [
        'completed'      => 'Completed',
        'in_progress'    => 'In Progress',
        'needs_revision' => 'Needs Revision',
        'absent'         => 'Absent',
    ];

    protected $fillable = [
        'student_id', 'teacher_id', 'lesson_id', 'lesson_topic_id',
        'lesson_date', 'status', 'score', 'teacher_comment', 'homework',
    ];

    protected $casts = [
        'lesson_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class)->withTrashed();
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class)->withTrashed();
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class)->withTrashed();
    }

    public function topic()
    {
        return $this->belongsTo(LessonTopic::class, 'lesson_topic_id');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'completed'      => 'bg-success',
            'in_progress'    => 'bg-info text-dark',
            'needs_revision' => 'bg-warning text-dark',
            'absent'         => 'bg-secondary',
            default          => 'bg-light text-dark',
        };
    }
}
