<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lawsuit extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'plot',
        'opponent',
        'rating',
        'contract_number',
        'contract_signing_date',
        'contract_validity',
        'power_of_attorney',
        'power_of_attorney_signing_date',
        'power_of_attorney_validity',
        'customer_id',
        'lawsuit_category_id',
        'user_id',
    ];

    protected function casts()
    {
        return [
            'contract_signing_date' => 'datetime',
            'contract_validity' => 'datetime',
            'power_of_attorney_signing_date' => 'datetime',
            'power_of_attorney_validity' => 'datetime',
        ];
    }

    protected $appends = [
        'contract_end_months',
        'contract_end_days',
        'power_of_attorney_end_months',
        'power_of_attorney_end_days',
    ];

    public function contractEndMonths(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return round($this->getContractValidityDateInterval()?->diffInMonths());
            },
        );
    }

    public function contractEndDays(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return round($this->getContractValidityDateInterval()?->diffInDays());
            },
        );
    }

    public function PowerOfAttorneyEndMonths(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return round($this->getContractValidityDateInterval()?->diffInMonths());
            },
        );
    }

    public function PowerOfAttorneyEndDays(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return round($this->getContractValidityDateInterval()?->diffInDays());
            },
        );
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function lawsuitCategory(): BelongsTo
    {
        return $this->belongsTo(LawsuitCategory::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function authorities(): HasMany
    {
        return $this->hasMany(Authority::class);
    }

    public function lawsuitEvents(): HasMany
    {
        return $this->hasMany(LawsuitEvent::class);
    }

    private function getContractValidityDateInterval()
    {
        if ($this->contract_validity && $this->contract_signing_date) {
            return $this->contract_validity->subtract($this->contract_signing_date);
        }

        return null;
    }

    private function getPowerOfAttorneyValidityDateInterval()
    {
        if ($this->power_of_attorney_validity && $this->power_of_attorney_signing_date) {
            return $this->power_of_attorney_validity->subtract($this->power_of_attorney_signing_date);
        }

        return null;
    }
}
