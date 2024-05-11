<?php

namespace App\Services;

use App\Exceptions\ServiceException;
use App\Models\Lawsuit;
use App\Models\LawsuitEvent;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class TaskService
{
    private ?Task $task;

    public function __construct(?Task $task)
    {
        $this->task = $task;
    }

    public function create(array $params, User $user): Task
    {
        $this->task = app(Task::class)->fill($params);
        $this->task->user()->associate($user);
        $this->setParams($params);
        $this->task->save();

        return $this->task;
    }

    public function update(array $params): Task
    {
        $this->setParams($params);
        $this->task->save();

        return $this->task;
    }

    public function setFinishedStatus(): Task
    {
        $this->task->status = LawsuitEvent::FINISHED_STATUS;
        $this->task->save();

        return $this->task;
    }

    private function setParams(array $params): void
    {
        $lawsuit = $params['lawsuit_id'] ? Lawsuit::find($params['lawsuit_id']) : null;
        if ($lawsuit && $params['customer_id'] && $params['customer_id'] !== $lawsuit->customer_id) {
            throw new ServiceException('Клиенты не совадают');
        }
        if ($lawsuit) {
            $this->task->lawsuit()->associate($lawsuit);
        } else if ($params['customer_id']) {
            $this->task->customer_id = $params['customer_id'];
        }
    }
}
