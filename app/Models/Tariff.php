<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tariff extends Model
{
    use SoftDeletes;

    public const ARCHIVE_STATUS = 'archive';
    public const ACTIVE_STATUS = 'active';
    public const DELETED_STATUS = 'deleted';

    public const STATUSES = [
        self::ACTIVE_STATUS,
        self::ARCHIVE_STATUS,
    ];

    protected $fillable = [
        'name',
        'cost',
        'comment',
        'status',
    ];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'tariff_permission');
    }
}
