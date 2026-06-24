<?php

namespace App\Http\Controllers;

use App\DTOs\Application\ApplicationFilterDTO;
use App\DTOs\Application\UpdateApplicationStatusDTO;
use App\Features\Application\DeleteApplicationFeature;
use App\Features\Application\DownloadResumeFeature;
use App\Features\Application\FilterApplicationsByRoleFeature;
use App\Features\Application\GetApplicationFeature;
use App\Features\Application\UpdateApplicationStatusFeature;
use App\Http\Requests\Application\ApplicationFilterRequest;
use App\Http\Requests\Application\UpdateApplicationStatusRequest;
use Illuminate\Http\JsonResponse;

class ApplicationController extends Controller
{
    public function __construct(
        private readonly FilterApplicationsByRoleFeature $filterApplicationsByRoleFeature,
        private readonly DownloadResumeFeature $downloadResumeFeature
    ) {
    }

    /**
     * Get all applications with optional filters
     */
    public function index(
        ApplicationFilterRequest $request
    ): JsonResponse {
        try {
            $dto = ApplicationFilterDTO::fromRequest($request);
            $applications = $this->filterApplicationsByRoleFeature->handle($dto->toArray());

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
     * Update application status (employer review)
     */
    public function review(
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
            ], $e->getCode() ?? 400);
        }
    }

    /**
     * Update application status (admin/old)
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
     * Download a resume
     */
    public function downloadResume(string $id): \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\JsonResponse
    {
        try {
            return $this->downloadResumeFeature->handle($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 403);
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
