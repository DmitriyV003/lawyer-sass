<?php

namespace App\Policies;

use App\Models\Authority;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuthorityPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Authority $authority): bool
    {
        return $this->checkUserAndModel($user, $authority);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Authority $authority): bool
    {
        return $this->checkUserAndModel($user, $authority);
    }

    public function delete(User $user, Authority $authority): bool
    {
        return $this->checkUserAndModel($user, $authority);
    }

    private function checkUserAndModel(User $user, Authority $model): bool
    {
        return $user->id === $model->lawsuit->user_id;
    }
}
