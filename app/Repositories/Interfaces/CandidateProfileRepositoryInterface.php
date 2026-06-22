<?php

namespace App\Repositories\Interfaces;

use App\Models\CandidateProfile;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

interface CandidateProfileRepositoryInterface
{
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
     * Create a new candidate profile
     */
    public function createProfile(array $data): CandidateProfile;

    /**
     * Update candidate profile
     */
    public function updateProfile(string $id, array $data): bool;

    /**
     * Delete candidate profile
     */
    public function deleteProfile(string $id): bool;

    /**
     * Filter candidate profiles by search and skills
     */
    public function filterProfiles(?string $search = null, ?string $skills = null, int $page = 1, int $perPage = 15): Paginator;
}
