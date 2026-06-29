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

class CategoryController extends Controller
{
    /**
     * Get all categories (public access)
     */
    public function index(GetCategoriesFeature $feature): JsonResponse
    {
        try {
            $categories = $feature->handle();

            return response()->json([
                'success' => true,
                'message' => 'Categories retrieved successfully',
                'data' => $categories,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Filter categories (public access)
     */
    public function filter(
        CategoryFilterRequest $request,
        FilterCategoriesFeature $feature
    ): JsonResponse {
        try {
            $dto = CategoryFilterDTO::fromRequest($request);
            $paginated = $feature->handle($dto);

            return response()->json([
                'success' => true,
                'message' => 'Categories filtered successfully',
                'data' => $paginated->items(),
                'pagination' => [
                    'total' => $paginated->total(),
                    'per_page' => $paginated->perPage(),
                    'current_page' => $paginated->currentPage(),
                    'last_page' => $paginated->lastPage(),
                    'from' => $paginated->firstItem(),
                    'to' => $paginated->lastItem(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a new category (admin only)
     */
    public function store(
        StoreCategoryRequest $request,
        CreateCategoryFeature $feature
    ): JsonResponse {
        try {
            $dto = CreateCategoryDTO::fromRequest($request);
            $category = $feature->handle($dto);

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully',
                'data' => $category,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show single category (public access)
     */
    public function show(string $id, GetCategoryFeature $feature): JsonResponse
    {
        try {
            $dto = new GetCategoryDTO($id);
            $category = $feature->handle($dto);

            return response()->json([
                'success' => true,
                'message' => 'Category retrieved successfully',
                'data' => $category,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() ?? 500);
        }
    }

    /**
     * Update category (admin only)
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
                'success' => true,
                'message' => 'Category updated successfully',
                'data' => $category,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() ?? 500);
        }
    }

    /**
     * Delete category (admin only)
     */
    public function destroy(string $id, DeleteCategoryFeature $feature): JsonResponse
    {
        try {
            $feature->handle($id);

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() ?? 500);
        }
    }
}
