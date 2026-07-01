<?php

namespace App\Features\Application;

use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\UnauthorizedException;

class DeleteApplicationFeature
{
    public function __construct(
        private readonly ApplicationRepositoryInterface $applicationRepository
    ) {
    }

    /**
     * Delete an application using repository delete()
     */
    public function handle(string $applicationId): bool
    {
        $application = $this->applicationRepository->findById($applicationId);

        if (!$application) {
            throw new ResourceNotFoundException('Application not found');
        }

        $user = auth()->user();

        // Authorization: only admin or the job owner (employer) can delete
        $application->load('job');
        if ($user->role !== 'admin' && $application->job->user_id !== $user->id) {
            throw new UnauthorizedException('You do not have permission to delete this application');
        }

        return $this->applicationRepository->delete((int)$applicationId);
    }
}
