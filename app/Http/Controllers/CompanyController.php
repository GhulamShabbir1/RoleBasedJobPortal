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
 *
 * Manages company registration, listing, filtering, and admin approval/rejection.
 * THIN controller - Request → DTO → Feature → Response
 * No business logic, no validation, no database queries
 */
class CompanyController extends Controller
{
  /**
   * Create a new company
   *
   * @param CreateCompanyRequest $request HTTP request with company details
   * @param CreateCompanyFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with created company data
   */
  public function store(
    CreateCompanyRequest $request,
    CreateCompanyFeature $feature
  ): JsonResponse {
    try {
      $dto = CreateCompanyDTO::fromRequest($request);
      $company = $feature->handle($dto);

      return response()->json([
        'status' => true,
        'message' => 'Company created successfully',
        'data' => $company,
      ], 201);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }

  /**
   * List all companies
   *
   * @param ListCompaniesRequest $request HTTP request with filter criteria
   * @param FilterCompaniesFeature $feature Feature class for filtering companies
   * @return JsonResponse JSON response with paginated companies
   */
  public function index(ListCompaniesRequest $request, FilterCompaniesFeature $feature): JsonResponse
  {
    try {
      $dto = CompanyFilterDTO::fromRequest($request);
      $result = $feature->handle($dto);

      return response()->json([
        'status' => true,
        'message' => 'Companies retrieved successfully',
        'data' => $result['data'],
        'pagination' => $result['pagination'],
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], 500);
    }
  }

  /**
   * Get a single company
   *
   * @param int $company Company identifier
   * @param GetCompanyFeature $feature Feature class for retrieving company
   * @return JsonResponse JSON response with company data
   */
  public function show(
    int $company,
    GetCompanyFeature $feature
  ): JsonResponse {
    try {
      $company = $feature->handle($company);

      return response()->json([
        'status' => true,
        'message' => 'Company retrieved successfully',
        'data' => $company,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], 404);
    }
  }

  /**
   * Update a company
   *
   * @param int $company Company identifier
   * @param UpdateCompanyRequest $request HTTP request with updated company details
   * @param UpdateCompanyFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with updated company data
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
        'status' => true,
        'message' => 'Company updated successfully',
        'data' => $updatedCompany,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], 500);
    }
  }

  /**
   * Delete a company
   *
   * @param int $company Company identifier
   * @param DeleteCompanyFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with deletion status
   */
  public function destroy(
    int $company,
    DeleteCompanyFeature $feature
  ): JsonResponse {
    try {
      $feature->handle($company);

      return response()->json([
        'status' => true,
        'message' => 'Company deleted successfully',
        'data' => [],
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], 500);
    }
  }

  /**
   * Approve a company
   *
   * @param ApproveCompanyRequest $request HTTP request with approval details
   * @param ApproveCompanyFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with approved company data
   */
  public function approve(
    ApproveCompanyRequest $request,
    ApproveCompanyFeature $feature
  ): JsonResponse {
    try {
      $dto = ApproveCompanyDTO::fromRequest($request);
      $company = $feature->handle($dto);

      return response()->json([
        'status' => true,
        'message' => 'Company approved successfully',
        'data' => $company,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], 500);
    }
  }

  /**
   * Reject a company
   *
   * @param RejectCompanyRequest $request HTTP request with rejection details
   * @param RejectCompanyFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with rejected company data
   */
  public function reject(
    RejectCompanyRequest $request,
    RejectCompanyFeature $feature
  ): JsonResponse {
    try {
      $dto = RejectCompanyDTO::fromRequest($request);
      $company = $feature->handle($dto);

      return response()->json([
        'status' => true,
        'message' => 'Company rejected successfully',
        'data' => $company,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], 500);
    }
  }
}
