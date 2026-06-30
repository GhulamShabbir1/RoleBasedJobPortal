<?php

namespace App\DTOs\Dashboard;

class EmployerStatsDTO
{
    public function __construct(
        public int $total_jobs,
        public int $active_jobs,
        public int $closed_jobs,
        public int $total_applications,
        public int $pending_applications,
        public int $accepted_applications,
        public int $total_views = 0,
        public string $response_rate = '0%',
        public string $avg_hire_time = 'N/A'
    ) {
    }

    public function toArray(): array
    {
        return [
            'total_jobs' => $this->total_jobs,
            'active_jobs' => $this->active_jobs,
            'closed_jobs' => $this->closed_jobs,
            'total_applications' => $this->total_applications,
            'pending_applications' => $this->pending_applications,
            'accepted_applications' => $this->accepted_applications,
            'total_views' => $this->total_views,
            'response_rate' => $this->response_rate,
            'avg_hire_time' => $this->avg_hire_time
        ];
    }
}
