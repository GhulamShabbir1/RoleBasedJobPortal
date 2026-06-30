# Active/Deactivate User API Examples

## Deactivate a User

### Request
```bash
curl -X PUT http://localhost:8000/api/users/user-id-here/status \
  -H "Authorization: Bearer YOUR_JWT_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"is_active": false}'
```

### Response (Success - 200)
```json
{
  "success": true,
  "message": "User deactivated successfully",
  "data": {
    "id": "550e8400-e29b-41d4-a716-446655440000",
    "name": "John Doe",
    "email": "john@example.com",
    "role": "candidate",
    "is_active": false,
    "created_at": "2026-06-30T11:27:28.000000Z"
  }
}
```

### Response (Error - 404)
```json
{
  "success": false,
  "message": "User not found"
}
```

---

## Activate a User

### Request
```bash
curl -X PUT http://localhost:8000/api/users/user-id-here/status \
  -H "Authorization: Bearer YOUR_JWT_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"is_active": true}'
```

### Response (Success - 200)
```json
{
  "success": true,
  "message": "User activated successfully",
  "data": {
    "id": "550e8400-e29b-41d4-a716-446655440000",
    "name": "John Doe",
    "email": "john@example.com",
    "role": "candidate",
    "is_active": true,
    "created_at": "2026-06-30T11:27:28.000000Z"
  }
}
```

---

## Login with Deactivated Account

### Request
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
```

### Response (Error - 403)
```json
{
  "success": false,
  "message": "Your account has been deactivated. Please contact the administrator."
}
```

---

## Login with Active Account

### Request (Same as above but with active user)
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
```

### Response (Success - 200)
```json
{
  "success": true,
  "message": "Login successfully",
  "data": {
    "user": {
      "id": "550e8400-e29b-41d4-a716-446655440000",
      "name": "John Doe",
      "email": "john@example.com",
      "role": "candidate",
      "is_active": true,
      "created_at": "2026-06-30T11:27:28.000000Z",
      "updated_at": "2026-06-30T11:27:28.000000Z"
    },
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "company_status": null
  }
}
```

---

## Filter Users by Status

### Request - Get Active Users
```bash
curl -X GET "http://localhost:8000/api/users/filter?status=active" \
  -H "Authorization: Bearer YOUR_JWT_TOKEN"
```

### Request - Get Inactive Users
```bash
curl -X GET "http://localhost:8000/api/users/filter?status=inactive" \
  -H "Authorization: Bearer YOUR_JWT_TOKEN"
```

### Response
```json
{
  "success": true,
  "message": "Users filtered successfully",
  "data": [
    {
      "id": "550e8400-e29b-41d4-a716-446655440000",
      "name": "John Doe",
      "email": "john@example.com",
      "role": "candidate",
      "is_active": true,
      "created_at": "2026-06-30T11:27:28.000000Z"
    },
    {
      "id": "550e8400-e29b-41d4-a716-446655440001",
      "name": "Jane Smith",
      "email": "jane@example.com",
      "role": "employer",
      "is_active": false,
      "created_at": "2026-06-29T10:15:20.000000Z"
    }
  ],
  "pagination": {
    "total": 2,
    "per_page": 15,
    "current_page": 1,
    "last_page": 1,
    "from": 1,
    "to": 2
  }
}
```

---

## Postman Collection

You can add these requests to your Postman collection:

### 1. Deactivate User
- **Method:** PUT
- **URL:** `{{base_url}}/api/users/{{userId}}/status`
- **Headers:**
  - `Authorization: Bearer {{token}}`
  - `Content-Type: application/json`
- **Body (raw JSON):**
  ```json
  {
    "is_active": false
  }
  ```

### 2. Activate User
- **Method:** PUT
- **URL:** `{{base_url}}/api/users/{{userId}}/status`
- **Headers:**
  - `Authorization: Bearer {{token}}`
  - `Content-Type: application/json`
- **Body (raw JSON):**
  ```json
  {
    "is_active": true
  }
  ```

### 3. Filter Users by Status
- **Method:** GET
- **URL:** `{{base_url}}/api/users/filter?status=active` or `?status=inactive`
- **Headers:**
  - `Authorization: Bearer {{token}}`
