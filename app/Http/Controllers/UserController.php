<?php

namespace App\Http\Controllers;

use App\DTOs\User\GetUserDTO;
use App\DTOs\User\UpdateUserDTO;
use App\DTOs\User\UpdateUserRoleDTO;
use App\DTOs\User\UpdateUserStatusDTO;
use App\DTOs\User\UserFilterDTO;
use App\Features\User\DeleteUserFeature;
use App\Features\User\FilterUsersFeature;
use App\Features\User\GetMyProfileFeature;
use App\Features\User\GetUserFeature;
use App\Features\User\GetUsersFeature;
use App\Features\User\UpdateUserFeature;
use App\Features\User\UpdateUserRoleFeature;
use App\Features\User\UpdateUserStatusFeature;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UpdateUserRoleRequest;
use App\Http\Requests\User\UserFilterRequest;
use Illuminate\Http\JsonResponse;

/**
 * UserController
 *
 * Manages user profile operations, role updates, status changes, and user
 * listing/filtering for administrators. Provides endpoints for user management
 * and profile retrieval.
 */
class UserController extends Controller
{
  public function __construct(
    private readonly GetMyProfileFeature $getMyProfileFeature
  ) {
  }

  /**
   * Get all users (admin only)
   *
   * @param GetUsersFeature $feature Feature class for retrieving users
   * @return JsonResponse JSON response with all users
   */
  public function index(GetUsersFeature $feature): JsonResponse
  {
    try {
      $users = $feature->handle();

      return response()->json([
        'status' => true,
        'message' => 'Users retrieved successfully',
        'data' => $users,
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
   * Get filtered users (admin only)
   *
   * @param UserFilterRequest $request HTTP request with filter criteria
   * @param FilterUsersFeature $feature Feature class for filtering users
   * @return JsonResponse Paginated JSON response with filtered users
   */
  public function filter(
    UserFilterRequest $request,
    FilterUsersFeature $feature
  ): JsonResponse {
    try {
      $dto = UserFilterDTO::fromRequest($request);
      $paginated = $feature->handle($dto);

      return response()->json([
        'status' => true,
        'message' => 'Users filtered successfully',
        'data' => $paginated->items(),
        'pagination' => [
          'total' => $paginated->total(),
          'per_page' => $paginated->perPage(),
          'current_page' => $paginated->currentPage(),
          'last_page' => $paginated->lastPage(),
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
   * Show single user
   *
   * @param string $id User identifier
   * @param GetUserFeature $feature Feature class for retrieving user
   * @return JsonResponse JSON response with user data
   */
  public function show(string $id, GetUserFeature $feature): JsonResponse
  {
    try {
      $dto = new GetUserDTO($id);
      $user = $feature->handle($dto);

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
      ], $e->getCode() ?? 500);
    }
  }

  /**
   * Update user profile
   *
   * @param string $id User identifier
   * @param UpdateUserRequest $request HTTP request with updated user data
   * @param UpdateUserFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with updated user data
   */
  public function update(
    string $id,
    UpdateUserRequest $request,
    UpdateUserFeature $feature
  ): JsonResponse {
    try {
      $dto = UpdateUserDTO::fromRequest($request);
      $user = $feature->handle($dto);

      return response()->json([
        'status' => true,
        'message' => 'User updated successfully',
        'data' => $user,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() ?? 500);
    }
  }

  /**
   * Update user role (admin only)
   *
   * @param string $id User identifier
   * @param UpdateUserRoleRequest $request HTTP request with new role
   * @param UpdateUserRoleFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with updated user data
   */
  public function updateRole(
    string $id,
    UpdateUserRoleRequest $request,
    UpdateUserRoleFeature $feature
  ): JsonResponse {
    try {
      $dto = UpdateUserRoleDTO::fromRequest($request);
      $user = $feature->handle($dto);

      return response()->json([
        'status' => true,
        'message' => 'User role updated successfully',
        'data' => $user,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() ?? 500);
    }
  }

  /**
   * Update user active/inactive status (admin only)
   *
   * @param string $id User identifier
   * @param UpdateUserStatusFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with updated user data
   */
  public function updateStatus(
    string $id,
    UpdateUserStatusFeature $feature
  ): JsonResponse {
    try {
      $isActive = request()->boolean('is_active', true);
      $dto = new UpdateUserStatusDTO($id, $isActive);
      $user = $feature->handle($dto);

      return response()->json([
        'status' => true,
        'message' => $isActive ? 'User activated successfully' : 'User deactivated successfully',
        'data' => $user,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() ?? 500);
    }
  }

  /**
   * Delete user (admin only)
   *
   * @param string $id User identifier
   * @param DeleteUserFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with deletion status
   */
  public function destroy(string $id, DeleteUserFeature $feature): JsonResponse
  {
    try {
      $feature->handle($id);

      return response()->json([
        'status' => true,
        'message' => 'User deleted successfully',
        'data' => [],
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() ?? 500);
    }
  }

  /**
   * Get current user profile
   *
   * @return JsonResponse JSON response with user profile data
   */
  public function profile(): JsonResponse
  {
    try {
      $user = $this->getMyProfileFeature->handle();

      return response()->json([
        'status' => true,
        'message' => 'Profile retrieved successfully',
        'data' => $user,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], 500);
    }
  }
}
