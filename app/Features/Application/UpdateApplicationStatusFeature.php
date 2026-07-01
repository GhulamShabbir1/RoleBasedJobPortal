<?php

namespace App\Features\Application;

use App\DTOs\Application\UpdateApplicationStatusDTO;
use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\UnauthorizedException;

class UpdateApplicationStatusFeature
{
    public function __construct(
        private readonly ApplicationRepositoryInterface $applicationRepository
    ) {
    }

    /**
     * Update application status using repository manage()
     */
    public function handle(string $applicationId, UpdateApplicationStatusDTO $dto): bool
    {
        $application = $this->applicationRepository->findById($applicationId);

        if (!$application) {
            throw new ResourceNotFoundException('Application not found');
        }

        $user = auth()->user();
        // Check ownership (admin or job owner)
        $application->load('job');
        if ($user->role !== 'admin' && $application->job->user_id !== $user->id) {
            throw new UnauthorizedException('You do not own this application');
        }

        // Validate status is in allowed list
        if (!in_array($dto->status, ['reviewed', 'accepted', 'rejected'])) {
            throw new UnauthorizedException('Invalid status');
        }

        $this->applicationRepository->manage([
            'status' => $dto->status,
        ], (int)$applicationId);

        return true;
    }
}
