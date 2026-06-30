<?php

namespace App\Http\Controllers;

use App\DTOs\Job\ApplyJobDTO;
use App\DTOs\Job\CreateJobDTO;
use App\DTOs\Job\FiltreJobDTO;
use App\DTOs\Job\JobDTO;
use App\DTOs\Job\UpdateJobDTO;
use App\Features\Job\ApplyJobFeature;
use App\Features\Job\CloseJobFeature;
use App\Features\Job\CreateJobFeature;
use App\Features\Job\DeleteJobFeature;
use App\Features\Job\FiltreJobFeature;
use App\Features\Job\GetJobFeature;
use App\Features\Job\UpdateJobFeature;
use App\Http\Requests\ApplyJobRequest;
use App\Http\Requests\Job\CreateJobRequest;
use App\Http\Requests\Job\FiltreJobRequest;
use App\Http\Requests\Job\UpdateJobRequest;
use App\Repositories\Interfaces\JobRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Exception;

class JobController extends Controller
{
    public function __construct(
        private readonly JobRepositoryInterface $jobRepository,
        private readonly GetJobFeature $getJobFeature,
        private readonly DeleteJobFeature $deleteJobFeature,
        private readonly CloseJobFeature $closeJobFeature
    ) {
    }

    /**
     * Create a new job posting
     */
    public function store(
        CreateJobRequest $request,
        CreateJobFeature $feature
    ): JsonResponse {
        try {
            $dto = CreateJobDTO::fromRequest($request);
            $job = $feature->handle($dto);

            return response()->json([
                'success' => true,
                'message' => 'Job created successfully',
                'data' => $job,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
        }
    }

    /**
     * Get all jobs with filters
     */
    public function index(
        FiltreJobRequest $request,
        FiltreJobFeature $feature
    ): JsonResponse {
        try {
            $dto = FiltreJobDTO::fromRequest($request);
            $paginated = $feature->handle($dto);

            return response()->json([
                'success' => true,
                'data' => $paginated->items(),
                'pagination' => [
                    'total' => $paginated->total(),
                    'per_page' => $paginated->perPage(),
                    'current_page' => $paginated->currentPage(),
                    'last_page' => $paginated->lastPage(),
                    'from' => $paginated->firstItem(),
                    'to' => $paginated->lastItem(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
        }
    }

    /**
     * Get single job details
     */
    public function show(int $id): JsonResponse
    {
        try {
            $job = $this->getJobFeature->handle((string)$id);

            return response()->json([
                'success' => true,
                'data' => $job->toArray(),
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
        }
    }

    /**
     * Update a job posting
     */
    public function update(
        int $id,
        UpdateJobRequest $request,
        UpdateJobFeature $feature
    ): JsonResponse {
        try {
            $dto = UpdateJobDTO::fromRequest($request);
            $updatedJob = $feature->handle((string)$id, $dto);

            return response()->json([
                'success' => true,
                'message' => 'Job updated successfully',
                'data' => $updatedJob,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
        }
    }

    /**
     * Delete a job posting
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->deleteJobFeature->handle($id);

            return response()->json([
                'success' => true,
                'message' => 'Job deleted successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
        }
    }

    /**
     * Apply for a job
     */
    public function apply(
        ApplyJobRequest $request,
        ApplyJobFeature $feature
    ): JsonResponse {
        try {
            $dto = ApplyJobDTO::fromRequest($request);
            $application = $feature->handle($dto);

            return response()->json([
                'success' => true,
                'message' => 'Job applied successfully',
                'data' => $application,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
        }
    }

    /**
     * Close a job
     */
    public function close(int $id): JsonResponse
    {
        try {
            $job = $this->closeJobFeature->handle((string)$id);

            return response()->json([
                'success' => true,
                'message' => 'Job closed successfully',
                'data' => $job,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
        }
    }

    /**
     * Admin: get all jobs
     */
    public function adminIndex(): JsonResponse
    {
        try {
            $jobs = $this->jobRepository->getAllJobs();

            return response()->json([
                'success' => true,
                'data' => $jobs,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
        }
    }

    /**
     * Employer: get all my jobs
     */
    public function employerIndex(): JsonResponse
    {
        try {
            $jobs = $this->jobRepository->getJobsByUserId(auth()->id());

            return response()->json([
                'success' => true,
                'data' => $jobs,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
        }
    }

    /**
     * Employer: get a single job by id
     */
    public function employerShow(string $id): JsonResponse
    {
        try {
            $job = $this->jobRepository->getJobById($id);
            // Ensure job belongs to authenticated user
            if ($job->user_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to view this job',
                ], 403);
            }

            return response()->json([
                'success' => true,
                'data' => $job,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Job not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
        }
    }

    /**
     * Admin: update job status (open/closed)
     */
    public function updateStatus(int $id): JsonResponse
    {
        try {
            $status = request()->input('status');

            if (!in_array($status, ['open', 'closed'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid status. Must be "open" or "closed"',
                ], 400);
            }

            $updated = $this->jobRepository->updateJob($id, ['status' => $status]);

            if (!$updated) {
                return response()->json([
                    'success' => false,
                    'message' => 'Job not found',
                ], 404);
            }

            $job = $this->jobRepository->findById((string)$id);

            return response()->json([
                'success' => true,
                'message' => "Job status updated to {$status}",
                'data' => $job,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
        }
    }

    /**
     * Admin: delete any job
     */
    public function adminDestroy(int $id): JsonResponse
    {
        return $this->destroy($id);
    }
}
