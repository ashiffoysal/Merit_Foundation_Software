<?php

namespace App\Models;

use App\Models\Concerns\IsLookup;
use Illuminate\Database\Eloquent\Model;

class ResourceCategory extends Model
{
    use IsLookup;

    protected $fillable = ['name', 'sort_order', 'is_active'];

    public function resources()
    {
        return $this->hasMany(LearningResource::class);
    }
}
