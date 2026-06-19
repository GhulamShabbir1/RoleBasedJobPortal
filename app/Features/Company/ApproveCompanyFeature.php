<?php

namespace App\Features\Company;

use App\DTOs\Company\ApproveCompanyDTO;
use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Exception;

/**
 * ApproveCompanyFeature
 * Business logic for approving a company registration
 */
class ApproveCompanyFeature
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository
    ) {
    }

    /**
     * Approve a company and set status to 'approved'
     *
     * @param ApproveCompanyDTO $dto Company approval data
     * @return Company
     * @throws Exception
     */
    public function handle(ApproveCompanyDTO $dto): Company
    {
        try {
            // Retrieve company from repository
            $company = $this->companyRepository->findById($dto->company_id);

            if (!$company) {
                throw new Exception('Company not found');
            }

            // Check if company is already approved
            if ($company->status === 'approved') {
                throw new Exception('Company is already approved');
            }

            // Update company status to approved
            $approvedCompany = $this->companyRepository->updateStatus(
                $company,
                'approved',
                $dto->notes
            );

            return $approvedCompany;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
