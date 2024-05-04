<?php

namespace App\Services;

use App\Models\Lawsuit;
use App\Models\User;

class LawsuitService
{
    public function create(array $params, User $user): Lawsuit
    {
        $lawsuit = app(Lawsuit::class)->fill($params);
        $lawsuit->user()->associate($user);
        $lawsuit->save();

        return $lawsuit;
    }

}
