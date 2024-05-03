<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function user()
    {
        return api_response(new UserResource(auth()->user()->load('roles')));
    }
}
