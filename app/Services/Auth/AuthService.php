<?php

namespace App\Services\Auth;

use App\ApiCode;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Repositories\PasswordReset\PasswordResetRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Traits\ResponseApi;

class AuthService implements AuthServiceInterface
{
    use ResponseApi;

    private UserRepositoryInterface $userRepository;

    private PasswordResetRepositoryInterface $passwordResetRepository;

    public function __construct(UserRepositoryInterface $userRepository, PasswordResetRepositoryInterface $passwordResetRepository)
    {
        $this->userRepository = $userRepository;
        $this->passwordResetRepository = $passwordResetRepository;
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $user = $this->userRepository->findBy('email', $request->email);

        if (! (bool) $user) {
            return $this->respondWithMessage(ApiCode::EMAIL_NOT_FOUND);
        }

        $opt = $this->passwordResetRepository->createOTP($request->email);

        // send mail

        return $this->respondWithMessage('Send.');
    }

    public function resetPassword(ChangePasswordRequest $request)
    {
        $opt = $this->passwordResetRepository->getOTP($request->email, $request->otp);

        if ($opt->count() == 0) {
            return $this->respondBadRequest(ApiCode::INVALID_RESET_PASSWORD_OTP);
        }

        $user = $this->userRepository->findBy('email', $request->email);

        $user->update(['password' => $request->password]);

        $opt->delete();

        // send mail

        return $this->respondWithMessage('Updated.');
    }
}
