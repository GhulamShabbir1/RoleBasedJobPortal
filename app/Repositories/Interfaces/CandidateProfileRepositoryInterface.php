<?php

namespace App\Repositories\Interfaces;

use App\Models\CandidateProfile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CandidateProfileRepositoryInterface
{
    /**
     * Create or update candidate profile using single manage method
     */
    public function manage(array $data, ?int $id = null): CandidateProfile;

    /**
     * Get all candidate profiles
     */
    public function getAllProfiles(): Collection;

    /**
     * Find candidate profile by ID
     */
    public function findById(string $id): ?CandidateProfile;

    /**
     * Find candidate profile by user ID
     */
    public function findByUserId(string $userId): ?CandidateProfile;

    /**
     * Delete candidate profile
     */
    public function delete(int $id): bool;

    /**
     * Delete candidate profile (legacy)
     */
    public function deleteProfile(string $id): bool;

    /**
     * Filter candidate profiles by search and skills
     */
    public function filterProfiles(?string $search = null, ?string $skills = null, int $page = 1, int $perPage = 15): LengthAwarePaginator;

    /**
     * Clear related cache
     */
    public function clearCache(): void;
}
