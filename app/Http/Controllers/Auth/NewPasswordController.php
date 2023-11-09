<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Services\Auth\AuthServiceInterface;

class NewPasswordController extends Controller
{
    public function __construct(
        private AuthServiceInterface $authService
    ) {
    }

    /**
     * Handle an incoming new password request.
     */
    public function store(ChangePasswordRequest $request)
    {
        return $this->authService->resetPassword($request);
    }
}
