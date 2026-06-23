# Critical Fixes - Code Implementation Guide

**Priority**: 🔴 HIGH  
**Time to Implement**: 4-5 hours  
**Impact**: Production readiness

---

## FIX 1: File Upload Validation (ApplyJobFeature)

### Current Implementation (❌ Missing Validation)

```php
// app/Features/Job/ApplyJobFeature.php
public function handle(ApplyJobDTO $dto): Application
{
    // ❌ No file validation
    // ❌ No size check
    // ❌ No storage error handling
}
```

### Fixed Implementation (✅ Complete)

```php
<?php

namespace App\Features\Job;

use App\DTOs\Job\ApplyJobDTO;
use App\Models\Application;
use App\Repositories\Interfaces\JobRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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

    public function handle(ApplyJobDTO $dto): Application
    {
        try {
            $jobId = $dto->job_id;

            // 1. Check if job exists
            $job = $this->jobRepository->findById($jobId);
            if (!$job) {
                throw new Exception('Job not found', 404);
            }

            // 2. Check if candidate already applied
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

            // 3. Check if company is approved
            if ($job->company->status !== 'approved') {
                throw new Exception(
                    'This job is no longer available (company not approved)',
                    403
                );
            }

            // 4. Validate resume file
            if (!$dto->resume) {
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

            // Generate unique filename
            $filename = sprintf(
                '%d_%s.%s',
                time(),
                str_slug($file->getClientOriginalName()),
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
                'job_id' => $jobId
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
```

---

## FIX 2: File Validation in FormRequest

### Create/Update: ApplyJobRequest

```php
<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ApplyJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'candidate';
    }

    public function rules(): array
    {
        return [
            'job_id' => [
                'required',
                'exists:jobs,id',
                function ($attribute, $value, $fail) {
                    $job = \App\Models\Job::find($value);
                    
                    if (!$job) {
                        $fail('Job not found');
                    }
                    
                    if ($job->status === 'closed') {
                        $fail('This job is no longer accepting applications');
                    }
                    
                    if ($job->dead_line < now()) {
                        $fail('Application deadline has passed');
                    }
                }
            ],
            'cover_letter' => 'nullable|string|max:500',
            'resume' => [
                'required',
                'file',
                'mimes:pdf,doc,docx',
                'max:5120', // 5MB in KB
                function ($attribute, $value, $fail) {
                    if (!$value->isValid()) {
                        $fail('Resume file is corrupted');
                    }
                    
                    // Additional check for file content
                    if ($value->getSize() === 0) {
                        $fail('Resume file is empty');
                    }
                }
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'job_id.required' => 'Job ID is required',
            'job_id.exists' => 'Job not found',
            'resume.required' => 'Resume file is required',
            'resume.file' => 'Resume must be a file',
            'resume.mimes' => 'Resume must be PDF, DOC, or DOCX format',
            'resume.max' => 'Resume must be less than 5MB',
            'cover_letter.max' => 'Cover letter cannot exceed 500 characters'
        ];
    }
}
```

---

## FIX 3: Company Approval Check (CreateJobFeature)

### Current Implementation (❌ Missing Check)

```php
public function handle(CreateJobDTO $dto): Job
{
    // ❌ Doesn't check if company is approved
    return Job::create($data);
}
```

### Fixed Implementation (✅ Complete)

```php
<?php

namespace App\Features\Job;

use App\DTOs\Job\CreateJobDTO;
use App\Models\Job;
use Exception;
use Illuminate\Support\Facades\Log;

class CreateJobFeature
{
    public function handle(CreateJobDTO $dto): Job
    {
        try {
            // 1. Get employer's company
            $employer = auth()->user();
            
            if ($employer->role !== 'employer') {
                throw new Exception('Only employers can post jobs', 403);
            }

            $company = $employer->company;

            // 2. Check if company exists
            if (!$company) {
                throw new Exception(
                    'You must create a company before posting jobs',
                    403
                );
            }

            // 3. Check if company is approved
            if ($company->status === 'pending_approval') {
                throw new Exception(
                    'Your company is pending approval. Please wait for admin review.',
                    403
                );
            }

            if ($company->status === 'rejected') {
                throw new Exception(
                    'Your company was rejected. Contact admin for details.',
                    403
                );
            }

            if ($company->status !== 'approved') {
                throw new Exception(
                    "Invalid company status: {$company->status}",
                    403
                );
            }

            // 4. Validate category exists
            $category = \App\Models\Category::find($dto->category_id);
            if (!$category) {
                throw new Exception('Category not found', 404);
            }

            // 5. Prepare data
            $data = $dto->toArray();
            $data['user_id'] = auth()->id();
            $data['company_id'] = $company->id;
            $data['status'] = 'active';
            
            if (!isset($data['created_at'])) {
                $data['created_at'] = now();
            }

            // 6. Create job
            $job = Job::create($data);

            Log::info('Job created successfully', [
                'job_id' => $job->id,
                'employer_id' => auth()->id(),
                'company_id' => $company->id,
                'title' => $job->title
            ]);

            return $job;

        } catch (Exception $e) {
            Log::error('Job creation failed', [
                'error' => $e->getMessage(),
                'employer_id' => auth()->id()
            ]);
            throw $e;
        }
    }
}
```

---

## FIX 4: Database Unique Constraint

### Create Migration

```bash
php artisan make:migration add_unique_constraint_to_applications
```

