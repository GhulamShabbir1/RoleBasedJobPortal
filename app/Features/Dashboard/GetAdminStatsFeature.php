<?php

namespace App\Features\Dashboard;

use App\DTOs\Dashboard\AdminStatsDTO;
use App\Models\Company;
use App\Models\Application;
use App\Models\Job;
use App\Models\User;

class GetAdminStatsFeature
{
    public function handle(): AdminStatsDTO
    {
        return new AdminStatsDTO(
            totalUsers: User::count(),
            totalCompanies: Company::count(),
            totalJobs: Job::count(),
            totalApplications: Application::count(),
            pendingCompanies: Company::where('status', 'pending')->count()
        );
    }
}
