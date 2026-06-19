<?php

namespace App\Features\Company;

use App\DTOs\Company\UpdateCompanyDTO;
use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Exception;

/**
 * UpdateCompanyFeature
 * Business logic for updating company information
 */
class UpdateCompanyFeature
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository
    ) {
    }

    /**
     * Update a company with new data
     *
     * @param int $id Company ID
     * @param UpdateCompanyDTO $dto Company update data
     * @return Company
     * @throws Exception
     */
    public function handle(int $id, UpdateCompanyDTO $dto): Company
    {
        try {
            // Retrieve company from repository
            $company = $this->companyRepository->findById($id);

            if (!$company) {
                throw new Exception('Company not found');
            }

            // Check if email is being changed and if it's unique
            if ($dto->email && $dto->email !== $company->email) {
                $existingCompany = $this->companyRepository->findByEmail($dto->email);
                if ($existingCompany) {
                    throw new Exception('Email already exists for another company');
                }
            }

            // Convert DTO to array and filter out null values
            $data = $dto->toArray();

            // Update company via repository
            $updatedCompany = $this->companyRepository->update($company, $data);

            return $updatedCompany;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
