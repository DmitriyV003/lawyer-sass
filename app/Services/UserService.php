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
        $user->assignRole(User::ADVOCATE_ROLE);
        $user->save();
    }

    public function createAdmin(array $params): void
    {
        $user = app(User::class)->fill($params);
        $user->name = '';
        $user->lastname = '';
        $user->type = '';
        $user->password = Hash::make($params['password']);
        $user->assignRole(User::SUPER_ADMIN_ROLE);
        $user->save();
    }
}
