<?php

namespace App\Features\Job;

use App\DTOs\Job\CreateJobDTO;
use App\Models\Company;
use App\Models\Job;
use App\Repositories\Interfaces\JobRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class CreateJobFeature
{
    public function __construct(
        private readonly JobRepositoryInterface $jobRepository
    ) {
    }

    public function handle(CreateJobDTO $dto): Job
    {
        try {
            $user = auth()->user();
            $userId = $user->id;

            $company = Company::where('user_id', $userId)->first();

            if (!$company) {
                Log::warning('Job creation attempted without company', [
                    'user_id' => $userId,
                    'timestamp' => now()
                ]);
                throw new Exception('You must create a company first before posting jobs', 403);
            }

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

            $data = $dto->toArray();
            $data['status'] = 'open';
            $data['user_id'] = $userId;
            $data['company_id'] = $company->id;

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
