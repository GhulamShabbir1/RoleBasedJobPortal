<?php

namespace App\Features\Job;

use App\DTOs\Job\ApplyJobDTO;
use App\Models\Application;
use App\Repositories\Interfaces\JobRepositoryInterface;
use Exception;

/**
 * ApplyJobFeature
 * Business logic for applying for a job
 */
class ApplyJobFeature
{
    public function __construct(
        private readonly JobRepositoryInterface $jobRepository
    ) {
    }

    /**
     * Apply for a job
     *
     * @param ApplyJobDTO $dto Job application data
     * @return Application
     * @throws Exception
     */
    public function handle(ApplyJobDTO $dto): Application
    {
        try {
            $jobId = $dto->job_id;

            // Check if job exists
            $job = $this->jobRepository->findById($jobId);
            if (!$job) {
                throw new Exception('Job not found');
            }

            // Create application record
            $data = $dto->toArray();
            $data['status'] = 'applied';
            $data['job_id'] = $jobId;
            $data['candidate_id'] = auth()->id();

            // Create application via Application model
            $application = Application::create($data);

            return $application;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
