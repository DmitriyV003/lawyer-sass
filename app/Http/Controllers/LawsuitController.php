<?php

namespace App\Http\Controllers;

use App\Http\Requests\LawsuitRequest;
use App\Http\Resources\AuthorityResource;
use App\Http\Resources\LawsuitResource;
use App\Models\Lawsuit;
use App\Services\LawsuitService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LawsuitController extends Controller
{
    use AuthorizesRequests;

    private const ITEMS_PER_PAGE = 20;

    public function index()
    {
        $this->authorize('viewAny', Lawsuit::class);

        return LawsuitResource::collection(
            auth()
                ->user()
                ->lawsuits()
                ->with(['customer', 'lawsuitCategory', 'authorities' => function ($query) {
                    $query->orderBy('created_at', 'desc')->limit(1);
                }])
                ->paginate(self::ITEMS_PER_PAGE),
        );
    }

    public function store(LawsuitRequest $request)
    {
        $this->authorize('create', Lawsuit::class);
        $lawsuit = app(LawsuitService::class)->create($request->validated(), auth()->user());

        return api_response(
            new LawsuitResource($lawsuit->load(['customer', 'lawsuitCategory'])),
            201,
        );
    }

    public function show(Lawsuit $lawsuit)
    {
        $this->authorize('view', $lawsuit);

        return api_response(
            (new LawsuitResource($lawsuit->load(['lawsuitCategory', 'customer'])))->loadCount('authorities')
        );
    }

    public function update(LawsuitRequest $request, Lawsuit $lawsuit)
    {
        $this->authorize('update', $lawsuit);

        $lawsuit->update($request->validated());

        return api_response(new LawsuitResource($lawsuit->load(['customer', 'lawsuitCategory'])));
    }

    public function destroy(Lawsuit $lawsuit)
    {
        $this->authorize('delete', $lawsuit);

        $lawsuit->delete();

        return api_response('', 204);
    }

    public function authorities(Lawsuit $lawsuit)
    {
        $this->authorize('authorities', $lawsuit);

        return api_response(AuthorityResource::collection($lawsuit->authorities()->orderBy('created_at', 'desc')->get()));
    }
}
