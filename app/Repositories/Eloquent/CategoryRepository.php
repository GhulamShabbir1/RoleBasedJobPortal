<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected $model;
    private const CACHE_KEY = 'categories:';
    private const CACHE_TTL = 3600;

    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    /**
     * Create or update category using single manage method
     */
    public function manage(array $data, ?int $id = null): Category
    {
        if ($id === null) {
            // Create new category
            $category = $this->model->create($data);
        } else {
            // Update existing category
            $category = $this->model->findOrFail($id);
            $category->update($data);
        }

        // Clear cache
        $this->clearCache();

        return $category;
    }

    /**
     * Get all categories with job counts
     */
    public function getAllCategories(): Collection
    {
        return $this->model->withCount('jobs')->get();
    }

    /**
     * Find category by ID with job count
     */
    public function findById(string $id): ?Category
    {
        return $this->model->withCount('jobs')->find($id);
    }

    /**
     * Find category by name with job count
     */
    public function findByName(string $name): ?Category
    {
        return $this->model->withCount('jobs')->where('name', $name)->first();
    }

    /**
     * Delete category
     */
    public function delete(int $id): bool
    {
        $category = $this->model->find($id);

        if (!$category) {
            return false;
        }

        $this->clearCache();
        return $category->delete();
    }

    /**
     * Legacy method for backward compatibility
     */
    public function deleteCategory(string $id): bool
    {
        return $this->delete((int)$id);
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

    /**
     * Clear related cache
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY . '*');
    }
}
