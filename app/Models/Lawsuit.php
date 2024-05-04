<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'case_category_id',
        'user_id',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function caseCategory(): BelongsTo
    {
        return $this->belongsTo(CaseCategory::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts()
    {
        return [
            'contract_signing_date' => 'datetime',
            'contract_validity' => 'datetime',
            'power_of_attorney_signing_date' => 'datetime',
            'power_of_attorney_validity' => 'datetime',
        ];
    }
}
