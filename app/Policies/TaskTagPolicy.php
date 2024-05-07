<?php

namespace App\Policies;

use App\Models\TaskTag;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskTagPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, TaskTag $taskTag): bool
    {
        return $this->checkUserAndModel($user, $taskTag);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, TaskTag $taskTag): bool
    {
        return $this->checkUserAndModel($user, $taskTag);
    }

    public function delete(User $user, TaskTag $taskTag): bool
    {
        return $this->checkUserAndModel($user, $taskTag);
    }

    private function checkUserAndModel(User $user, TaskTag $taskTag): bool
    {
        return $user->id === $taskTag->user_id;
    }
}
