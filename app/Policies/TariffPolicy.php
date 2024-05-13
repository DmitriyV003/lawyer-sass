<?php

namespace App\Policies;

use App\Models\Tariff;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TariffPolicy
{
    use HandlesAuthorization;

    public function before(User $user): bool|null
    {
        return $user->hasRole(User::SUPER_ADMIN_ROLE);
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Tariff $tariff): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Tariff $tariff): bool
    {
        return true;
    }

    public function delete(User $user, Tariff $tariff): bool
    {
        return true;
    }
}
