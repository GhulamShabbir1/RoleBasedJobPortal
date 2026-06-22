<?php

namespace App\Features\Application;

use App\Models\Application;
use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use Exception;

class GetApplicationFeature
{
    public function __construct(
        private readonly ApplicationRepositoryInterface $applicationRepository
    ) {
    }

    /**
     * Get a single application by ID
     *
     * @param string $applicationId Application ID
     * @return Application
     * @throws Exception
     */
    public function handle(string $applicationId): Application
    {
        try {
            $application = $this->applicationRepository->findById($applicationId);
            if (!$application) {
                throw new Exception('Application not found');
            }
            return $application;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
