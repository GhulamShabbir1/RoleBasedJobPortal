# TODO_admin_workflow.md

- [x] Step 1: Verify JWT + `role:admin` middleware allows admin access to all required endpoints (no over-restriction).
- [ ] Step 2: Wire admin dashboard stats (Total Users, Total Companies, Total Jobs, Total Applications, Pending Companies) to real API data.
- [ ] Step 3: Implement/complete admin UI for Manage Users (list, details, delete) and ensure candidate/employer visibility.
- [ ] Step 4: Implement/complete admin UI for Manage Companies (info, logo, registration certificate) + approve/reject actions.
- [ ] Step 5: Ensure approve/reject company impacts job creation:
    - [ ] Approved => employer can create jobs
    - [ ] Rejected => employer cannot create jobs
- [ ] Step 6: Implement/complete admin UI for Manage Categories (create/update/delete/view).
- [ ] Step 7: Implement/complete admin UI for Manage Jobs (view details, delete, close jobs).
- [ ] Step 8: Implement/complete admin UI for Review Applications (candidate info, resume, cover letter, review status updates).
- [ ] Step 9: Ensure `PUT /applications/{id}` and job/company/category delete/update endpoints are correctly wired to UI.
- [ ] Step 10: Run sanity checks:
    - [ ] PHPStan/PHPUnit (if configured)
    - [ ] Manual API checks using Postman collection / test plans
