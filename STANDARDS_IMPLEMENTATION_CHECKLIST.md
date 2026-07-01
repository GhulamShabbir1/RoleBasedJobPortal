# Coding Standards - Implementation Checklist

**Last Updated:** 2024  
**Total Issues:** 67  
**Estimated Effort:** 21 hours  

---

## QUICK REFERENCE

| Priority | Category | Count | Status |
|----------|----------|-------|--------|
| 🔴 CRITICAL | ID Encryption | 1 | ⬜ Not Started |
| 🔴 CRITICAL | Response Format | 12 | ⬜ Not Started |
| 🟠 HIGH | PHPDoc Class Level | 18 | ⬜ Not Started |
| 🟠 HIGH | @param/@return Docs | 20+ | ⬜ Not Started |
| 🟡 MEDIUM | Type Hints | 8 | ⬜ Not Started |
| 🟡 MEDIUM | Route Middleware | 5 | ⬜ Not Started |
| 🟢 LOW | Method Naming | 4 | ⬜ Not Started |

---

## PHASE 1: CRITICAL (Do First)

### Task 1.1: Implement ID Encryption
**Estimated Time:** 4 hours  
**Impact:** CRITICAL - Security

- [ ] Install Hashids package: `composer require vinkla/hashids`
- [ ] Create `app/Traits/HasEncryptedId.php` trait
- [ ] Implement encryption helper methods
- [ ] Create middleware for automatic ID decryption in requests
- [ ] Update base response helper to encrypt IDs
- [ ] Test with sample API calls
- [ ] Update API documentation

**Files to create:**
- [ ] `app/Traits/HasEncryptedId.php`
- [ ] `app/Http/Middleware/DecryptIds.php`
- [ ] `app/Services/IdEncryptionService.php`

**Files to update:**
- All 8 controllers (lines with response()->json())
- All repository methods returning objects

---

### Task 1.2: Standardize API Response Format

**Estimated Time:** 2 hours  
**Impact:** CRITICAL - Backend-Frontend Contract

**File-by-file checklist:**

#### JobController.php
- [ ] Line 54: Update success response format
  - [ ] Add 'status' => true
  - [ ] Ensure 'message' included
  - [ ] Verify 'data' structure
- [ ] Line 68-95: Update index() response
  - [ ] Add 'status' => true
  - [ ] Fix pagination format
- [ ] Line 111-160: Update show/update methods
  - [ ] Standardize error responses with 'errors' field
- [ ] Line 200+: Update all error catches
  - [ ] Use consistent error format

#### UserController.php
- [ ] Line 31-50: Update index() response format
  - [ ] Change 'success' to 'status'
  - [ ] Add 'message' to error responses
- [ ] Line 56-75: Update filter() method
  - [ ] Standardize pagination
- [ ] Line 99-118: Update show/update methods
  - [ ] Add missing 'message' keys
- [ ] Line 158+: Review all error responses

#### CandidateProfileController.php
- [ ] Line 24-42: Update index() response
- [ ] Line 50-75: Update filter() response
- [ ] Line 101: Review file upload response
- [ ] Line 113-189: Update all CRUD operations

#### ApplicationController.php
- [ ] Line 37-50: Fix inconsistent pagination
- [ ] Line 58-75: Update show() method
- [ ] Line 118-119: Review resume download

#### CategoryController.php
- [ ] Line 31-50: Standardize all responses
- [ ] Line 61-137: Fix error response format

#### CompanyController.php
- [ ] Line 31-115: Update all methods
- [ ] Fix 'success' → 'status' throughout

**Response Format Template:**
```php
// Copy this template for all responses
return response()->json([
    'status' => true,
    'message' => 'Operation description',
    'data' => $resource,
    // Optional pagination
    'pagination' => [
        'total' => $paginated->total(),
        'per_page' => $paginated->perPage(),
        'current_page' => $paginated->currentPage(),
        'last_page' => $paginated->lastPage(),
    ]
], 200);
```

---

## PHASE 2: HIGH PRIORITY (Next)

### Task 2.1: Add Class-Level PHPDoc

**Estimated Time:** 8 hours  
**Impact:** HIGH - Code Documentation

