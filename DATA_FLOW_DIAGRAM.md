# 📊 Data Flow Diagrams - Authentication Module

## Complete Request Flow

```
┌─────────────────────────────────────────────────────────────────┐
│                        CLIENT REQUEST                            │
│                  POST /api/auth/register                         │
│  { "name": "John", "email": "john@test.com", "password": "..." }│
└────────────────────────┬────────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────────────┐
│                    MIDDLEWARE LAYER                              │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐          │
│  │ JWT Validate │  │ Role Check   │  │ Rate Limit   │          │
│  └──────────────┘  └──────────────┘  └──────────────┘          │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────────────┐
│                   VALIDATION LAYER                               │
│                  RegisterRequest.php                             │
│  ┌──────────────────────────────────────────────────┐           │
│  │  rules(): [                                      │           │
│  │    'name' => 'required|string|max:255',         │           │
│  │    'email' => 'required|email|unique:users',    │           │
│  │    'password' => 'required|min:6',              │           │
│  │    'role' => 'in:admin,employer,candidate'      │           │
│  │  ]                                               │           │
│  └──────────────────────────────────────────────────┘           │
│                    ✅ Validation ONLY                            │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────────────┐
│                      DTO LAYER                                   │
│              RegisterUserDTO::fromRequest()                      │
│  ┌──────────────────────────────────────────────────┐           │
│  │  new RegisterUserDTO(                            │           │
│  │    name: "John",                                 │           │
│  │    email: "john@test.com",                       │           │
│  │    password: "password123",                      │           │
│  │    role: "candidate"                             │           │
│  │  )                                                │           │
│  └──────────────────────────────────────────────────┘           │
│            ✅ Type-safe, Immutable Data Transfer                 │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────────────┐
│                  CONTROLLER LAYER (THIN)                         │
│                 AuthController::register()                       │
│  ┌──────────────────────────────────────────────────┐           │
│  │  $dto = RegisterUserDTO::fromRequest($request);  │           │
│  │  $result = $feature->handle($dto);               │           │
│  │  return response()->json([...], 201);            │           │
│  └──────────────────────────────────────────────────┘           │
│         ✅ Orchestration ONLY - NO Business Logic               │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────────────┐
│              FEATURE LAYER (Business Logic)                      │
│               RegisterUserFeature::handle()                      │
│  ┌──────────────────────────────────────────────────┐           │
│  │  try {                                            │           │
│  │    // 1. Create user via repository               │           │
│  │    $user = $this->authRepository                 │           │
│  │              ->createUser($dto->toArray());       │           │
│  │                                                    │           │
│  │    // 2. Generate JWT token                       │           │
│  │    $token = auth()->login($user);                │           │
│  │                                                    │           │
│  │    // 3. Return result                            │           │
│  │    return ['user' => $user, 'token' => $token];  │           │
│  │  } catch (Exception $e) {                         │           │
│  │    throw new Exception('Registration failed');   │           │
│  │  }                                                 │           │
│  └──────────────────────────────────────────────────┘           │
│              ✅ ALL Business Logic Here                          │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────────────┐
│           REPOSITORY LAYER (Database Operations)                 │
│             AuthRepository::createUser()                         │
│  ┌──────────────────────────────────────────────────┐           │
│  │  return User::create([                            │           │
│  │    'name' => $data['name'],                       │           │
│  │    'email' => $data['email'],                     │           │
│  │    'password' => Hash::make($data['password']),   │           │
│  │    'role' => $data['role'] ?? 'candidate',        │           │
│  │  ]);                                               │           │
│  └──────────────────────────────────────────────────┘           │
│              ✅ Database Operations ONLY                         │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────────────┐
│                      MODEL LAYER                                 │
│                       User.php                                   │
│  ┌──────────────────────────────────────────────────┐           │
│  │  protected $fillable = [                          │           │
│  │    'name', 'email', 'password', 'role'            │           │
│  │  ];                                                │           │
│  │  Relationships: company(), candidateProfile()     │           │
│  └──────────────────────────────────────────────────┘           │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────────────┐
│                     DATABASE                                     │
│              users table (MySQL)                                 │
│  ┌──────────────────────────────────────────────────┐           │
│  │  INSERT INTO users (name, email, password, role)  │           │
│  │  VALUES ('John', 'john@test.com', '$2y$...', ... │           │
│  └──────────────────────────────────────────────────┘           │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         ▼ (Response flows back up)
┌─────────────────────────────────────────────────────────────────┐
│                    JSON RESPONSE                                 │
│  {                                                               │
│    "success": true,                                              │
│    "message": "User registered successfully",                    │
│    "data": {                                                     │
│      "user": {                                                   │
│        "id": 1,                                                  │
│        "name": "John",                                           │
│        "email": "john@test.com",                                 │
│        "role": "candidate"                                       │
│      },                                                          │
│      "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."          │
│    }                                                             │
│  }                                                               │
└─────────────────────────────────────────────────────────────────┘
```

---

## Layer Comparison: Before vs After

### BEFORE (Mixed Responsibilities)

```
┌──────────────────────────────────┐
│        AuthController            │
│                                  │
│  ❌ Validation                   │
│  ❌ Business Logic               │
│  ❌ Database Queries             │
│  ❌ Response Formatting          │
│                                  │
│  register(Request $request) {    │
│    // Validation here            │
│    // Business logic here        │
│    // DB queries here            │
│    // Return response            │
│  }                               │
└──────────────────────────────────┘
         FAT CONTROLLER 😞
```

### AFTER (Clean Separation)

