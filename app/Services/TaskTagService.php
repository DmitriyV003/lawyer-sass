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
//        if ($this->taskTag->lawsuits()->exists()) {
//            throw new ServiceException('В категории есть дела, удалить нельзя');
//        }
        $this->taskTag->delete();
    }

}
