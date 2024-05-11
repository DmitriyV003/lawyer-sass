<?php

namespace App\Reporters;

use App\Models\LawsuitEvent;
use App\Models\User;

class EventReporter
{
    private ?int $customerId = null;
    private ?User $user = null;

    public function builder()
    {
        return LawsuitEvent::query()
            ->join(
                'lawsuit_event_categories',
                'lawsuit_event_categories.id',
                '=',
                'lawsuit_events.lawsuit_event_category_id',
            )
            ->when($this->user, function ($query, $user) {
                $query->where('lawsuit_events.user_id', $user->id);
            })
            ->when($this->customerId, function ($query, $customerId) {
                $query->leftJoin('lawsuits', 'lawsuits.id', 'lawsuit_events.lawsuit_id');
                $query->where(function ($query) use ($customerId) {
                    $query->where('lawsuit_events.customer_id', $customerId)
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
