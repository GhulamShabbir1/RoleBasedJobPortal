<?php

namespace App\Repositories\Eloquent;

use App\Models\Application;
use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use Illuminate\Support\Collection;

class ApplicationRepository implements ApplicationRepositoryInterface
{
    /**
     * Create a new application in the database
     */
    public function createApplication(array $data): Application
    {
        return Application::create($data);
    }

    /**
     * Find application by id
     */
    public function findById(string $id): ?Application
    {
        return Application::find($id);
    }

    /**
     * Update an application in the database
     */
    public function updateApplication(string $id, array $data): bool
    {
        $application = $this->findById($id);
        if (!$application) {
            return false;
        }
        $application->update($data);
        return true;
    }

    /**
     * Delete an application in the database
     */
    public function deleteApplication(string $id): bool
    {
        $application = $this->findById($id);
        if (!$application) {
            return false;
        }
        return $application->delete();
    }

    /**
     * Get all applications
     */
    public function getAllApplications(): Collection
    {
        return Application::all();
    }

    /**
     * Get applications by company id
     */
    public function getApplicationsByCompanyId(string $companyId): Collection
    {
        return Application::where('company_id', $companyId)->get();
    }

    /**
     * Get applications by job id
     */
    public function getApplicationsByJobId(string $jobId): Collection
    {
        return Application::where('job_id', $jobId)->get();
    }

    /**
     * Get applications by user id
     */
    public function getApplicationsByUserId(string $userId): Collection
    {
        return Application::where('user_id', $userId)->get();
    }

    /**
     * Get application status by id
     */
    public function getApplicationStatusById(string $id): ?string
    {
        return Application::where('id', $id)->value('status');
    }

    /**
     * Get applications by job id and status
     */
    public function getApplicationsByJobIdAndStatus(string $jobId, string $status): Collection
    {
        return Application::where('job_id', $jobId)->where('status', $status)->get();
    }

    /**
     * Get applications by status
     */
    public function getApplicationsByStatus(string $status): Collection
    {
        return Application::where('status', $status)->get();
    }

    /**
     * Filter applications by criteria
     */
    public function filterApplications(array $filters): Collection
    {
        $query = Application::query();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['job_id'])) {
            $query->where('job_id', $filters['job_id']);
        }

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['company_id'])) {
            $query->where('company_id', $filters['company_id']);
        }

        return $query->get();
    }
}
