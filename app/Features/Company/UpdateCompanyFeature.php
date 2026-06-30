<?php

namespace App\Features\Company;

use App\DTOs\Company\UpdateCompanyDTO;
use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Storage;

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

            // Ownership check
            if (auth()->id() !== $company->user_id && auth()->user()->role !== 'admin') {
                throw new \Illuminate\Auth\Access\AuthorizationException('You do not own this company.');
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

            // Store logo if uploaded
            if ($dto->logo) {
                // Delete old logo if exists
                if ($updatedCompany->logo) {
                    Storage::disk('public')->delete($updatedCompany->logo);
                }
                $logoPath = $dto->logo->store('companies/logos', 'public');
                $updatedCompany->update(['logo' => $logoPath]);
            }

            // Store certificate if uploaded
            if ($dto->certificate) {
                // Delete old certificate if exists
                if ($updatedCompany->certificate) {
                    Storage::disk('public')->delete($updatedCompany->certificate);
                }
                $certPath = $dto->certificate->store('companies/certificates', 'public');
                $updatedCompany->update(['certificate' => $certPath]);
            }

            return $updatedCompany;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
