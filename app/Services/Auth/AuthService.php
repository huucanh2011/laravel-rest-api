<?php

namespace App\Services\Auth;

use App\ApiCode;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\PasswordReset\PasswordResetRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Traits\ResponseApi;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService implements AuthServiceInterface
{
    use ResponseApi;

    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PasswordResetRepositoryInterface $passwordResetRepository
    ) {
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

    public function refreshToken()
    {
        return $this->respondWithToken(JWTAuth::refresh());
    }

    public function getCurrentUser()
    {
        return $this->respond(JWTAuth::user());
    }

    private function respondWithToken($token)
    {
        return $this->respond([
            'access_token' => $token,
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ], 'Login Successful');
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
