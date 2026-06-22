<?php

namespace App\Features\Category;

use App\DTOs\Category\UpdateCategoryDTO;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Exception;

class UpdateCategoryFeature
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository
    ) {
    }

    /**
     * Update a category
     *
     * @param UpdateCategoryDTO $dto Category data to update
     * @return Category
     * @throws Exception
     */
    public function handle(UpdateCategoryDTO $dto): Category
    {
        try {
            $category = $this->categoryRepository->findById($dto->id);

            if (!$category) {
                throw new Exception('Category not found', 404);
            }

            $data = $dto->toArray();

            if (!empty($data)) {
                $this->categoryRepository->updateCategory($dto->id, $data);
            }

            return $this->categoryRepository->findById($dto->id);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