```
┌─────────────────┐
│  FormRequest    │  ✅ Validation ONLY
│  (Validation)   │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│      DTO        │  ✅ Data Transfer ONLY
│  (Data Object)  │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│   Controller    │  ✅ Orchestration ONLY
│     (Thin)      │     (5-10 lines)
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│    Feature      │  ✅ Business Logic ONLY
│ (Business Use)  │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│   Repository    │  ✅ Database ONLY
│   (Database)    │
└─────────────────┘
   CLEAN CODE 😊
```

---

## All Authentication Flows

### 1. Register Flow

```
POST /api/auth/register
  ↓
RegisterRequest (validate)
  ↓
RegisterUserDTO (transfer data)
  ↓
AuthController::register (orchestrate)
  ↓
RegisterUserFeature::handle (business logic)
  ↓
AuthRepository::createUser (database)
  ↓
User Model
  ↓
Database INSERT
  ↓
Return: User + Token
```

### 2. Login Flow

```
POST /api/auth/login
  ↓
LoginRequest (validate)
  ↓
LoginUserDTO (transfer data)
  ↓
AuthController::login (orchestrate)
  ↓
LoginUserFeature::handle (business logic)
  ↓
AuthRepository::attemptLogin (database)
  ↓
JWT Authentication
  ↓
Return: User + Token
```

### 3. Get Authenticated User Flow

```
GET /api/auth/me
  ↓
JwtMiddleware (validate token)
  ↓
AuthController::me (orchestrate)
  ↓
GetAuthenticatedUserFeature::handle (business logic)
  ↓
AuthRepository::getCurrentUser (database)
  ↓
Return: User
```

### 4. Logout Flow

```
POST /api/auth/logout
  ↓
JwtMiddleware (validate token)
  ↓
AuthController::logout (orchestrate)
  ↓
LogoutUserFeature::handle (business logic)
  ↓
AuthRepository::invalidateToken (database)
  ↓
JWT Blacklist
  ↓
Return: Success message
```

### 5. Forgot Password Flow

```
POST /api/auth/forgot-password
  ↓
ForgetRequest (validate)
  ↓
ForgotPasswordDTO (transfer data)
  ↓
AuthController::forgotPassword (orchestrate)
  ↓
ForgotPasswordFeature::handle (business logic)
  ↓
AuthRepository::sendPasswordResetLink (database)
  ↓
Password::sendResetLink
  ↓
Email sent
  ↓
Return: Success message
```

### 6. Reset Password Flow

```
POST /api/auth/reset-password
  ↓
ResetPasswordRequest (validate)
  ↓
ResetPasswordDTO (transfer data)
  ↓
AuthController::resetPassword (orchestrate)
  ↓
ResetPasswordFeature::handle (business logic)
  ↓
AuthRepository::resetUserPassword (database)
  ↓
Password::reset
  ↓
Update user password
  ↓
Return: Success message
```

### 7. Refresh Token Flow

```
POST /api/auth/refresh
  ↓
JwtMiddleware (validate current token)
  ↓
AuthController::refresh (orchestrate)
  ↓
RefreshTokenFeature::handle (business logic)
  ↓
AuthRepository::refreshToken (database)
  ↓
JWT Refresh
  ↓
Return: New Token
```

---

## Dependency Flow

```
Controller
    ↓ (depends on)
Feature Classes
    ↓ (depends on)
Repository Interface
    ↓ (implemented by)
Repository Implementation
    ↓ (depends on)
Model
    ↓ (depends on)
Database
```

### Dependency Injection Example

```php
// Controller receives Feature via DI
public function register(
    RegisterRequest $request,
    RegisterUserFeature $feature  // ← Injected
): JsonResponse

// Feature receives Repository via DI
public function __construct(
    private readonly AuthRepositoryInterface $authRepository  // ← Injected
)

// Repository is bound in AppServiceProvider
$this->app->bind(
    AuthRepositoryInterface::class,
    AuthRepository::class
);
```

---

## Error Handling Flow

```
Controller (try/catch)
    ↓
Feature throws Exception
    ↓
Controller catches
    ↓
Return error JSON response
{
    "success": false,
    "message": "Error message"
}
```

---

## File Organization Map

```
app/
│
├── DTOs/Auth/                    ← Data Transfer Objects
│   ├── RegisterUserDTO.php
│   ├── LoginUserDTO.php
│   ├── ForgotPasswordDTO.php
│   └── ResetPasswordDTO.php
│
├── Features/Auth/                ← Business Logic (Use Cases)
│   ├── RegisterUserFeature.php
│   ├── LoginUserFeature.php
│   ├── LogoutUserFeature.php
│   ├── GetAuthenticatedUserFeature.php
│   ├── RefreshTokenFeature.php
│   ├── ForgotPasswordFeature.php
│   └── ResetPasswordFeature.php
│
├── Http/
│   ├── Controllers/
│   │   └── AuthController.php   ← Thin Orchestration Layer
│   │
│   ├── Requests/Auth/            ← Validation Layer
│   │   ├── RegisterRequest.php
│   │   ├── LoginRequest.php
│   │   ├── ForgetRequest.php
│   │   └── ResetPasswordRequest.php
│   │
│   └── Middleware/               ← Request Filtering
│       ├── JwtMiddleware.php
│       └── RoleMiddleware.php
│
├── Repositories/
│   ├── Interfaces/
│   │   └── AuthRepositoryInterface.php  ← Contract
│   └── Eloquent/
│       └── AuthRepository.php           ← Database Operations
│
└── Models/
    └── User.php                  ← Data Structure
```

---

## Summary

✅ Each layer has **ONE clear responsibility**
✅ Data flows **in one direction** (top to bottom)
✅ Dependencies point **inward** (to abstractions)
✅ **Type-safe** at every step
✅ **Testable** in isolation
✅ **Maintainable** and scalable

**This is production-ready clean architecture!** 🚀
