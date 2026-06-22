<?php

namespace App\Repositories\Interfaces;

use App\Models\Application;

interface ApplicationRepositoryInterface
{
    /**
     * Create a new application in the database
     */
    public function createApplication(array $data): Application;

    /**
     * Find application by id
     */
    public function findById(string $id): ?Application;

    /**
     * Attempt to apply for a job
     */
    public function applyForJob(array $credentials): ?string;

    /**
     * Get currently authenticated user
     */
    public function getCurrentUser(): ?Application;

    /**
     * Invalidate the current application
     */
    public function invalidateApplication(): bool;

    /**
     * Get all applications
     */
    public function getAllApplications(): Collection;

    /**
     * Get applications by company id
     */
    public function getApplicationsByCompanyId(string $companyId): Collection;

    /**
     * Get applications by job id
     */
    public function getApplicationsByJobId(string $jobId): Collection;

    /**
     * Get applications by user id
     */
    public function getApplicationsByUserId(string $userId): Collection;

    /**
     * Get application status by id
     */
    public function getApplicationStatusById(string $id): ?Application;

    /**
     * Get applications by job id and status
     */
    public function getApplicationsByJobIdAndStatus(string $jobId, string $status): Collection;

    /**
     * Get applications by status
     */
    public function getApplicationsByStatus(string $status): Collection;

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
}
