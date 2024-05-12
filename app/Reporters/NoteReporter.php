<?php

namespace App\Reporters;

use App\Models\Note;
use App\Models\User;

class NoteReporter
{
    private ?User $user = null;
    private ?int $lawsuitId = null;
    private ?bool $emptyLawsuitId = false;

    public function builder()
    {
        return Note::query()
            ->when($this->user, function ($query, $user) {
                $query->where('user_id', $user->id);
            })
            ->when($this->lawsuitId, function ($query, $lawsuitId) {
                $query->where('lawsuit_id', $lawsuitId);
            })
            ->when(!$this->lawsuitId, function ($query) {
                $query->whereNull('lawsuit_id');
            });
    }

    public function emptyLawsuit(): self
    {
        $this->emptyLawsuitId = true;

        return $this;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function setLawsuitId(?int $lawsuitId): self
    {
        $this->lawsuitId = $lawsuitId;

        return $this;
    }

}
