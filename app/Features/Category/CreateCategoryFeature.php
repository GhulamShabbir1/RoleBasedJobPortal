<?php

namespace App\Features\Category;

use App\DTOs\Category\CreateCategoryDTO;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Exception;

class CreateCategoryFeature
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository
    ) {
    }

    /**
     * Create a new category
     *
     * @param CreateCategoryDTO $dto Category data
     * @return Category
     * @throws Exception
     */
    public function handle(CreateCategoryDTO $dto): Category
    {
        try {
            // Prevent duplicate category names
            $existing = $this->categoryRepository->findByName($dto->name);
            if ($existing) {
                throw new Exception('A category with this name already exists', 409);
            }

            return $this->categoryRepository->createCategory($dto->toArray());
        } catch (Exception $e) {
            throw $e;
        }
    }
}
