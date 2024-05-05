<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Authority extends Model
{
    protected $fillable = [
        'lawsuit_number',
        'lawsuit_number_link',
        'authority',
        'judge',
        'cabinet',
        'comment',
        'lawsuit_id',
    ];

    public function lawsuit(): BelongsTo
    {
        return $this->belongsTo(Lawsuit::class);
    }
}
