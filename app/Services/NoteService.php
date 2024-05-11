<?php

namespace App\Services;

use App\Exceptions\ServiceException;
use App\Models\Lawsuit;
use App\Models\Note;
use App\Models\User;

class NoteService
{
    private ?Note $note;

    public function __construct(?Note $note)
    {
        $this->note = $note;
    }

    public function create(array $params, User $user): Note
    {
        $this->note = app(Note::class)->fill($params);
        $this->note->user()->associate($user);
        $this->setParams($params);
        $this->note->save();

        return $this->note;
    }

    public function update(array $params): Note
    {
        $this->note->fill($params);
        $this->setParams($params);
        $this->note->save();

        return $this->note;
    }

    private function setParams(array $params): void
    {
        $lawsuit = $params['lawsuit_id'] ? Lawsuit::find($params['lawsuit_id']) : null;
        if ($lawsuit && $params['customer_id'] && $params['customer_id'] !== $lawsuit->customer_id) {
            throw new ServiceException('Клиенты не совадают');
        }
        if ($lawsuit) {
            $this->note->lawsuit()->associate($lawsuit);
        } else if ($params['customer_id']) {
            $this->note->customer_id = $params['customer_id'];
        }
    }
}
