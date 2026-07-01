<?php

namespace App\Features\Job;

use App\DTOs\Job\CreateJobDTO;
use App\Models\Company;
use App\Models\Job;
use App\Repositories\Interfaces\JobRepositoryInterface;
use App\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Log;

class CreateJobFeature
{
    public function __construct(
        private readonly JobRepositoryInterface $jobRepository
    ) {
    }

    /**
     * Create a new job using repository manage()
     */
    public function handle(CreateJobDTO $dto): Job
    {
        $user = auth()->user();
        $userId = $user->id;

        $company = Company::where('user_id', $userId)->first();

        if (!$company) {
            Log::warning('Job creation attempted without company', [
                'user_id' => $userId,
                'timestamp' => now()
            ]);
            throw new UnauthorizedException('You must create a company first before posting jobs.');
        }

        if ($company->status !== 'approved') {
            Log::warning('Job creation attempted with unapproved company', [
                'user_id' => $userId,
                'company_id' => $company->id,
                'company_status' => $company->status,
                'timestamp' => now()
            ]);
            throw new UnauthorizedException(
                'Your company is not approved yet. Current status: ' . $company->status .
                '. Please wait for admin approval before posting jobs.'
            );
        }

        $data = $dto->toArray();
        $data['status'] = 'open';
        $data['user_id'] = $userId;
        $data['company_id'] = $company->id;

        // Use manage() method with null ID to create job
        $job = $this->jobRepository->manage($data);

        Log::info('Job created successfully', [
            'job_id' => $job->id,
            'user_id' => $userId,
            'company_id' => $company->id
        ]);

        return $job;
    }
}
