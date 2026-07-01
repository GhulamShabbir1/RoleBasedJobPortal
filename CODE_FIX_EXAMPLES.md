# Code Fix Examples - Before & After

**Purpose:** Provide specific code examples for implementing coding standards  
**Date:** 2024

---

## 1. API RESPONSE FORMAT FIXES

### BEFORE: Inconsistent Response Format
```php
// JobController.php - Line 54
return response()->json([
    'success' => true,
    'message' => 'Job created successfully',
    'data' => $job,
], 201);

// Different format elsewhere
return response()->json([
    'success' => false,
    'message' => $e->getMessage(),
], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
```

### AFTER: Standardized Response Format
```php
// JobController.php - Line 54
return response()->json([
    'status' => true,
    'message' => 'Job created successfully',
    'data' => $job,
], 201);

// Consistent error format
return response()->json([
    'status' => false,
    'message' => $e->getMessage(),
    'errors' => [],
], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
```

---

## 2. PHPDOC CLASS DOCUMENTATION

### BEFORE: No Class Documentation
```php
<?php

namespace App\Http\Controllers;

class JobController extends Controller
{
    public function __construct(...)
    {
    }
}
```

### AFTER: Comprehensive Class Documentation
```php
<?php

namespace App\Http\Controllers;

/**
 * JobController
 * 
 * Handles all job-related operations including creation, retrieval, filtering,
 * updating, deletion, and job applications. Provides endpoints for:
 * - Public users: Browse and apply for jobs
 * - Employers: Create, manage, and monitor jobs
 * - Admins: Oversee all jobs and manage system
 */
class JobController extends Controller
{
    public function __construct(...)
    {
    }
}
```

---

## 3. MODEL PROPERTY DOCUMENTATION

### BEFORE: No @property Annotations
```php
<?php

namespace App\Models;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];
```

### AFTER: Complete @property Documentation
```php
<?php

namespace App\Models;

/**
 * User Model
 * 
 * Represents a system user with role-based access control.
 * Implements JWT authentication for API access.
 * 
 * @property int $id
 * @property string $name User's full name
 * @property string $email User's email address (unique)
 * @property string $password Hashed password
 * @property string $role User role: admin|employer|candidate
 * @property bool $is_active Account active status
 * @property \Carbon\Carbon $created_at Created timestamp
 * @property \Carbon\Carbon $updated_at Updated timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection $jobs Jobs created by user
 * @property-read \Illuminate\Database\Eloquent\Collection $applications Applications submitted by candidate
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];
```

---

## 4. METHOD DOCUMENTATION

### BEFORE: Minimal/No Documentation
```php
public function store(
    CreateJobRequest $request,
    CreateJobFeature $feature
): JsonResponse {
    try {
        $dto = CreateJobDTO::fromRequest($request);
        $job = $feature->handle($dto);
```

### AFTER: Complete Method Documentation
```php
/**
 * Create a new job posting
 * 
 * Validates request, creates DTO, processes through feature layer,
 * and returns standardized JSON response.
 * 
 * @param CreateJobRequest $request HTTP request with job details
 * @param CreateJobFeature $feature Feature class for business logic
 * @return JsonResponse JSON response with status, message, and job data
 * @throws Exception If job creation fails
 */
public function store(
    CreateJobRequest $request,
    CreateJobFeature $feature
): JsonResponse {
    try {
        $dto = CreateJobDTO::fromRequest($request);
        $job = $feature->handle($dto);
```

---

## 5. REPOSITORY TYPE HINTS

### BEFORE: Missing Type Hints
```php
class UserRepository implements UserRepositoryInterface
{
    protected $model;
    private const CACHE_KEY = 'users:';

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function findById(string $id): ?User
    {
        return $this->model->find($id);
    }
```

### AFTER: Complete Type Hints
```php
class UserRepository implements UserRepositoryInterface
{
    /**
     * User model instance
     * 
     * @var User
     */
    protected User $model;
    
    private const CACHE_KEY = 'users:';
    private const CACHE_TTL = 3600;

    /**
     * Initialize repository with user model
     * 
     * @param User $user User model instance
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Find user by ID
     * 
     * @param string $id User identifier
     * @return User|null User instance or null if not found
     */
    public function findById(string $id): ?User
    {
        return $this->model->find($id);
    }
```

---

## 6. DTO DOCUMENTATION

### BEFORE: Minimal DTO Documentation
```php
<?php

namespace App\DTOs\Job;

class CreateJobDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly int $category_id,
        public readonly string $job_type,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            title: $request->validated('title'),
            description: $request->validated('description'),
            category_id: $request->validated('category_id'),
            job_type: $request->validated('job_type'),
        );
    }
}
```

