<?php

namespace App\Services\Auth;

use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;

interface AuthServiceInterface
{
    public function login(LoginRequest $request);

    public function logout();

    public function refreshToken();

    public function getCurrentUser();

    public function forgotPassword(ForgotPasswordRequest $request);

    public function resetPassword(ChangePasswordRequest $request);
}
