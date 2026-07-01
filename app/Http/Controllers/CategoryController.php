<?php

namespace App\Http\Controllers;

use App\DTOs\Category\CategoryFilterDTO;
use App\DTOs\Category\CreateCategoryDTO;
use App\DTOs\Category\GetCategoryDTO;
use App\DTOs\Category\UpdateCategoryDTO;
use App\Features\Category\CreateCategoryFeature;
use App\Features\Category\DeleteCategoryFeature;
use App\Features\Category\FilterCategoriesFeature;
use App\Features\Category\GetCategoriesFeature;
use App\Features\Category\GetCategoryFeature;
use App\Features\Category\UpdateCategoryFeature;
use App\Http\Requests\Category\CategoryFilterRequest;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use Illuminate\Http\JsonResponse;

/**
 * CategoryController
 *
 * Provides public access to job categories and admin capabilities
 * for category management (CRUD operations).
 */
class CategoryController extends Controller
{
  /**
   * Get all categories (public access)
   *
   * @param GetCategoriesFeature $feature Feature class for retrieving categories
   * @return JsonResponse JSON response with all categories
   */
  public function index(GetCategoriesFeature $feature): JsonResponse
  {
    try {
      $categories = $feature->handle();

      return response()->json([
        'status' => true,
        'message' => 'Categories retrieved successfully',
        'data' => $categories,
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
   * Filter categories (public access)
   *
   * @param CategoryFilterRequest $request HTTP request with filter criteria
   * @param FilterCategoriesFeature $feature Feature class for filtering categories
   * @return JsonResponse Paginated JSON response with filtered categories
   */
  public function filter(
    CategoryFilterRequest $request,
    FilterCategoriesFeature $feature
  ): JsonResponse {
    try {
      $dto = CategoryFilterDTO::fromRequest($request);
      $paginated = $feature->handle($dto);

      return response()->json([
        'status' => true,
        'message' => 'Categories filtered successfully',
        'data' => $paginated->items(),
        'pagination' => [
          'total' => $paginated->total(),
          'per_page' => $paginated->perPage(),
          'current_page' => $paginated->currentPage(),
          'last_page' => $paginated->lastPage(),
        ],
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
   * Store a new category (admin only)
   *
   * @param StoreCategoryRequest $request HTTP request with category details
   * @param CreateCategoryFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with created category
   */
  public function store(
    StoreCategoryRequest $request,
    CreateCategoryFeature $feature
  ): JsonResponse {
    try {
      $dto = CreateCategoryDTO::fromRequest($request);
      $category = $feature->handle($dto);

      return response()->json([
        'status' => true,
        'message' => 'Category created successfully',
        'data' => $category,
      ], 201);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], 500);
    }
  }

  /**
   * Show single category (public access)
   *
   * @param string $id Category identifier
   * @param GetCategoryFeature $feature Feature class for retrieving category
   * @return JsonResponse JSON response with category data
   */
  public function show(string $id, GetCategoryFeature $feature): JsonResponse
  {
    try {
      $dto = new GetCategoryDTO($id);
      $category = $feature->handle($dto);

      return response()->json([
        'status' => true,
        'message' => 'Category retrieved successfully',
        'data' => $category,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() ?? 500);
    }
  }

  /**
   * Update category (admin only)
   *
   * @param string $id Category identifier
   * @param UpdateCategoryRequest $request HTTP request with updated category details
   * @param UpdateCategoryFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with updated category
   */
  public function update(
    string $id,
    UpdateCategoryRequest $request,
    UpdateCategoryFeature $feature
  ): JsonResponse {
    try {
      $dto = UpdateCategoryDTO::fromRequest($request);
      $category = $feature->handle($dto);

      return response()->json([
        'status' => true,
        'message' => 'Category updated successfully',
        'data' => $category,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() ?? 500);
    }
  }

  /**
   * Delete category (admin only)
   *
   * @param string $id Category identifier
   * @param DeleteCategoryFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with deletion status
   */
  public function destroy(string $id, DeleteCategoryFeature $feature): JsonResponse
  {
    try {
      $feature->handle($id);

      return response()->json([
        'status' => true,
        'message' => 'Category deleted successfully',
        'data' => [],
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() ?? 500);
    }
  }
}
