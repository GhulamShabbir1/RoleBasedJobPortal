<?php

namespace App\Http\Controllers;

use App\DTOs\User\GetUserDTO;
use App\DTOs\User\UpdateUserDTO;
use App\DTOs\User\UpdateUserRoleDTO;
use App\DTOs\User\UserFilterDTO;
use App\Features\User\DeleteUserFeature;
use App\Features\User\FilterUsersFeature;
use App\Features\User\GetUserFeature;
use App\Features\User\GetUsersFeature;
use App\Features\User\UpdateUserFeature;
use App\Features\User\UpdateUserRoleFeature;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UpdateUserRoleRequest;
use App\Http\Requests\User\UserFilterRequest;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Get all users (admin only)
     */
    public function index(GetUsersFeature $feature): JsonResponse
    {
        try {
            $users = $feature->handle();

            return response()->json([
                'success' => true,
                'message' => 'Users retrieved successfully',
                'data' => $users,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get filtered users (admin only)
     */
    public function filter(
        UserFilterRequest $request,
        FilterUsersFeature $feature
    ): JsonResponse {
        try {
            $dto = UserFilterDTO::fromRequest($request);
            $users = $feature->handle($dto);

            return response()->json([
                'success' => true,
                'message' => 'Users filtered successfully',
                'data' => $users,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show single user
     */
    public function show(string $id, GetUserFeature $feature): JsonResponse
    {
        try {
            $dto = new GetUserDTO($id);
            $user = $feature->handle($dto);

            return response()->json([
                'success' => true,
                'message' => 'User retrieved successfully',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() ?? 500);
        }
    }

    /**
     * Update user profile
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
                'success' => true,
                'message' => 'User updated successfully',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() ?? 500);
        }
    }

    /**
     * Update user role (admin only)
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
                'success' => true,
                'message' => 'User role updated successfully',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() ?? 500);
        }
    }

    /**
     * Delete user (admin only)
     */
    public function destroy(string $id, DeleteUserFeature $feature): JsonResponse
    {
        try {
            $feature->handle($id);

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() ?? 500);
        }
    }
}
