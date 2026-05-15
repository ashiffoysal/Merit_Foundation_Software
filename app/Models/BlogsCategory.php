<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogsCategory extends Model
{
    // BLOGS RELATION
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id');
    }
}
