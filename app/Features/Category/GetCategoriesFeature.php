<?php

namespace App\Features\Category;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;

class GetCategoriesFeature
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository
    ) {
    }

    /**
     * Get all categories
     *
     * @return Collection
     * @throws Exception
     */
    public function handle(): Collection
    {
        try {
            return $this->categoryRepository->getAllCategories();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
