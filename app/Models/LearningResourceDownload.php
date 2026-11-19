<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningResourceDownload extends Model
{
    public $timestamps = false;

    protected $fillable = ['learning_resource_id', 'teacher_id', 'admin_id', 'downloaded_at'];

    protected $casts = ['downloaded_at' => 'datetime'];

    public function resource()
    {
        return $this->belongsTo(LearningResource::class, 'learning_resource_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class)->withTrashed();
    }
}
