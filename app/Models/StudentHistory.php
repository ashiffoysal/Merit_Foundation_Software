<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentHistory extends Model
{
    protected $fillable = ['student_id', 'event', 'description', 'changes', 'admin_id'];

    protected $casts = ['changes' => 'array'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
