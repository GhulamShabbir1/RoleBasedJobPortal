<?php

namespace App\Features\Company;

use App\DTOs\Company\CreateCompanyDTO;
use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Storage;

class CreateCompanyFeature
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository
    ) {
    }

    /**
     * Create a new company using repository manage()
     */
    public function handle(CreateCompanyDTO $dto): Company
    {
        $userId = auth()->id();

        // One company per employer rule
        $existing = $this->companyRepository->getByUserId($userId);
        if ($existing) {
            throw new UnauthorizedException('You already have a registered company.');
        }

        // Check if company with same email already exists
        $existingCompany = $this->companyRepository->findByEmail($dto->email);
        if ($existingCompany) {
            throw new UnauthorizedException('Company with this email already exists.');
        }

        // Create company data array with pending status
        $data = $dto->toArray();
        $data['status'] = 'pending';
        $data['user_id'] = $userId;

        // Use manage() method with null ID to create company
        $company = $this->companyRepository->manage($data);

        // Store logo
        if ($dto->logo) {
            $logoPath = $dto->logo->store('companies/logos', 'public');
            $company = $this->companyRepository->manage(['logo' => $logoPath], $company->id);
        }

        // Store certificate
        if ($dto->certificate) {
            $certPath = $dto->certificate->store('companies/certificates', 'public');
            $company = $this->companyRepository->manage(['certificate' => $certPath], $company->id);
        }

        return $company;
    }
}
