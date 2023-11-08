<?php

namespace App\Services\Auth;

use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;

interface AuthServiceInterface
{
    public function forgotPassword(ForgotPasswordRequest $request);

    public function resetPassword(ChangePasswordRequest $request);
}