#### Controllers (8 files)
- [ ] JobController.php
  ```php
  /**
   * JobController
   * 
   * Handles all job-related operations including creation, retrieval, filtering,
   * updating, deletion, and job applications. Provides endpoints for candidates
   * to apply, employers to manage jobs, and admins to oversee all jobs.
   */
  ```

- [ ] UserController.php
  ```php
  /**
   * UserController
   * 
   * Manages user profile operations, role updates, status changes, and user
   * listing/filtering for administrators.
   */
  ```

- [ ] CandidateProfileController.php
  ```php
  /**
   * CandidateProfileController
   * 
   * Handles candidate profile CRUD operations, filtering, and resume uploads.
   * Candidates can create/update their profiles with resume files and skills.
   */
  ```

- [ ] ApplicationController.php
  ```php
  /**
   * ApplicationController
   * 
   * Manages job applications including status updates, resume downloads,
   * and filtering applications by role (candidate/employer/admin).
   */
  ```

- [ ] CategoryController.php
  ```php
  /**
   * CategoryController
   * 
   * Provides public access to job categories and admin capabilities
   * for category management (CRUD operations).
   */
  ```

- [ ] CompanyController.php
- [ ] AuthController.php
- [ ] DashboardController.php (if exists)

#### Models (6 files)
- [ ] User.php
  ```php
  /**
   * User Model
   * 
   * Represents a system user with role-based access (admin, employer, candidate).
   * Implements JWT authentication and has associations with companies, jobs,
   * applications, and candidate profiles.
   * 
   * @property int $id
   * @property string $name
   * @property string $email
   * @property string $password
   * @property string $role (admin|employer|candidate)
   * @property bool $is_active
   * @property \Carbon\Carbon $created_at
   * @property \Carbon\Carbon $updated_at
   */
  ```

- [ ] Job.php
- [ ] Application.php
- [ ] Category.php
- [ ] Company.php
- [ ] CandidateProfile.php

#### Repositories (7 files)
- [ ] UserRepository.php
- [ ] JobRepository.php
- [ ] ApplicationRepository.php
- [ ] CategoryRepository.php
- [ ] CompanyRepository.php
- [ ] CandidateProfileRepository.php
- [ ] AuthRepository.php

#### DTOs (15+ files)
- [ ] RegisterUserDTO.php
- [ ] LoginUserDTO.php
- [ ] CreateJobDTO.php
- [ ] UpdateJobDTO.php
- [ ] CreateCategoryDTO.php
- [ ] ApplyJobDTO.php
- [ ] And 9+ more DTO files

---

### Task 2.2: Add @property Annotations to Models

**Estimated Time:** 2 hours  
**Impact:** HIGH - IDE Support & Documentation

#### User.php
- [ ] Add @property for: id, name, email, password, role, is_active, created_at, updated_at
- [ ] Add @property-read for computed properties

#### Job.php
- [ ] Add @property for: id, user_id, company_id, category_id, title, description, city, job_type, min_salary, max_salary, deadline, vacancies, status, created_at, updated_at
- [ ] Add relationship @property for: user, category, applications, company

#### Application.php
- [ ] Add @property for: id, job_id, candidate_id, status, cover_letter, resume_path, applied_at, created_at, updated_at

#### Category.php
- [ ] Add @property for: id, name, description, created_at, updated_at

#### Company.php
- [ ] Add @property for all columns

#### CandidateProfile.php
- [ ] Add @property for all columns

---

### Task 2.3: Add @param and @return Documentation

**Estimated Time:** 4 hours  
**Impact:** HIGH - API Documentation

#### Controllers - All 8 files
For each public method, add:
```php
/**
 * Description of what method does
 * 
 * @param TypeHint $paramName Description
 * @return JsonResponse
 * @throws Exception Description
 */
```

#### Repositories - All 7 files
For each public method:
```php
/**
 * Description
 * 
 * @param int|string $id Identifier
 * @param array $data Data array
 * @return ModelClass|Collection|LengthAwarePaginator
 * @throws ModelNotFoundException
 */
```

