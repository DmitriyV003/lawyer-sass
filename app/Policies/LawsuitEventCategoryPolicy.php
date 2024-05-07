<?php

namespace App\Policies;

use App\Models\LawsuitEventCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LawsuitEventCategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, LawsuitEventCategory $lawsuitEventCategory): bool
    {
        return $this->checkUserAndModel($user, $lawsuitEventCategory);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, LawsuitEventCategory $lawsuitEventCategory): bool
    {
        return $this->checkUserAndModel($user, $lawsuitEventCategory);
    }

    public function delete(User $user, LawsuitEventCategory $lawsuitEventCategory): bool
    {
        return $this->checkUserAndModel($user, $lawsuitEventCategory);
    }

    private function checkUserAndModel(User $user, LawsuitEventCategory $lawsuitEventCategory): bool
    {
        return $user->id === $lawsuitEventCategory->user_id;
    }
}
