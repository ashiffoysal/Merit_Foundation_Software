<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonSessionStudent extends Model
{
    public const ATTENDANCE = ['present' => 'Present', 'late' => 'Late', 'absent' => 'Absent', 'excused' => 'Excused'];

    public const PROGRESS = ['excellent' => 'Excellent', 'good' => 'Good', 'satisfactory' => 'Satisfactory', 'needs_improvement' => 'Needs improvement'];

    public const UNDERSTANDING = ['excellent' => 'Excellent', 'good' => 'Good', 'fair' => 'Fair', 'poor' => 'Poor'];

    public const UNDERSTANDING_COLORS = ['excellent' => 'success', 'good' => 'primary', 'fair' => 'warning', 'poor' => 'danger'];

    public const ATTENDANCE_COLORS = ['present' => 'success', 'late' => 'warning', 'absent' => 'danger', 'excused' => 'secondary'];

    public const PROGRESS_COLORS = ['excellent' => 'success', 'good' => 'primary', 'satisfactory' => 'info', 'needs_improvement' => 'warning'];

    protected $fillable = ['lesson_session_id', 'student_id', 'attendance', 'progress', 'understanding', 'score', 'homework_done', 'challenges', 'comment'];

    protected $casts = ['score' => 'integer', 'homework_done' => 'boolean'];

    public function session()
    {
        return $this->belongsTo(LessonSession::class, 'lesson_session_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class)->withTrashed();
    }
}
