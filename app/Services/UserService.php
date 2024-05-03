<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function create(array $params): void
    {
        $user = app(User::class)->fill($params);
        $user->password = Hash::make($params['password']);
        $user->save();
    }
}
