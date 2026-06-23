# API Testing Plan (JWT + Roles) — Job Recruitment Portal

This plan is based on the live routes in `routes/api.php`.

## 0) Base URL

- **Base:** `http://localhost:8000`
- **API root:** `http://localhost:8000/api`

## 1) Create/Obtain JWT tokens

You need **one token per role** you want to test.

### Register (optional, then login)

- `POST /api/auth/register`
    - body:
        - `name`
        - `email`
        - `password`
        - `password_confirmation`
        - `role` = `candidate|employer|admin`

### Login

- `POST /api/auth/login`
    - body:
        - `email`
        - `password`
    - Response should include:
        - `data.token` (JWT)
        - `data.user` (user info)

### Authorization header for protected endpoints

- `Authorization: Bearer <token>`

## 2) Public endpoints (no JWT)

Test these first.

### Categories

1. `GET /api/categories`
2. `GET /api/categories/search?search=<term>&page=1&per_page=10` (query params optional)
3. `GET /api/categories/{id}`

### Candidate Profiles (public)

4. `GET /api/candidate-profiles`
5. `GET /api/candidate-profiles/search?search=<term>&skills=<skills>&page=1&per_page=10`
6. `GET /api/candidate-profiles/{id}`

### Jobs (public listings)

7. `GET /api/jobs`
8. `GET /api/jobs/{id}`

Expected: All return JSON with at least `{ success: true|false, data: ... }`.

## 3) Protected (JWT) common endpoints (any authenticated user)

Use **any valid token**.

9. `GET /api/auth/me`
10. `POST /api/auth/logout`
11. `POST /api/auth/refresh`
12. `GET /api/profile`

## 4) Admin endpoints (token role=admin)

Use **admin token**.

### Users

13. `GET /api/users`
14. `GET /api/users/search?role=candidate&search=<term>&page=1&per_page=10`
15. `GET /api/users/{id}`
16. `PUT /api/users/{id}`
17. `PUT /api/users/{id}/role` (body: `{ "role": "candidate|employer|admin" }`)
18. `DELETE /api/users/{id}`

### Categories management

19. `POST /api/categories`
20. `PUT /api/categories/{id}`
21. `DELETE /api/categories/{id}`

### Company approvals

22. `POST /api/companies/{id}/approve`
23. `POST /api/companies/{id}/reject`

- body for reject: `{ "rejection_reason": "..." }` (per your Postman collection)

### Application management

24. `PUT /api/applications/{id}`

- body: `{ "status": "accepted|pending|rejected" }`

25. `DELETE /api/applications/{id}`

## 5) Candidate endpoints (token role=candidate)

Use **candidate token**.

### Candidate profile management

26. `POST /api/candidate-profiles`
27. `PUT /api/candidate-profiles/{id}`
28. `DELETE /api/candidate-profiles/{id}`

### Apply for jobs

29. `POST /api/jobs/{id}/apply`

- body: `{ "job_id": "<id>", "cover_letter": "...", "resume": "<resume path or url>" }`

### Own applications

30. `GET /api/applications`
31. `GET /api/applications/{id}`
32. `POST /api/applications`

## 6) Employer endpoints (token role=employer)

Use **employer token**.

### Company management

33. `POST /api/companies`
34. `PUT /api/companies/{companyId}`
35. `DELETE /api/companies/{companyId}`

### Job management

36. `GET /api/jobs` (employer jobs list per your controller)
37. `POST /api/jobs`
38. `PUT /api/jobs/{id}`
39. `DELETE /api/jobs/{id}`

## 7) Response validation checklist

For each endpoint:

- Status code is 200/201 for success; 4xx/5xx for errors.
- JSON contains `success` boolean.
- On error: `message` is present and meaningful.
- When protected: verify you get `401/403` when token missing/role mismatch.

## 8) Recommended manual testing order

1. Public endpoints (categories, profiles, jobs)
2. Register/login for each role
3. `/api/auth/me`
4. Admin endpoints with admin token
5. Employer endpoints with employer token
6. Candidate endpoints with candidate token

## 9) Postman automation (optional)

- Import your `Postman_Collection_Complete.json`
- Set `base_url` to `http://localhost:8000`
- Save JWT into `token` variable after login
- Repeat per role.
