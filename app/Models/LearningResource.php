<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LearningResource extends Model
{
    /** allowed upload extensions (validated by extension AND detected MIME type) */
    public const EXTENSIONS = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'odt', 'odp', 'ods', 'txt', 'rtf', 'jpg', 'jpeg', 'png', 'mp3', 'mp4'];

    public const MAX_KB = 20480; // 20 MB

    protected $fillable = [
        'title', 'description', 'resource_category_id', 'topic', 'file_path', 'original_name',
        'mime_type', 'size', 'is_active', 'uploaded_by',
    ];

    protected $attributes = ['is_active' => true, 'download_count' => 0];

    protected $casts = ['is_active' => 'boolean', 'size' => 'integer', 'download_count' => 'integer'];

    public function category()
    {
        return $this->belongsTo(ResourceCategory::class, 'resource_category_id');
    }

    public function levels()
    {
        return $this->belongsToMany(Level::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function downloads()
    {
        return $this->hasMany(LearningResourceDownload::class);
    }

    public function uploader()
    {
        return $this->belongsTo(Admin::class, 'uploaded_by');
    }

    public function getExtensionAttribute(): string
    {
        return strtolower(pathinfo($this->original_name, PATHINFO_EXTENSION));
    }

    public function getIconAttribute(): string
    {
        return match ($this->extension) {
            'pdf' => 'fa-file-pdf text-danger',
            'doc', 'docx', 'odt', 'rtf' => 'fa-file-word text-primary',
            'ppt', 'pptx', 'odp' => 'fa-file-powerpoint text-warning',
            'xls', 'xlsx', 'ods' => 'fa-file-excel text-success',
            'jpg', 'jpeg', 'png' => 'fa-file-image text-info',
            'mp3' => 'fa-file-audio text-secondary',
            'mp4' => 'fa-file-video text-secondary',
            default => 'fa-file-alt text-muted',
        };
    }

    public function isPreviewable(): bool
    {
        return $this->mime_type === 'application/pdf' || str_starts_with($this->mime_type, 'image/');
    }

    /**
     * THE access rule: an active resource is visible to a teacher when at least one of its levels
     * is one of the teacher's levels AND at least one of its subjects is one of the teacher's subjects.
     * A teacher with no levels or no subjects sees nothing.
     */
    public function scopeVisibleTo(Builder $q, Teacher $teacher): Builder
    {
        $levelIds   = $teacher->levels()->pluck('levels.id');
        $subjectIds = $teacher->subjects()->pluck('subjects.id');

        if ($levelIds->isEmpty() || $subjectIds->isEmpty()) {
            return $q->whereRaw('1 = 0');
        }

        return $q->where('is_active', true)
            ->whereHas('levels', fn ($l) => $l->whereIn('levels.id', $levelIds))
            ->whereHas('subjects', fn ($s) => $s->whereIn('subjects.id', $subjectIds));
    }

    public function isVisibleTo(Teacher $teacher): bool
    {
        return static::query()->visibleTo($teacher)->whereKey($this->id)->exists();
    }

    /** Teachers who can currently see this resource (for the admin screen) */
    public function eligibleTeachers()
    {
        $levelIds   = $this->levels->pluck('id');
        $subjectIds = $this->subjects->pluck('id');

        return Teacher::query()
            ->where('is_active', true)
            ->whereHas('levels', fn ($l) => $l->whereIn('levels.id', $levelIds))
            ->whereHas('subjects', fn ($s) => $s->whereIn('subjects.id', $subjectIds))
            ->orderBy('first_name');
    }
}
