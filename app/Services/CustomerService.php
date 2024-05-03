<?php

namespace App\Services;

use App\Models\Customer;

class CustomerService
{
    public function create(array $params): Customer
    {
        $customer = app(Customer::class)->fill($params);
        $customer->user()->associate(auth()->user());
        $customer->save();

        return $customer;
    }

}
