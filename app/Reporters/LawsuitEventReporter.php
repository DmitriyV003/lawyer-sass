<?php

namespace App\Reporters;

use App\Models\LawsuitEvent;
use App\Models\User;

class LawsuitEventReporter
{
    private ?string $sinceStart = null;
    private ?string $sinceEnd = null;
    private ?User $user;

    public function builder()
    {
        return LawsuitEvent::query()
            ->when($this->user, function ($query, $user) {
                $query->where('user_id', $user->id);
            })
            ->when($this->sinceStart, function ($query, $sinceStart) {
                $query->where('since', '>=', $sinceStart);
            })
            ->when($this->sinceEnd, function ($query, $sinceEnd) {
                $query->where('since', '<=', $sinceEnd);
            });
    }

    public function setSinceStart(?string $sinceStart): self
    {
        $this->sinceStart = $sinceStart;

        return $this;
    }

    public function setSinceEnd(?string $sinceEnd): self
    {
        $this->sinceEnd = $sinceEnd;

        return $this;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
