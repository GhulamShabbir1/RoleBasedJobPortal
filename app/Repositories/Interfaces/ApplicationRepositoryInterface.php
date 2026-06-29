<?php

namespace App\Repositories\Interfaces;

use App\Models\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ApplicationRepositoryInterface
{
    public function findById(string $id): ?Application;

    public function getApplicationById(int $id): ?Application;

    public function getApplicationStatusById(int $id): ?string;

    public function filterApplicationsByCandidateId(int $candidateId, array $filters): LengthAwarePaginator;

    public function filterApplicationsByEmployerId(int $employerId, array $filters): LengthAwarePaginator;

    public function filterAllApplications(array $filters): LengthAwarePaginator;

    public function createApplication(array $data): Application;

    public function updateApplication(int $id, array $data): Application;

    public function deleteApplication(int $id): bool;
}
