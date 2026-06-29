<?php

namespace App\Http\Controllers;

use App\Features\Employer\GetEmployerStatusFeature;
use Exception;
use Illuminate\Http\JsonResponse;

class EmployerController extends Controller
{
    /**
     * Get employer status (company registration & approval)
     *
     * This endpoint should be called after login or on dashboard load
     * to determine if the employer needs to register a company first
     */
    public function getStatus(GetEmployerStatusFeature $feature): JsonResponse
    {
        try {
            $status = $feature->handle();

            return response()->json([
                'success' => true,
                'data' => $status,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
        }
    }
}
