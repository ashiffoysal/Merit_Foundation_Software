<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

/** Shared behaviour for admin-managed dropdown tables (branches, subjects, levels ...) */
trait IsLookup
{
    public function initializeIsLookup(): void
    {
        $this->mergeCasts(['is_active' => 'boolean', 'sort_order' => 'integer']);
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true);
    }

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderBy('sort_order')->orderBy('name');
    }

    /** Active rows, plus any ids that are already selected on a record (so editing never loses a value). */
    public static function options(array|int|null $keep = []): \Illuminate\Support\Collection
    {
        $keep = array_filter((array) $keep);

        return static::query()
            ->where(fn ($q) => $q->where('is_active', true)->when($keep, fn ($q) => $q->orWhereIn('id', $keep)))
            ->ordered()
            ->get();
    }
}
