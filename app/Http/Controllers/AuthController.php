<?php

namespace App\Http\Controllers;

use App\DTOs\Auth\ForgotPasswordDTO;
use App\DTOs\Auth\LoginUserDTO;
use App\DTOs\Auth\RegisterUserDTO;
use App\DTOs\Auth\ResetPasswordDTO;
use App\Features\Auth\ChangePasswordFeature;
use App\Features\Auth\ForgotPasswordFeature;
use App\Features\Auth\GetAuthenticatedUserFeature;
use App\Features\Auth\LoginUserFeature;
use App\Features\Auth\LogoutUserFeature;
use App\Features\Auth\RefreshTokenFeature;
use App\Features\Auth\RegisterUserFeature;
use App\Features\Auth\ResetPasswordFeature;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgetRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(
        RegisterRequest $request,
        RegisterUserFeature $feature
    ): JsonResponse {
        try {
            $dto = RegisterUserDTO::fromRequest($request);
            $result = $feature->handle($dto);

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
                'data' => $result,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Login user
     */
    public function login(
        LoginRequest $request,
        LoginUserFeature $feature
    ): JsonResponse {
        try {
            $dto = LoginUserDTO::fromRequest($request);
            $result = $feature->handle($dto);

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => $result,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 401);
        }
    }

    /**
     * Get authenticated user
     */
    public function me(GetAuthenticatedUserFeature $feature): JsonResponse
    {
        try {
            $user = $feature->handle();

            return response()->json([
                'success' => true,
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 401);
        }
    }

    /**
     * Logout user
     */
    public function logout(LogoutUserFeature $feature): JsonResponse
    {
        try {
            $feature->handle();

            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Send password reset link
     */
    public function forgotPassword(
        ForgetRequest $request,
        ForgotPasswordFeature $feature
    ): JsonResponse {
        try {
            $dto = ForgotPasswordDTO::fromRequest($request);
            $feature->handle($dto);

            return response()->json([
                'success' => true,
                'message' => 'Password reset link sent to your email',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Reset password
     */
    public function resetPassword(
        ResetPasswordRequest $request,
        ResetPasswordFeature $feature
    ): JsonResponse {
        try {
            $dto = ResetPasswordDTO::fromRequest($request);
            $feature->handle($dto);

            return response()->json([
                'success' => true,
                'message' => 'Password reset successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Refresh JWT token
     */
    public function refresh(RefreshTokenFeature $feature): JsonResponse
    {
        try {
            $token = $feature->handle();

            return response()->json([
                'success' => true,
                'data' => [
                    'token' => $token,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Change password
     */
    public function changePassword(
        ChangePasswordRequest $request,
        ChangePasswordFeature $feature
    ): JsonResponse {
        try {
            $dto = \App\DTOs\Auth\ChangePasswordDTO::fromRequest($request);
            $feature->handle($dto->currentPassword, $dto->newPassword);

            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 400);
        }
    }
}

