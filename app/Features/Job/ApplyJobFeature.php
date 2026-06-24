<?php

namespace App\Features\Job;

use App\DTOs\Job\ApplyJobDTO;
use App\Models\Application;
use App\Repositories\Interfaces\JobRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

/**
 * ApplyJobFeature
 * Business logic for applying for a job with file upload validation
 */
class ApplyJobFeature
{
    private const ALLOWED_MIME_TYPES = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];

    private const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB
    private const ALLOWED_EXTENSIONS = ['pdf', 'doc', 'docx'];

    public function __construct(
        private readonly JobRepositoryInterface $jobRepository
    ) {
    }

    /**
     * Apply for a job
     *
     * @param ApplyJobDTO $dto Job application data
     * @return Application
     * @throws Exception
     */
    public function handle(ApplyJobDTO $dto): Application
    {
        try {
            $jobId = $dto->job_id;

            // 1. Check if job exists
            $job = $this->jobRepository->findById($jobId);
            if (!$job) {
                throw new Exception('Job not found', 404);
            }

            // 2. Check if candidate already applied (Duplicate Prevention)
            $existing = Application::where('job_id', $jobId)
                                   ->where('candidate_id', auth()->id())
                                   ->exists();

            if ($existing) {
                Log::warning('Duplicate application attempt', [
                    'candidate_id' => auth()->id(),
                    'job_id' => $jobId,
                    'timestamp' => now()
                ]);
                throw new Exception('You have already applied to this job', 409);
            }

            // 3. Check if job is open
            if (!isset($job->status) || $job->status !== 'open') {
                throw new Exception('This job is not open for applications', 403);
            }

            // Ensure company relation is loaded for status check
            $job->loadMissing('company');

            // 4. Check if company is approved
            if (!$job->company || $job->company->status !== 'approved') {
                throw new Exception(
                    'This job is no longer available (company not approved)',
                    403
                );
            }

            // 5. Validate resume file
            if (!isset($dto->resume) || !$dto->resume) {
                throw new Exception('Resume file is required', 422);
            }

            $this->validateResume($dto->resume);

            // 5. Store resume file
            $resumePath = $this->storeResume($dto->resume, $jobId);

            // 6. Create application record
            $data = $dto->toArray();
            $data['status'] = 'pending';
            $data['job_id'] = $jobId;
            $data['candidate_id'] = auth()->id();
            $data['resume_path'] = $resumePath;
            $data['applied_at'] = now();

            $application = Application::create($data);

            Log::info('Application created successfully', [
                'application_id' => $application->id,
                'candidate_id' => auth()->id(),
                'job_id' => $jobId
            ]);

            return $application;

        } catch (\Illuminate\Database\QueryException $e) {
            // Handle duplicate key error from database constraint
            if ($e->getCode() === '23000') {
                Log::warning('Database duplicate key error', [
                    'candidate_id' => auth()->id(),
                    'job_id' => $jobId ?? null
                ]);
                throw new Exception('You have already applied to this job', 409);
            }
            throw $e;
        } catch (Exception $e) {
            Log::error('Application creation failed', [
                'error' => $e->getMessage(),
                'candidate_id' => auth()->id(),
                'job_id' => $jobId ?? null
            ]);
            throw $e;
        }
    }

    /**
     * Validate resume file
     */
    private function validateResume($file): void
    {
        // 1. Check file is uploaded
        if (!$file->isValid()) {
            throw new Exception('Resume file is corrupted or invalid', 422);
        }

        // 2. Check file size
        if ($file->getSize() > self::MAX_FILE_SIZE) {
            throw new Exception(
                'Resume must be less than 5MB. Current size: ' .
                round($file->getSize() / 1024 / 1024, 2) . 'MB',
                422
            );
        }

        // 3. Check file extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, self::ALLOWED_EXTENSIONS)) {
            throw new Exception(
                'Resume must be PDF or DOCX format. Received: .' . $extension,
                422
            );
        }

        // 4. Check MIME type
        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, self::ALLOWED_MIME_TYPES)) {
            throw new Exception(
                'Invalid resume file format. Please upload PDF or DOCX.',
                422
            );
        }

        // 5. Try to read file (detect corruption)
        try {
            $content = $file->get();
            if (empty($content)) {
                throw new Exception('Resume file is empty', 422);
            }
        } catch (Exception $e) {
            throw new Exception('Cannot read resume file: ' . $e->getMessage(), 422);
        }
    }

    /**
     * Store resume in structured folder
     */
    private function storeResume($file, $jobId): string
    {
        try {
            // Create structured path
            $storagePath = sprintf(
                'resumes/%d/%d',
                $jobId,
                auth()->id()
            );

            // Ensure directory exists
            Storage::disk('public')->makeDirectory($storagePath);

            // Generate unique filename with timestamp
            $filename = sprintf(
                '%d_%s.%s',
                time(),
                str_replace(' ', '_', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)),
                $file->getClientOriginalExtension()
            );

            // Store file
            $path = $file->storeAs(
                $storagePath,
                $filename,
                'public'
            );

            if (!$path) {
                throw new Exception('Failed to store resume file', 500);
            }

            Log::info('Resume stored successfully', [
                'path' => $path,
                'candidate_id' => auth()->id(),
                'job_id' => $jobId,
                'file_size' => $file->getSize()
            ]);

            return $path;

        } catch (Exception $e) {
            Log::error('Resume storage failed', [
                'error' => $e->getMessage(),
                'candidate_id' => auth()->id(),
                'job_id' => $jobId
            ]);
            throw new Exception('Failed to upload resume. Please try again.', 500);
        }
    }
}
