<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\SecurityService;
use Tymon\JWTAuth\Facades\JWTFactory;

class AuthController extends Controller
{
    private const TOKEN_TYPE = 'bearer';

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $user = User::email($credentials['email'])->first();
        if ($this->restrictedRole($user)) {
            return api_error(['error' => 'Unauthorized'], 401);
        }

        if (!$token = auth()->attempt($credentials)) {
            $user ? app(SecurityService::class)->increaseLoginAttempts($user) : null;
            return api_error(['error' => 'Unauthorized'], 401);
        }

        if (!$user?->isActive()) {
            return api_error(['error' => 'User is not active'], 401);
        }

        app(SecurityService::class)->resetLoginAttempts($user);

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->invalidate(true);
        auth()->logout();

        return api_response(['message' => 'Successfully logged out']);
    }

    protected function restrictedRole($user): bool
    {
        return $user?->hasRole(User::SUPER_ADMIN_ROLE);
    }

    protected function respondWithToken($token)
    {
        return api_response([
            'access_token' => $token,
            'token_type' => self::TOKEN_TYPE,
            'expires_in' => auth()->factory(JWTFactory::class)->getTTL() * 60,
            'user' => new UserResource(auth()->user()->load('roles')),
        ]);
    }
}
