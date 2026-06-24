<?php

namespace App\Repositories\Interfaces;

use App\Models\Company;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * CompanyRepositoryInterface
 * Database contract for company operations
 * Pure abstraction - no implementation
 */
interface CompanyRepositoryInterface
{
    /**
     * Create a new company record
     *
     * @param array $data Company data
     * @return Company
     */
    public function create(array $data): Company;

    /**
     * Find company by ID
     *
     * @param int $id Company ID
     * @return Company|null
     */
    public function findById(int $id): ?Company;

    /**
     * Get all companies with optional filters and pagination
     *
     * @param array $filters Filter criteria
     * @param int $perPage Pagination limit
     * @return LengthAwarePaginator
     */
    public function getAll(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    /**
     * Update company record
     *
     * @param Company $company Company instance
     * @param array $data Data to update
     * @return Company
     */
    public function update(Company $company, array $data): Company;

    /**
     * Delete company record
     *
     * @param Company $company Company instance
     * @return bool
     */
    public function delete(Company $company): bool;

    /**
     * Find company by email
     *
     * @param string $email Company email
     * @return Company|null
     */
    public function findByEmail(string $email): ?Company;

    /**
     * Find company by user ID
     *
     * @param int $userId User ID
     * @return Company|null
     */
    public function getByUserId(int $userId): ?Company;

    /**
     * Update company status
     *
     * @param Company $company Company instance
     * @param string $status New status
     * @param string|null $notes Optional status notes
     * @return Company
     */
    public function updateStatus(Company $company, string $status, ?string $notes = null): Company;
}
