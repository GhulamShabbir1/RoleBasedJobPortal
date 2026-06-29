<?php

namespace App\Repositories\Eloquent;

use App\Models\Application;
use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ApplicationRepository implements ApplicationRepositoryInterface
{
    public function findById(string $id): ?Application
    {
        return Application::find($id);
    }

    public function getApplicationById(int $id): ?Application
    {
        return Application::find($id);
    }

    public function getApplicationStatusById(int $id): ?string
    {
        return Application::where('id', $id)->value('status');
    }

    public function filterApplicationsByCandidateId(int $candidateId, array $filters): LengthAwarePaginator
    {
        $query = Application::where('candidate_id', $candidateId);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['job_id'])) {
            $query->where('job_id', $filters['job_id']);
        }

        return $query->paginate(10);
    }

    public function filterApplicationsByEmployerId(int $employerId, array $filters): LengthAwarePaginator
    {
        $query = Application::whereHas('job', function($q) use ($employerId) {
            $q->where('user_id', $employerId);
        });

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['job_id'])) {
            $query->where('job_id', $filters['job_id']);
        }

        return $query->paginate(10);
    }

    public function filterAllApplications(array $filters): LengthAwarePaginator
    {
        $query = Application::query();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['job_id'])) {
            $query->where('job_id', $filters['job_id']);
        }

        if (!empty($filters['candidate_id'])) {
            $query->where('candidate_id', $filters['candidate_id']);
        }

        return $query->paginate(10);
    }

    public function createApplication(array $data): Application
    {
        return Application::create($data);
    }

    public function updateApplication(int $id, array $data): Application
    {
        $application = $this->getApplicationById($id);
        if (!$application) {
            throw new \Exception('Application not found');
        }
        $application->update($data);
        return $application;
    }

    public function deleteApplication(int $id): bool
    {
        $application = $this->getApplicationById($id);
        if (!$application) {
            return false;
        }
        return $application->delete();
    }
}
