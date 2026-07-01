<?php

namespace App\Features\Job;

use App\Repositories\Interfaces\JobRepositoryInterface;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\UnauthorizedException;

class DeleteJobFeature
{
    public function __construct(
        private readonly JobRepositoryInterface $jobRepository
    ) {
    }

    /**
     * Delete a job using repository delete()
     */
    public function handle(int $id): bool
    {
        $job = $this->jobRepository->findById((string)$id);

        if (!$job) {
            throw new ResourceNotFoundException('Job not found');
        }

        $user = auth()->user();
        if ($user->role !== 'admin' && $job->user_id !== $user->id) {
            throw new UnauthorizedException('You do not own this job');
        }

        return $this->jobRepository->delete($id);
    }
}
