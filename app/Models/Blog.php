<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    // CATEGORY RELATION
    public function category()
    {
        return $this->belongsTo(BlogsCategory::class, 'category_id');
    }

    // 
    
}
