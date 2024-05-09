<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LawsuitEvent extends Model
{
    public const PLANNED_STATUS = 'planned';
    public const FINISHED_STATUS = 'finished';

    protected $fillable = [
        'theme',
        'is_important',
        'since',
        'till',
        'cost',
        'place',
        'comment',
        'lawsuit_event_category_id',
        'user_id',
    ];

    protected $casts = [
        'is_important' => 'boolean',
    ];

    protected $attributes = [
        'is_important' => false,
        'status' => self::PLANNED_STATUS,
    ];

    protected $appends = [
        'remain_days',
    ];

    public function remainDays(): Attribute
    {
        return new Attribute(
            get: fn ($value) => round(Carbon::now()->diffInDays($this->since)),
        );
    }

    public function lawsuitEventCategory(): BelongsTo
    {
        return $this->belongsTo(LawsuitEventCategory::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function lawsuit(): BelongsTo
    {
        return $this->belongsTo(Lawsuit::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts()
    {
        return [
            'since' => 'datetime',
            'till' => 'datetime',
        ];
    }
}
