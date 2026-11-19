<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonTopic extends Model
{
    protected $fillable = ['lesson_id', 'title', 'description', 'sort_order'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function records()
    {
        return $this->hasMany(LessonRecord::class);
    }
}
