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

/**
 * ApplicationController
 *
 * Manages job applications including status updates, resume downloads,
 * and filtering applications by role (candidate/employer/admin).
 */
class ApplicationController extends Controller
{
  public function __construct(
    private readonly FilterApplicationsByRoleFeature $filterApplicationsByRoleFeature,
    private readonly DownloadResumeFeature $downloadResumeFeature
  ) {
  }

  /**
   * Get all applications with optional filters
   *
   * @param ApplicationFilterRequest $request HTTP request with filter criteria
   * @return JsonResponse JSON response with applications
   */
  public function index(
    ApplicationFilterRequest $request
  ): JsonResponse {
    try {
      $dto = ApplicationFilterDTO::fromRequest($request);
      $applications = $this->filterApplicationsByRoleFeature->handle($dto->toArray());

      // If limit is provided, return just the first N items as a collection
      $limit = $request->query('limit');
      if ($limit && is_numeric($limit)) {
        $applications = $applications->take((int)$limit);
      }

      return response()->json([
        'status' => true,
        'message' => 'Applications retrieved successfully',
        'data' => $applications instanceof \Illuminate\Pagination\LengthAwarePaginator ? $applications->items() : $applications,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }

  /**
   * Get a single application
   *
   * @param string $id Application identifier
   * @param GetApplicationFeature $feature Feature class for retrieving application
   * @return JsonResponse JSON response with application data
   */
  public function show(
    string $id,
    GetApplicationFeature $feature
  ): JsonResponse {
    try {
      $application = $feature->handle($id);

      return response()->json([
        'status' => true,
        'message' => 'Application retrieved successfully',
        'data' => $application,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }

  /**
   * Update application status (employer review)
   *
   * @param string $id Application identifier
   * @param UpdateApplicationStatusRequest $request HTTP request with new status
   * @param UpdateApplicationStatusFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with update status
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
          'status' => false,
          'message' => 'Failed to update application',
          'errors' => [],
        ], 400);
      }

      return response()->json([
        'status' => true,
        'message' => 'Application updated successfully',
        'data' => [],
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }

  /**
   * Update application status (admin/old)
   *
   * @param string $id Application identifier
   * @param UpdateApplicationStatusRequest $request HTTP request with new status
   * @param UpdateApplicationStatusFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with update status
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
          'status' => false,
          'message' => 'Failed to update application',
          'errors' => [],
        ], 400);
      }

      return response()->json([
        'status' => true,
        'message' => 'Application updated successfully',
        'data' => [],
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }

  /**
   * Download a resume
   *
   * @param string $id Application identifier
   * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|JsonResponse Resume file or error response
   */
  public function downloadResume(string $id): \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\JsonResponse
  {
    try {
      return $this->downloadResumeFeature->handle($id);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], 404);
    } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], 403);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], 400);
    }
  }

  /**
   * Spec-aligned: GET /api/resumes/download/{application_id}
   *
   * @param int $application_id Application identifier
   * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|JsonResponse Resume file or error response
   */
  public function downloadResumeByApplicationId(int $application_id): \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\JsonResponse
  {
    return $this->downloadResume((string) $application_id);
  }

  /**
   * Delete an application
   *
   * @param string $id Application identifier
   * @param DeleteApplicationFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with deletion status
   */
  public function destroy(
    string $id,
    DeleteApplicationFeature $feature
  ): JsonResponse {
    try {
      $success = $feature->handle($id);

      if (!$success) {
        return response()->json([
          'status' => false,
          'message' => 'Failed to delete application',
          'errors' => [],
        ], 400);
      }

      return response()->json([
        'status' => true,
        'message' => 'Application deleted successfully',
        'data' => [],
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }
}
