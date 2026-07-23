<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeTrial extends Model
{
    //filable
    protected $fillable = [
        'parent_name',
        'child_name',
        'child_age',
        'current_level',
        'tutor_gender',
        'country',
        'email',
        'whatsapp',
        'time',
        
    
    ];


}
