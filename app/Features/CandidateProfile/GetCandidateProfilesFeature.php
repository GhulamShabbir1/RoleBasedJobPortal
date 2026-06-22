<?php

namespace App\Features\CandidateProfile;

use App\Repositories\Interfaces\CandidateProfileRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;

class GetCandidateProfilesFeature
{
    public function __construct(
        private readonly CandidateProfileRepositoryInterface $candidateProfileRepository
    ) {
    }

    /**
     * Get all candidate profiles
     *
     * @return Collection
     * @throws Exception
     */
    public function handle(): Collection
    {
        try {
            return $this->candidateProfileRepository->getAllProfiles();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
