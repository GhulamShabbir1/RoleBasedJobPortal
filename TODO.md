# TODO

## UI Fix: Candidate Dashboard styling not complete

- [ ] Identify why candidate dashboard styles are not loading (Tailwind classes vs custom CSS / layout mismatch).
- [ ] Inspect candidate dashboard blade(s) and any shared dashboard components.
- [ ] Inspect Tailwind build pipeline (vite.config.js, resources/css/app.css, tailwind directives) and ensure classes used in dashboard are generated.
- [ ] Fix any missing @vite/@stack/@push sections in layouts and/or dashboard views.
- [ ] Ensure material-icons font and Tailwind compiled CSS are included on dashboard pages.
- [ ] Run build (`npm run dev` or `npm run build`) and verify in browser.
- [ ] Regression-check other dashboard pages.
