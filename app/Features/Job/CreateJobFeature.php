<?php

namespace App\Features\Job;

use App\DTOs\Job\CreateJobDTO;
use App\Models\Company;
use App\Models\Job;
use App\Repositories\Interfaces\JobRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * CreateJobFeature
 * Business logic for creating a new job
 * Includes company approval check
 */
class CreateJobFeature
{
    public function __construct(
        private readonly JobRepositoryInterface $jobRepository
    ) {
    }

    /**
     * Create a new job with pending status
     * Verifies company is approved before job creation
     *
     * @param CreateJobDTO $dto Job creation data
     * @return Job
     * @throws Exception
     */
    public function handle(CreateJobDTO $dto): Job
    {
        try {
            $userId = auth()->id();

            // 1. Find user's company
            $company = Company::where('user_id', $userId)->first();

            if (!$company) {
                Log::warning('Job creation attempted without company', [
                    'user_id' => $userId,
                    'timestamp' => now()
                ]);
                throw new Exception('You must create a company first before posting jobs', 403);
            }

            // 2. Check if company is approved
            if ($company->status !== 'approved') {
                Log::warning('Job creation attempted with unapproved company', [
                    'user_id' => $userId,
                    'company_id' => $company->id,
                    'company_status' => $company->status,
                    'timestamp' => now()
                ]);
                throw new Exception(
                    'Your company is not approved yet. Current status: ' . $company->status .
                    '. Please wait for admin approval before posting jobs.',
                    403
                );
            }

            // 3. Create job data array with pending status
            $data = $dto->toArray();
            $data['status'] = 'pending';
            $data['user_id'] = $userId;
            $data['company_id'] = $company->id;

            // 4. Create job via repository
            $job = $this->jobRepository->createJob($data);

            Log::info('Job created successfully', [
                'job_id' => $job->id,
                'user_id' => $userId,
                'company_id' => $company->id
            ]);

            return $job;

        } catch (Exception $e) {
            Log::error('Job creation failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            throw $e;
        }
    }
}
