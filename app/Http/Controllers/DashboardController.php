<?php

namespace App\Http\Controllers;

use App\Features\Dashboard\GetAdminStatsFeature;
use App\Features\Dashboard\GetCandidateStatsFeature;
use App\Features\Dashboard\GetEmployerStatsFeature;
use Illuminate\Http\JsonResponse;

/**
 * DashboardController
 *
 * Provides dashboard statistics endpoints for different user roles:
 * admin, employer, and candidate. Returns role-specific metrics and analytics.
 */
class DashboardController extends Controller
{
  /**
   * Get admin dashboard statistics
   *
   * @return JsonResponse JSON response with admin statistics
   */
  public function adminStats(): JsonResponse
  {
    try {
      $stats = (new GetAdminStatsFeature())->handle();
      return response()->json([
        'status' => true,
        'message' => 'Admin statistics retrieved successfully',
        'data' => $stats->toArray()
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], 500);
    }
  }

  /**
   * Get employer dashboard statistics
   *
   * @return JsonResponse JSON response with employer statistics
   */
  public function employerStats(): JsonResponse
  {
    try {
      $stats = (new GetEmployerStatsFeature())->handle();
      return response()->json([
        'status' => true,
        'message' => 'Employer statistics retrieved successfully',
        'data' => $stats->toArray()
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], 500);
    }
  }

  /**
   * Get candidate dashboard statistics
   *
   * @return JsonResponse JSON response with candidate statistics
   */
  public function candidateStats(): JsonResponse
  {
    try {
      $stats = (new GetCandidateStatsFeature())->handle();
      return response()->json([
        'status' => true,
        'message' => 'Candidate statistics retrieved successfully',
        'data' => $stats->toArray()
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], 500);
    }
  }
}
