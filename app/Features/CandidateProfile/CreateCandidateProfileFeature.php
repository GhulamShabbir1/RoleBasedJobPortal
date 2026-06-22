<?php

namespace App\Features\CandidateProfile;

use App\DTOs\CandidateProfile\CreateCandidateProfileDTO;
use App\Models\CandidateProfile;
use App\Repositories\Interfaces\CandidateProfileRepositoryInterface;
use Exception;

class CreateCandidateProfileFeature
{
    public function __construct(
        private readonly CandidateProfileRepositoryInterface $candidateProfileRepository
    ) {
    }

    /**
     * Create a new candidate profile
     *
     * @param CreateCandidateProfileDTO $dto Candidate profile data
     * @return CandidateProfile
     * @throws Exception
     */
    public function handle(CreateCandidateProfileDTO $dto): CandidateProfile
    {
        try {
            $data = $dto->toArray();
            return $this->candidateProfileRepository->createProfile($data);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
