<?php

namespace App\Features\Application;

use App\Models\Application;
use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use Exception;

class GetApplicationFeature
{
    public function __construct(
        private readonly ApplicationRepositoryInterface $applicationRepository
    ) {
    }

    /**
     * Get a single application by ID
     *
     * @param string $applicationId Application ID
     * @return Application
     * @throws Exception
     */
    public function handle(string $applicationId): Application
    {
        try {
            $application = $this->applicationRepository->findById($applicationId);
            if (!$application) {
                throw new Exception('Application not found', 404);
            }

            $user = auth()->user();

            // Authorization: admin, job owner (employer), or candidate (own application only)
            $application->load('job');

            if ($user->role === 'admin') {
                // Admin can view any application
                return $application;
            } elseif ($user->role === 'employer' && $application->job->user_id === $user->id) {
                // Employer can view applications to their own jobs
                return $application;
            } elseif ($user->role === 'candidate' && $application->candidate_id === $user->id) {
                // Candidate can view only their own applications
                return $application;
            } else {
                throw new \Illuminate\Auth\Access\AuthorizationException('You do not have permission to view this application', 403);
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
}
