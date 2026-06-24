# TODO - Candidate (Job Seeker) Workflow Spec Alignment

## Done
- Added request validation for candidate applying to a job: `app/Http/Requests/ApplyJobRequest.php`
  - `job_id` required + exists
  - `resume` required file, PDF/DOC/DOCX, max 5MB
  - `cover_letter` optional

## Step 1: Identify active apply flow
- Inspect route/controller mapping:
  - `POST /jobs/{id}/apply` -> `JobController@apply` -> `ApplyJobFeature`
  - `POST /applications` -> `ApplicationController@store` -> `ApplyApplicationFeature`
- Confirm which endpoint(s) are used by the candidate UI/test plan.

## Step 2: Remove conflict with spec (resume + OPEN jobs + duplicate prevention)
Current state:
- `ApplyJobFeature` matches spec better (candidate_id + job_id duplicate check, resume upload + validation, company approved gating).
- `ApplyApplicationFeature` is conflicting (expects `resume` as string, has weaker validation, uses `user_id` fields, and does not enforce job/company OPEN/APPROVED rules).

Required changes (pick one approach):
- Option A (recommended): **Disallow** candidate access to `POST /applications` (and related update routes if necessary), so candidates must apply via `POST /jobs/{id}/apply`.
- Option B: Update `ApplyApplicationFeature` + its request/DTO to enforce:
  - resume file required + validation (PDF/DOC/DOCX)
  - job must be OPEN
  - company must be approved
  - duplicate prevention using `candidate_id + job_id`
  - correct DB column usage (`candidate_id` / `resume_path`)

## Step 3: Candidate profile single-instance rule
- Ensure repository/feature enforces: only one candidate profile per candidate (user).
- If not present: implement check in `CreateCandidateProfileFeature` (via repository).

## Step 4: Browse/search/filter visibility (OPEN jobs + approved companies)
- Ensure job list and filters only return:
  - jobs where `status = open`
  - jobs whose company `status = approved`
- Verify `JobController@index` / `JobRepository@filterJobs` / any “search” code.

## Step 5: Track applications
- Ensure candidate can only GET own applications.
- Verify `ApplicationController@index/show` + the underlying `FilterApplicationsFeature/GetApplicationsFeature`.

## Step 6: Candidate cannot change application status
- Ensure `ApplicationController@update` is behind admin-only middleware (already looks like `role:admin`).

## Step 7: Test
- Use `API_TEST_PLAN.md` / `API_INTEGRATION_TEST_BLADE_PLAN.md` and Postman collection to validate:
  - duplicate application blocked with message: "You have already applied for this job."
  - resume validation errors returned correctly
  - browse/search/filter returns only OPEN jobs from APPROVED companies
  - candidate profile single-instance enforcement works

