<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Billable;
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'password',
        'google_id',
        'avatar',
    ];



    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // Helper: full name
    public function getNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }



      public function getFullNameAttribute(): string
    {
        return trim("{$this->name} {$this->last_name}");
    }
 
    /**
     * A user can have many transactions.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }
 
    /**
     * A user can have many subscriptions.
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'user_id');
    }
 
    /**
     * The user's most recent subscription (used to infer a "plan"
     * for a transaction, since transactions has no subscription_id FK).
     */
    public function latestSubscription()
    {
        return $this->hasOne(Subscription::class, 'user_id')->latestOfMany();
    }
}
