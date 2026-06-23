@extends('layouts.app')

@section('title', 'Companies · Job Board')
@section('page_title', 'Companies')
@section('page_subtitle', '· manage or browse companies')

@push('styles')
<style>
    .companies-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.8rem;
    }

    .company-logo {
        width: 60px;
        height: 60px;
        background: #f0f0f0;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: #666;
        margin-bottom: 1rem;
    }

    .company-name {
        font-size: 1.15rem;
        font-weight: 600;
        color: #111;
        margin-bottom: 0.5rem;
    }

    .company-meta {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        margin: 1rem 0;
        font-size: 0.9rem;
        color: #666;
    }

    .company-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .company-meta-item i {
        color: #888;
        width: 1rem;
    }

    .company-status {
        display: inline-block;
        padding: 0.3rem 0.8rem;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.01em;
        margin: 0.8rem 0;
    }

    .company-status.approved { background: #e8f5e9; color: #2a7a2a; }
    .company-status.pending { background: #f9f5f0; color: #b5651d; }
    .company-status.rejected { background: #f8e0e0; color: #b33; }

    .company-actions {
        display: flex;
        gap: 0.8rem;
        margin-top: 1.2rem;
        padding-top: 1rem;
        border-top: 1px solid #f0f0f0;
    }

    .btn-action {
        flex: 1;
        background: #111;
        color: #fff;
        border: none;
        padding: 0.5rem 0.8rem;
        border-radius: 40px;
        font-weight: 500;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.3rem;
    }

    .btn-action:hover { background: #2a2a2a; }

    .btn-action.outlined {
        background: transparent;
        border: 1px solid #111;
        color: #111;
    }

    .btn-action.outlined:hover {
        background: #111;
        color: #fff;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        background: #fff;
        border-radius: 16px;
        border: 1px solid #ececec;
        grid-column: 1 / -1;
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
        margin-bottom: 1.5rem;
    }

    @media (max-width: 820px) {
        .companies-grid { grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); }
    }
    @media (max-width: 480px) {
        .companies-grid { grid-template-columns: 1fr; }
        .company-actions { flex-direction: column; }
    }
</style>
@endpush

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: flex-end;" id="createCompanyBtnContainer">
    <!-- Inserted by JS if role == employer -->
</div>

<!-- COMPANIES GRID -->
<div class="companies-grid" id="companiesGrid">
    <div class="empty-state">
        <i class="fas fa-spinner fa-spin"></i>
        <p>Loading companies...</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let allCompanies = [];

    document.addEventListener('DOMContentLoaded', () => {
        if (currentUser.role === 'employer') {
            document.getElementById('createCompanyBtnContainer').innerHTML = `
                <a href="/companies/create" class="btn">
                    <i class="fas fa-plus"></i> New Company
                </a>
            `;
        }
        loadCompanies();
    });

    async function loadCompanies() {
        try {
            const response = await fetch(`${API_URL}/companies`, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success && data.data) {
                // If data.data is paginated
                const companies = data.data.data ? data.data.data : data.data;
                allCompanies = Array.isArray(companies) ? companies : [companies];
                displayCompanies(allCompanies);
            } else {
                showEmpty();
            }
        } catch (err) {
            console.error('Error loading companies:', err);
            showEmpty('Failed to load companies.');
        }
    }

    function displayCompanies(companies) {
        const grid = document.getElementById('companiesGrid');

        if (companies.length === 0) {
            showEmpty();
            return;
        }

        grid.innerHTML = companies.map(company => {
            const status = company.status || 'pending';
            const statusLabel = status.charAt(0).toUpperCase() + status.slice(1);
            const initials = (company.name || 'C').substring(0, 2).toUpperCase();
            
            // Generate logo URL from logo_path if available
            const logoHtml = company.logo_path 
                ? `<img src="http://localhost:8000/storage/${company.logo_path}" alt="${company.name}" style="width:100%; height:100%; object-fit:cover; border-radius:12px;" />` 
                : initials;

            let actionsHtml = '';
            if (currentUser.role === 'employer') {
                actionsHtml = `
                    <div class="company-actions">
                        <a href="/companies/${company.id}/edit" class="btn-action outlined">
                            <i class="fas fa-edit" style="font-size:0.75rem;"></i> Edit
                        </a>
                        <button class="btn-action" onclick="deleteCompany('${company.id}')">
                            <i class="fas fa-trash" style="font-size:0.75rem;"></i> Delete
                        </button>
                    </div>
                `;
            }

            return `
                <div class="card" style="padding: 1.8rem;">
                    <div class="company-logo">
                        ${logoHtml}
                    </div>

                    <div class="company-name">${company.name || 'Untitled Company'}</div>
                    <span class="company-status ${status}">${statusLabel}</span>

                    <div class="company-meta">
                        <div class="company-meta-item"><i class="fas fa-envelope"></i> ${company.email || 'N/A'}</div>
                        <div class="company-meta-item"><i class="fas fa-map-marker-alt"></i> ${company.city || company.location || 'N/A'}</div>
                        <div class="company-meta-item"><i class="fas fa-briefcase"></i> ${company.industry || 'N/A'}</div>
                    </div>

                    ${actionsHtml}
                </div>
            `;
        }).join('');
    }

    function showEmpty() {
        const grid = document.getElementById('companiesGrid');
        grid.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-building"></i>
                <h3>No Companies Found</h3>
                <p>No companies are currently available to display.</p>
                ${currentUser.role === 'employer' ? `<a href="/companies/create" class="btn"><i class="fas fa-plus"></i> Register Company</a>` : ''}
            </div>
        `;
    }

    async function deleteCompany(companyId) {
        if (!confirm('Are you sure you want to delete this company?')) return;

        try {
            const response = await fetch(`${API_URL}/companies/${companyId}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                alert('Company deleted successfully!');
                loadCompanies();
            } else {
                alert('Error: ' + (data.message || 'Failed to delete company'));
            }
        } catch (err) {
            console.error('Error:', err);
            alert('An error occurred while deleting the company.');
        }
    }
</script>
@endpush
