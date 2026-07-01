<?php

namespace App\Repositories\Eloquent;

use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class CompanyRepository implements CompanyRepositoryInterface
{
    private const CACHE_KEY = 'companies:';
    private const CACHE_TTL = 3600;

    /**
     * Create or update company using single manage method
     */
    public function manage(array $data, ?int $id = null): Company
    {
        if ($id === null) {
            // Create new company
            $company = Company::create($data);
        } else {
            // Update existing company
            $company = Company::findOrFail($id);
            $company->update($data);
        }

        // Clear cache
        $this->clearCache();

        return $company;
    }

    /**
     * Find company by ID
     */
    public function findById(int $id): ?Company
    {
        return Company::find($id);
    }

    /**
     * Get all companies with optional filters and pagination
     */
    public function getAll(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Company::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('city', 'like', "%$search%");
            });
        }

        if (isset($filters['city'])) {
            $query->where('city', $filters['city']);
        }

        if (isset($filters['country'])) {
            $query->where('country', $filters['country']);
        }

        return $query->paginate($perPage);
    }

    /**
     * Delete company record
     */
    public function delete(int $id): bool
    {
        $company = Company::find($id);

        if (!$company) {
            return false;
        }

        $this->clearCache();
        return $company->delete();
    }

    /**
     * Find company by email
     */
    public function findByEmail(string $email): ?Company
    {
        return Company::where('email', $email)->first();
    }

    /**
     * Find company by user ID
     */
    public function getByUserId(int $userId): ?Company
    {
        return Company::where('user_id', $userId)->first();
    }

    /**
     * Clear related cache
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY . '*');
    }
}
