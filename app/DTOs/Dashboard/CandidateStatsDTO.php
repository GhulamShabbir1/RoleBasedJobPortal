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
            'totalApplications' => $this->totalApplications,
            'pending' => $this->pending,
            'reviewed' => $this->reviewed,
            'accepted' => $this->accepted,
            'rejected' => $this->rejected
        ];
    }
}
