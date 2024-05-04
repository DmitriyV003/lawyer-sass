<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;

class UserController extends Controller
{
    public function user()
    {
        return api_response(new UserResource(auth()->user()->load('roles')));
    }

    public function update(ProfileRequest $request)
    {
        return api_response(app(UserService::class, ['user' => auth()->user()])->update($request->validated()));
    }

    public function destroy()
    {
        app(UserService::class, ['user' => auth()->user()])->delete();
        auth()->invalidate(true);
        auth()->logout();

        return api_response('', 204);
    }
}
