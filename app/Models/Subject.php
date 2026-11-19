<?php

namespace App\Models;

use App\Models\Concerns\IsLookup;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use IsLookup;

    protected $table = 'subjects';

    protected $fillable = ['name', 'sort_order', 'is_active'];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }

    public function learningResources()
    {
        return $this->belongsToMany(LearningResource::class);
    }
}
