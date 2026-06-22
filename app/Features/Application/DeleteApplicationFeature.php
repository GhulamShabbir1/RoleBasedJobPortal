<?php

namespace App\Features\Application;

use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use Exception;

class DeleteApplicationFeature
{
    public function __construct(
        private readonly ApplicationRepositoryInterface $applicationRepository
    ) {
    }

    /**
     * Delete an application
     *
     * @param string $applicationId Application ID
     * @return bool
     * @throws Exception
     */
    public function handle(string $applicationId): bool
    {
        try {
            $application = $this->applicationRepository->findById($applicationId);
            if (!$application) {
                throw new Exception('Application not found');
            }

            return $this->applicationRepository->deleteApplication($applicationId);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
