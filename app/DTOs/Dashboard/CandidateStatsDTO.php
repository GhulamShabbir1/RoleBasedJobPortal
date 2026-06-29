<?php

namespace App\DTOs\Dashboard;

class CandidateStatsDTO
{
    public function __construct(
        public int $totalApplications,
        public int $pending,
        public int $reviewed,
        public int $accepted,
        public int $rejected
    ) {
    }

    public function toArray(): array
    {
        return [
            'total_applications' => $this->totalApplications,
            'pending_applications' => $this->pending,
            'reviewed_applications' => $this->reviewed,
            'accepted_applications' => $this->accepted,
            'rejected_applications' => $this->rejected
        ];
    }
}
