<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaseCategoryRequest;
use App\Http\Resources\CaseCategoryResource;
use App\Models\CaseCategory;
use App\Services\CaseCategoryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CaseCategoryController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', CaseCategory::class);

        return api_response(CaseCategoryResource::collection(CaseCategory::all()));
    }

    public function store(CaseCategoryRequest $request)
    {
        $this->authorize('create', CaseCategory::class);

        return api_response(
            new CaseCategoryResource(app(CaseCategoryService::class)->create($request->validated(), auth()->user())),
            201,
        );
    }

    public function show(CaseCategory $caseCategory)
    {
        $this->authorize('view', $caseCategory);

        return api_response(new CaseCategoryResource($caseCategory));
    }

    public function update(CaseCategoryRequest $request, CaseCategory $caseCategory)
    {
        $this->authorize('update', $caseCategory);

        $caseCategory->update($request->validated());

        return api_response(new CaseCategoryResource($caseCategory));
    }

    public function destroy(CaseCategory $caseCategory)
    {
        $this->authorize('delete', $caseCategory);

        $caseCategory->delete();

        return api_response('', 204);
    }
}
