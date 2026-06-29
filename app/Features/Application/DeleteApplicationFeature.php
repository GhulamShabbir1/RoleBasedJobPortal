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
                throw new Exception('Application not found', 404);
            }

            $user = auth()->user();

            // Authorization: only admin or the job owner (employer) can delete
            $application->load('job');
            if ($user->role !== 'admin' && $application->job->user_id !== $user->id) {
                throw new \Illuminate\Auth\Access\AuthorizationException('You do not have permission to delete this application', 403);
            }

            return $this->applicationRepository->deleteApplication($applicationId);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
