<?php

namespace App\Features\Category;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Exceptions\ResourceNotFoundException;

class DeleteCategoryFeature
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository
    ) {
    }

    /**
     * Delete a category using repository delete()
     */
    public function handle(string $categoryId): bool
    {
        $category = $this->categoryRepository->findById($categoryId);

        if (!$category) {
            throw new ResourceNotFoundException('Category not found');
        }

        return $this->categoryRepository->delete((int)$categoryId);
    }
}
