<?php

namespace App\Models;

use App\Notifications\CustomerPasswordReset;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'city',
        'email_verified_at',
        'password',
        'is_deleted',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_deleted'        => 'boolean',
    ];

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new CustomerPasswordReset($token));
    }

    /**
     * Customer ke orders.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}