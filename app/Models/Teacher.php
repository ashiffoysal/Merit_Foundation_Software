<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

/** Also the login account for the teacher panel (guard: teacher). */
class Teacher extends Authenticatable
{
    use SoftDeletes;

    public const GENDERS = ['male' => 'Male', 'female' => 'Female', 'other' => 'Other'];

    public const DOCUMENT_TYPES = [
        'proof_of_address' => 'Proof of Address',
        'proof_of_id'      => 'Proof of ID',
        'dbs'              => 'DBS Certificate',
        'contract'         => 'Contract',
        'certificate'      => 'Qualification Certificate',
        'other'            => 'Other',
    ];

    protected $fillable = [
        'first_name', 'last_name', 'phone', 'email', 'address', 'postcode', 'date_of_birth', 'gender', 'photo_path',
        'password', 'branch_id', 'job_title', 'ni_number', 'next_of_kin', 'next_of_kin_phone', 'skills',
        'certifications', 'hourly_rate', 'joining_date', 'resignation_date', 'has_dbs', 'is_active', 'last_login_at',
    ];

    protected $hidden = ['password', 'remember_token', 'ni_number'];

    /** same defaults as the database, so new in-memory models behave correctly */
    protected $attributes = ['is_active' => true, 'has_dbs' => false, 'hourly_rate' => 0];

    protected function casts(): array
    {
        return [
            'date_of_birth'    => 'date',
            'joining_date'     => 'date',
            'resignation_date' => 'date',
            'last_login_at'    => 'datetime',
            'hourly_rate'      => 'decimal:2',
            'has_dbs'          => 'boolean',
            'is_active'        => 'boolean',
            'password'         => 'hashed',
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

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo_path ? route('admin.teachers.photo', $this) . '?v=' . optional($this->updated_at)->timestamp : null;
    }

    /** NI number masked for listings: AB****56C */
    public function getMaskedNiAttribute(): ?string
    {
        $ni = $this->ni_number;
        return $ni ? substr($ni, 0, 2) . str_repeat('*', max(strlen($ni) - 5, 0)) . substr($ni, -3) : null;
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function levels()
    {
        return $this->belongsToMany(Level::class);
    }

    public function documents()
    {
        return $this->hasMany(TeacherDocument::class)->latest();
    }

    public function histories()
    {
        return $this->hasMany(TeacherEmploymentHistory::class)->latest()->latest('id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function lessonSessions()
    {
        return $this->hasMany(LessonSession::class);
    }

    /** Can this teacher use the teacher panel right now? */
    public function canUsePanel(): bool
    {
        return $this->is_active && ! $this->trashed()
            && (! $this->resignation_date || $this->resignation_date->endOfDay()->isFuture());
    }
}
