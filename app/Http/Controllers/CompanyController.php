<?php

namespace App\Http\Controllers;

use App\DTOs\Company\ApproveCompanyDTO;
use App\DTOs\Company\CompanyFilterDTO;
use App\DTOs\Company\CreateCompanyDTO;
use App\DTOs\Company\RejectCompanyDTO;
use App\DTOs\Company\UpdateCompanyDTO;
use App\Features\Company\ApproveCompanyFeature;
use App\Features\Company\CreateCompanyFeature;
use App\Features\Company\DeleteCompanyFeature;
use App\Features\Company\FilterCompaniesFeature;
use App\Features\Company\GetCompanyFeature;
use App\Features\Company\RejectCompanyFeature;
use App\Features\Company\UpdateCompanyFeature;
use App\Http\Requests\Company\ApproveCompanyRequest;
use App\Http\Requests\Company\CreateCompanyRequest;
use App\Http\Requests\Company\ListCompaniesRequest;
use App\Http\Requests\Company\RejectCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use Illuminate\Http\JsonResponse;

/**
 * CompanyController
 * THIN controller - Request → DTO → Feature → Response
 * No business logic, no validation, no database queries
 */
class CompanyController extends Controller
{
    /**
     * Create a new company
     */
    public function store(
        CreateCompanyRequest $request,
        CreateCompanyFeature $feature
    ): JsonResponse {
        try {
            $dto = CreateCompanyDTO::fromRequest($request);
            $company = $feature->handle($dto);

            return response()->json([
                'success' => true,
                'message' => 'Company created successfully',
                'data' => $company,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * List all companies
     */
    public function index(ListCompaniesRequest $request, FilterCompaniesFeature $feature): JsonResponse
    {
        try {
            $dto = CompanyFilterDTO::fromRequest($request);
            $result = $feature->handle($dto);

            return response()->json([
                'success' => true,
                'data' => $result['data'],
                'pagination' => $result['pagination'],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get a single company
     */
    public function show(
        int $company,
        GetCompanyFeature $feature
    ): JsonResponse {
        try {
            $company = $feature->handle($company);

            return response()->json([
                'success' => true,
                'data' => $company,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Update a company
     */
    public function update(
        int $company,
        UpdateCompanyRequest $request,
        UpdateCompanyFeature $feature
    ): JsonResponse {
        try {
            $dto = UpdateCompanyDTO::fromRequest($request);
            $updatedCompany = $feature->handle($company, $dto);

            return response()->json([
                'success' => true,
                'message' => 'Company updated successfully',
                'data' => $updatedCompany,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a company
     */
    public function destroy(
        int $company,
        DeleteCompanyFeature $feature
    ): JsonResponse {
        try {
            $feature->handle($company);

            return response()->json([
                'success' => true,
                'message' => 'Company deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Approve a company
     */
    public function approve(
        ApproveCompanyRequest $request,
        ApproveCompanyFeature $feature
    ): JsonResponse {
        try {
            $dto = ApproveCompanyDTO::fromRequest($request);
            $company = $feature->handle($dto);

            return response()->json([
                'success' => true,
                'message' => 'Company approved successfully',
                'data' => $company,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Reject a company
     */
    public function reject(
        RejectCompanyRequest $request,
        RejectCompanyFeature $feature
    ): JsonResponse {
        try {
            $dto = RejectCompanyDTO::fromRequest($request);
            $company = $feature->handle($dto);

            return response()->json([
                'success' => true,
                'message' => 'Company rejected successfully',
                'data' => $company,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
