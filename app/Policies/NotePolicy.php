<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Note $note): bool
    {
        return $this->checkUserAndModel($user, $note);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Note $note): bool
    {
        return $this->checkUserAndModel($user, $note);
    }

    public function delete(User $user, Note $note): bool
    {
        return $this->checkUserAndModel($user, $note);
    }

    private function checkUserAndModel(User $user, Note $note): bool
    {
        return $user->id === $note->user_id;
    }
}
