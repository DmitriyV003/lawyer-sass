<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ServiceException;
use App\Http\Controllers\Controller;
use App\Http\Requests\TariffRequest;
use App\Http\Requests\TariffStatusRequest;
use App\Http\Resources\TariffResource;
use App\Models\Tariff;
use App\Services\TariffService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\HttpFoundation\Response;

class TariffController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Tariff::class);

        return TariffResource::collection(Tariff::query()->withCount('users')->withTrashed()->paginate(40));
    }

    public function store(TariffRequest $request)
    {
        $this->authorize('create', Tariff::class);

        return api_response(new TariffResource(Tariff::create($request->validated())));
    }

    public function show(Tariff $tariff)
    {
        $this->authorize('view', $tariff);

        return api_response(new TariffResource($tariff));
    }

    public function update(TariffRequest $request, Tariff $tariff)
    {
        $this->authorize('update', $tariff);

        $tariff->update($request->validated());

        return api_response(new TariffResource($tariff));
    }

    public function destroy(Tariff $tariff)
    {
        $this->authorize('delete', $tariff);

        try {
            app(TariffService::class, ['tariff' => $tariff])->delete();
        } catch (ServiceException $exception) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, $exception->getMessage());
        }

        return api_response();
    }

    public function updateStatus(TariffStatusRequest $request, Tariff $tariff)
    {
        $this->authorize('update', $tariff);

        app(TariffService::class, ['tariff' => $tariff])->updateStatus($request->get('status'));

        return api_response();
    }
}
