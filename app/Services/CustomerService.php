<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\User;

class CustomerService
{
    public function create(array $params, User $user): Customer
    {
        $customer = app(Customer::class)->fill($params);
        $customer->user()->associate($user);
        $customer->save();

        return $customer;
    }

}
