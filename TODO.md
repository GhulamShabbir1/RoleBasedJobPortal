# TODO - Fix Alpine errors (installHook.js)

## What was found

- Console errors: `selectedJob is not defined` from Alpine expressions like `selectedJob?.category?.name`.
- Console errors: `showModal is not defined` from Alpine bindings.
- These occur in `resources/views/jobs/admin-manage.blade.php`.

## Planned fix

1. Ensure the modal and all `selectedJob`/`showModal` bindings live inside the `x-data="adminJobsPage()"` scope.
2. Make sure `adminJobsPage()` defines `showModal` and `selectedJob` (already present).
3. Make modal `x-show` safe by initializing `showModal: false` and using only `x-show="showModal"` inside the same Alpine component.
4. Remove any inline `x-data`/DOM mismatch that could cause Alpine to evaluate expressions outside of the component scope.

## Follow-up (after code changes)

- Hard refresh the browser (clear cached JS).
- Re-test the admin manage jobs page.
- Verify no more `selectedJob`/`showModal` Alpine expression errors.
