<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookLesson extends Model
{
      protected $fillable = [
        'parent_name',
        'email',
        'phone',
        'emergency_phone',
        'package_id',
        'address',
        'post_code',
        'student_first_name',
        'student_last_name',
        'current_level',
        'preferred_tutor',
        'preferred_time',
        'notes',
        'donation_interest',
        'status',
        'admin_notes',
        'contacted_at',
    ];
}
