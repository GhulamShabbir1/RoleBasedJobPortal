<?php

namespace App\Features\Company;

use App\DTOs\Company\CompanyFilterDTO;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Exception;

/**
 * FilterCompaniesFeature
 * Business logic for filtering companies
 */
class FilterCompaniesFeature
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository
    ) {
    }

    /**
     * Filter and paginate companies
     *
     * @param CompanyFilterDTO $dto Filter criteria
     * @return array
     * @throws Exception
     */
    public function handle(CompanyFilterDTO $dto): array
    {
        try {
            // Retrieve paginated companies from repository
            $companies = $this->companyRepository->getAll($dto->toArray(), $dto->per_page);

            return [
                'data' => $companies->items(),
                'pagination' => [
                    'total' => $companies->total(),
                    'per_page' => $companies->perPage(),
                    'current_page' => $companies->currentPage(),
                    'last_page' => $companies->lastPage(),
                    'from' => $companies->firstItem(),
                    'to' => $companies->lastItem(),
                ],
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }
}
