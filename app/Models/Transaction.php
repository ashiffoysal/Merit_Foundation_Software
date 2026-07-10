<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'stripe_invoice_id', 'amount', 'currency',
        'status', 'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Status -> Bootstrap badge class map, used by both the
     * controller (DataTables JSON) and blade (fallback / non-JS render).
     */
    public static function statusBadgeMap(): array
    {
        return [
            'paid'    => 'success',
            'pending' => 'warning',
            'failed'  => 'danger',
            'refunded' => 'secondary',
        ];
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return self::statusBadgeMap()[strtolower($this->status)] ?? 'light';
    }
}
