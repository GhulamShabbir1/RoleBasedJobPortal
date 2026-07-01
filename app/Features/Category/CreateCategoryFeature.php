<?php

namespace App\Features\Category;

use App\DTOs\Category\CreateCategoryDTO;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Exceptions\ForbiddenException;

class CreateCategoryFeature
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository
    ) {
    }

    /**
     * Create a new category using repository manage()
     */
    public function handle(CreateCategoryDTO $dto): Category
    {
        // Prevent duplicate category names
        $existing = $this->categoryRepository->findByName($dto->name);
        if ($existing) {
            throw new ForbiddenException('A category with this name already exists');
        }

        // Use manage() method with null ID to create category
        return $this->categoryRepository->manage($dto->toArray());
    }
}
