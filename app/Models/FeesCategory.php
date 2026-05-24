<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeesCategory extends Model
{
    public function plans()
    {
        return $this->hasMany(Plan::class, 'category_id');
    }
}
