<?php

namespace App\Features\Company;

use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Exception;

/**
 * ListCompaniesFeature
 * Business logic for listing companies with filters
 */
class ListCompaniesFeature
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository
    ) {
    }

    /**
     * List all companies with optional filters and pagination
     *
     * @param array $filters Filter criteria (status, search, city, country)
     * @return array
     * @throws Exception
     */
    public function handle(array $filters = []): array
    {
        try {
            // Get per_page from filters or use default
            $perPage = $filters['per_page'] ?? 15;
            unset($filters['per_page']);

            // Retrieve paginated companies from repository
            $companies = $this->companyRepository->getAll($filters, $perPage);

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
