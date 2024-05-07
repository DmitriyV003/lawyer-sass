<?php

namespace App\Http\Controllers;

use App\Exceptions\ServiceException;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Response;

class   UserController extends Controller
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

    public function updatePassword(UpdateUserPasswordRequest $request)
    {
        try {
            app(UserService::class, ['user' => auth()->user()])->updatePassword($request->validated());
        } catch (ServiceException $exception) {
            return api_error($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return api_response();
    }
}
