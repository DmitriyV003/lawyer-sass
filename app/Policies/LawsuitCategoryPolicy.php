<?php

namespace App\Policies;

use App\Models\LawsuitCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LawsuitCategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, LawsuitCategory $caseCategory): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, LawsuitCategory $caseCategory): bool
    {
        return true;
    }

    public function delete(User $user, LawsuitCategory $caseCategory): bool
    {
        return true;
    }

    public function restore(User $user, LawsuitCategory $caseCategory): bool
    {
        return true;
    }

    public function forceDelete(User $user, LawsuitCategory $caseCategory): bool
    {
        return true;
    }
}
