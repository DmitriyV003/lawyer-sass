<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LawsuitCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'color',
        'notify_before_hours',
        'mark_before_days',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
