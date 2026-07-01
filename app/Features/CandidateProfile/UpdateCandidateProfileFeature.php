<?php

namespace App\Features\CandidateProfile;

use App\DTOs\CandidateProfile\UpdateCandidateProfileDTO;
use App\Models\CandidateProfile;
use App\Repositories\Interfaces\CandidateProfileRepositoryInterface;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\UnauthorizedException;

class UpdateCandidateProfileFeature
{
    public function __construct(
        private readonly CandidateProfileRepositoryInterface $candidateProfileRepository
    ) {
    }

    /**
     * Update a candidate profile using repository manage()
     */
    public function handle(UpdateCandidateProfileDTO $dto): CandidateProfile
    {
        $profile = $this->candidateProfileRepository->findById($dto->id);

        if (!$profile) {
            throw new ResourceNotFoundException('Candidate profile not found');
        }

        $user = auth()->user();
        if ($profile->user_id !== $user->id) {
            throw new UnauthorizedException('You do not own this profile');
        }

        $data = $dto->toArray();

        // Use manage() method with ID for update
        return $this->candidateProfileRepository->manage($data, (int)$dto->id);
    }
}
