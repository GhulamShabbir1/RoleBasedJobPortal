<?php

namespace App\Features\Company;

use App\DTOs\Company\CreateCompanyDTO;
use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Exception;

/**
 * CreateCompanyFeature
 * Business logic for creating a new company
 */
class CreateCompanyFeature
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository
    ) {
    }

    /**
     * Create a new company with pending status
     *
     * @param CreateCompanyDTO $dto Company creation data
     * @return Company
     * @throws Exception
     */
    public function handle(CreateCompanyDTO $dto): Company
    {
        try {
            // Check if company with same email already exists
            $existingCompany = $this->companyRepository->findByEmail($dto->email);
            if ($existingCompany) {
                throw new Exception('Company with this email already exists');
            }

            // Create company data array with pending status
            $data = $dto->toArray();
            $data['status'] = 'pending';
            $data['user_id'] = auth()->id();

            // Create company via repository
            $company = $this->companyRepository->create($data);

            return $company;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
