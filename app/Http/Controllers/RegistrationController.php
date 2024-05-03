<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Services\UserService;

class RegistrationController extends Controller
{
    public function registration(RegistrationRequest $request)
    {
        app(UserService::class)->create($request->validated());

        return response()->json([], 201);
    }
}
