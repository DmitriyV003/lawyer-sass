<?php

namespace App\Services;

use App\Models\Authority;
use App\Models\Lawsuit;

class AuthorityService
{
    public function create(array $params, Lawsuit $lawsuit): Authority
    {
        $authority = app(Authority::class)->fill($params);
        $authority->lawsuit()->associate($lawsuit);
        $authority->save();

        return $authority;
    }

}
