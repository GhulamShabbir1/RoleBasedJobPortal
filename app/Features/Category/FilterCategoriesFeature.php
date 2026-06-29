<?php

namespace App\Features\Category;

use App\DTOs\Category\CategoryFilterDTO;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class FilterCategoriesFeature
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository
    ) {
    }

    /**
     * Filter categories by search and pagination
     *
     * @param CategoryFilterDTO $dto Filter criteria
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function handle(CategoryFilterDTO $dto): LengthAwarePaginator
    {
        try {
            return $this->categoryRepository->filterCategories(
                search: $dto->search,
                page: $dto->page,
                perPage: $dto->perPage
            );
        } catch (Exception $e) {
            throw $e;
        }
    }
}
