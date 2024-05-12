<?php

namespace App\Reporters;

use App\Models\LawsuitEvent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventReporter
{
    private ?int $customerId = null;
    private ?Carbon $since = null;
    private ?Carbon $till = null;
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
            ->when($this->since, function ($query, $since) {
                $query->where('since', '>=', $since->copy()->startOfDay());
            })
            ->when($this->till, function ($query, $till) {
                $query->where('since', '<=', $till->copy()->endOfDay());
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

    public function groupBySince()
    {
        return $this->builder()->with('lawsuitEventCategory')->get()->groupBy(function ($item) {
            return $item->since->format('Y-m-d');
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

    public function setSince(?Carbon $since): self
    {
        $this->since = $since;

        return $this;
    }

    public function setTill(?Carbon $till): self
    {
        $this->till = $till;

        return $this;
    }
}
