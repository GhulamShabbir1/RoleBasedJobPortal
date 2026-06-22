<?php

namespace App\Repositories\Interfaces;

use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
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
     * Create a new category
     */
    public function createCategory(array $data): Category;

    /**
     * Update category
     */
    public function updateCategory(string $id, array $data): bool;

    /**
     * Delete category
     */
    public function deleteCategory(string $id): bool;

    /**
     * Filter categories by search
     */
    public function filterCategories(?string $search = null, int $page = 1, int $perPage = 15): Paginator;
}
