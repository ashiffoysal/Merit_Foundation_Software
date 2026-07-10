<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id', 'type', 'stripe_id', 'stripe_status', 'stripe_price',
        'quantity', 'trial_ends_at', 'ends_at',
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'ends_at'       => 'datetime',
        'quantity'      => 'integer',
    ];

    /**
     * Map Stripe Price IDs to human-readable plan names.
     *
     * The `subscriptions` table only stores the raw Stripe `stripe_price`
     * ID (e.g. "price_1TnzAyli1Z8eD8l6DLfDwkvg") — there is no plan-name
     * column in the schema. Keep this map updated whenever you add a
     * new Stripe Price in your dashboard, or move it into config/plans.php.
     */
    public static function planNameMap(): array
    {
        return [
            'price_1TnzAyli1Z8eD8l6DLfDwkvg' => 'Standard Monthly',
            'price_1TmcwLli1Z8eD8l6VJh9N0L3' => 'Premium Monthly',
            'price_1Tqy9Mli1Z8eD8l6yNF460vX' => 'Standard Yearly',
        ];
    }

    public static function planNameFromPrice(?string $stripePrice): string
    {
        if (!$stripePrice) {
            return 'N/A';
        }

        return self::planNameMap()[$stripePrice] ?? $stripePrice;
    }

    /**
     * Accessor: readable plan name for this subscription instance.
     */
    public function getPlanNameAttribute(): string
    {
        return self::planNameFromPrice($this->stripe_price);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope: active subscriptions only.
     */
    public function scopeActive($query)
    {
        return $query->where('stripe_status', 'active');
    }
}
