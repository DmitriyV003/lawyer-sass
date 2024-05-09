<?php

namespace App\Http\Controllers;

use App\Exceptions\ServiceException;
use App\Http\Requests\LawsuitCategoryRequest;
use App\Http\Resources\LawsuitCategoryResource;
use App\Models\LawsuitCategory;
use App\Services\LawsuitCategoryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LawsuitCategoryController extends Controller
{
    use AuthorizesRequests;

    private const ITEMS_PER_PAGE = 20;

    public function index(Request $request)
    {
        $this->authorize('viewAny', LawsuitCategory::class);

        return api_response(
            LawsuitCategoryResource::collection(
                auth()
                    ->user()
                    ->lawsuitCategories()
                    ->paginate(min($request->query->get('items_per_page'), self::ITEMS_PER_PAGE)),
            ),
        );
    }

    public function store(LawsuitCategoryRequest $request)
    {
        $this->authorize('create', LawsuitCategory::class);

        return api_response(
            new LawsuitCategoryResource(app(LawsuitCategoryService::class)->create($request->validated(), auth()->user())),
            201,
        );
    }

    public function show(LawsuitCategory $lawsuitCategory)
    {
        $this->authorize('view', $lawsuitCategory);

        return api_response(new LawsuitCategoryResource($lawsuitCategory));
    }

    public function update(LawsuitCategoryRequest $request, LawsuitCategory $lawsuitCategory)
    {
        $this->authorize('update', $lawsuitCategory);

        $lawsuitCategory->update($request->validated());

        return api_response(new LawsuitCategoryResource($lawsuitCategory));
    }

    public function destroy(LawsuitCategory $lawsuitCategory)
    {
        $this->authorize('delete', $lawsuitCategory);

        try {
            app(LawsuitCategoryService::class, ['lawsuitCategory' => $lawsuitCategory])->delete();
        } catch (ServiceException $exception) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, $exception->getMessage());
        }

        return api_response('', 204);
    }
}
