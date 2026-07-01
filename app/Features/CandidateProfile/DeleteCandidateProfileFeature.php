<?php

namespace App\Features\CandidateProfile;

use App\Repositories\Interfaces\CandidateProfileRepositoryInterface;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\UnauthorizedException;

class DeleteCandidateProfileFeature
{
    public function __construct(
        private readonly CandidateProfileRepositoryInterface $candidateProfileRepository
    ) {
    }

    /**
     * Delete a candidate profile using repository delete()
     */
    public function handle(string $profileId): bool
    {
        $profile = $this->candidateProfileRepository->findById($profileId);

        if (!$profile) {
            throw new ResourceNotFoundException('Candidate profile not found');
        }

        $user = auth()->user();
        if ($profile->user_id !== $user->id) {
            throw new UnauthorizedException('You do not own this profile');
        }

        return $this->candidateProfileRepository->delete((int)$profileId);
    }
}
