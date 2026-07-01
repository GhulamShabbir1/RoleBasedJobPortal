<?php

namespace App\DTOs\Dashboard;

class AdminStatsDTO
{
    public function __construct(
        public int $totalUsers,
        public int $totalCompanies,
        public int $totalJobs,
        public int $totalApplications,
        public int $pendingCompanies
    ) {
    }

    public function toArray(): array
    {
        return [
            'total_users' => $this->totalUsers,
            'total_companies' => $this->totalCompanies,
            'total_jobs' => $this->totalJobs,
            'total_applications' => $this->totalApplications,
            'pending_companies' => $this->pendingCompanies
        ];
    }
}
