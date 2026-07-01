<?php

namespace App\Features\Job;

use App\DTOs\Job\UpdateJobDTO;
use App\Models\Job;
use App\Repositories\Interfaces\JobRepositoryInterface;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\UnauthorizedException;

class UpdateJobFeature
{
    public function __construct(
        private readonly JobRepositoryInterface $jobRepository
    ) {
    }

    /**
     * Update a job using repository manage()
     */
    public function handle(string $id, UpdateJobDTO $dto): Job
    {
        $job = $this->jobRepository->findById($id);

        if (!$job) {
            throw new ResourceNotFoundException('Job not found');
        }

        $user = auth()->user();
        if ($user->role !== 'admin' && $job->user_id !== $user->id) {
            throw new UnauthorizedException('Unauthorized');
        }

        $data = $dto->toArray();

        // Use manage() method with ID for update
        return $this->jobRepository->manage($data, (int)$id);
    }
}
