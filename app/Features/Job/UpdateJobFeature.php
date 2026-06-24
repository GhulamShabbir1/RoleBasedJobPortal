<?php

namespace App\Features\Job;

use App\DTOs\Job\UpdateJobDTO;
use App\Models\Job;
use App\Repositories\Interfaces\JobRepositoryInterface;
use Exception;

/**
 * UpdateJobFeature
 * Business logic for updating a job
 */
class UpdateJobFeature
{
    public function __construct(
        private readonly JobRepositoryInterface $jobRepository
    ) {
    }

    /**
     * Update a job
     *
     * @param string $id Job id
     * @param UpdateJobDTO $dto Job update data
     * @return Job
     * @throws Exception
     */
    public function handle(string $id, UpdateJobDTO $dto): Job
    {
        try {
            // Find job
            $job = $this->jobRepository->findById($id);
            if (!$job) {
                throw new Exception('Job not found');
            }

            $user = auth()->user();
            if ($user->role !== 'admin' && $job->user_id !== $user->id) {
                throw new Exception('Unauthorized', 403);
            }

            // Update job
            $data = $dto->toArray();
            $this->jobRepository->updateJob($id, $data);

            // Return updated job
            return $this->jobRepository->findById($id);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
