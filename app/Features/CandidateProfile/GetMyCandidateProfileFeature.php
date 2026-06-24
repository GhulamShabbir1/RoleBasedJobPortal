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
        $profile = $this->candidateProfileRepository->findByUserId((string)$user->id);
        if (!$profile) {
            throw new Exception('Profile not found', 404);
        }
        return $profile;
    }
}
