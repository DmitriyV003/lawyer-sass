<?php

namespace App\Reporters;

use App\Models\Task;
use App\Models\User;

class TaskReporter
{
    private ?int $customerId = null;
    private ?User $user = null;

    public function builder()
    {
        return Task::query()
            ->join(
                'task_tags',
                'task_tags.id',
                '=',
                'tasks.task_tag_id',
            )
            ->when($this->user, function ($query, $user) {
                $query->where('tasks.user_id', $user->id);
            })
            ->when($this->customerId, function ($query, $customerId) {
                $query ->leftJoin('lawsuits', 'lawsuits.id', 'tasks.lawsuit_id');
                $query->where(function ($query) use ($customerId) {
                    $query->where('tasks.customer_id', $customerId)
                        ->orWhere(function ($query) use ($customerId) {
                            $query->where('lawsuits.customer_id', $customerId);
                        });
                });
            });
    }

    public function setCustomerId(?int $customerId): self
    {
        $this->customerId = $customerId;

        return $this;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
