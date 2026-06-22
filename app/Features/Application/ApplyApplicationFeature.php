<?php

namespace App\Features\Application;

use App\DTOs\Application\ApplyApplicationDTO;
use App\Models\Application;
use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use Exception;

class ApplyApplicationFeature
{
    public function __construct(
        private readonly ApplicationRepositoryInterface $applicationRepository
    ) {
    }

    /**
     * Apply for a job
     *
     * @param ApplyApplicationDTO $dto Application data
     * @return Application
     * @throws Exception
     */
    public function handle(ApplyApplicationDTO $dto): Application
    {
        try {
            // Check if user already applied for this job
            $existing = Application::where('user_id', $dto->user_id)
                ->where('job_id', $dto->job_id)
                ->first();

            if ($existing) {
                throw new Exception('You have already applied for this job');
            }

            return $this->applicationRepository->createApplication([
                'job_id' => $dto->job_id,
                'user_id' => $dto->user_id,
                'company_id' => $dto->company_id,
                'cover_letter' => $dto->cover_letter,
                'resume' => $dto->resume,
                'status' => 'pending',
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
