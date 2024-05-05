<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    public const MAX_LOGIN_ATTEMPTS = 3;

    public const ADVOCATE_ROLE = 'advocate';
    public const SUPER_ADMIN_ROLE = 'super admin';

    protected $fillable = [
        'name',
        'lastname',
        'surname',
        'email',
        'phone',
        'type',
        'is_active',
        'login_attempts',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'is_active' => true,
        'login_attempts' => 0,
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function lawsuits(): HasMany
    {
        return $this->hasMany(Lawsuit::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function isActive(): bool
    {
        return $this->is_active && $this->login_attempts < self::MAX_LOGIN_ATTEMPTS;
    }

    public function scopeEmail($builder, string $email): void
    {
        $builder->where('email', $email);
    }

    protected function phone(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => sprintf('+%s', $value)
        );
    }
}