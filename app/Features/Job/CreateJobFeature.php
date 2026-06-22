<?php

namespace App\Features\Job;

use App\DTOs\Job\CreateJobDTO;
use App\Models\Job;
use App\Repositories\Interfaces\JobRepositoryInterface;
use Exception;

/**
 * CreateJobFeature
 * Business logic for creating a new job
 */
class CreateJobFeature
{
    public function __construct(
        private readonly JobRepositoryInterface $jobRepository
    ) {
    }

    /**
     * Create a new job with pending status
     *
     * @param CreateJobDTO $dto Job creation data
     * @return Job
     * @throws Exception
     */
    public function handle(CreateJobDTO $dto): Job
    {
        try {
            // Create job data array with pending status
            $data = $dto->toArray();
            $data['status'] = 'pending';
            $data['user_id'] = auth()->id();

            // Create job via repository
            $job = $this->jobRepository->create($data);

            return $job;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
