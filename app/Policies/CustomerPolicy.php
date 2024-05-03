<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Customer $customer): bool
    {
        return $this->checkUserAndCustomer($user, $customer);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Customer $customer): bool
    {
        return $this->checkUserAndCustomer($user, $customer);
    }

    public function delete(User $user, Customer $customer): bool
    {
        return $this->checkUserAndCustomer($user, $customer);
    }

    private function checkUserAndCustomer(User $user, Customer $customer): bool
    {
        return $user->id === $customer->user_id;
    }
}
