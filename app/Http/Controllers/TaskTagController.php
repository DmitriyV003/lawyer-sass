<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskTagRequest;
use App\Http\Resources\TaskTagResource;
use App\Models\TaskTag;
use App\Services\TaskTagService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskTagController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', TaskTag::class);

        return TaskTagResource::collection(auth()->user()->taskTags()->get());
    }

    public function store(TaskTagRequest $request)
    {
        $this->authorize('create', TaskTag::class);

        return api_response(
            new TaskTagResource(
                TaskTag::create(app(TaskTagService::class)->create($request->validated(), auth()->user())),
            ),
        );
    }

    public function show(TaskTag $taskTag)
    {
        $this->authorize('view', $taskTag);

        return api_response(new TaskTagResource($taskTag));
    }

    public function update(TaskTagRequest $request, TaskTag $taskTag)
    {
        $this->authorize('update', $taskTag);

        $taskTag->update($request->validated());

        return api_response(new TaskTagResource($taskTag));
    }

    public function destroy(TaskTag $taskTag)
    {
        $this->authorize('delete', $taskTag);

        $taskTag->delete();

        return api_response();
    }
}
