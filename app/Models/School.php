<?php

namespace App\Models;

use App\Models\Concerns\IsLookup;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use IsLookup;

    protected $table = 'schools';

    protected $fillable = ['name', 'sort_order', 'is_active'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
