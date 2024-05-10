<?php

namespace App\Services;

use App\Models\Note;
use App\Models\User;

class NoteService
{
    public function create(array $params, User $user): Note
    {
        $note = app(Note::class)->fill($params);
        $note->user()->associate($user);
        $note->save();

        return $note;
    }
}
