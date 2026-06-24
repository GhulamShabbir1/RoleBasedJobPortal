<?php

namespace App\Features\CandidateProfile;

use App\DTOs\CandidateProfile\CreateCandidateProfileDTO;
use App\Models\CandidateProfile;
use App\Repositories\Interfaces\CandidateProfileRepositoryInterface;
use Exception;

class CreateCandidateProfileFeature
{
    public function __construct(
        private readonly CandidateProfileRepositoryInterface $candidateProfileRepository
    ) {
    }

    /**
     * Create a new candidate profile
     *
     * @param CreateCandidateProfileDTO $dto Candidate profile data
     * @return CandidateProfile
     * @throws Exception
     */
    public function handle(CreateCandidateProfileDTO $dto): CandidateProfile
    {
        try {
            $userId = auth()->id();
            if (!$userId) {
                throw new Exception('Unauthorized', 401);
            }

            // Candidate profile single-instance rule: only one profile per candidate user
            $existing = $this->candidateProfileRepository->findByUserId((string) $userId);
            if ($existing) {
                throw new Exception('Candidate profile already exists', 409);
            }

            $data = $dto->toArray();
            $data['user_id'] = $userId;

            return $this->candidateProfileRepository->createProfile($data);
        } catch (Exception $e) {
            throw $e;
        }
    }

}
