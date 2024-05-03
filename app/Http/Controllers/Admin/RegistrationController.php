<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RegistrationRequest;
use App\Services\UserService;

class RegistrationController extends Controller
{
    public function registration(RegistrationRequest $request)
    {
        app(UserService::class)->createAdmin($request->validated());

        return api_response([], 201);
    }
}
