<?php

namespace App\Features\Job;

use App\Models\Job;
use App\Repositories\Interfaces\JobRepositoryInterface;
use Exception;

class CloseJobFeature
{
    public function __construct(
        private readonly JobRepositoryInterface $jobRepository
    ) {
    }

    public function handle(string $id): Job
    {
        try {
            $job = $this->jobRepository->findById($id);
            if (!$job) {
                throw new Exception('Job not found');
            }

            $user = auth()->user();
            if ($user->role !== 'admin' && $job->user_id !== $user->id) {
                throw new Exception('Unauthorized', 403);
            }

            $job->status = 'closed';
            $job->save();

            return $job;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
