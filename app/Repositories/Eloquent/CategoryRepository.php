<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected $model;

    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    /**
     * Get all categories
     */
    public function getAllCategories(): Collection
    {
        return $this->model->all();
    }

    /**
     * Find category by ID
     */
    public function findById(string $id): ?Category
    {
        return $this->model->find($id);
    }

    /**
     * Find category by name
     */
    public function findByName(string $name): ?Category
    {
        return $this->model->where('name', $name)->first();
    }

    /**
     * Create a new category
     */
    public function createCategory(array $data): Category
    {
        return $this->model->create($data);
    }

    /**
     * Update category
     */
    public function updateCategory(string $id, array $data): bool
    {
        $category = $this->findById($id);

        if (!$category) {
            return false;
        }

        return $category->update($data);
    }

    /**
     * Delete category
     */
    public function deleteCategory(string $id): bool
    {
        $category = $this->findById($id);

        if (!$category) {
            return false;
        }

        return $category->delete();
    }

    /**
     * Filter categories by search
     */
    public function filterCategories(?string $search = null, int $page = 1, int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->query();

        if ($search) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
