<?php

namespace App\Features\Company;

use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Exception;

class GetMyCompanyStatusFeature
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository
    ) {
    }

    /**
     * Returns the authenticated employer's company (if any) with status and UI guidance.
     *
     * Status flow:
     * - no_company: Employer hasn't registered a company yet (show company registration form)
     * - pending: Company registered, awaiting admin approval (show pending message)
     * - approved: Company approved, can post jobs (show job creation available)
     * - rejected: Company was rejected (show rejection reason and allow re-registration)
     *
     * @return array
     */
    public function handle(): array
    {
        $userId = auth()->id();
        if (!$userId) {
            throw new Exception('Unauthorized', 401);
        }

        /** @var Company|null $company */
        $company = Company::where('user_id', $userId)->first();

        if (!$company) {
            return [
                'status' => 'no_company',
                'message' => 'You need to register a company before posting jobs',
                'company_found' => false,
                'can_post_jobs' => false,
                'company' => null,
            ];
        }

        return [
            'status' => (string) $company->status,
            'message' => $this->getStatusMessage($company->status),
            'company_found' => true,
            'can_post_jobs' => $company->status === 'approved',
            'company' => [
                'id' => (int) $company->id,
                'name' => $company->name,
                'status' => $company->status,
                'created_at' => $company->created_at,
                'updated_at' => $company->updated_at,
            ],
        ];
    }

    /**
     * Get user-friendly message for each status
     */
    private function getStatusMessage(string $status): string
    {
        return match($status) {
            'pending' => 'Your company is awaiting admin approval. You cannot post jobs until approved.',
            'approved' => 'Your company is approved. You can now post jobs!',
            'rejected' => 'Your company registration was rejected. Please contact support or try registering again.',
            default => 'Your company status is unknown. Please contact support.',
        };
    }
}

