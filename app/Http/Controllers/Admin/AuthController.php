<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AuthController as UserAuthController;
use App\Models\User;

class AuthController extends UserAuthController
{
    protected function restrictedRole($user): bool
    {
        return $user ? $user->hasRole(User::ADVOCATE_ROLE) : true;
    }
}
