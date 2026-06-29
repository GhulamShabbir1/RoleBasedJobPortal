<?php

namespace App\Features\CandidateProfile;

use App\Models\CandidateProfile;
use App\Repositories\Interfaces\CandidateProfileRepositoryInterface;
use Exception;

class GetMyCandidateProfileFeature
{
    public function __construct(
        private readonly CandidateProfileRepositoryInterface $candidateProfileRepository
    ) {
    }

    public function handle(): CandidateProfile
    {
        $user = auth()->user();
        $userId = $user?->id;

        if (!$userId) {
            throw new Exception('Unauthenticated', 401);
        }

        $profile = $this->candidateProfileRepository->findByUserId((string) $userId);
        if (!$profile) {
            throw new Exception('Candidate profile not found', 404);
        }

        return $profile;
    }
}
