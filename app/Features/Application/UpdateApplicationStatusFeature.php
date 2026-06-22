<?php

namespace App\Features\Application;

use App\DTOs\Application\UpdateApplicationStatusDTO;
use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use Exception;

class UpdateApplicationStatusFeature
{
    public function __construct(
        private readonly ApplicationRepositoryInterface $applicationRepository
    ) {
    }

    /**
     * Update application status
     *
     * @param string $applicationId Application ID
     * @param UpdateApplicationStatusDTO $dto Status update data
     * @return bool
     * @throws Exception
     */
    public function handle(string $applicationId, UpdateApplicationStatusDTO $dto): bool
    {
        try {
            $application = $this->applicationRepository->findById($applicationId);
            if (!$application) {
                throw new Exception('Application not found');
            }

            return $this->applicationRepository->updateApplication($applicationId, [
                'status' => $dto->status,
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
