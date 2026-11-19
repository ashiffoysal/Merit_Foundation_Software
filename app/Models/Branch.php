<?php

namespace App\Models;

use App\Models\Concerns\IsLookup;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use IsLookup;

    protected $table = 'branches';

    protected $fillable = ['name', 'code', 'address', 'phone', 'sort_order', 'is_active'];

    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_branches');
    }
}
