<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherEmploymentHistory extends Model
{
    protected $fillable = ['teacher_id', 'event', 'description', 'old_value', 'new_value', 'effective_date', 'admin_id'];

    protected $casts = ['effective_date' => 'date'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
