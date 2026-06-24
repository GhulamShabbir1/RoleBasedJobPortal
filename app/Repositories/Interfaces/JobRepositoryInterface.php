<?php

namespace App\Repositories\Interfaces;

use App\Models\Job;
use Illuminate\Support\Collection;

interface JobRepositoryInterface
{
    /**
     * Create a new job in the database
     */
    public function createJob(array $data): Job;

    /**
     * Find job by id
     */
    public function findById(string $id): ?Job;

    /**
     * Update a job in the database
     */
    public function updateJob(string $id, array $data): bool;

    /**
     * Delete a job in the database
     */
    public function deleteJob(string $id): bool;

    /**
     * Get all jobs
     */
    public function getAllJobs(): Collection;

    /**
     * Get jobs by company id
     */
    public function getJobsByCompanyId(string $companyId): Collection;

    /**
     * Get jobs by category id
     */
    public function getJobsByCategoryId(string $categoryId): Collection;

    /**
     * Get jobs by job type
     */
    public function getJobsByJobType(string $jobType): Collection;

    /**
     * Get jobs by location
     */
    public function getJobsByLocation(string $location): Collection;

    /**
     * Get jobs by salary range
     */
    public function getJobsBySalaryRange(int $minSalary, int $maxSalary): Collection;

    /**
     * Get jobs by status
     */
    public function getJobsByStatus(string $status): Collection;

    /**
     * Get jobs by deadline
     */
    public function getJobsByDeadline(string $deadline): Collection;

    /**
     * Get jobs by user id
     */
    public function getJobsByUserId(string $userId): Collection;

    /**
     * Get jobs by search query
     */
    public function searchJobs(string $query): Collection;

    /**
     * Filter and paginate jobs
     */
    public function filterJobs(array $filters, int $page, int $perPage, ?string $role = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
}
