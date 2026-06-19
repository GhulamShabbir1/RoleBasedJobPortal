<?php

namespace App\Features\Company;

use App\DTOs\Company\RejectCompanyDTO;
use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Exception;

/**
 * RejectCompanyFeature
 * Business logic for rejecting a company registration
 */
class RejectCompanyFeature
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository
    ) {
    }

    /**
     * Reject a company and set status to 'rejected'
     *
     * @param RejectCompanyDTO $dto Company rejection data
     * @return Company
     * @throws Exception
     */
    public function handle(RejectCompanyDTO $dto): Company
    {
        try {
            // Retrieve company from repository
            $company = $this->companyRepository->findById($dto->company_id);

            if (!$company) {
                throw new Exception('Company not found');
            }

            // Check if company is already rejected
            if ($company->status === 'rejected') {
                throw new Exception('Company is already rejected');
            }

            // Update company status to rejected
            $rejectedCompany = $this->companyRepository->updateStatus(
                $company,
                'rejected',
                $dto->reason
            );

            return $rejectedCompany;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
