<?php

namespace App\Http\Controllers\Auth;

use App\ApiCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(['jwt.auth'], ['except' => ['login']]);
    }

    public function login(LoginRequest $request)
    {
        if (! $token = JWTAuth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return $this->respondUnAuthorizedRequest(ApiCode::INVALID_CREDENTIALS);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::parseToken());

        return $this->respondWithMessage('User successfully logged out');
    }

    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh());
    }

    public function me()
    {
        return $this->respond(JWTAuth::user());
    }

    private function respondWithToken($token)
    {
        return $this->respond([
            'token' => $token,
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ], 'Login Successful');
    }
}
