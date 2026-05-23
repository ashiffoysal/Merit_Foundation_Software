<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    // App\Models\FeePlan.php
            public function category()
            {
                return $this->belongsTo(FeesCategory::class, 'category_id');
            }
            protected $fillable = [
            'name', 'category_id', 'country_code', 'duration', 'days_per_week',
            'monthly_price', 'currency', 'billing_interval', 'subtitle', 'description',
            'features', 'badge', 'button_text', 'stripe_price_id', 'stripe_product_id',
            'is_active', 'sort_order',
        ];

        
        protected $casts = [
            'features'  => 'array',
            'is_active' => 'boolean',
        ];
}
