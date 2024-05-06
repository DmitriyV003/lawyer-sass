<?php

namespace App\Http\Controllers;

use App\Http\Requests\LawsuitCategoryRequest;
use App\Http\Resources\LawsuitCategoryResource;
use App\Models\LawsuitCategory;
use App\Services\LawsuitCategoryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LawsuitCategoryController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', LawsuitCategory::class);

        return api_response(LawsuitCategoryResource::collection(auth()->user()->lawsuitCategories));
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

        $lawsuitCategory->delete();

        return api_response('', 204);
    }
}
