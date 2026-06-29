<?php

namespace App\Features\Application;

use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;

class GetApplicationsFeature
{
    public function __construct(
        private readonly ApplicationRepositoryInterface $applicationRepository
    ) {
    }

    /**
     * Get all applications
     *
     * @return Collection
     * @throws Exception
     */
    public function handle(): Collection
    {
        try {
            $user = auth()->user();

            // Only admin can fetch all applications without filters
            if ($user->role !== 'admin') {
                throw new \Illuminate\Auth\Access\AuthorizationException('Only admin can view all applications', 403);
            }

            return $this->applicationRepository->getAllApplications();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
