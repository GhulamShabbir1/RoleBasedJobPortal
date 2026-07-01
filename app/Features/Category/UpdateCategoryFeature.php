<?php

namespace App\Features\Category;

use App\DTOs\Category\UpdateCategoryDTO;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Exceptions\ResourceNotFoundException;

class UpdateCategoryFeature
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository
    ) {
    }

    /**
     * Update a category using repository manage()
     */
    public function handle(UpdateCategoryDTO $dto): Category
    {
        $category = $this->categoryRepository->findById($dto->id);

        if (!$category) {
            throw new ResourceNotFoundException('Category not found');
        }

        $data = $dto->toArray();

        // Use manage() method with ID for update
        return $this->categoryRepository->manage($data, (int)$dto->id);
    }
}
