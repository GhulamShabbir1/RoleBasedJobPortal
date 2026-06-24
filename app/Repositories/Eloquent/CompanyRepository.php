<?php

namespace App\Repositories\Eloquent;

use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * CompanyRepository
 * Database operations ONLY - no business logic
 * Implements CompanyRepositoryInterface
 */
class CompanyRepository implements CompanyRepositoryInterface
{
    /**
     * Create a new company record
     *
     * @param array $data Company data
     * @return Company
     */
    public function create(array $data): Company
    {
        return Company::create($data);
    }

    /**
     * Find company by ID
     *
     * @param int $id Company ID
     * @return Company|null
     */
    public function findById(int $id): ?Company
    {
        return Company::find($id);
    }

    /**
     * Get all companies with optional filters and pagination
     *
     * @param array $filters Filter criteria
     * @param int $perPage Pagination limit
     * @return LengthAwarePaginator
     */
    public function getAll(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Company::query();

        // Apply status filter if provided
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Apply search filter if provided
        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('city', 'like', "%$search%");
            });
        }

        // Apply city filter if provided
        if (isset($filters['city'])) {
            $query->where('city', $filters['city']);
        }

        // Apply country filter if provided
        if (isset($filters['country'])) {
            $query->where('country', $filters['country']);
        }

        return $query->paginate($perPage);
    }

    /**
     * Update company record
     *
     * @param Company $company Company instance
     * @param array $data Data to update
     * @return Company
     */
    public function update(Company $company, array $data): Company
    {
        $company->update($data);

        return $company;
    }

    /**
     * Delete company record
     *
     * @param Company $company Company instance
     * @return bool
     */
    public function delete(Company $company): bool
    {
        return $company->delete();
    }

    /**
     * Find company by email
     *
     * @param string $email Company email
     * @return Company|null
     */
    public function findByEmail(string $email): ?Company
    {
        return Company::where('email', $email)->first();
    }

    /**
     * Find company by user ID
     *
     * @param int $userId User ID
     * @return Company|null
     */
    public function getByUserId(int $userId): ?Company
    {
        return Company::where('user_id', $userId)->first();
    }

    /**
     * Update company status
     *
     * @param Company $company Company instance
     * @param string $status New status
     * @param string|null $notes Optional status notes
     * @return Company
     */
    public function updateStatus(Company $company, string $status, ?string $notes = null): Company
    {
        $company->update([
            'status' => $status,
        ]);

        return $company;
    }
}
