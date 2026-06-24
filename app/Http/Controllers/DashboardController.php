<?php

namespace App\Http\Controllers;

use App\Features\Dashboard\GetAdminStatsFeature;
use App\Features\Dashboard\GetCandidateStatsFeature;
use App\Features\Dashboard\GetEmployerStatsFeature;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function adminStats(): JsonResponse
    {
        try {
            $stats = (new GetAdminStatsFeature())->handle();
            return response()->json([
                'success' => true,
                'data' => $stats->toArray()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function employerStats(): JsonResponse
    {
        try {
            $stats = (new GetEmployerStatsFeature())->handle();
            return response()->json([
                'success' => true,
                'data' => $stats->toArray()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function candidateStats(): JsonResponse
    {
        try {
            $stats = (new GetCandidateStatsFeature())->handle();
            return response()->json([
                'success' => true,
                'data' => $stats->toArray()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
