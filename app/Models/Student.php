<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    public const GENDERS = Teacher::GENDERS;

    protected $fillable = [
        'first_name', 'last_name', 'date_of_birth', 'gender', 'photo_path',
        'level_id', 'school_id', 'year_group_id',
        'registration_fee', 'refundable_deposit', 'hourly_fee',
        'assessment_date', 'assessment_time', 'student_status_id',
        'note', 'childcare', 'is_fee_delayed', 'due_date_extended', 'is_active',
    ];

    protected $attributes = [
        'registration_fee'   => 0,
        'refundable_deposit' => 50,
        'hourly_fee'         => 0,
        'childcare'          => false,
        'is_fee_delayed'     => false,
        'is_active'          => true,
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth'      => 'date',
            'assessment_date'    => 'date',
            'due_date_extended'  => 'date',
            'registration_fee'   => 'decimal:2',
            'refundable_deposit' => 'decimal:2',
            'hourly_fee'         => 'decimal:2',
            'childcare'          => 'boolean',
            'is_fee_delayed'     => 'boolean',
            'is_active'          => 'boolean',
        ];
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getInitialsAttribute(): string
    {
        return strtoupper(mb_substr($this->first_name, 0, 1) . mb_substr($this->last_name, 0, 1));
    }

    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth?->age;
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo_path ? route('admin.students.photo', $this) . '?v=' . optional($this->updated_at)->timestamp : null;
    }

    public function getAssessmentTimeShortAttribute(): ?string
    {
        return $this->assessment_time ? substr($this->assessment_time, 0, 5) : null;
    }

    public function parents()
    {
        return $this->belongsToMany(Guardian::class, 'student_parent', 'student_id', 'parent_id')
            ->withPivot('is_primary')->withTimestamps()->orderByPivot('is_primary', 'desc');
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'student_branches');
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function yearGroup()
    {
        return $this->belongsTo(YearGroup::class);
    }

    public function status()
    {
        return $this->belongsTo(StudentStatus::class, 'student_status_id');
    }

    public function histories()
    {
        return $this->hasMany(StudentHistory::class)->latest()->latest('id');
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_students')->withPivot('enrolled_at')->withTimestamps();
    }

    public function progressReports()
    {
        return $this->hasMany(LessonSessionStudent::class);
    }
}
