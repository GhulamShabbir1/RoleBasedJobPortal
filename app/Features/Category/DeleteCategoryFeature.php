<?php

namespace App\Features\Category;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Exception;

class DeleteCategoryFeature
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository
    ) {
    }

    /**
     * Delete a category
     *
     * @param string $categoryId Category ID to delete
     * @return bool
     * @throws Exception
     */
    public function handle(string $categoryId): bool
    {
        try {
            $category = $this->categoryRepository->findById($categoryId);

            if (!$category) {
                throw new Exception('Category not found', 404);
            }

            return $this->categoryRepository->deleteCategory($categoryId);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
