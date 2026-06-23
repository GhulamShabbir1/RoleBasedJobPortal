# API Integration Blade Template Plan (JWT + Roles)

## Goal

Create a Blade template (web page) that can execute/validate **all REST API endpoints** defined in `routes/api.php` against **real running backend** (localhost), using JWT tokens for different roles.

## Information Gathered

- `routes/api.php` defines:
    - Public endpoints: `auth/register/login/forgot/reset`, `categories/*`, `candidate-profiles/*`, `jobs/*`.
    - JWT-protected endpoints under middleware `jwt`:
        - Auth: `POST /api/auth/logout`, `GET /api/auth/me`, `POST /api/auth/refresh`.
        - Common: `GET /api/profile`.
        - Admin role: `/api/users*`, `/api/categories*`, `/api/companies/{id}/approve|reject`, `/api/applications/{id}` (update/delete).
        - Candidate role: candidate profile CRUD, `POST /api/jobs/{id}/apply`, and applications list/get/create.
        - Employer role: company CRUD, job CRUD.
- Existing Blade layout exists (`resources/views/layouts/app.blade.php`) with:
    - `API_URL = http://localhost:8000/api`
    - Logout implementation using localStorage token/user.
    - Sidebar rendered by reading `localStorage.getItem('user')`.
- Current web routes (`routes/web.php`) are page-based; there is no API test page yet.

## Plan

1. **Create a new Blade page**
    - File: `resources/views/api-test/api-e2e.blade.php`.
    - UI elements:
        - Buttons: `Run All`, `Run Public`, `Run Admin`, `Run Employer`, `Run Candidate`.
        - Sections per group showing results: endpoint, method, status, time(ms), success flag, response excerpt.
        - Inputs for optional settings: base URL, page size, search term.

2. **Add a web route to access the test page**
    - Update `routes/web.php`:
        - `GET /api-test` -> return view(`api-test/api-e2e`).

3. **Implement JS runner inside the Blade page**
    - Use `fetch` to call backend endpoints.
    - Implement token acquisition:
        - Register (optional) then login for each role.
        - Save tokens in JS memory and localStorage (for convenience) under separate keys.
    - Implement generic request executor:
        - `request({method, url, token, body, query})`.
        - Measures latency using `performance.now()`.
        - Records JSON response and errors.

4. **Implement endpoint execution order with dependency handling**
    - Because many endpoints require existing IDs (companies/jobs/users/applications/candidate profiles), the runner should:
        - Fetch public lists to get IDs (e.g., get categories, jobs, candidate profiles).
        - Create/update resources when needed (e.g., create candidate profile for candidate flow, create company/job for employer flow).
        - Then apply actions using IDs fetched/created.
    - If an ID is not available:
        - Attempt creation (when endpoint supports it).
        - Otherwise mark as `SKIPPED (no id available)`.

5. **Expose all API routes to the runner**
    - Runner will include a scripted list mapping exactly to the endpoints in `routes/api.php`.
    - Each item includes:
        - method, path template (e.g., `/api/companies/{id}/approve`), role, needsAuth, body schema, and expected success fields.

6. **Response validation rules**
    - Verify:
        - HTTP status in expected range (2xx)
        - JSON has `success` boolean if present.
        - On protected endpoints: verify `401/403` when token missing/role mismatch (optional toggle).

7. **Persist run summaries**
    - After completion, create a downloadable JSON report (`Blob` + `a` link) including:
        - timestamps, tokens used (redacted), per-endpoint result.

## Dependent Files to Edit

- `routes/web.php`
- Create: `resources/views/api-test/api-e2e.blade.php`

## Followup Steps

1. Start Laravel server: `php artisan serve --port=8000` (or existing config).
2. Navigate to `http://localhost:8000/api-test`.
3. Click `Run All`.
4. Fix any failing endpoint payloads by aligning request bodies to controller/validation.

<ask_followup_question>
Confirm: should the Blade runner **auto-register** users for roles (candidate/employer/admin) or should it only **login using existing users** (you will provide emails/passwords)?
</ask_followup_question>
