<?php

namespace App\Features\CandidateProfile;

use App\DTOs\CandidateProfile\UpdateCandidateProfileDTO;
use App\Models\CandidateProfile;
use App\Repositories\Interfaces\CandidateProfileRepositoryInterface;
use Exception;

class UpdateCandidateProfileFeature
{
    public function __construct(
        private readonly CandidateProfileRepositoryInterface $candidateProfileRepository
    ) {
    }

    /**
     * Update a candidate profile
     *
     * @param UpdateCandidateProfileDTO $dto Candidate profile data to update
     * @return CandidateProfile
     * @throws Exception
     */
    public function handle(UpdateCandidateProfileDTO $dto): CandidateProfile
    {
        try {
            $profile = $this->candidateProfileRepository->findById($dto->id);

            if (!$profile) {
                throw new Exception('Candidate profile not found', 404);
            }

            $data = $dto->toArray();

            if (!empty($data)) {
                $this->candidateProfileRepository->updateProfile($dto->id, $data);
            }

            return $this->candidateProfileRepository->findById($dto->id);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
