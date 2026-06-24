<?php

namespace App\Features\Application;

use App\Models\Application;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

class DownloadResumeFeature
{
    public function handle(string $applicationId): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $application = Application::with('job')->find($applicationId);

        if (!$application) {
            throw new ModelNotFoundException('Application not found');
        }

        $user = auth()->user();
        $role = $user?->role;

        // Authorization check
        $isAuthorized = false;
        if ($role === 'admin') {
            $isAuthorized = true;
        } elseif ($role === 'employer') {
            $isAuthorized = $application->job?->user_id === $user->id;
        } elseif ($role === 'candidate') {
            $isAuthorized = $application->candidate_id === $user->id;
        }

        if (!$isAuthorized) {
            throw new AuthorizationException('You are not authorized to download this resume');
        }

        if (!$application->resume_path) {
            throw new \Exception('Resume not found');
        }

        return Storage::download($application->resume_path);
    }
}
