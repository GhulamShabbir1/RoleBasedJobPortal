<?php

namespace App\Features\Employer;

use App\Models\Company;
use Exception;
use Illuminate\Support\Facades\Log;

class GetEmployerStatusFeature
{
    /**
     * Get employer status (company registration and approval status)
     *
     * Returns:
     * - no_company: Employer hasn't registered a company yet
     * - pending: Company registered but awaiting admin approval
     * - approved: Company approved, can post jobs
     * - rejected: Company was rejected
     */
    public function handle(): array
    {
        try {
            $user = auth()->user();

            if (!$user) {
                throw new Exception('User not authenticated', 401);
            }

            // Only employers should have company status
            if ($user->role !== 'employer') {
                throw new Exception('This feature is only available for employers', 403);
            }

            $company = Company::where('user_id', $user->id)->first();

            // No company registered
            if (!$company) {
                return [
                    'status' => 'no_company',
                    'message' => 'You need to register a company before posting jobs',
                    'company' => null,
                    'can_post_jobs' => false,
                ];
            }

            // Company exists, check approval status
            return [
                'status' => $company->status,
                'message' => $this->getStatusMessage($company->status),
                'company' => [
                    'id' => $company->id,
                    'name' => $company->name,
                    'status' => $company->status,
                    'created_at' => $company->created_at,
                    'updated_at' => $company->updated_at,
                ],
                'can_post_jobs' => $company->status === 'approved',
            ];

        } catch (Exception $e) {
            Log::error('Error getting employer status', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            throw $e;
        }
    }

    private function getStatusMessage(string $status): string
    {
        return match($status) {
            'pending' => 'Your company is awaiting admin approval. You cannot post jobs until approved.',
            'approved' => 'Your company is approved. You can now post jobs.',
            'rejected' => 'Your company registration was rejected. Please contact support.',
            default => 'Unknown company status.',
        };
    }
}
