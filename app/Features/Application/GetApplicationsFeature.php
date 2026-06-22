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
            return $this->applicationRepository->getAllApplications();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
