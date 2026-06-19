<?php

namespace App\Features\Company;

use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Exception;

/**
 * GetCompanyFeature
 * Business logic for retrieving a single company
 */
class GetCompanyFeature
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository
    ) {
    }

    /**
     * Get a single company by ID
     *
     * @param int $id Company ID
     * @return Company
     * @throws Exception
     */
    public function handle(int $id): Company
    {
        try {
            // Retrieve company from repository
            $company = $this->companyRepository->findById($id);

            if (!$company) {
                throw new Exception('Company not found');
            }

            return $company;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
