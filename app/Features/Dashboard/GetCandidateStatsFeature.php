<?php

namespace App\Features\Dashboard;

use App\DTOs\Dashboard\CandidateStatsDTO;
use App\Models\Application;

class GetCandidateStatsFeature
{
    public function handle(): CandidateStatsDTO
    {
        $userId = auth()->id();

        return new CandidateStatsDTO(
            totalApplications: Application::where('candidate_id', $userId)->count(),
            pending: Application::where('candidate_id', $userId)->where('status', 'pending')->count(),
            reviewed: Application::where('candidate_id', $userId)->where('status', 'reviewed')->count(),
            accepted: Application::where('candidate_id', $userId)->where('status', 'accepted')->count(),
            rejected: Application::where('candidate_id', $userId)->where('status', 'rejected')->count()
        );
    }
}
