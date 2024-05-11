<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LawsuitEvent extends Model
{
    public const PLANNED_STATUS = 'planned';
    public const FINISHED_STATUS = 'finished';

    public const EVENT_TYPE = 'event';
    public const TASK_TYPE = 'task';

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

    protected function casts()
    {
        return [
            'since' => 'datetime',
            'till' => 'datetime',
        ];
    }

    public function remainDays(): Attribute
    {
        return new Attribute(
            get: fn ($value) => max(round(Carbon::now()->diffInDays($this->since)), 0),
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

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function isFinished(): bool
    {
        return $this->status === self::FINISHED_STATUS;
    }
}
