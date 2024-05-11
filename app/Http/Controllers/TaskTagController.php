<?php

namespace App\Http\Controllers;

use App\Exceptions\ServiceException;
use App\Http\Requests\TaskTagRequest;
use App\Http\Resources\TaskTagResource;
use App\Models\TaskTag;
use App\Services\TaskTagService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\HttpFoundation\Response;

class TaskTagController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', TaskTag::class);

        return TaskTagResource::collection(auth()->user()->taskTags);
    }

    public function store(TaskTagRequest $request)
    {
        $this->authorize('create', TaskTag::class);

        return api_response(
            new TaskTagResource(
                app(TaskTagService::class)->create($request->validated(), auth()->user()),
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

        try {
            app(TaskTagService::class, ['taskTag' => $taskTag])->delete();
        } catch (ServiceException $exception) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, $exception->getMessage());
        }

        return api_response();
    }
}
