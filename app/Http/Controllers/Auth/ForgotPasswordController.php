<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Services\Auth\AuthServiceInterface;

class ForgotPasswordController extends Controller
{
    public function __construct(
        private AuthServiceInterface $authService
    ) {
    }

    /**
     * Handle an incoming password reset link request.
     */
    public function store(ForgotPasswordRequest $request)
    {
        return $this->authService->forgotPassword($request);
    }
}
