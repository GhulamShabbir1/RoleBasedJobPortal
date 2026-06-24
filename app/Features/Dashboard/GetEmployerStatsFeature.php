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

        return new EmployerStatsDTO(
            totalJobs: Job::where('user_id', $userId)->count(),
            openJobs: Job::where('user_id', $userId)->where('status', 'open')->count(),
            closedJobs: Job::where('user_id', $userId)->where('status', 'closed')->count(),
            totalApplications: Application::whereHas('job', fn($q) => $q->where('user_id', $userId))->count()
        );
    }
}
