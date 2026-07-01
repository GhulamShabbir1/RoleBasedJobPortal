<?php

namespace App\Features\Company;

use App\DTOs\Company\UpdateCompanyDTO;
use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\ForbiddenException;
use Illuminate\Support\Facades\Storage;

class UpdateCompanyFeature
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository
    ) {
    }

    /**
     * Update a company using repository manage()
     */
    public function handle(int $id, UpdateCompanyDTO $dto): Company
    {
        $company = $this->companyRepository->findById($id);

        if (!$company) {
            throw new ResourceNotFoundException('Company not found');
        }

        // Ownership check
        if (auth()->id() !== $company->user_id && auth()->user()->role !== 'admin') {
            throw new ForbiddenException('You do not own this company.');
        }

        // Check if email is being changed and if it's unique
        if ($dto->email && $dto->email !== $company->email) {
            $existingCompany = $this->companyRepository->findByEmail($dto->email);
            if ($existingCompany) {
                throw new ForbiddenException('Email already exists for another company');
            }
        }

        // Convert DTO to array
        $data = $dto->toArray();

        // Use manage() method with ID for update
        $updatedCompany = $this->companyRepository->manage($data, $id);

        // Store logo if uploaded
        if ($dto->logo) {
            if ($updatedCompany->logo) {
                Storage::disk('public')->delete($updatedCompany->logo);
            }
            $logoPath = $dto->logo->store('companies/logos', 'public');
            $updatedCompany = $this->companyRepository->manage(['logo' => $logoPath], $id);
        }

        // Store certificate if uploaded
        if ($dto->certificate) {
            if ($updatedCompany->certificate) {
                Storage::disk('public')->delete($updatedCompany->certificate);
            }
            $certPath = $dto->certificate->store('companies/certificates', 'public');
            $updatedCompany = $this->companyRepository->manage(['certificate' => $certPath], $id);
        }

        return $updatedCompany;
    }
}
