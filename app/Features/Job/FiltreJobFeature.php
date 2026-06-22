<?php

namespace App\Features\Job;

use App\DTOs\Job\FiltreJobDTO;
use Illuminate\Support\Collection;
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
     * @return Collection
     * @throws Exception
     */
    public function handle(FiltreJobDTO $dto): Collection
    {
        try {
            $jobs = $this->jobRepository->getAllJobs();

            // Apply filters
            if ($dto->search) {
                $jobs = $this->jobRepository->searchJobs($dto->search);
            }

            if ($dto->category_id) {
                $jobs = $this->jobRepository->getJobsByCategoryId((string)$dto->category_id);
            }

            if ($dto->job_type) {
                $jobs = $this->jobRepository->getJobsByJobType($dto->job_type);
            }

            if ($dto->city) {
                $jobs = $this->jobRepository->getJobsByLocation($dto->city);
            }

            if ($dto->status) {
                $jobs = $this->jobRepository->getJobsByStatus($dto->status);
            }

            if ($dto->min_salary && $dto->max_salary) {
                $jobs = $this->jobRepository->getJobsBySalaryRange($dto->min_salary, $dto->max_salary);
            }

            return $jobs;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
