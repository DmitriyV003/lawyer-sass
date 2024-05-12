<?php

namespace App\Services;

use App\Exceptions\ServiceException;
use App\Models\Customer;
use App\Models\Lawsuit;
use App\Models\Task;
use App\Models\User;

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

    public function updateStatus(string $status): Task
    {
        if ($this->task->status == $status) {
            throw new ServiceException('Нельзя обновить статус');
        }
        $this->task->status = $status;
        $this->task->save();

        return $this->task;
    }

    private function setParams(array $params): void
    {
        $lawsuit = !empty($params['lawsuit_id']) ? Lawsuit::find($params['lawsuit_id']) : null;
        if ($lawsuit && $params['customer_id'] && $params['customer_id'] !== $lawsuit->customer_id) {
            throw new ServiceException('Клиенты не совадают');
        }
        if ($lawsuit) {
            $this->task->lawsuit()->associate($lawsuit);
        } else if (!empty($params['customer_id']) && $customer = Customer::find($params['customer_id'])) {
            $this->task->customer()->associate($customer);
        }
    }
}
