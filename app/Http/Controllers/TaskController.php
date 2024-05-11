<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Requests\UpdateTaskToDoDateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Task::class);

        return TaskResource::collection(
            auth()->user()->tasks()->paginate(min($request->query->get('items_per_page'), 40)),
        );
    }

    public function store(TaskRequest $request)
    {
        $this->authorize('create', Task::class);

        $task = app(TaskService::class, ['task' => null])->create($request->validated(), auth()->user());

        return api_response(new TaskResource($task));
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return api_response(new TaskResource($task));
    }

    public function update(TaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $updatedTask = app(TaskService::class, ['task' => $task])->update($request->validated());

        return api_response(new TaskResource($updatedTask));
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return api_response();
    }

    public function updateToDoDate(UpdateTaskToDoDateRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $updatedTask = app(TaskService::class, ['task' => $task])->update($request->validated());

        return api_response(new TaskResource($updatedTask));
    }
}
