<?php

namespace App\Policies;

use App\Models\Lawsuit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LawsuitPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Lawsuit $lawsuit): bool
    {
        return $this->checkUserAndModel($user, $lawsuit);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Lawsuit $lawsuit): bool
    {
        return $this->checkUserAndModel($user, $lawsuit);
    }

    public function delete(User $user, Lawsuit $lawsuit): bool
    {
        return $this->checkUserAndModel($user, $lawsuit);
    }

    private function checkUserAndModel(User $user, Lawsuit $lawsuit): bool
    {
        return $user->id === $lawsuit->user_id;
    }
}
