<?php

namespace App\Http\Controllers;

use App\DTOs\Application\ApplyApplicationDTO;
use App\DTOs\Application\ApplicationFilterDTO;
use App\DTOs\Application\UpdateApplicationStatusDTO;
use App\Features\Application\ApplyApplicationFeature;
use App\Features\Application\DeleteApplicationFeature;
use App\Features\Application\FilterApplicationsFeature;
use App\Features\Application\GetApplicationFeature;
use App\Features\Application\GetApplicationsFeature;
use App\Features\Application\UpdateApplicationStatusFeature;
use App\Http\Requests\Application\ApplyApplicationRequest;
use App\Http\Requests\Application\ApplicationFilterRequest;
use App\Http\Requests\Application\UpdateApplicationStatusRequest;
use Illuminate\Http\JsonResponse;

class ApplicationController extends Controller
{
    /**
     * Get all applications with optional filters
     */
    public function index(
        ApplicationFilterRequest $request,
        FilterApplicationsFeature $feature
    ): JsonResponse {
        try {
            $dto = ApplicationFilterDTO::fromRequest($request);
            $applications = $feature->handle($dto);

            return response()->json([
                'success' => true,
                'data' => $applications,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get a single application
     */
    public function show(
        string $id,
        GetApplicationFeature $feature
    ): JsonResponse {
        try {
            $application = $feature->handle($id);

            return response()->json([
                'success' => true,
                'data' => $application,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Apply for a job
     */
    public function store(
        ApplyApplicationRequest $request,
        ApplyApplicationFeature $feature
    ): JsonResponse {
        try {
            $dto = ApplyApplicationDTO::fromRequest($request);
            $application = $feature->handle($dto);

            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully',
                'data' => $application,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Update application status
     */
    public function update(
        string $id,
        UpdateApplicationStatusRequest $request,
        UpdateApplicationStatusFeature $feature
    ): JsonResponse {
        try {
            $dto = UpdateApplicationStatusDTO::fromRequest($request);
            $success = $feature->handle($id, $dto);

            if (!$success) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update application',
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Application updated successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Delete an application
     */
    public function destroy(
        string $id,
        DeleteApplicationFeature $feature
    ): JsonResponse {
        try {
            $success = $feature->handle($id);

            if (!$success) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete application',
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Application deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
        }
    }
}
