<?php

namespace App\Features\Job;

use App\DTOs\Job\FiltreJobDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Interfaces\JobRepositoryInterface;
use Exception;

/**
 * FiltreJobFeature
 * Business logic for filtering jobs
 */
class FiltreJobFeature
{
    public function __construct(
        private readonly JobRepositoryInterface $jobRepository
    ) {
    }

    /**
     * Filter jobs
     *
     * @param FiltreJobDTO $dto Job filtering data
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function handle(FiltreJobDTO $dto): LengthAwarePaginator
    {
        try {
            return $this->jobRepository->filterJobs($dto->toArray(), $dto->page, $dto->per_page);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
