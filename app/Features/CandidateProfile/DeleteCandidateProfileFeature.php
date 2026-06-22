<?php

namespace App\Features\CandidateProfile;

use App\Repositories\Interfaces\CandidateProfileRepositoryInterface;
use Exception;

class DeleteCandidateProfileFeature
{
    public function __construct(
        private readonly CandidateProfileRepositoryInterface $candidateProfileRepository
    ) {
    }

    /**
     * Delete a candidate profile
     *
     * @param string $profileId Profile ID to delete
     * @return bool
     * @throws Exception
     */
    public function handle(string $profileId): bool
    {
        try {
            $profile = $this->candidateProfileRepository->findById($profileId);

            if (!$profile) {
                throw new Exception('Candidate profile not found', 404);
            }

            return $this->candidateProfileRepository->deleteProfile($profileId);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
