<?php

namespace App\Repositories\Interfaces;

use App\Models\Company;
use Illuminate\Pagination\LengthAwarePaginator;

interface CompanyRepositoryInterface
{
    /**
     * Create or update company using single manage method
     */
    public function manage(array $data, ?int $id = null): Company;

    /**
     * Find company by ID
     */
    public function findById(int $id): ?Company;

    /**
     * Get all companies with optional filters and pagination
     */
    public function getAll(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    /**
     * Delete company record
     */
    public function delete(int $id): bool;

    /**
     * Find company by email
     */
    public function findByEmail(string $email): ?Company;

    /**
     * Find company by user ID
     */
    public function getByUserId(int $userId): ?Company;

    /**
     * Clear related cache
     */
    public function clearCache(): void;
}
