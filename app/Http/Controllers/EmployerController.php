<?php

namespace App\Http\Controllers;

use App\Features\Employer\GetEmployerStatusFeature;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * EmployerController
 *
 * Handles employer-specific operations including status retrieval for
 * company registration and approval workflow.
 */
class EmployerController extends Controller
{
  /**
   * Get employer status (company registration & approval)
   *
   * This endpoint should be called after login or on dashboard load
   * to determine if the employer needs to register a company first.
   *
   * @param GetEmployerStatusFeature $feature Feature class for retrieving status
   * @return JsonResponse JSON response with employer status data
   */
  public function getStatus(GetEmployerStatusFeature $feature): JsonResponse
  {
    try {
      $status = $feature->handle();

      return response()->json([
        'status' => true,
        'message' => 'Employer status retrieved successfully',
        'data' => $status,
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }
}
