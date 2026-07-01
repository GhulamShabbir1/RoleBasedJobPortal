<?php

namespace App\Repositories\Eloquent;

use App\Models\CandidateProfile;
use App\Repositories\Interfaces\CandidateProfileRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CandidateProfileRepository implements CandidateProfileRepositoryInterface
{
    protected $model;
    private const CACHE_KEY = 'candidate_profiles:';
    private const CACHE_TTL = 3600;

    public function __construct(CandidateProfile $candidateProfile)
    {
        $this->model = $candidateProfile;
    }

    /**
     * Create or update candidate profile using single manage method
     */
    public function manage(array $data, ?int $id = null): CandidateProfile
    {
        if ($id === null) {
            // Create new profile
            $profile = $this->model->create($data);
        } else {
            // Update existing profile
            $profile = $this->model->findOrFail($id);
            $profile->update($data);
        }

        // Clear cache
        $this->clearCache();

        return $profile;
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
     * Delete candidate profile
     */
    public function delete(int $id): bool
    {
        $profile = $this->model->find($id);

        if (!$profile) {
            return false;
        }

        $this->clearCache();
        return $profile->delete();
    }

    /**
     * Legacy method for backward compatibility
     */
    public function deleteProfile(string $id): bool
    {
        return $this->delete((int)$id);
    }

    /**
     * Filter candidate profiles by search and skills
     */
    public function filterProfiles(?string $search = null, ?string $skills = null, int $page = 1, int $perPage = 15): LengthAwarePaginator
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

    /**
     * Clear related cache
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY . '*');
    }
}
