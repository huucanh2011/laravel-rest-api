<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Services\Auth\AuthServiceInterface;

class NewPasswordController extends Controller
{
    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle an incoming new password request.
     */
    public function store(ChangePasswordRequest $request)
    {
        return $this->authService->resetPassword($request);
    }
}
