<?php

namespace App\Policies;

use App\Models\CaseCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CaseCategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, CaseCategory $caseCategory): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, CaseCategory $caseCategory): bool
    {
        return true;
    }

    public function delete(User $user, CaseCategory $caseCategory): bool
    {
        return true;
    }

    public function restore(User $user, CaseCategory $caseCategory): bool
    {
        return true;
    }

    public function forceDelete(User $user, CaseCategory $caseCategory): bool
    {
        return true;
    }
}
