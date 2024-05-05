<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AuthController as UserAuthController;

class AuthController extends UserAuthController
{
    protected function restrictedRole($user): bool
    {
        return true;
    }
}
