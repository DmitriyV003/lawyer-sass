<?php

namespace App\Services;

use App\Exceptions\ServiceException;
use App\Models\TaskTag;
use App\Models\User;

class TaskTagService
{
    private ?TaskTag $taskTag;

    public function __construct(?TaskTag $taskTag)
    {
        $this->taskTag = $taskTag;
    }

    public function create(array $params, User $user): TaskTag
    {
        $taskTag = app(TaskTag::class)->fill($params);
        $taskTag->user()->associate($user);
        $taskTag->save();

        return $taskTag;
    }

    public function delete(): void
    {
        if ($this->taskTag->tasks()->exists()) {
            throw new ServiceException('Тег привязан к задачам, удалить нельзя');
        }
        $this->taskTag->delete();
    }

}
