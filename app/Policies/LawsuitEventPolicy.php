<?php

namespace App\Policies;

use App\Models\LawsuitEvent;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LawsuitEventPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, LawsuitEvent $lawsuitEvent): bool
    {
        return $this->checkUserAndModel($user, $lawsuitEvent);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, LawsuitEvent $lawsuitEvent): bool
    {
        return $this->checkUserAndModel($user, $lawsuitEvent);
    }

    public function delete(User $user, LawsuitEvent $lawsuitEvent): bool
    {
        return $this->checkUserAndModel($user, $lawsuitEvent);
    }

    private function checkUserAndModel(User $user, LawsuitEvent $lawsuitEvent): bool
    {
        return $user->id === $lawsuitEvent->user_id;
    }
}
