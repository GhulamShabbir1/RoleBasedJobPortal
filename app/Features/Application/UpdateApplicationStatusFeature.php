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

            $user = auth()->user();
            // Check ownership (admin or job owner)
            $application->load('job');
            if ($user->role !== 'admin' && $application->job->user_id !== $user->id) {
                throw new \Illuminate\Auth\Access\AuthorizationException('You do not own this application');
            }

            // Validate status is in allowed list
            if (!in_array($dto->status, ['reviewed', 'accepted', 'rejected'])) {
                throw new Exception('Invalid status');
            }

            $this->applicationRepository->updateApplication((int)$applicationId, [
                'status' => $dto->status,
            ]);
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
