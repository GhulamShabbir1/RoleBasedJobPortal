<?php

namespace App\Http\Controllers;

use App\Features\Company\GetMyCompanyStatusFeature;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

/**
 * CompanyStatusController
 *
 * Handles company status retrieval for authenticated employer users.
 * Provides information about company registration and approval status.
 */
class CompanyStatusController extends Controller
{
  /**
   * Get current user's company status
   *
   * @param GetMyCompanyStatusFeature $feature Feature class for retrieving company status
   * @return JsonResponse JSON response with company status data
   */
  public function myCompanyStatus(GetMyCompanyStatusFeature $feature): JsonResponse
  {
    try {
      return response()->json([
        'status' => true,
        'message' => 'Company status retrieved successfully',
        'data' => $feature->handle(),
      ], 200);
    } catch (\Exception $e) {
      Log::warning('myCompanyStatus failed', ['error' => $e->getMessage()]);

      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], 401);
    }
  }
}


