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
            'totalUsers' => $this->totalUsers,
            'totalCompanies' => $this->totalCompanies,
            'totalJobs' => $this->totalJobs,
            'totalApplications' => $this->totalApplications,
            'pendingCompanies' => $this->pendingCompanies
        ];
    }
}
