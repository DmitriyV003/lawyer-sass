<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\TaskOrEventResource;
use App\Models\Customer;
use App\Models\LawsuitEvent;
use App\Models\Task;
use App\Reporters\EventReporter;
use App\Reporters\TaskReporter;
use App\Services\CustomerService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\select;

class CustomerController extends Controller
{
    use AuthorizesRequests;

    private const ITEMS_PER_PAGE = 20;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Customer::class);

        return CustomerResource::collection(
            auth()->user()->customers()->paginate(min($request->query->get('items_per_page'), self::ITEMS_PER_PAGE)),
        );
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

    public function events(Request $request, Customer $customer)
    {
        $eventBuilder = app(EventReporter::class)
            ->setUser(auth()->user())
            ->setCustomerId($customer->id)
            ->builder()
            ->select(DB::raw('
                lawsuit_events.id as id ,
                theme,
                lawsuit_event_categories.name as category_name,
                lawsuit_event_categories.color as color,
                lawsuit_event_categories.mark_before_days as mark_before_days,
                since as since,
                comment as comment,
                lawsuit_events.status as status,
                GREATEST(DATE_PART(\'day\', since - now()::timestamp), 0)::int as remain_time_days,
                \'event\' as type
            '));

        return app(TaskReporter::class)
            ->setUser(auth()->user())
            ->setCustomerId($customer->id)
            ->builder()
            ->select(DB::raw('
                tasks.id as id,
                theme,
                task_tags.name as category_name,
                task_tags.color as color,
                0 as mark_before_days,
                deadline as since,
                comment as comment,
                tasks.status as status,
                GREATEST(DATE_PART(\'day\', deadline - now()::timestamp), 0)::int as remain_time_days,
                \'task\' as type
            '))
            ->union($eventBuilder->getQuery())
            ->orderBy('remain_time_days')
            ->paginate(min($request->query->get('items_per_page'), 40));
    }
}
