<?php

namespace App\Features\Job;

use App\DTOs\Job\JobDTO;
use App\Models\Job;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetJobFeature
{
    public function handle(string $jobId): JobDTO
    {
        $user = auth()->user();
        $role = $user?->role;

        $query = Job::with('company')
            ->where('jobs.id', $jobId);

        // Apply role-based filters
        if (!in_array($role, ['admin', 'employer'])) {
            $query->where('jobs.status', 'open')
                  ->whereHas('company', function ($q) {
                      $q->where('status', 'approved');
                  });
        }

        $job = $query->first();

        if (!$job) {
            throw new ModelNotFoundException('Job not found');
        }

        // Add company_name to job model if relation is loaded
        if ($job->relationLoaded('company') && $job->company) {
            $job->company_name = $job->company->name;
        }

        return JobDTO::fromModel($job);
    }
}
