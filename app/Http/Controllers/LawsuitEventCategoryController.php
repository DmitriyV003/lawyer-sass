<?php

namespace App\Http\Controllers;

use App\Exceptions\ServiceException;
use App\Http\Requests\LawsuitEventCategoryRequest;
use App\Http\Resources\LawsuitEventCategoryResource;
use App\Models\LawsuitEventCategory;
use App\Services\LawsuitEventCategoryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\HttpFoundation\Response;

class LawsuitEventCategoryController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', LawsuitEventCategory::class);

        return api_response(LawsuitEventCategoryResource::collection(auth()->user()->lawsuitEventCategories));
    }

    public function store(LawsuitEventCategoryRequest $request)
    {
        $this->authorize('create', LawsuitEventCategory::class);

        return api_response(new LawsuitEventCategoryResource(
            app(LawsuitEventCategoryService::class)->create($request->validated(), auth()->user()),
        ));
    }

    public function show(LawsuitEventCategory $lawsuitEventCategory)
    {
        $this->authorize('view', $lawsuitEventCategory);

        return api_response(new LawsuitEventCategoryResource($lawsuitEventCategory));
    }

    public function update(LawsuitEventCategoryRequest $request, LawsuitEventCategory $lawsuitEventCategory)
    {
        $this->authorize('update', $lawsuitEventCategory);

        $lawsuitEventCategory->update($request->validated());

        return api_response(new LawsuitEventCategoryResource($lawsuitEventCategory));
    }

    public function destroy(LawsuitEventCategory $lawsuitEventCategory)
    {
        $this->authorize('delete', $lawsuitEventCategory);

        try {
            app(LawsuitEventCategoryService::class, ['lawsuitEventCategory' => $lawsuitEventCategory])->delete();
        } catch (ServiceException $exception) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, $exception->getMessage());
        }

        return api_response();
    }
}
