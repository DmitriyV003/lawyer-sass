<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Models\LawsuitEvent;
use App\Models\Permission;
use App\Models\Task;

class ApplicationController extends Controller
{
    public function __invoke()
    {
        return api_response([
            'permissions' => PermissionResource::collection(Permission::all()),
        ]);
    }
}
