<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentDocument extends Model
{
    protected $fillable = ['parent_id', 'type', 'title', 'path', 'original_name', 'mime_type', 'size', 'uploaded_by'];

    public function owner()
    {
        return $this->belongsTo(Guardian::class, 'parent_id')->withTrashed();
    }

    public function getTypeLabelAttribute(): string
    {
        return Guardian::DOCUMENT_TYPES[$this->type] ?? ucfirst(str_replace('_', ' ', $this->type));
    }
}
