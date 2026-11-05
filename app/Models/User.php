<?php

namespace App\Models;

use App\Models\Watched;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Subscription;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *use Illuminate\Database\Eloquent\Relations\HasMany;
     * @var array<int, string>
     */
    protected $guarded = [
        "id",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    public function isDemoAccount(): bool
    {
        return in_array($this->email, ['admin@demo.com', 'viewer@demo.com'], true);
    }

    public function isViewer(): bool
    {
        return ! $this->is_admin;
    }

    public function tierLabel(): string
    {
        return match ($this->role) {
            1 => 'Monthly',
            2 => 'Yearly',
            default => 'Free',
        };
    }

    public function watched(): HasMany
    {
        return $this->hasMany(Watched::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    
}
