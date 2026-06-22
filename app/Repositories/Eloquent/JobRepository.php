<?php

namespace App\Repositories\Eloquent;

use App\Models\Job;
use App\Repositories\Interfaces\JobRepositoryInterface;
use Illuminate\Support\Collection;

class JobRepository implements JobRepositoryInterface
{
   /**
     * Create a new job in the database
     */
    public function createJob(array $data): Job
    {
        return Job::create($data);
    }

    /**
     * Find job by id
     */
    public function findById(string $id): ?Job
    {
        return Job::find($id);
    }

    /**
     * Update a job in the database
     */
    public function updateJob(string $id, array $data): bool
    {
        $job = $this->findById($id);
        if (!$job) {
            return false;
        }
        $job->update($data);
        return true;
    }

    /**
     * Delete a job in the database
     */
    public function deleteJob(string $id): bool
    {
        $job = $this->findById($id);
        if (!$job) {
            return false;
        }
        return $job->delete();
    }

    /**
     * Get all jobs
     */
    public function getAllJobs(): Collection
    {
        return Job::all();
    }

    /**
     * Get jobs by company id
     */
    public function getJobsByCompanyId(string $companyId): Collection
    {
        return Job::where('company_id', $companyId)->get();
    }

    /**
     * Get jobs by category id
     */
    public function getJobsByCategoryId(string $categoryId): Collection
    {
        return Job::where('category_id', $categoryId)->get();
    }

    /**
     * Get jobs by job type
     */
    public function getJobsByJobType(string $jobType): Collection
    {
        return Job::where('job_type', $jobType)->get();
    }

    /**
     * Get jobs by location
     */
    public function getJobsByLocation(string $location): Collection
    {
        return Job::where('city', $location)->get();
    }

    /**
     * Get jobs by salary range
     */
    public function getJobsBySalaryRange(int $minSalary, int $maxSalary): Collection
    {
        return Job::whereBetween('salary', [$minSalary, $maxSalary])->get();
    }

    /**
     * Get jobs by status
     */
    public function getJobsByStatus(string $status): Collection
    {
        return Job::where('status', $status)->get();
    }

    /**
     * Get jobs by deadline
     */
    public function getJobsByDeadline(string $deadline): Collection
    {
        return Job::where('deadline', $deadline)->get();
    }

    /**
     * Get jobs by user id
     */
    public function getJobsByUserId(string $userId): Collection
    {
        return Job::where('user_id', $userId)->get();
    }

    /**
     * Get jobs by search query
     */
    public function searchJobs(string $query): Collection
    {
        return Job::where('title', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->get();
    }
}