### AFTER: Complete DTO Documentation
```php
<?php

namespace App\DTOs\Job;

/**
 * CreateJobDTO
 * 
 * Data Transfer Object for creating new job postings.
 * Transfers validated data from request to feature layer.
 * 
 * @property string $title Job title/position name
 * @property string $description Full job description
 * @property int $category_id Job category identifier
 * @property string $job_type Employment type (full-time, part-time, etc.)
 * @property string $city Job location city
 * @property int|null $min_salary Minimum salary (nullable)
 * @property int|null $max_salary Maximum salary (nullable)
 */
class CreateJobDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly int $category_id,
        public readonly string $job_type,
        public readonly string $city,
        public readonly ?int $min_salary = null,
        public readonly ?int $max_salary = null,
    ) {
    }

    /**
     * Create DTO from validated HTTP request
     * 
     * @param Request $request HTTP request with validated data
     * @return static New instance with request data
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            title: $request->validated('title'),
            description: $request->validated('description'),
            category_id: $request->validated('category_id'),
            job_type: $request->validated('job_type'),
            city: $request->validated('city'),
            min_salary: $request->validated('min_salary'),
            max_salary: $request->validated('max_salary'),
        );
    }

    /**
     * Convert DTO to associative array
     * 
     * @return array DTO data as array
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'job_type' => $this->job_type,
            'city' => $this->city,
            'min_salary' => $this->min_salary,
            'max_salary' => $this->max_salary,
        ];
    }
}
```

---

## 7. PAGINATION RESPONSE FORMAT

### BEFORE: Inconsistent Pagination
```php
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
```

### AFTER: Standardized Pagination Response
```php
return response()->json([
    'status' => true,
    'message' => 'Users retrieved successfully',
    'data' => $paginated->items(),
    'pagination' => [
        'total' => $paginated->total(),
        'per_page' => $paginated->perPage(),
        'current_page' => $paginated->currentPage(),
        'last_page' => $paginated->lastPage(),
    ],
], 200);
```

---

## 8. ERROR RESPONSE FORMAT

### BEFORE: Inconsistent Error Responses
```php
catch (\Exception $e) {
    return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
    ], 500);
}

// Different format elsewhere
catch (\Exception $e) {
    return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
    ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
}
```

### AFTER: Standardized Error Response
```php
catch (\Illuminate\Validation\ValidationException $e) {
    return response()->json([
        'status' => false,
        'message' => 'Validation failed',
        'errors' => $e->errors(),
    ], 422);
}

catch (ModelNotFoundException $e) {
    return response()->json([
        'status' => false,
        'message' => 'Resource not found',
        'errors' => [],
    ], 404);
}

catch (\Exception $e) {
    return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'errors' => [],
    ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
}
```

---

## 9. FEATURE CLASS DOCUMENTATION

### BEFORE: Minimal Feature Documentation
```php
class ApplyJobFeature
{
    private const ALLOWED_MIME_TYPES = [
        'application/pdf',
        'application/msword',
    ];

    private const MAX_FILE_SIZE = 5 * 1024 * 1024;

    public function __construct(
        private readonly JobRepositoryInterface $jobRepository
    ) {
    }

    public function handle(ApplyJobDTO $dto): Application
    {
```

### AFTER: Complete Feature Documentation
```php
/**
 * ApplyJobFeature
 * 
 * Handles business logic for job applications including:
 * - Job availability validation
 * - Duplicate application prevention
 * - Resume file validation and storage
 * - Application record creation
 * 
 * Supported file types: PDF, DOC, DOCX (max 5MB)
 */
class ApplyJobFeature
{
    private const ALLOWED_MIME_TYPES = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];

    private const MAX_FILE_SIZE_BYTES = 5 * 1024 * 1024;
    private const ALLOWED_EXTENSIONS = ['pdf', 'doc', 'docx'];

    /**
     * Initialize feature with job repository
     * 
     * @param JobRepositoryInterface $jobRepository Repository for job queries
     */
    public function __construct(
        private readonly JobRepositoryInterface $jobRepository
    ) {
    }

    /**
     * Process job application
     * 
     * Validates job exists, checks for duplicates, verifies job is open,
     * validates and stores resume, creates application record.
     * 
     * @param ApplyJobDTO $dto Application data including resume file
     * @return Application Created application record
     * @throws Exception If validation fails or job not found
     */
    public function handle(ApplyJobDTO $dto): Application
    {
```

---

## 10. EXTRACT CONSTANTS FROM MAGIC VALUES

### BEFORE: Magic Strings in Code
```php
if (!in_array($status, ['open', 'closed'])) {
    return response()->json([
        'success' => false,
        'message' => 'Invalid status. Must be "open" or "closed"',
    ], 400);
}

if ($job->user->role !== 'admin' && $job->user_id !== $user->id) {
    // unauthorized
}
```

