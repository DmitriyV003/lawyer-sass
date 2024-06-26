<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'telegram',
        'whats_app',
        'phone',
        'email',
        'last_active_at',
        'user_id',
    ];

    protected function casts()
    {
        return [
            'last_active_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lawsuits(): HasMany
    {
        return $this->hasMany(Lawsuit::class);
    }

    public function latestLawsuitByContractValidityDate(): HasOne
    {
        return $this->hasOne(Lawsuit::class)->latestOfMany('contract_validity');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function lawsuitEvents(): HasMany
    {
        return $this->hasMany(LawsuitEvent::class);
    }

    protected function phone(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => sprintf('+%s', $value)
        );
    }

    protected function whatsApp(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => sprintf('+%s', $value)
        );
    }
}