#### DTOs - All 15+ files
For static and instance methods:
```php
/**
 * Create instance from request
 * 
 * @param Request $request HTTP request
 * @return static
 */
public static function fromRequest(Request $request): self
```

---

## PHASE 3: MEDIUM PRIORITY (Then)

### Task 3.1: Add Type Hints to Properties

**Estimated Time:** 1 hour  
**Impact:** MEDIUM - Type Safety

- [ ] UserRepository.php: Line 14
  - [ ] Change: `protected $model;` → `protected User $model;`

- [ ] CategoryRepository.php: Line 14
  - [ ] Change: `protected $model;` → `protected Category $model;`

- [ ] Similar changes in all 7 repositories

- [ ] All DTO classes: Add type hints to constructor properties
  ```php
  public function __construct(
      public readonly string $name,
      public readonly int $userId,
      // etc...
  ) { }
  ```

---

### Task 3.2: Add Route Middleware Documentation

**Estimated Time:** 1 hour  
**Impact:** MEDIUM - Route Clarity

#### routes/api.php
- [ ] Add middleware comment before each Route::middleware() block
  ```php
  // Protected routes - require JWT authentication
  Route::middleware('jwt')->group(function () {
      // Candidate-only routes
      Route::middleware('role:candidate')->group(function () {
          // ...
      });
  });
  ```

#### routes/web.php
- [ ] Add middleware comments where applicable
- [ ] Document role-based view redirects

---

### Task 3.3: Extract Constants from Magic Values

**Estimated Time:** 1 hour  
**Impact:** MEDIUM - Maintainability

- [ ] ApplyJobFeature.php: Extract MAX_FILE_SIZE, ALLOWED_EXTENSIONS
  ```php
  private const MAX_FILE_SIZE_MB = 5;
  private const MAX_FILE_SIZE_BYTES = self::MAX_FILE_SIZE_MB * 1024 * 1024;
  ```

- [ ] JobController.php: Extract status values
  ```php
  private const VALID_STATUSES = ['open', 'closed'];
  ```

- [ ] Create `app/Constants/Roles.php`:
  ```php
  class Roles {
      const ADMIN = 'admin';
      const EMPLOYER = 'employer';
      const CANDIDATE = 'candidate';
  }
  ```

- [ ] Create `app/Constants/JobStatus.php`
- [ ] Create `app/Constants/CompanyStatus.php`

---

## PHASE 4: LOW PRIORITY (Polish)

### Task 4.1: Fix Method Naming

**Estimated Time:** 1 hour  
**Impact:** LOW - Consistency

- [ ] JobController.php
  - [ ] Rename `adminIndex()` → consolidate into `index()` with conditional
  - [ ] Rename `employerIndex()` → consolidate
  - [ ] Rename `adminDestroy()` → consolidate

- [ ] UserController.php
  - [ ] Review method naming consistency

**Implementation:** Use route-based conditions instead of separate methods

---

### Task 4.2: Fix Route Naming Inconsistencies

**Estimated Time:** 1 hour  
**Impact:** LOW - Consistency

#### routes/api.php
- [ ] Line 32: Rename '/search' route to '/filter' or vice versa
- [ ] Ensure all list endpoints use consistent naming
- [ ] Update route names to follow 'resource.action' pattern throughout

---

### Task 4.3: Remove Debug Code

**Estimated Time:** 30 mins  
**Impact:** LOW - Security

- [ ] CandidateProfileController.php: Remove `debugListAllProfiles()` method
- [ ] routes/api.php: Remove debug endpoint reference
- [ ] Search for other debug methods or temporary code

---

## PHASE 5: VERIFICATION

### Task 5.1: Code Review Checklist

- [ ] All classes have PHPDoc with @property annotations
- [ ] All public methods have @param and @return
- [ ] All API responses use {status, message, data} format
- [ ] All IDs are encrypted in responses
- [ ] No debug code remains
- [ ] All routes have middleware documented
- [ ] No magic values in code
- [ ] Type hints added to all properties

### Task 5.2: Automated Checks

```bash
# Run these commands to verify
php artisan tinker

# Check response format
Route::get('/test', function () {
    return response()->json([
        'status' => true,
        'message' => 'OK',
        'data' => []
    ]);
});

# Run tests
php artisan test

# Code style check
./vendor/bin/phpcs --standard=PSR12 app/

# Static analysis
./vendor/bin/phpstan analyse app/
```

