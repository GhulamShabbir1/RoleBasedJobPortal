# 🏗️ Authentication Module - Clean Architecture

## Architecture Pattern

This authentication module follows **Feature-Driven Clean Architecture** with strict separation of concerns:

```
Request
  ↓
Middleware (JWT/Auth/Role)
  ↓
FormRequest (Validation ONLY)
  ↓
DTO (Data Transfer Object)
  ↓
Controller (Thin Layer - NO Business Logic)
  ↓
Feature Class (Business Use Case Layer)
  ↓
Repository (Database Operations ONLY)
  ↓
Model
  ↓
Database
```

---

## 📂 File Structure

```
app/
├── DTOs/Auth/
│   ├── RegisterUserDTO.php
│   ├── LoginUserDTO.php
│   ├── ForgotPasswordDTO.php
│   └── ResetPasswordDTO.php
│
├── Features/Auth/
│   ├── RegisterUserFeature.php
│   ├── LoginUserFeature.php
│   ├── LogoutUserFeature.php
│   ├── GetAuthenticatedUserFeature.php
│   ├── RefreshTokenFeature.php
│   ├── ForgotPasswordFeature.php
│   └── ResetPasswordFeature.php
│
├── Repositories/
│   ├── Interfaces/
│   │   └── AuthRepositoryInterface.php
│   └── Eloquent/
│       └── AuthRepository.php
│
├── Http/
│   ├── Requests/Auth/
│   │   ├── RegisterRequest.php
│   │   ├── LoginRequest.php
│   │   ├── ForgetRequest.php
│   │   └── ResetPasswordRequest.php
│   │
│   ├── Middleware/
│   │   ├── JwtMiddleware.php
│   │   └── RoleMiddleware.php
│   │
│   └── Controllers/
│       └── AuthController.php (ULTRA THIN)
│
└── Models/
    └── User.php
```

---

## 🎯 Layer Responsibilities

### 1. **FormRequest Layer** (Validation ONLY)
**Files:** `LoginRequest.php`, `RegisterRequest.php`, etc.

**Responsibilities:**
- ✅ Validate incoming request data
- ✅ Define validation rules
- ✅ Custom error messages
- ❌ NO business logic
- ❌ NO database queries
- ❌ NO data transformation

**Example:**
```php
public function rules(): array
{
    return [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];
}
```

---

### 2. **DTO Layer** (Data Transfer Objects)
**Files:** `RegisterUserDTO.php`, `LoginUserDTO.php`, etc.

**Responsibilities:**
- ✅ Transfer validated data between layers
- ✅ Type-safe data containers
- ✅ Immutable with readonly properties
- ✅ Factory method `fromRequest()`
- ❌ NO validation
- ❌ NO business logic

**Example:**
```php
class LoginUserDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            email: $request->validated('email'),
            password: $request->validated('password')
        );
    }
}
```

---

### 3. **Controller Layer** (Thin Orchestration)
**File:** `AuthController.php`

**Responsibilities:**
- ✅ Receive validated requests
- ✅ Create DTOs from requests
- ✅ Call Feature classes
- ✅ Return JSON responses
- ❌ NO validation logic
- ❌ NO business logic
- ❌ NO database queries

**Example:**
```php
public function register(
    RegisterRequest $request,
    RegisterUserFeature $feature
): JsonResponse {
    $dto = RegisterUserDTO::fromRequest($request);
    $result = $feature->handle($dto);
    
    return response()->json([
        'success' => true,
        'data' => $result,
    ], 201);
}
```

---

### 4. **Feature Layer** (Business Logic/Use Cases)
**Files:** `RegisterUserFeature.php`, `LoginUserFeature.php`, etc.

**Responsibilities:**
- ✅ Business logic implementation
- ✅ Use case orchestration
- ✅ Call repository methods
- ✅ Error handling
- ✅ Transaction management
- ❌ NO validation
- ❌ NO direct database queries
- ❌ NO HTTP concerns

**Example:**
```php
class RegisterUserFeature
{
    public function __construct(
        private readonly AuthRepositoryInterface $authRepository
    ) {}

    public function handle(RegisterUserDTO $dto): array
    {
        try {
            $user = $this->authRepository->createUser($dto->toArray());
            $token = auth()->login($user);
            
            return [
                'user' => $user,
                'token' => $token,
            ];
        } catch (Exception $e) {
            throw new Exception('Registration failed: ' . $e->getMessage());
        }
    }
}
```

---

### 5. **Repository Layer** (Database Operations ONLY)
**Files:** `AuthRepositoryInterface.php`, `AuthRepository.php`

**Responsibilities:**
- ✅ Database operations (CRUD)
- ✅ Query building
- ✅ Data persistence
- ✅ Implement interface contract
- ❌ NO business logic
- ❌ NO validation
- ❌ NO response formatting

