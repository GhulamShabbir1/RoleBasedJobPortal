<?php

namespace App\DTOs\Dashboard;

class EmployerStatsDTO
{
    public function __construct(
        public int $totalJobs,
        public int $openJobs,
        public int $closedJobs,
        public int $totalApplications
    ) {
    }

    public function toArray(): array
    {
        return [
            'totalJobs' => $this->totalJobs,
            'openJobs' => $this->openJobs,
            'closedJobs' => $this->closedJobs,
            'totalApplications' => $this->totalApplications
        ];
    }
}
