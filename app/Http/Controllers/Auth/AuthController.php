<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthServiceInterface;

class AuthController extends Controller
{
    public function __construct(
        private AuthServiceInterface $authService,
    ) {
        $this->middleware(['jwt.auth'], ['except' => ['login']]);
    }

    public function login(LoginRequest $request)
    {
        return $this->authService->login($request);
    }

    public function logout()
    {
        return $this->authService->logout();
    }

    public function refresh()
    {
        return $this->authService->refreshToken();
    }

    public function me()
    {
        return $this->authService->getCurrentUser();
    }
}
