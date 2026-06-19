<?php

namespace App\Features\Company;

use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Exception;

/**
 * DeleteCompanyFeature
 * Business logic for deleting a company
 */
class DeleteCompanyFeature
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository
    ) {
    }

    /**
     * Delete a company by ID
     *
     * @param int $id Company ID
     * @return bool
     * @throws Exception
     */
    public function handle(int $id): bool
    {
        try {
            // Retrieve company from repository
            $company = $this->companyRepository->findById($id);

            if (!$company) {
                throw new Exception('Company not found');
            }

            // Delete company via repository
            return $this->companyRepository->delete($company);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
