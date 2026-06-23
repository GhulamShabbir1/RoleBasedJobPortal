@extends('layouts.app')

@section('title', 'Browse Jobs · Job Board')
@section('page_title', 'Browse Jobs')
@section('page_subtitle', '· find your next role')

@push('styles')
<style>
    /* --- FILTERS --- */
    .filters {
        background: #fff;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid #ececec;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .filter-group label {
        display: block;
        font-weight: 500;
        font-size: 0.9rem;
        color: #222;
        margin-bottom: 0.5rem;
    }

    .filter-group input,
    .filter-group select {
        width: 100%;
        padding: 0.6rem 1rem;
        border: 1px solid #ddd;
        border-radius: 10px;
        background: #fcfcfc;
        font-size: 0.9rem;
        transition: border-color 0.2s;
    }

    .filter-group input:focus,
    .filter-group select:focus {
        outline: none;
        border-color: #111;
        background: #fff;
    }

    .btn-search {
        background: #111;
        color: #fff;
        border: none;
        padding: 0.6rem 1.8rem;
        border-radius: 40px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
        align-self: flex-end;
    }

    .btn-search:hover {
        background: #2a2a2a;
    }

    /* --- JOBS GRID --- */
    .jobs-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .job-item {
        background: #fff;
        border: 1px solid #ececec;
        border-radius: 16px;
        padding: 1.8rem;
        transition: all 0.25s;
    }

    .job-item:hover {
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        border-color: #ccc;
    }

    .job-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 1rem;
    }

    .job-title-group h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111;
        margin-bottom: 0.3rem;
    }

    .job-company {
        color: #666;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .job-status {
        display: inline-block;
        background: #111;
        color: #fff;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.3rem 0.9rem;
        border-radius: 40px;
        letter-spacing: 0.01em;
    }

    .job-description {
        color: #555;
        margin: 1rem 0;
        line-height: 1.7;
    }

    .job-meta {
        display: flex;
        gap: 1.5rem;
        margin: 1rem 0;
        flex-wrap: wrap;
    }

    .job-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: #666;
    }

    .job-meta-item i {
        color: #888;
    }

    .job-tags {
        display: flex;
        gap: 0.6rem;
        margin: 1rem 0;
        flex-wrap: wrap;
    }

    .job-tag {
        display: inline-block;
        background: #f0f0f0;
        padding: 0.25rem 0.8rem;
        border-radius: 40px;
        font-size: 0.8rem;
        font-weight: 500;
        color: #333;
    }

    .job-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1.2rem;
        padding-top: 1rem;
        border-top: 1px solid #f0f0f0;
    }

    .job-salary {
        font-weight: 600;
        color: #111;
        font-size: 1rem;
    }

    .btn-apply {
        background: #111;
        color: #fff;
        border: none;
        padding: 0.6rem 1.8rem;
        border-radius: 40px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-apply:hover {
        background: #2a2a2a;
        transform: scale(1.02);
    }

    /* --- EMPTY STATE --- */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        background: #fff;
        border-radius: 16px;
        border: 1px solid #ececec;
    }

    .empty-state i {
        font-size: 3rem;
        color: #ccc;
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        color: #111;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #666;
    }

    /* --- LOADING --- */
    .loading-spinner {
        display: inline-block;
        width: 24px;
        height: 24px;
        border: 2px solid #ddd;
        border-top-color: #111;
        border-radius: 50%;
        animation: spin 0.7s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    @media (max-width: 820px) {
        .filters { grid-template-columns: 1fr 1fr; }
        .job-header { flex-direction: column; }
        .job-footer { flex-direction: column; gap: 1rem; align-items: flex-start; }
    }

    @media (max-width: 480px) {
        .filters { grid-template-columns: 1fr; }
        .job-meta { gap: 0.8rem; font-size: 0.85rem; }
        .btn-apply { width: 100%; text-align: center; }
    }
</style>
@endpush

@section('content')
<!-- FILTERS -->
<div class="filters">
    <div class="filter-group">
        <label for="search">Search</label>
        <input type="text" id="search" placeholder="Job title, keywords..." />
    </div>
    <div class="filter-group">
        <label for="location">Location</label>
        <input type="text" id="location" placeholder="City or remote" />
    </div>
    <div class="filter-group">
        <label for="jobType">Job Type</label>
        <select id="jobType">
            <option value="">All types</option>
            <option value="full-time">Full-time</option>
            <option value="part-time">Part-time</option>
            <option value="contract">Contract</option>
        </select>
    </div>
    <div class="filter-group">
        <label for="salaryMin">Salary Min ($)</label>
        <input type="number" id="salaryMin" placeholder="50000" />
    </div>
    <button class="btn-search" onclick="filterJobs()"><i class="fas fa-filter"></i> Search</button>
</div>

<!-- JOBS LIST -->
<div class="jobs-list" id="jobsList">
    <div class="empty-state">
        <div class="loading-spinner" style="margin: 0 auto; margin-bottom: 1rem;"></div>
        <p>Loading jobs...</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let allJobs = [];

    async function loadJobs() {
        try {
            const response = await fetch(`${API_URL}/jobs`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success && data.data) {
                // Handle pagination if data.data is paginated
                const items = data.data.data ? data.data.data : data.data;
                allJobs = Array.isArray(items) ? items : [items];
                displayJobs(allJobs);
            } else {
                showEmpty();
            }
        } catch (err) {
            console.error('Error loading jobs:', err);
            showEmpty('Failed to load jobs. Please try again.');
        }
    }

    function displayJobs(jobs) {
        const jobsList = document.getElementById('jobsList');

        if (jobs.length === 0) {
            showEmpty('No jobs found matching your criteria.');
            return;
        }

        jobsList.innerHTML = jobs.map(job => `
            <div class="job-item">
                <div class="job-header">
                    <div class="job-title-group">
                        <h3><a href="/jobs/${job.id}" style="color: inherit; text-decoration: none;">${job.title || 'Untitled'}</a></h3>
                        <div class="job-company">
                            <i class="fas fa-building" style="margin-right:0.4rem;"></i>
                            ${job.company_name || 'Unknown Company'}
                        </div>
                    </div>
                    <span class="job-status">Active</span>
                </div>

                <div class="job-description">
                    ${job.description ? job.description.substring(0, 200) + '...' : 'No description available'}
                </div>

                <div class="job-meta">
                    <div class="job-meta-item">
                        <i class="fas fa-map-marker-alt"></i>
                        ${job.location || job.city || 'Remote'}
                    </div>
                    <div class="job-meta-item">
                        <i class="fas fa-briefcase"></i>
                        ${job.job_type || 'Full-time'}
                    </div>
                    <div class="job-meta-item">
                        <i class="fas fa-graduation-cap"></i>
                        ${job.experience_level || 'Mid-level'}
                    </div>
                </div>

                <div class="job-footer">
                    <div class="job-salary">
                        $${job.salary_min || 'TBD'} - $${job.salary_max || 'TBD'}
                    </div>
                    <a href="/jobs/${job.id}" class="btn-apply">
                        View Details <i class="fas fa-arrow-right" style="margin-left:0.4rem;"></i>
                    </a>
                </div>
            </div>
        `).join('');
    }

    function showEmpty(message = 'No jobs found.') {
        const jobsList = document.getElementById('jobsList');
        jobsList.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-briefcase"></i>
                <h3>No Results</h3>
                <p>${message}</p>
            </div>
        `;
    }

    function filterJobs() {
        const search = document.getElementById('search').value.toLowerCase();
        const location = document.getElementById('location').value.toLowerCase();
        const jobType = document.getElementById('jobType').value.toLowerCase();
        const salaryMin = parseInt(document.getElementById('salaryMin').value) || 0;

        const filtered = allJobs.filter(job => {
            const titleMatch = (job.title || '').toLowerCase().includes(search);
            const locationMatch = (job.location || job.city || '').toLowerCase().includes(location);
            const typeMatch = !jobType || (job.job_type || '').toLowerCase().includes(jobType);
            const salaryMatch = (job.salary_min || 0) >= salaryMin;

            return titleMatch && locationMatch && typeMatch && salaryMatch;
        });

        displayJobs(filtered);
    }

    document.addEventListener('DOMContentLoaded', loadJobs);
</script>
@endpush
