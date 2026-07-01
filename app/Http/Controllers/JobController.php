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

/**
 * JobController
 *
 * Handles all job-related operations including creation, retrieval, filtering,
 * updating, deletion, and job applications. Provides endpoints for candidates
 * to apply, employers to manage jobs, and admins to oversee all jobs.
 */
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
   *
   * @param CreateJobRequest $request HTTP request with job details
   * @param CreateJobFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with status, message, and job data
   */
  public function store(
    CreateJobRequest $request,
    CreateJobFeature $feature
  ): JsonResponse {
    try {
      $dto = CreateJobDTO::fromRequest($request);
      $job = $feature->handle($dto);

      return response()->json([
        'status' => true,
        'message' => 'Job created successfully',
        'data' => $job,
      ], 201);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }

  /**
   * Get all jobs with filters
   *
   * @param FiltreJobRequest $request HTTP request with filter criteria
   * @param FiltreJobFeature $feature Feature class for filtering jobs
   * @return JsonResponse Paginated JSON response with jobs
   */
  public function index(
    FiltreJobRequest $request,
    FiltreJobFeature $feature
  ): JsonResponse {
    try {
      $dto = FiltreJobDTO::fromRequest($request);
      $paginated = $feature->handle($dto);

      return response()->json([
        'status' => true,
        'message' => 'Jobs retrieved successfully',
        'data' => $paginated->items(),
        'pagination' => [
          'total' => $paginated->total(),
          'per_page' => $paginated->perPage(),
          'current_page' => $paginated->currentPage(),
          'last_page' => $paginated->lastPage(),
        ],
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }

  /**
   * Get single job details
   *
   * @param int $id Job identifier
   * @return JsonResponse JSON response with job data
   */
  public function show(int $id): JsonResponse
  {
    try {
      $job = $this->getJobFeature->handle((string)$id);

      return response()->json([
        'status' => true,
        'message' => 'Job retrieved successfully',
        'data' => $job->toArray(),
      ], 200);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'status' => false,
        'message' => 'Job not found',
        'errors' => [],
      ], 404);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }

  /**
   * Update a job posting
   *
   * @param int $id Job identifier
   * @param UpdateJobRequest $request HTTP request with updated job details
   * @param UpdateJobFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with updated job data
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
        'status' => true,
        'message' => 'Job updated successfully',
        'data' => $updatedJob,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }

  /**
   * Delete a job posting
   *
   * @param int $id Job identifier
   * @return JsonResponse JSON response with deletion status
   */
  public function destroy(int $id): JsonResponse
  {
    try {
      $this->deleteJobFeature->handle($id);

      return response()->json([
        'status' => true,
        'message' => 'Job deleted successfully',
        'data' => [],
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }

  /**
   * Apply for a job
   *
   * @param ApplyJobRequest $request HTTP request with application details
   * @param ApplyJobFeature $feature Feature class for business logic
   * @return JsonResponse JSON response with created application
   */
  public function apply(
    ApplyJobRequest $request,
    ApplyJobFeature $feature
  ): JsonResponse {
    try {
      $dto = ApplyJobDTO::fromRequest($request);
      $application = $feature->handle($dto);

      return response()->json([
        'status' => true,
        'message' => 'Job applied successfully',
        'data' => $application,
      ], 201);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }

  /**
   * Close a job
   *
   * @param int $id Job identifier
   * @return JsonResponse JSON response with updated job data
   */
  public function close(int $id): JsonResponse
  {
    try {
      $job = $this->closeJobFeature->handle((string)$id);

      return response()->json([
        'status' => true,
        'message' => 'Job closed successfully',
        'data' => $job,
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }

  /**
   * Open a job
   *
   * @param int $id Job identifier
   * @return JsonResponse JSON response with updated job data
   */
  public function open(int $id): JsonResponse
        {
            try {
                $job = $this->jobRepository->manage(['status' => 'open'], $id);
                
                return response()->json([
                    'status' => true,
                    'message' => 'Job opened successfully',
                    'data' => $job,
                ], 200);
            } catch (Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage(),
                    'errors' => [],
                ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
            }
        }

  /**
   * Get all jobs (Admin)
   *
   * @return JsonResponse JSON response with all jobs
   */
  public function adminIndex(): JsonResponse
  {
    try {
      $jobs = $this->jobRepository->getAllJobs();

      return response()->json([
        'status' => true,
        'message' => 'All jobs retrieved successfully',
        'data' => $jobs,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }

  /**
   * Get jobs by authenticated user (Employer)
   *
   * @return JsonResponse JSON response with employer's jobs
   */
  public function employerIndex(): JsonResponse
  {
    try {
      $jobs = $this->jobRepository->getJobsByUserId(auth()->id());

      return response()->json([
        'status' => true,
        'message' => 'Your jobs retrieved successfully',
        'data' => $jobs,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }

  /**
   * Get a single job by ID (Employer)
   *
   * @param string $id Job identifier
   * @return JsonResponse JSON response with job data
   */
  public function employerShow(string $id): JsonResponse
  {
    try {
      $job = $this->jobRepository->getJobById($id);
      // Ensure job belongs to authenticated user
      if ($job->user_id !== auth()->id()) {
        return response()->json([
          'status' => false,
          'message' => 'You are not authorized to view this job',
          'errors' => [],
        ], 403);
      }

      return response()->json([
        'status' => true,
        'message' => 'Job retrieved successfully',
        'data' => $job,
      ], 200);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'status' => false,
        'message' => 'Job not found',
        'errors' => [],
      ], 404);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }

  /**
   * Update job status (Admin)
   *
   * @param int $id Job identifier
   * @return JsonResponse JSON response with updated job data
   */
  public function updateStatus(int $id): JsonResponse
  {
    try {
      $status = request()->input('status');

      if (!in_array($status, ['open', 'closed'])) {
        return response()->json([
          'status' => false,
          'message' => 'Invalid status. Must be "open" or "closed"',
          'errors' => [],
        ], 400);
      }

      $job = $this->jobRepository->manage(['status' => $status], $id);

      return response()->json([
        'status' => true,
        'message' => "Job status updated to {$status}",
        'data' => $job,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
      ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    }
  }

  /**
   * Delete a job (Admin)
   *
   * @param int $id Job identifier
   * @return JsonResponse JSON response with deletion status
   */
  public function adminDestroy(int $id): JsonResponse
  {
    return $this->destroy($id);
  }
}
