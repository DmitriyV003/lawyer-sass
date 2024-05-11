<?php

namespace App\Http\Controllers;

use App\Exceptions\ServiceException;
use App\Http\Requests\LawsuitEventQueryRequest;
use App\Http\Requests\LawsuitEventRequest;
use App\Http\Resources\LawsuitEventResource;
use App\Models\LawsuitEvent;
use App\Reporters\LawsuitEventReporter;
use App\Services\LawsuitEventService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\HttpFoundation\Response;

class LawsuitEventController extends Controller
{
    use AuthorizesRequests;

    public function index(LawsuitEventQueryRequest $request)
    {
        $this->authorize('viewAny', LawsuitEvent::class);
        $query = app(LawsuitEventReporter::class)
            ->setUser(auth()->user())
            ->setSinceStart($request->query->get('since_start'))
            ->setSinceEnd($request->query->get('since_end'))
            ->builder()
            ->with(['lawsuit', 'customer', 'lawsuit.customer']);

        return LawsuitEventResource::collection($query->get());
    }

    public function store(LawsuitEventRequest $request)
    {
        $this->authorize('create', LawsuitEvent::class);

        try {
            $event = app(LawsuitEventService::class)->create($request->validated(), auth()->user());
        } catch (ServiceException $exception) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, $exception->getMessage());
        }

        return api_response(new LawsuitEventResource($event));
    }

    public function show(LawsuitEvent $lawsuitEvent)
    {
        $this->authorize('view', $lawsuitEvent);

        return api_response(new LawsuitEventResource($lawsuitEvent->load(['lawsuit', 'customer', 'lawsuit.customer'])));
    }

    public function update(LawsuitEventRequest $request, LawsuitEvent $lawsuitEvent)
    {
        $this->authorize('update', $lawsuitEvent);

        $lawsuitEvent->update($request->validated());

        return api_response(new LawsuitEventResource($lawsuitEvent));
    }

    public function destroy(LawsuitEvent $lawsuitEvent)
    {
        $this->authorize('delete', $lawsuitEvent);

        $lawsuitEvent->delete();

        return api_response();
    }

    public function finish(LawsuitEvent $lawsuitEvent)
    {
        $this->authorize('finish', $lawsuitEvent);

        try {
            $updatedEvent = app(LawsuitEventService::class, ['lawsuitEvent' => $lawsuitEvent])->setFinishedStatus();
        } catch (ServiceException $exception) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, $exception->getMessage());
        }

        return api_response(new LawsuitEventResource($updatedEvent->load(['lawsuit', 'customer', 'lawsuit.customer'])));
    }
}
