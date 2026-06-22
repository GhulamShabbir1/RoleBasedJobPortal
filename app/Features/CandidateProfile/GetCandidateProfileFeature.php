<?php

namespace App\Features\CandidateProfile;

use App\Models\CandidateProfile;
use App\Repositories\Interfaces\CandidateProfileRepositoryInterface;
use Exception;

class GetCandidateProfileFeature
{
    public function __construct(
        private readonly CandidateProfileRepositoryInterface $candidateProfileRepository
    ) {
    }

    /**
     * Get a single candidate profile by ID
     *
     * @param string $profileId Profile ID
     * @return CandidateProfile
     * @throws Exception
     */
    public function handle(string $profileId): CandidateProfile
    {
        try {
            $profile = $this->candidateProfileRepository->findById($profileId);

            if (!$profile) {
                throw new Exception('Candidate profile not found', 404);
            }

            return $profile;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
