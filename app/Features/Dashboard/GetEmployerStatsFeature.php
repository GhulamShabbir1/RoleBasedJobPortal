<?php

namespace App\Features\Dashboard;

use App\DTOs\Dashboard\EmployerStatsDTO;
use App\Models\Application;
use App\Models\Job;

class GetEmployerStatsFeature
{
    public function handle(): EmployerStatsDTO
    {
        $userId = auth()->id();

        $totalJobs = Job::where('user_id', $userId)->count();
        $activeJobs = Job::where('user_id', $userId)->where('status', 'open')->count();
        $closedJobs = Job::where('user_id', $userId)->where('status', 'closed')->count();

        $totalApplications = Application::whereHas('job', fn($q) => $q->where('user_id', $userId))->count();
        $pendingApplications = Application::whereHas('job', fn($q) => $q->where('user_id', $userId))
            ->where('status', 'pending')->count();
        $acceptedApplications = Application::whereHas('job', fn($q) => $q->where('user_id', $userId))
            ->where('status', 'accepted')->count();

        return new EmployerStatsDTO(
            total_jobs: $totalJobs,
            active_jobs: $activeJobs,
            closed_jobs: $closedJobs,
            total_applications: $totalApplications,
            pending_applications: $pendingApplications,
            accepted_applications: $acceptedApplications,
            total_views: 0,
            response_rate: $totalApplications > 0 
                ? round(((($totalApplications - $pendingApplications) / $totalApplications) * 100), 1) . '%' 
                : '0%',
            avg_hire_time: 'N/A'
        );
    }
}
