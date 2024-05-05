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

        return api_response(LawsuitCategoryResource::collection(LawsuitCategory::all()));
    }

    public function store(LawsuitCategoryRequest $request)
    {
        $this->authorize('create', LawsuitCategory::class);

        return api_response(
            new LawsuitCategoryResource(app(LawsuitCategoryService::class)->create($request->validated(), auth()->user())),
            201,
        );
    }

    public function show(LawsuitCategory $caseCategory)
    {
        $this->authorize('view', $caseCategory);

        return api_response(new LawsuitCategoryResource($caseCategory));
    }

    public function update(LawsuitCategoryRequest $request, LawsuitCategory $caseCategory)
    {
        $this->authorize('update', $caseCategory);

        $caseCategory->update($request->validated());

        return api_response(new LawsuitCategoryResource($caseCategory));
    }

    public function destroy(LawsuitCategory $caseCategory)
    {
        $this->authorize('delete', $caseCategory);

        $caseCategory->delete();

        return api_response('', 204);
    }
}
