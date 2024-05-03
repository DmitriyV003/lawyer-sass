<?php

namespace App\Services;

use App\Models\User;

class SecurityService
{
    public function increaseLoginAttempts(User $user): void
    {
        $user->login_attempts += 1;
        if ($user->login_attempts === User::MAX_LOGIN_ATTEMPTS) {
            $user->is_active = false;
        }
        $user->save();
    }

    public function resetLoginAttempts(User $user): void
    {
        $user->login_attempts = 0;
        $user->save();
    }
}
