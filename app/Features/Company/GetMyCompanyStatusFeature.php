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
     * Returns the authenticated employer's company (if any) with status.
     *
     * @return array{ id:int|null, status:string, company_found:bool }
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
                'id' => null,
                'status' => 'none',
                'company_found' => false,
            ];
        }

        return [
            'id' => (int) $company->id,
            'status' => (string) $company->status,
            'company_found' => true,
        ];

    }
}

