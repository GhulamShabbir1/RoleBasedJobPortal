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
     * Get all jobs with eager loaded relationships
     */
    public function getAllJobs(): Collection
    {
        return Job::with('category', 'company', 'applications')->get();
    }

    /**
     * Get jobs by company id
     */
    public function getJobsByCompanyId(string $companyId): Collection
    {
        return Job::where('company_id', $companyId)
            ->with('category', 'company', 'applications')
            ->get();
    }

    /**
     * Get jobs by category id
     */
    public function getJobsByCategoryId(string $categoryId): Collection
    {
        return Job::where('category_id', $categoryId)
            ->with('category', 'company', 'applications')
            ->get();
    }

    /**
     * Get jobs by job type
     */
    public function getJobsByJobType(string $jobType): Collection
    {
        return Job::where('job_type', $jobType)
            ->with('category', 'company', 'applications')
            ->get();
    }

    /**
     * Get jobs by location
     */
    public function getJobsByLocation(string $location): Collection
    {
        return Job::where('city', $location)
            ->with('category', 'company', 'applications')
            ->get();
    }

    /**
     * Get jobs by salary range
     */
    public function getJobsBySalaryRange(int $minSalary, int $maxSalary): Collection
    {
        return Job::where('min_salary', '>=', $minSalary)
            ->where('max_salary', '<=', $maxSalary)
            ->with('category', 'company', 'applications')
            ->get();
    }

    /**
     * Get jobs by status
     */
    public function getJobsByStatus(string $status): Collection
    {
        return Job::where('status', $status)
            ->with('category', 'company', 'applications')
            ->get();
    }

    /**
     * Get jobs by deadline
     */
    public function getJobsByDeadline(string $deadline): Collection
    {
        return Job::where('deadline', $deadline)
            ->with('category', 'company', 'applications')
            ->get();
    }

    /**
     * Get jobs by user id
     */
    public function getJobsByUserId(string $userId): Collection
    {
        return Job::where('user_id', $userId)
            ->with('category', 'company', 'applications')
            ->get();
    }

    /**
     * Get jobs by search query
     */
    public function searchJobs(string $query): Collection
    {
        return Job::where('title', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->with('category', 'company', 'applications')
            ->get();
    }

    /**
     * Filter and paginate jobs
     */
    public function filterJobs(array $filters, int $page, int $perPage, ?string $role = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Job::query()
            ->with('category', 'company', 'applications')
            ->select('jobs.*')
            ->join('companies', 'companies.id', '=', 'jobs.company_id');

        // Apply role-based filters
        if (!in_array($role, ['admin', 'employer'])) {
            $query->where('jobs.status', 'open')
                  ->where('companies.status', 'approved');
        }

        if (!empty($filters['search'])) {
            $query->where(function($q) use ($filters) {
                $q->where('jobs.title', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('jobs.description', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('companies.name', 'like', '%' . $filters['search'] . '%');
            });
        }
        if (!empty($filters['category_id'])) {
            $query->where('jobs.category_id', $filters['category_id']);
        }
        if (!empty($filters['job_type'])) {
            $query->where('jobs.job_type', $filters['job_type']);
        }
        if (!empty($filters['city'])) {
            $query->where('jobs.city', $filters['city']);
        }
        if (!empty($filters['status'])) {
            $query->where('jobs.status', $filters['status']);
        }

        if (isset($filters['min_salary']) && is_numeric($filters['min_salary'])) {
            $query->where('jobs.max_salary', '>=', $filters['min_salary']);
        }
        if (isset($filters['max_salary']) && is_numeric($filters['max_salary'])) {
            $query->where('jobs.min_salary', '<=', $filters['max_salary']);
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