### Task 5.3: Integration Testing

- [ ] Test all CRUD endpoints with new response format
- [ ] Test ID encryption/decryption in API calls
- [ ] Test pagination responses
- [ ] Test error responses with new format
- [ ] Test with Postman/Insomnia collection
- [ ] Verify frontend still works with new format

---

## FILE STATUS TRACKER

### Controllers
- [ ] JobController.php - PENDING
- [ ] UserController.php - PENDING
- [ ] CandidateProfileController.php - PENDING
- [ ] ApplicationController.php - PENDING
- [ ] CategoryController.php - PENDING
- [ ] CompanyController.php - PENDING
- [ ] AuthController.php - PENDING
- [ ] DashboardController.php - PENDING

### Models
- [ ] User.php - PENDING
- [ ] Job.php - PENDING
- [ ] Application.php - PENDING
- [ ] Category.php - PENDING
- [ ] Company.php - PENDING
- [ ] CandidateProfile.php - PENDING

### Repositories
- [ ] UserRepository.php - PENDING
- [ ] JobRepository.php - PENDING
- [ ] ApplicationRepository.php - PENDING
- [ ] CategoryRepository.php - PENDING
- [ ] CompanyRepository.php - PENDING
- [ ] CandidateProfileRepository.php - PENDING
- [ ] AuthRepository.php - PENDING

### Features (20+ files)
- [ ] Job Feature files - PENDING
- [ ] User Feature files - PENDING
- [ ] Application Feature files - PENDING
- [ ] Category Feature files - PENDING
- [ ] Company Feature files - PENDING

### DTOs (15+ files)
- [ ] Auth DTOs - PENDING
- [ ] Job DTOs - PENDING
- [ ] User DTOs - PENDING
- [ ] Category DTOs - PENDING
- [ ] Company DTOs - PENDING

---

## PROGRESS TRACKING

| Phase | Task | Status | Hours |
|-------|------|--------|-------|
| 1 | ID Encryption | ⬜ | 4h |
| 1 | Response Format | ⬜ | 2h |
| 2 | Class PHPDoc | ⬜ | 8h |
| 2 | @property Docs | ⬜ | 2h |
| 2 | @param/@return | ⬜ | 4h |
| 3 | Type Hints | ⬜ | 1h |
| 3 | Route Middleware | ⬜ | 1h |
| 3 | Extract Constants | ⬜ | 1h |
| 4 | Method Naming | ⬜ | 1h |
| 4 | Route Naming | ⬜ | 1h |
| 4 | Remove Debug | ⬜ | 0.5h |
| 5 | Code Review | ⬜ | 1h |
| 5 | Automated Tests | ⬜ | 1h |
| 5 | Integration Tests | ⬜ | 2h |
| **TOTAL** | — | — | **21h** |

---

## NOTES FOR IMPLEMENTATION TEAM

1. **Start with Phase 1** - These are blocking issues for production
2. **Test after each phase** - Run full test suite to catch regressions
3. **Update frontend simultaneously** - Response format changes affect frontend
4. **Database backup first** - Though no schema changes, backup before deployment
5. **Use IDE features** - VS Code PHP DocBlocker can auto-generate stubs
6. **Review before merge** - Have 2 team members review critical changes
7. **Document as you go** - Update API docs after each controller update
8. **Communicate changes** - Notify frontend team of response format changes

---

## USEFUL COMMANDS

```bash
# Generate class PHPDoc stubs
# In VS Code: Type /** and press Enter above class

# Auto-format code
./vendor/bin/phpcbf --standard=PSR12 app/

# Find TODO markers
grep -r "TODO" app/

# Find debug functions
grep -r "var_dump\|dd\|debug" app/

# Count violations
grep -r "@property" app/ | wc -l

# List files without PHPDoc
find app -name "*.php" -exec grep -L "^/\*\*" {} \;
```

---

**Last Updated:** 2024  
**Next Review:** After completion of Phase 1  
**Owner:** Development Team  
**Status:** Ready for Implementation
