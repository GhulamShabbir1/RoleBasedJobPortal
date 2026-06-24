<?php

namespace App\Features\Application;

use App\DTOs\Application\ApplicationFilterDTO;
use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;

class FilterApplicationsFeature
{
    public function __construct(
        private readonly ApplicationRepositoryInterface $applicationRepository
    ) {
    }

    /**
     * Filter applications by criteria
     *
     * @param ApplicationFilterDTO $dto Filter criteria
     * @return Collection
     * @throws Exception
     */
    public function handle(ApplicationFilterDTO $dto): Collection
    {
        try {
            return $this->applicationRepository->filterApplications($dto->toArray());
        } catch (Exception $e) {
            throw $e;
        }
    }
}
