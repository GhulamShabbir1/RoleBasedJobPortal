<?php

namespace App\Features\CandidateProfile;

use App\DTOs\CandidateProfile\CreateCandidateProfileDTO;
use App\Models\CandidateProfile;
use App\Repositories\Interfaces\CandidateProfileRepositoryInterface;
use App\Exceptions\UnauthorizedException;
use App\Exceptions\ForbiddenException;

class CreateCandidateProfileFeature
{
    public function __construct(
        private readonly CandidateProfileRepositoryInterface $candidateProfileRepository
    ) {
    }

    /**
     * Create a new candidate profile using repository manage()
     */
    public function handle(CreateCandidateProfileDTO $dto): CandidateProfile
    {
        $userId = auth()->id();
        if (!$userId) {
            throw new UnauthorizedException('Unauthorized');
        }

        // Candidate profile single-instance rule: only one profile per candidate user
        $existing = $this->candidateProfileRepository->findByUserId((string)$userId);
        if ($existing) {
            throw new ForbiddenException('Candidate profile already exists');
        }

        $data = $dto->toArray();
        $data['user_id'] = $userId;

        // Use manage() method with null ID to create profile
        return $this->candidateProfileRepository->manage($data);
    }
}
