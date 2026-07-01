<?php

namespace App\Repositories\Interfaces;

use App\Models\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ApplicationRepositoryInterface
{
    /**
     * Create or update application using single manage method
     */
    public function manage(array $data, ?int $id = null): Application;

    public function findById(string $id): ?Application;

    public function getApplicationById(int $id): ?Application;

    public function getApplicationStatusById(int $id): ?string;

    public function filterApplicationsByCandidateId(int $candidateId, array $filters): LengthAwarePaginator;

    public function filterApplicationsByEmployerId(int $employerId, array $filters): LengthAwarePaginator;

    public function filterAllApplications(array $filters): LengthAwarePaginator;

    /**
     * Delete application
     */
    public function delete(int $id): bool;

    /**
     * Delete application (legacy)
     */
    public function deleteApplication(int $id): bool;

    /**
     * Clear related cache
     */
    public function clearCache(): void;
}
