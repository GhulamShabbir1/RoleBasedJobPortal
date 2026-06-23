@extends('layouts.app')

@section('title', 'Dashboard · Job Board')
@section('page_title', 'Dashboard')
@section('page_subtitle', '· overview')

@push('styles')
<style>
    /* ---------- CARDS (monochrome) ---------- */
    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.8rem;
        margin-bottom: 2.8rem;
    }

    .stat-card {
        background: #fff;
        padding: 1.6rem 1.8rem;
        border-radius: 20px;
        border: 1px solid #ececec;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        transition: transform 0.15s ease, box-shadow 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.04);
    }

    .stat-card .icon {
        font-size: 1.8rem;
        color: #222;
        margin-bottom: 0.4rem;
    }

    .stat-card .label {
        font-size: 0.9rem;
        font-weight: 500;
        color: #555;
        letter-spacing: 0.01em;
    }

    .stat-card .value {
        font-size: 2.2rem;
        font-weight: 600;
        color: #111;
        margin: 0.2rem 0 0.3rem;
    }

    .stat-card .sub {
        font-size: 0.85rem;
        color: #777;
    }

    .stat-card .action-link {
        display: inline-block;
        margin-top: 1rem;
        font-weight: 500;
        font-size: 0.9rem;
        color: #111;
        text-decoration: none;
        border-bottom: 1.5px solid #ccc;
        padding-bottom: 2px;
        transition: border-color 0.2s;
    }
    .stat-card .action-link:hover {
        border-color: #111;
    }

    /* ---------- ACTIVITY SECTION ---------- */
    .activity-section {
        background: #fff;
        border-radius: 24px;
        border: 1px solid #ececec;
        padding: 2rem 2.2rem;
        margin-bottom: 2.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.01);
    }

    .activity-section h3 {
        font-size: 1.3rem;
        font-weight: 600;
        color: #111;
        margin-bottom: 1.5rem;
        letter-spacing: -0.01em;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #ececec;
    }

    .table th {
        color: #777;
        font-weight: 500;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge {
        display: inline-block;
        padding: 0.3rem 0.8rem;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge.pending { background: #fff3cd; color: #856404; }
    .badge.approved { background: #d4edda; color: #155724; }
    .badge.rejected { background: #f8d7da; color: #721c24; }

    @media (max-width: 820px) {
        .card-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 480px) {
        .card-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<!-- STAT CARDS -->
<div class="card-grid" id="dashboardStats">
    <!-- Rendered by JS -->
</div>

<!-- ACTIVITY / ADMIN SECTION -->
<div class="activity-section" id="dashboardMainArea">
    <h3>Loading...</h3>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const statsContainer = document.getElementById('dashboardStats');
        const mainArea = document.getElementById('dashboardMainArea');
        const role = currentUser.role || 'candidate';

        if (role === 'admin') {
            statsContainer.innerHTML = `
                <div class="stat-card">
                    <div class="icon"><i class="fas fa-building"></i></div>
                    <div class="label">Pending Companies</div>
                    <div class="value" id="statPendingCompanies">-</div>
                    <div class="sub">Requires approval</div>
                </div>
                <div class="stat-card">
                    <div class="icon"><i class="fas fa-users"></i></div>
                    <div class="label">Total Users</div>
                    <div class="value" id="statUsers">-</div>
                    <div class="sub">Registered users</div>
                </div>
                <div class="stat-card">
                    <div class="icon"><i class="fas fa-briefcase"></i></div>
                    <div class="label">Total Jobs</div>
                    <div class="value" id="statJobs">-</div>
                    <div class="sub">Platform wide</div>
                </div>
            `;
            
            mainArea.innerHTML = `
                <h3>Pending Companies</h3>
                <div style="overflow-x: auto;">
                    <table class="table" id="companiesTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="4" class="text-center text-muted">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
            `;
            loadAdminData();
        } else if (role === 'employer') {
            statsContainer.innerHTML = `
                <div class="stat-card">
                    <div class="icon"><i class="fas fa-briefcase"></i></div>
                    <div class="label">Your Jobs</div>
                    <div class="value" id="statEmployerJobs">-</div>
                    <a href="/jobs/create" class="action-link">Post new job →</a>
                </div>
                <div class="stat-card">
                    <div class="icon"><i class="fas fa-file-alt"></i></div>
                    <div class="label">Applications</div>
                    <div class="value" id="statEmployerApps">-</div>
                    <a href="/applications" class="action-link">Review applications →</a>
                </div>
            `;
            mainArea.innerHTML = `
                <h3>Recent Applications</h3>
                <p class="text-muted">You will see candidates applying for your jobs here.</p>
                <a href="/applications" class="btn outlined mt-2">View All Applications</a>
            `;
            // loadEmployerData() could be called here
        } else {
            // Candidate
            statsContainer.innerHTML = `
                <div class="stat-card">
                    <div class="icon"><i class="fas fa-search"></i></div>
                    <div class="label">Available Jobs</div>
                    <div class="value" id="statCandidateJobs">-</div>
                    <a href="/jobs" class="action-link">Browse jobs →</a>
                </div>
                <div class="stat-card">
                    <div class="icon"><i class="fas fa-pen-fancy"></i></div>
                    <div class="label">Applications</div>
                    <div class="value" id="statCandidateApps">-</div>
                    <a href="/applications" class="action-link">View status →</a>
                </div>
            `;
            mainArea.innerHTML = `
                <h3>Your Recent Applications</h3>
                <p class="text-muted">Check your application status here.</p>
                <a href="/applications" class="btn outlined mt-2">View All Applications</a>
            `;
            // loadCandidateData()
        }
    });

    async function loadAdminData() {
        try {
            // Fetch companies
            const response = await fetch(`${API_URL}/companies`, {
                headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
            });
            const data = await response.json();
            
            if (data.success && data.data) {
                const companies = data.data.data ? data.data.data : data.data;
                const tbody = document.querySelector('#companiesTable tbody');
                
                // Update stats
                document.getElementById('statPendingCompanies').textContent = companies.filter(c => c.status === 'pending').length;
                
                if (companies.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">No companies found.</td></tr>`;
                    return;
                }

                tbody.innerHTML = companies.map(c => `
                    <tr>
                        <td><strong>${c.name}</strong><br><small class="text-muted">${c.industry || ''}</small></td>
                        <td>${c.email || 'N/A'}</td>
                        <td><span class="badge ${c.status}">${c.status}</span></td>
                        <td>
                            ${c.status === 'pending' ? `
                                <button class="btn outlined" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;" onclick="updateCompanyStatus('${c.id}', 'approve')">Approve</button>
                                <button class="btn outlined" style="padding: 0.3rem 0.8rem; font-size: 0.8rem; color: #dc3545; border-color: #dc3545;" onclick="updateCompanyStatus('${c.id}', 'reject')">Reject</button>
                            ` : '-'}
                        </td>
                    </tr>
                `).join('');
            }
        } catch (err) {
            console.error('Failed to load admin data', err);
        }
    }

    async function updateCompanyStatus(id, status) {
        try {
            const response = await fetch(`${API_URL}/companies/${id}/${status}`, {
                method: 'POST',
                headers: { 
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: status === 'reject' ? JSON.stringify({ rejection_reason: 'Rejected by admin' }) : JSON.stringify({})
            });
            const data = await response.json();
            if(data.success) {
                alert(`Company ${status === 'approve' ? 'approved' : 'rejected'} successfully!`);
                loadAdminData();
            } else {
                alert(`Error: ${data.message}`);
            }
        } catch(err) {
            alert('Failed to update company status.');
        }
    }
</script>
@endpush
