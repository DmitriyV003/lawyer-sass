<?php

namespace App\Reporters;

use App\Models\Lawsuit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LawsuitReporter
{
    private ?User $user = null;
    private ?string $upcomingEventSort = null;
    private ?string $ratingSort = null;
    private ?string $opponentSort = null;
    private ?int $customerId = null;

    public function builder()
    {
        return Lawsuit::query()
            ->when($this->user, function ($query, $user) {
                $query->where('user_id', $user->id);
            })
            ->when($this->upcomingEventSort, function ($query, $sort) {
                $latestEvent = DB::table('lawsuit_events')
                    ->whereColumn('lawsuit_id', 'lawsuits.id')
                    ->orderBy(DB::raw('since - now()::timestamp'), 'desc')
                    ->limit(1);
                $query->joinLateral($latestEvent, 'latest_event', 'left')
                    ->orderBy(DB::raw('latest_event.since - now()::timestamp'), $sort);
            })
            ->when($this->ratingSort, function ($query, $sort) {
                $query->orderBy('rating', $sort);
            })
            ->when($this->customerId, function ($query, $customerId) {
                $query->where('customer_id', $customerId);
            })
            ->when($this->opponentSort, function ($query, $sort) {
                $query->orderBy('opponent', $sort);
            });
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function setUpcomingEventSort(?string $upcomingEventSort): self
    {
        $this->upcomingEventSort = $upcomingEventSort;

        return $this;
    }

    public function setRatingSort(?string $ratingSort): self
    {
        $this->ratingSort = $ratingSort;

        return $this;
    }

    public function setOpponentSort(?string $opponentSort): self
    {
        $this->opponentSort = $opponentSort;

        return $this;
    }

    public function setCustomerId(?int $customerId): self
    {
        $this->customerId = $customerId;

        return $this;
    }


}
