<?php

namespace App\Features\Job;

use App\Repositories\Interfaces\JobRepositoryInterface;
use Exception;

class DeleteJobFeature
{
    public function __construct(
        private readonly JobRepositoryInterface $jobRepository
    ) {
    }

    public function handle(int $id): bool
    {
        try {
            $job = $this->jobRepository->findById((string)$id);

            if (!$job) {
                throw new Exception('Job not found');
            }

            $user = auth()->user();
            if ($user->role !== 'admin' && $job->user_id !== $user->id) {
                throw new \Illuminate\Auth\Access\AuthorizationException('You do not own this job');
            }

            return $this->jobRepository->deleteJob((string)$id);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
