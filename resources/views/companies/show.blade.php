@extends('layouts.app')

@section('title', 'Company Profile · Job Board')
@section('page_title', 'Company Profile')
@section('page_subtitle', '')

@push('styles')
<style>
    .company-hero {
        background: linear-gradient(135deg, #111 0%, #2a2a2a 100%);
        border-radius: 20px;
        padding: 3rem;
        color: #fff;
        margin-bottom: 2rem;
    }
    .company-hero .logo {
        width: 120px;
        height: 120px;
        background: #fff;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: #111;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }
    .company-hero h1 {
        color: #fff;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .company-hero .tagline {
        color: #aaa;
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }
    .company-hero .meta {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    .company-hero .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #ccc;
        font-size: 0.95rem;
    }
    .company-section {
        background: #fff;
        border: 1px solid #ececec;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .company-section h2 {
        font-size: 1.4rem;
        font-weight: 600;
        color: #111;
        margin-bottom: 1rem;
    }
    .company-section p {
        color: #666;
        line-height: 1.8;
    }
    .jobs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    .job-card {
        border: 1px solid #ececec;
        border-radius: 16px;
        padding: 1.5rem;
        transition: all 0.2s;
    }
    .job-card:hover {
        border-color: #ccc;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .job-card h3 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #111;
        margin-bottom: 0.5rem;
    }
    .job-card .meta {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    .btn-view {
        background: #111;
        color: #fff;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 40px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }
</style>
@endpush

@section('content')
<div id="companyProfile">
    <div class="empty-state" style="margin-bottom: 2rem;">
        <div class="loading-spinner" style="margin: 0 auto; margin-bottom: 1rem;"></div>
        <p>Loading company profile...</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', async () => {
    const urlParams = new URLSearchParams(window.location.search);
    const id = window.location.pathname.split('/').pop() || urlParams.get('id');
    
    if (!id) {
        window.location.href = '/companies';
        return;
    }

    try {
        const response = await fetch(`${API_URL}/companies/${id}`, {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'Content-Type': 'application/json'
            }
        });
        const data = await response.json();
        if (data.success && data.data) {
            renderCompany(data.data);
        } else {
            showError('Company not found');
        }
    } catch (err) {
        console.error(err);
        showError('Failed to load company profile');
    }
});

function renderCompany(company) {
    const container = document.getElementById('companyProfile');
    container.innerHTML = `
        <div class="company-hero">
            <div class="logo">${company.name ? company.name.charAt(0).toUpperCase() : 'C'}</div>
            <h1>${company.name || 'Company Name'}</h1>
            <p class="tagline">${company.description ? company.description.substring(0, 100) + '...' : ''}</p>
            <div class="meta">
                ${company.email ? '<div class="meta-item"><i class="fas fa-envelope"></i> ' + company.email + '</div>' : ''}
                ${company.website ? '<div class="meta-item"><i class="fas fa-globe"></i> ' + company.website + '</div>' : ''}
                ${company.city ? '<div class="meta-item"><i class="fas fa-map-marker-alt"></i> ' + company.city + '</div>' : ''}
            </div>
        </div>

        <div class="company-section">
            <h2>About the Company</h2>
            <p>${company.description || 'No description available'}</p>
        </div>

        <div class="company-section">
            <h2>Open Positions</h2>
            <div class="jobs-grid" id="companyJobs">
                <div class="empty-state">
                    <p>No open positions listed yet</p>
                </div>
            </div>
        </div>
    `;
}

function showError(message) {
    const container = document.getElementById('companyProfile');
    container.innerHTML = `
        <div class="empty-state">
            <i class="fas fa-exclamation-triangle"></i>
            <h3>Error</h3>
            <p>${message}</p>
            <a href="/companies" style="margin-top:1rem; display: inline-block;">Back to companies</a>
        </div>
    `;
}
</script>
@endpush
