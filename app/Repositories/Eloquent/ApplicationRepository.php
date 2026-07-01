<?php

namespace App\Repositories\Eloquent;

use App\Models\Application;
use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class ApplicationRepository implements ApplicationRepositoryInterface
{
    private const CACHE_KEY = 'applications:';
    private const CACHE_TTL = 3600;

    /**
     * Eager load relationships for complete application data
     */
    private function withRelationships()
    {
        return Application::with([
            'candidate',
            'candidate.candidateProfile',
            'job',
            'job.company',
            'job.category'
        ]);
    }

    /**
     * Create or update application using single manage method
     */
    public function manage(array $data, ?int $id = null): Application
    {
        if ($id === null) {
            // Create new application
            $application = Application::create($data);
        } else {
            // Update existing application
            $application = Application::findOrFail($id);
            $application->update($data);
        }

        // Clear cache
        $this->clearCache();

        return $application;
    }

    public function findById(string $id): ?Application
    {
        return $this->withRelationships()->find($id);
    }

    public function getApplicationById(int $id): ?Application
    {
        return $this->withRelationships()->find($id);
    }

    public function getApplicationStatusById(int $id): ?string
    {
        return Application::where('id', $id)->value('status');
    }

    public function filterApplicationsByCandidateId(int $candidateId, array $filters): LengthAwarePaginator
    {
        $query = $this->withRelationships()->where('candidate_id', $candidateId);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['job_id'])) {
            $query->where('job_id', $filters['job_id']);
        }

        return $query->paginate(10);
    }

    public function filterApplicationsByEmployerId(int $employerId, array $filters): LengthAwarePaginator
    {
        $query = $this->withRelationships()->whereHas('job', function($q) use ($employerId) {
            $q->where('user_id', $employerId);
        });

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['job_id'])) {
            $query->where('job_id', $filters['job_id']);
        }

        return $query->paginate(10);
    }

    public function filterAllApplications(array $filters): LengthAwarePaginator
    {
        $query = $this->withRelationships();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['job_id'])) {
            $query->where('job_id', $filters['job_id']);
        }

        if (!empty($filters['candidate_id'])) {
            $query->where('candidate_id', $filters['candidate_id']);
        }

        return $query->paginate(10);
    }

    /**
     * Delete application
     */
    public function delete(int $id): bool
    {
        $application = $this->getApplicationById($id);

        if (!$application) {
            return false;
        }

        $this->clearCache();
        return $application->delete();
    }

    /**
     * Legacy method for backward compatibility
     */
    public function deleteApplication(int $id): bool
    {
        return $this->delete($id);
    }

    /**
     * Clear related cache
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY . '*');
    }
}
