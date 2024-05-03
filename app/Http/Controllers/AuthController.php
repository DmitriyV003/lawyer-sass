<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\SecurityService;

class AuthController extends Controller
{
    private const TOKEN_TYPE = 'bearer';

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $user = User::email($credentials['email'])->first();
        if (!$token = auth()->attempt($credentials)) {
            $user ? app(SecurityService::class)->increaseLoginAttempts($user) : null;
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (!$user?->isActive()) {
            return response()->json(['error' => 'User is not active'], 401);
        }

        app(SecurityService::class)->resetLoginAttempts($user);

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->invalidate(true);
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => self::TOKEN_TYPE,
        ]);
    }
}
