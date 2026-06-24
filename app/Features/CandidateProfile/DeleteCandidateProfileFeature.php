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

            $user = auth()->user();
            if ($profile->user_id !== $user->id) {
                throw new \Illuminate\Auth\Access\AuthorizationException('You do not own this profile');
            }

            return $this->candidateProfileRepository->deleteProfile($profileId);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
