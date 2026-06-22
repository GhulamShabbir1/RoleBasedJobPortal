<?php

namespace App\Http\Controllers;

use App\DTOs\Job\ApplyJobDTO;
use App\DTOs\Job\CreateJobDTO;
use App\DTOs\Job\FiltreJobDTO;
use App\DTOs\Job\UpdateJobDTO;
use App\Features\Job\ApplyJobFeature;
use App\Features\Job\CreateJobFeature;
use App\Features\Job\FiltreJobFeature;
use App\Features\Job\UpdateJobFeature;
use App\Http\Requests\ApplyJobRequest;
use App\Http\Requests\CreateJobRequest;
use App\Http\Requests\FiltreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Repositories\Interfaces\JobRepositoryInterface;
use Illuminate\Http\JsonResponse;

class JobController extends Controller
{
    public function __construct(
        private readonly JobRepositoryInterface $jobRepository
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
            ], 500);
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
            $jobs = $feature->handle($dto);

            return response()->json([
                'success' => true,
                'data' => $jobs,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get single job details
     */
    public function show(int $id): JsonResponse
    {
        try {
            $job = $this->jobRepository->findById((string)$id);

            if (!$job) {
                return response()->json([
                    'success' => false,
                    'message' => 'Job not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $job,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
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
            ], 500);
        }
    }

    /**
     * Delete a job posting
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $result = $this->jobRepository->deleteJob((string)$id);

            if (!$result) {
                return response()->json([
                    'success' => false,
                    'message' => 'Job not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Job deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
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
            ], 500);
        }
    }
}
