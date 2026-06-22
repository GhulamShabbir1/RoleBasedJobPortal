<?php

namespace App\Repositories\Eloquent;

use App\Models\CandidateProfile;
use App\Repositories\Interfaces\CandidateProfileRepositoryInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class CandidateProfileRepository implements CandidateProfileRepositoryInterface
{
    protected $model;

    public function __construct(CandidateProfile $candidateProfile)
    {
        $this->model = $candidateProfile;
    }

    /**
     * Get all candidate profiles
     */
    public function getAllProfiles(): Collection
    {
        return $this->model->all();
    }

    /**
     * Find candidate profile by ID
     */
    public function findById(string $id): ?CandidateProfile
    {
        return $this->model->find($id);
    }

    /**
     * Find candidate profile by user ID
     */
    public function findByUserId(string $userId): ?CandidateProfile
    {
        return $this->model->where('user_id', $userId)->first();
    }

    /**
     * Create a new candidate profile
     */
    public function createProfile(array $data): CandidateProfile
    {
        return $this->model->create($data);
    }

    /**
     * Update candidate profile
     */
    public function updateProfile(string $id, array $data): bool
    {
        $profile = $this->findById($id);

        if (!$profile) {
            return false;
        }

        return $profile->update($data);
    }

    /**
     * Delete candidate profile
     */
    public function deleteProfile(string $id): bool
    {
        $profile = $this->findById($id);

        if (!$profile) {
            return false;
        }

        return $profile->delete();
    }

    /**
     * Filter candidate profiles by search and skills
     */
    public function filterProfiles(?string $search = null, ?string $skills = null, int $page = 1, int $perPage = 15): Paginator
    {
        $query = $this->model->query();

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            })
            ->orWhere('bio', 'like', "%$search%");
        }

        if ($skills) {
            $query->where('skills', 'like', "%$skills%");
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