### Migration File

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            // Add unique constraint to prevent duplicate applications
            $table->unique(
                ['job_id', 'candidate_id'],
                'unique_job_application'
            );
            
            // Add indexes for query performance
            $table->index(['job_id'], 'idx_job_id');
            $table->index(['candidate_id'], 'idx_candidate_id');
            $table->index(['status'], 'idx_status');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropUnique('unique_job_application');
            $table->dropIndex('idx_job_id');
            $table->dropIndex('idx_candidate_id');
            $table->dropIndex('idx_status');
        });
    }
};
```

### Run Migration

```bash
php artisan migrate
```

---

## FIX 5: Handle Database Constraint in Feature

```php
// In ApplyJobFeature.php - handle race condition

catch (\Illuminate\Database\QueryException $e) {
    if ($e->getCode() === '23000') { // Duplicate key error
        Log::warning('Database duplicate key error', [
            'candidate_id' => auth()->id(),
            'job_id' => $jobId
        ]);
        throw new Exception('You have already applied to this job', 409);
    }
    throw $e;
}
```

---

## FIX 6: Storage Structure Setup

### Create Storage Directories in Feature

```php
// In CreateCompanyFeature.php

private function createStorageDirectories($company): void
{
    $basePath = "companies/{$company->id}";
    
    try {
        \Storage::disk('public')->makeDirectory($basePath);
        \Storage::disk('public')->makeDirectory($basePath . '/documents');
        
        Log::info('Company storage directories created', [
            'company_id' => $company->id,
            'base_path' => $basePath
        ]);
    } catch (Exception $e) {
        Log::error('Failed to create storage directories', [
            'error' => $e->getMessage(),
            'company_id' => $company->id
        ]);
    }
}
```

---

## FIX 7: Company Approval Check in FormRequest

```php
<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Check user is employer
        if (auth()->user()->role !== 'employer') {
            return false;
        }

        // Check company exists and is approved
        $company = auth()->user()->company;
        
        if (!$company) {
            return false;
        }

        if ($company->status !== 'approved') {
            return false;
        }

        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'city' => 'required|string|max:100',
            'job_type' => 'required|in:full-time,part-time,contract',
            'min_salary' => 'required|numeric|min:0',
            'max_salary' => 'required|numeric|min:0|gte:min_salary',
            'dead_line' => 'required|date|after_or_equal:today|before_or_equal:' . now()->addMonths(3)->format('Y-m-d'),
            'vacancies' => 'required|integer|min:1|max:100'
        ];
    }

    public function messages(): array
    {
        return [
            'authorize' => 'Your company must be approved before posting jobs',
            'max_salary.gte' => 'Maximum salary must be greater than or equal to minimum salary',
            'dead_line.after_or_equal' => 'Application deadline must be today or later',
            'dead_line.before_or_equal' => 'Application deadline cannot be more than 3 months from now'
        ];
    }
}
```

---

## FIX 8: Enhanced Exception Mapping in Controller

```php
<?php

namespace App\Http\Controllers;

use App\Features\Job\ApplyJobFeature;
use App\Http\Requests\ApplyJobRequest;
use Illuminate\Http\JsonResponse;

class JobController extends Controller
{
    public function apply(
        ApplyJobRequest $request,
        ApplyJobFeature $feature
    ): JsonResponse {
        try {
            $dto = ApplyJobDTO::fromRequest($request);
            $application = $feature->handle($dto);

            return response()->json([
                'success' => true,
                'message' => 'Applied successfully',
                'data' => $application,
            ], 201);

        } catch (Exception $e) {
            // Map exception code to HTTP status
            $statusCode = match((int)$e->getCode()) {
                404 => 404,
                403 => 403,
                409 => 409,
                422 => 422,
                default => 500
            };

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], $statusCode);
        }
    }
}
```

---

## 📋 IMPLEMENTATION CHECKLIST

- [ ] Update ApplyJobFeature.php with validation
- [ ] Update ApplyJobRequest.php with file rules
- [ ] Update CreateJobFeature.php with approval check
- [ ] Create and run migration for unique constraint
- [ ] Update CreateJobRequest.php authorize() method
- [ ] Update JobController exception handling
- [ ] Create storage directories in features
- [ ] Add logging to all critical operations
- [ ] Test duplicate application prevention
- [ ] Test file upload validation
- [ ] Test company approval workflow

---

## 🧪 TESTING THE FIXES

### Test 1: File Upload Validation
```bash
# Try uploading invalid file type (should return 422)
POST /api/jobs/1/apply
- resume: resume.txt (invalid)

# Expected: 422 Validation Error
```

### Test 2: File Size Limit
```bash
# Try uploading file > 5MB (should return 422)
POST /api/jobs/1/apply
- resume: large_resume.pdf (10MB)

# Expected: 422 File too large
```

### Test 3: Duplicate Prevention
```bash
# Apply twice to same job (should return 409)
POST /api/jobs/1/apply (first)  → 201 Success
POST /api/jobs/1/apply (second) → 409 Conflict

# Expected: "Already applied to this job"
```

### Test 4: Company Approval
```bash
# Try posting job with unapproved company (should return 403)
POST /api/jobs
- company.status = "pending_approval"

# Expected: 403 Company not approved
```

---

## 📊 ESTIMATED IMPACT

| Fix | Effort | Impact | Risk |
|-----|--------|--------|------|
| File validation | 2h | High | Low |
| DB constraint | 1h | High | Low |
| Company check | 1h | High | Low |
| Storage structure | 1h | High | Low |
| **Total** | **5h** | **High** | **Low** |

---

## ✅ RESULT AFTER FIXES

- ✅ 100% file upload validation
- ✅ Race condition protected
- ✅ Company approval enforced
- ✅ Duplicate applications impossible
- ✅ Production ready
- ✅ Exception handling complete

**Estimated Result**: 100% production ready after implementation!