**Example:**
```php
public function createUser(array $data): User
{
    return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role' => $data['role'] ?? 'candidate',
    ]);
}
```

---

### 6. **Middleware Layer** (Request Filtering)
**Files:** `JwtMiddleware.php`, `RoleMiddleware.php`

**Responsibilities:**
- ✅ Authentication verification
- ✅ Authorization checks
- ✅ Token validation
- ✅ Role-based access control

---

## 📊 Data Flow Examples

### Example 1: User Registration

```
1. POST /api/auth/register
   {
     "name": "John Doe",
     "email": "john@example.com",
     "password": "password123",
     "role": "candidate"
   }
   
2. RegisterRequest validates the data
   ✅ All fields present and valid
   
3. RegisterUserDTO::fromRequest() creates immutable DTO
   DTO {
     name: "John Doe",
     email: "john@example.com",
     password: "password123",
     role: "candidate"
   }
   
4. AuthController::register() calls Feature
   Controller is THIN - just orchestrates
   
5. RegisterUserFeature::handle(DTO) executes business logic
   - Calls AuthRepository to create user
   - Generates JWT token
   - Returns result
   
6. AuthRepository::createUser() performs DB operation
   - Hashes password
   - Creates user record
   - Returns User model
   
7. Controller returns JSON response
   {
     "success": true,
     "message": "User registered successfully",
     "data": {
       "user": {...},
       "token": "eyJ0eXAiOiJKV1QiLCJh..."
     }
   }
```

### Example 2: User Login

```
1. POST /api/auth/login
   {
     "email": "john@example.com",
     "password": "password123"
   }
   
2. LoginRequest validates credentials
   
3. LoginUserDTO::fromRequest() creates DTO
   
4. AuthController::login() calls LoginUserFeature
   
5. LoginUserFeature::handle(DTO) executes login logic
   - Calls AuthRepository::attemptLogin()
   - If successful, get current user
   - Return user + token
   
6. AuthRepository::attemptLogin() uses JWT auth
   - Attempts authentication
   - Returns token or null
   
7. Controller returns success/error response
```

---

## 🔒 Security Features

1. **JWT Authentication**
   - Token-based stateless auth
   - Middleware protection
   - Token refresh mechanism

2. **Password Security**
   - Bcrypt hashing in repository
   - Minimum length validation
   - Password reset flow

3. **Role-Based Access Control**
   - Admin, Employer, Candidate roles
   - RoleMiddleware enforcement
   - Route-level protection

4. **Input Validation**
   - FormRequest validation
   - Custom error messages
   - Email uniqueness checks

---

## ✅ Architecture Benefits

1. **Separation of Concerns**
   - Each layer has ONE responsibility
   - Easy to test in isolation
   - Changes don't ripple across layers

2. **Testability**
   - Feature classes test business logic
   - Repository mocking for unit tests
   - DTOs make data flow explicit

3. **Maintainability**
   - Clear where to add new features
   - Easy to locate bugs
   - Consistent patterns

4. **Scalability**
   - Add new features without touching existing code
   - Swap implementations (e.g., different DB)
   - Easy to add new authentication methods

5. **Type Safety**
   - DTOs with readonly properties
   - Type hints everywhere
   - Catch errors at compile time

---

## 📝 Coding Standards

1. **Controllers are THIN**
   - Max 10 lines per method
   - No business logic
   - Just orchestration

2. **Feature Classes are FOCUSED**
   - One use case per class
   - Dependency injection
   - Exception handling

3. **Repositories are DATA ONLY**
   - CRUD operations
   - Query building
   - No business decisions

4. **DTOs are IMMUTABLE**
   - Readonly properties
   - Factory methods
   - Type-safe

5. **Consistent Response Format**
   ```json
   {
     "success": true/false,
     "message": "string",
     "data": {}
   }
   ```

---

## 🚀 Adding New Features

To add a new auth feature (e.g., Email Verification):

1. Create DTO: `VerifyEmailDTO.php`
2. Create Feature: `VerifyEmailFeature.php`
3. Add Repository method: `verifyUserEmail()`
4. Create FormRequest: `VerifyEmailRequest.php`
5. Add Controller method: `verify()` (thin, calls feature)
6. Add route: `POST /api/auth/verify-email`

**Each layer stays focused on its responsibility!**

---

## 📚 Key Principles

1. **Single Responsibility Principle**
   - Each class has ONE job

2. **Dependency Inversion**
   - Depend on interfaces, not implementations

3. **Open/Closed Principle**
   - Open for extension, closed for modification

4. **Interface Segregation**
   - Small, focused interfaces

5. **DRY (Don't Repeat Yourself)**
   - Reuse through composition

---

## ✨ Summary

This architecture provides:
- ✅ Clean separation of concerns
- ✅ Testable business logic
- ✅ Type-safe data flow
- ✅ Easy to maintain and extend
- ✅ Production-ready code quality

**Your auth module now follows industry best practices!** 🎉
