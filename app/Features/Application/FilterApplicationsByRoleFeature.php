<?php

namespace App\Features\Application;

use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class FilterApplicationsByRoleFeature
{
    public function __construct(
        private readonly ApplicationRepositoryInterface $applicationRepository
    ) {
    }

    public function handle(array $filters = []): LengthAwarePaginator
    {
        $user = auth()->user();
        $userId = $user->id;
        $role = $user->role;

        if ($role === 'admin') {
            return $this->applicationRepository->filterAllApplications($filters);
        } elseif ($role === 'employer') {
            return $this->applicationRepository->filterApplicationsByEmployerId($userId, $filters);
        } elseif ($role === 'candidate') {
            return $this->applicationRepository->filterApplicationsByCandidateId($userId, $filters);
        }

        // Fallback if no valid role
        return $this->applicationRepository->filterAllApplications($filters);
    }
}
