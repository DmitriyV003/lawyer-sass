<?php

namespace App\Services;

use App\Models\TaskTag;
use App\Models\User;

class TaskTagService
{
    public function create(array $params, User $user): TaskTag
    {
        $taskTag = app(TaskTag::class)->fill($params);
        $taskTag->user()->associate($user);
        $taskTag->save();

        return $taskTag;
    }

}
