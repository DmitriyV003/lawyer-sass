<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LawsuitEventCategory extends Model
{
    protected $fillable = [
        'name',
        'color',
        'notify_before_hours',
        'mark_before_days',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
