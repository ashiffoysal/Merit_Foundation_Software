<?php

namespace App\Models;

use App\Models\Concerns\IsLookup;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use IsLookup;

    protected $fillable = ['branch_id', 'name', 'capacity', 'sort_order', 'is_active'];

    protected $casts = ['capacity' => 'integer'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function getLabelAttribute(): string
    {
        return $this->name . ($this->branch ? ' — ' . $this->branch->name : '');
    }
}
