<?php

namespace App\Services;

use App\Exceptions\ServiceException;
use App\Models\Customer;
use App\Models\Lawsuit;
use App\Models\LawsuitEvent;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class LawsuitEventService
{
    private ?LawsuitEvent $lawsuitEvent;

    public function __construct(?LawsuitEvent $lawsuitEvent)
    {
        $this->lawsuitEvent = $lawsuitEvent;
    }

    public function create(array $params, User $user): LawsuitEvent
    {
        $this->lawsuitEvent = app(LawsuitEvent::class)->fill($params);
        $this->lawsuitEvent->user()->associate($user);
        $this->setParams($params, $user);
        $this->lawsuitEvent->save();

        return $this->lawsuitEvent;
    }

    public function update(array $params, User $user): LawsuitEvent
    {
        $this->setParams($params, $user);
        $this->lawsuitEvent->save();

        return $this->lawsuitEvent;
    }

    public function updateStatus(string $status): LawsuitEvent
    {
        if ($this->lawsuitEvent->status == $status) {
            throw new ServiceException('Нельзя обновить статус');
        }
        $this->lawsuitEvent->status = $status;
        $this->lawsuitEvent->save();

        return $this->lawsuitEvent;
    }

    private function setParams(array $params, User $user): void
    {
        $lawsuit = $params['lawsuit_id'] ? Lawsuit::find($params['lawsuit_id']) : null;
        if ($lawsuit && $params['customer_id'] && $params['customer_id'] !== $lawsuit->customer_id) {
            throw new ServiceException('Клиенты не совадают');
        }
        if ($lawsuit) {
            $this->lawsuitEvent->lawsuit()->associate($lawsuit);
        } else if ($params['customer_id'] && $customer = Customer::find($params['customer_id'])) {
            $this->lawsuitEvent->customer()->associate($customer);
        }
        $addStartTime = $this->parseTime($params['since_time'], $user->start_working_time, $params['is_all_day']);
        $this->lawsuitEvent->since = (Carbon::createFromFormat('Y-d-m', $params['since_date']))
            ->setTime($addStartTime->hour, $addStartTime->minute);
        if ($params['till_date']) {
            $addEndTime = $this->parseTime($params['till_time'], $user->end_working_time, $params['is_all_day']);
            $this->lawsuitEvent->till = (Carbon::createFromFormat('Y-d-m', $params['till_date']))
                ->setTime($addEndTime->hour, $addEndTime->minute);
        }

        if ($params['task_id'] && $task = Task::find($params['task_id'])) {
            $this->lawsuitEvent->task()->associate($task);
        }
    }

    private function parseTime(?string $time, string $userTime, bool|null $isAllDay): Carbon
    {
        return $isAllDay
            ? Carbon::createFromFormat('H:i:s', $userTime)
            : Carbon::createFromFormat('H:i:s', $time);
    }
}
