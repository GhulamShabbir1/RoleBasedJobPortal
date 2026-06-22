<?php

namespace App\Features\CandidateProfile;

use App\DTOs\CandidateProfile\CandidateProfileFilterDTO;
use App\Repositories\Interfaces\CandidateProfileRepositoryInterface;
use Exception;
use Illuminate\Pagination\Paginator;

class FilterCandidateProfilesFeature
{
    public function __construct(
        private readonly CandidateProfileRepositoryInterface $candidateProfileRepository
    ) {
    }

    /**
     * Filter candidate profiles by search and skills
     *
     * @param CandidateProfileFilterDTO $dto Filter criteria
     * @return Paginator
     * @throws Exception
     */
    public function handle(CandidateProfileFilterDTO $dto): Paginator
    {
        try {
            return $this->candidateProfileRepository->filterProfiles(
                search: $dto->search,
                skills: $dto->skills,
                page: $dto->page,
                perPage: $dto->perPage
            );
        } catch (Exception $e) {
            throw $e;
        }
    }
}
