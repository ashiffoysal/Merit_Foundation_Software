<?php

namespace App\Models;

use App\Models\Concerns\IsLookup;
use Illuminate\Database\Eloquent\Model;

class StudentStatus extends Model
{
    use IsLookup;

    public const COLORS = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark'];

    protected $fillable = ['name', 'color', 'sort_order', 'is_active'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
