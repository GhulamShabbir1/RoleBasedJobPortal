<?php

namespace App\Features\Category;

use App\DTOs\Category\GetCategoryDTO;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Exception;

class GetCategoryFeature
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository
    ) {
    }

    /**
     * Get a single category by ID
     *
     * @param GetCategoryDTO $dto Category ID
     * @return Category
     * @throws Exception
     */
    public function handle(GetCategoryDTO $dto): Category
    {
        try {
            $category = $this->categoryRepository->findById($dto->id);

            if (!$category) {
                throw new Exception('Category not found', 404);
            }

            return $category;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
