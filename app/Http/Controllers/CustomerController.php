<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CustomerController extends Controller
{
    use AuthorizesRequests;

    private const ITEMS_PER_PAGE = 1;

    public function index()
    {
        $this->authorize('viewAny', Customer::class);

        return CustomerResource::collection(auth()->user()->customers()->paginate(self::ITEMS_PER_PAGE));
    }

    public function store(CustomerRequest $request)
    {
        $this->authorize('create', Customer::class);

        return api_response(
            new CustomerResource(app(CustomerService::class)->create($request->validated(), auth()->user())),
            201,
        );
    }

    public function show(Customer $customer)
    {
        $this->authorize('view', $customer);

        return api_response(
            new CustomerResource($customer->load(['lawsuits'])),
        );
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $this->authorize('update', $customer);

        $customer->update($request->validated());

        return api_response(new CustomerResource($customer));
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);

        $customer->delete();

        return api_response('', 204);
    }
}