### AFTER: Extracted Constants
```php
// app/Constants/JobStatus.php
<?php

namespace App\Constants;

class JobStatus
{
    const OPEN = 'open';
    const CLOSED = 'closed';
    
    const VALID_STATUSES = [
        self::OPEN,
        self::CLOSED,
    ];
}

// app/Constants/UserRole.php
<?php

namespace App\Constants;

class UserRole
{
    const ADMIN = 'admin';
    const EMPLOYER = 'employer';
    const CANDIDATE = 'candidate';
}

// Usage in JobController
if (!in_array($status, JobStatus::VALID_STATUSES)) {
    return response()->json([
        'status' => false,
        'message' => sprintf('Invalid status. Must be %s', implode(' or ', JobStatus::VALID_STATUSES)),
    ], 400);
}

if ($job->user->role !== UserRole::ADMIN && $job->user_id !== $user->id) {
    // unauthorized
}
```

---

## 11. ROUTE MIDDLEWARE DOCUMENTATION

### BEFORE: Unclear Route Middleware
```php
Route::middleware('jwt')->group(function () {
    Route::middleware('role:candidate')->prefix('candidate')->group(function () {
        Route::prefix('profiles')->group(function () {
            Route::get('/me', [CandidateProfileController::class, 'me']);
            Route::post('/', [CandidateProfileController::class, 'store']);
        });
    });
});
```

### AFTER: Documented Route Middleware
```php
// Protected routes - require JWT authentication
Route::middleware('jwt')->group(function () {
    
    // Candidate-only routes
    // Middleware: jwt (required), role:candidate (verified)
    Route::middleware('role:candidate')->prefix('candidate')->group(function () {
        
        /**
         * Candidate Profile Routes
         * 
         * GET  /api/candidate/profiles/me     - Get current user's profile
         * POST /api/candidate/profiles        - Create new profile
         * PUT  /api/candidate/profiles/{id}   - Update existing profile
         * DELETE /api/candidate/profiles/{id} - Delete profile
         */
        Route::prefix('profiles')->group(function () {
            Route::get('/me', [CandidateProfileController::class, 'me'])->name('profiles.me');
            Route::post('/', [CandidateProfileController::class, 'store'])->name('profiles.store');
            Route::put('/{id}', [CandidateProfileController::class, 'update'])->name('profiles.update');
            Route::delete('/{id}', [CandidateProfileController::class, 'destroy'])->name('profiles.destroy');
        });
    });
});
```

---

## 12. PRIVATE METHOD DOCUMENTATION

### BEFORE: Undocumented Private Methods
```php
private function validateResume($file): void
{
    if (!$file->isValid()) {
        throw new Exception('Resume file is corrupted or invalid', 422);
    }

    if ($file->getSize() > self::MAX_FILE_SIZE) {
        throw new Exception(
            'Resume must be less than 5MB. Current size: ' .
            round($file->getSize() / 1024 / 1024, 2) . 'MB',
            422
        );
    }
}

private function storeResume($file, $jobId): string
{
```

### AFTER: Documented Private Methods
```php
/**
 * Validate resume file meets requirements
 * 
 * Checks file validity, size, extension, MIME type, and readability.
 * 
 * @param \Illuminate\Http\UploadedFile $file Resume file to validate
 * @return void
 * @throws Exception If validation fails
 */
private function validateResume($file): void
{
    if (!$file->isValid()) {
        throw new Exception('Resume file is corrupted or invalid', 422);
    }

    if ($file->getSize() > self::MAX_FILE_SIZE_BYTES) {
        $sizeMB = round($file->getSize() / 1024 / 1024, 2);
        throw new Exception(
            "Resume must be less than 5MB. Current size: {$sizeMB}MB",
            422
        );
    }
}

/**
 * Store resume file in structured directory
 * 
 * Creates resume/{jobId}/{userId}/ directory and stores file with
 * timestamp-based filename for uniqueness.
 * 
 * @param \Illuminate\Http\UploadedFile $file Resume file to store
 * @param int $jobId Job identifier for directory structure
 * @return string Relative path to stored file
 * @throws Exception If storage fails
 */
private function storeResume($file, $jobId): string
{
```

---

## SUMMARY OF KEY CHANGES

| Category | Before | After |
|----------|--------|-------|
| Response Key | 'success' | 'status' (boolean) |
| Error Field | Missing | 'errors' object |
| Message Field | Sometimes missing | Always present |
| Class Docs | Absent | Comprehensive |
| @property | Missing | Complete with descriptions |
| @param Docs | Partial/missing | Complete with types |
| @return Docs | Missing | Complete with types |
| Type Hints | Missing | On properties and methods |
| Constants | Magic strings | Named constants |
| Route Docs | Minimal | Clear with examples |
| Private Methods | Undocumented | Fully documented |

**Next:** Use these examples as templates for fixing all files in the project.
