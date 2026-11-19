<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherDocument extends Model
{
    protected $fillable = ['teacher_id', 'type', 'title', 'path', 'original_name', 'mime_type', 'size', 'uploaded_by'];

    public function owner()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id')->withTrashed();
    }

    public function getTypeLabelAttribute(): string
    {
        return Teacher::DOCUMENT_TYPES[$this->type] ?? ucfirst(str_replace('_', ' ', $this->type));
    }
}
