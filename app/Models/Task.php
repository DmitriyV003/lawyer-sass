<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
    public const PLANNED_STATUS = 'planned';

    protected $fillable = [
        'theme',
        'is_important',
        'deadline',
        'cost',
        'comment',
        'to_do_date',
        'customer_id',
        'lawsuit_id',
        'task_tag_id',
    ];

    protected function casts()
    {
        return [
            'deadline' => 'datetime',
            'to_do_date' => 'datetime',
        ];
    }

    protected $attributes = [
        'is_important' => false,
        'status' => self::PLANNED_STATUS,
    ];

    public function remainDays(): Attribute
    {
        return new Attribute(
            get: fn ($value) => max(round(Carbon::now()->diffInDays($this->deadline)), 0),
        );
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function lawsuit(): BelongsTo
    {
        return $this->belongsTo(Lawsuit::class);
    }

    public function taskTag(): BelongsTo
    {
        return $this->belongsTo(TaskTag::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lawsuitEvent(): HasOne
    {
        return $this->hasOne(LawsuitEvent::class);
    }
}
