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

/**
 * AuthController
 *
 * Handles authentication operations including registration, login, logout,
 * password reset, token refresh, and profile retrieval for JWT-authenticated users.
 */
class AuthController extends Controller
{
  /**
   * Register a new user
   *
   * @param RegisterRequest $request HTTP request with registration details
   * @param RegisterUserFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with registered user data
   */
  public function register(
    RegisterRequest $request,
    RegisterUserFeature $feature
  ): JsonResponse {
    try {
      $dto = RegisterUserDTO::fromRequest($request);
      $result = $feature->handle($dto);

      return response()->json([
        'status' => true,
        'message' => 'User registered successfully',
        'data' => $result,
      ], 201);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], 500);
    }
  }

  /**
   * Login user
   *
   * @param LoginRequest $request HTTP request with login credentials
   * @param LoginUserFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with authentication token
   */
  public function login(
    LoginRequest $request,
    LoginUserFeature $feature
  ): JsonResponse {
    try {
      $dto = LoginUserDTO::fromRequest($request);
      $result = $feature->handle($dto);

      return response()->json([
        'status' => true,
        'message' => 'Login successful',
        'data' => $result,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], 401);
    }
  }

  /**
   * Get authenticated user
   *
   * @param GetAuthenticatedUserFeature $feature Feature class for retrieving user
   * @return JsonResponse JSON response with user data
   */
  public function me(GetAuthenticatedUserFeature $feature): JsonResponse
  {
    try {
      $user = $feature->handle();

      return response()->json([
        'status' => true,
        'message' => 'User retrieved successfully',
        'data' => $user,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], 401);
    }
  }

  /**
   * Logout user
   *
   * @param LogoutUserFeature $feature Feature class for logout logic
   * @return JsonResponse JSON response with logout status
   */
  public function logout(LogoutUserFeature $feature): JsonResponse
  {
    try {
      $feature->handle();

      return response()->json([
        'status' => true,
        'message' => 'Logged out successfully',
        'data' => [],
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], 500);
    }
  }

  /**
   * Send password reset link
   *
   * @param ForgetRequest $request HTTP request with email address
   * @param ForgotPasswordFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with status
   */
  public function forgotPassword(
    ForgetRequest $request,
    ForgotPasswordFeature $feature
  ): JsonResponse {
    try {
      $dto = ForgotPasswordDTO::fromRequest($request);
      $feature->handle($dto);

      return response()->json([
        'status' => true,
        'message' => 'Password reset link sent to your email',
        'data' => [],
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], 500);
    }
  }

  /**
   * Reset password
   *
   * @param ResetPasswordRequest $request HTTP request with reset token and new password
   * @param ResetPasswordFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with status
   */
  public function resetPassword(
    ResetPasswordRequest $request,
    ResetPasswordFeature $feature
  ): JsonResponse {
    try {
      $dto = ResetPasswordDTO::fromRequest($request);
      $feature->handle($dto);

      return response()->json([
        'status' => true,
        'message' => 'Password reset successfully',
        'data' => [],
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], 500);
    }
  }

  /**
   * Refresh JWT token
   *
   * @param RefreshTokenFeature $feature Feature class for token refresh
   * @return JsonResponse JSON response with new token
   */
  public function refresh(RefreshTokenFeature $feature): JsonResponse
  {
    try {
      $token = $feature->handle();

      return response()->json([
        'status' => true,
        'message' => 'Token refreshed successfully',
        'data' => [
          'token' => $token,
        ],
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], 500);
    }
  }

  /**
   * Change password
   *
   * @param ChangePasswordRequest $request HTTP request with current and new password
   * @param ChangePasswordFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with status
   */
  public function changePassword(
    ChangePasswordRequest $request,
    ChangePasswordFeature $feature
  ): JsonResponse {
    try {
      $dto = \App\DTOs\Auth\ChangePasswordDTO::fromRequest($request);
      $feature->handle($dto->currentPassword, $dto->newPassword);

      return response()->json([
        'status' => true,
        'message' => 'Password changed successfully',
        'data' => [],
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 400);
    }
  }
}

