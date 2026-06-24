<?php

namespace App\Http\Controllers;

use App\Features\Company\GetMyCompanyStatusFeature;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CompanyStatusController extends Controller
{
    public function myCompanyStatus(GetMyCompanyStatusFeature $feature): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $feature->handle(),
            ], 200);
        } catch (\Exception $e) {
            Log::warning('myCompanyStatus failed', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 401);
        }
    }
}


