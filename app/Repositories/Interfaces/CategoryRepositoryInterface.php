<?php

namespace App\Repositories\Interfaces;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    /**
     * Create or update category using single manage method
     */
    public function manage(array $data, ?int $id = null): Category;

    /**
     * Get all categories
     */
    public function getAllCategories(): Collection;

    /**
     * Find category by ID
     */
    public function findById(string $id): ?Category;

    /**
     * Find category by name
     */
    public function findByName(string $name): ?Category;

    /**
     * Delete category
     */
    public function delete(int $id): bool;

    /**
     * Delete category (legacy)
     */
    public function deleteCategory(string $id): bool;

    /**
     * Filter categories by search
     */
    public function filterCategories(?string $search = null, int $page = 1, int $perPage = 15): LengthAwarePaginator;

    /**
     * Clear related cache
     */
    public function clearCache(): void;
}
