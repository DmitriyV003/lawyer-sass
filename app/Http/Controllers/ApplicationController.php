<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Models\LawsuitEvent;
use App\Models\Task;

class ApplicationController extends Controller
{
    public function __invoke()
    {
        return api_response([
            'task_statuses' => Task::STATUSES,
            'lawsuit_event_statuses' => LawsuitEvent::STATUSES,
            'lawsuit_event_types' => LawsuitEvent::TYPES,
            'user_types' => UserType::labels(),
        ]);
    }
}
