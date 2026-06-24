# TODO Progress Tracker

- [x] Step 1: Enforce business rules in Feature/Repository layer
    - [x] Company must be approved before creating jobs

    - [ ] Employer can manage only own company/jobs
    - [x] Candidate browse: only OPEN jobs + APPROVED companies
        - [x] Candidate apply: resume mandatory + job open + company approved + duplicate apply prevention
    - [x] Closed jobs cannot receive applications

- [ ] Step 2: Resolve candidate apply-flow conflict
    - [ ] Disallow POST /applications for candidates (ensure backend rejects)
- [ ] Step 3: Admin dashboard + wiring
    - [ ] Admin stats endpoint(s) for total users/companies/jobs/applications/pending companies
    - [ ] Ensure admin CRUD endpoints map to real data
- [ ] Step 4: Candidate profile single-instance rule
    - [x] Ensure one profile per candidate user

- [ ] Step 5: Testing
    - [ ] Run existing API tests/plans
    - [ ] Add/adjust tests for above rules
