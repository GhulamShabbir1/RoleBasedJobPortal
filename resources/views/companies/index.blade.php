<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Companies · Job Board</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background: #fafafa;
            color: #111;
            line-height: 1.5;
        }

        .app {
            display: grid;
            grid-template-columns: 260px 1fr;
            min-height: 100vh;
        }

        .sidebar {
            background: #111;
            color: #eee;
            padding: 2rem 0 1.5rem;
            position: sticky;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            border-right: 1px solid #2a2a2a;
        }

        .sidebar-brand {
            padding: 0 1.8rem 2rem;
            border-bottom: 1px solid #2a2a2a;
            margin-bottom: 1.5rem;
        }

        .sidebar-brand h1 {
            font-size: 1.6rem;
            font-weight: 600;
            letter-spacing: -0.02em;
            color: #fff;
        }

        .sidebar-brand h1 span {
            font-weight: 300;
            color: #aaa;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            padding: 0 1rem;
            flex: 1;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.7rem 1rem;
            border-radius: 8px;
            color: #ccc;
            text-decoration: none;
            font-weight: 450;
            transition: all 0.15s ease;
            font-size: 0.95rem;
        }

        .sidebar-nav a i {
            width: 1.3rem;
            font-size: 1rem;
            color: #888;
            transition: color 0.15s;
        }

        .sidebar-nav a:hover {
            background: #2a2a2a;
            color: #fff;
        }

        .sidebar-nav a.active {
            background: #2a2a2a;
            color: #fff;
            font-weight: 500;
        }

        .sidebar-footer {
            padding: 1.5rem 1.8rem 0.5rem;
            border-top: 1px solid #2a2a2a;
            margin-top: 1rem;
        }

        .btn-logout {
            width: 100%;
            background: transparent;
            border: 1px solid #3a3a3a;
            color: #ddd;
            padding: 0.7rem;
            border-radius: 40px;
            font-weight: 500;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
        }

        .btn-logout:hover {
            background: #2a2a2a;
            border-color: #666;
            color: #fff;
        }

        .main {
            background: #fafafa;
            padding: 2rem 2.5rem;
            min-height: 100vh;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        .header h2 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #111;
        }

        .btn-create {
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
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
        }

        .btn-create:hover {
            background: #2a2a2a;
        }

        .companies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.8rem;
        }

        .company-card {
            background: #fff;
            border: 1px solid #ececec;
            border-radius: 16px;
            padding: 1.8rem;
            transition: all 0.25s;
        }

        .company-card:hover {
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            border-color: #ccc;
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

        .company-status.approved {
            background: #e8f5e9;
            color: #2a7a2a;
        }

        .company-status.pending {
            background: #f9f5f0;
            color: #b5651d;
        }

        .company-status.rejected {
            background: #f8e0e0;
            color: #b33;
        }

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

        .btn-action:hover {
            background: #2a2a2a;
        }

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

        .btn-empty {
            background: #111;
            color: #fff;
            border: none;
            padding: 0.7rem 1.8rem;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-empty:hover {
            background: #2a2a2a;
        }

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
            .app {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: relative;
                height: auto;
                border-right: none;
                border-bottom: 1px solid #2a2a2a;
            }

            .sidebar-nav {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .header {
                flex-direction: column;
                align-items: start;
                gap: 1rem;
            }

            .main {
                padding: 1.5rem;
            }

            .companies-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
        }

        @media (max-width: 480px) {
            .companies-grid {
                grid-template-columns: 1fr;
            }

            .company-actions {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="app">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h1>job<span>board</span></h1>
        </div>

        <nav class="sidebar-nav">
            <a href="/dashboard"><i class="fas fa-chart-pie"></i> Dashboard</a>
            <a href="/jobs"><i class="fas fa-search"></i> Browse Jobs</a>
            <a href="/applications"><i class="fas fa-file-alt"></i> Applications</a>
            <a href="/companies" class="active"><i class="fas fa-building"></i> Companies</a>
            <a href="/profile"><i class="fas fa-user"></i> Profile</a>
            <a href="/settings"><i class="fas fa-cog"></i> Settings</a>
        </nav>

        <div class="sidebar-footer">
            <button class="btn-logout" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="main">
        <div class="header">
            <h2>Companies</h2>
            <button class="btn-create" onclick="showCreateModal()">
                <i class="fas fa-plus"></i> New Company
            </button>
        </div>

        <!-- COMPANIES GRID -->
        <div class="companies-grid" id="companiesGrid">
            <div class="empty-state">
                <div class="loading-spinner" style="margin: 0 auto; margin-bottom: 1rem;"></div>
                <p>Loading companies...</p>
            </div>
        </div>
    </main>
</div>

<!-- CREATE MODAL -->
<div id="createModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; display:flex; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:16px; padding:2rem; max-width:500px; width:90%; max-height:80vh; overflow-y:auto;">
        <h3 style="font-size:1.4rem; font-weight:600; margin-bottom:1.5rem;">Create New Company</h3>

        <form id="createCompanyForm" onsubmit="submitCreateCompany(event)">
            <div style="margin-bottom:1rem;">
                <label style="display:block; font-weight:500; margin-bottom:0.5rem;">Company Name</label>
                <input type="text" id="companyName" placeholder="Acme Corporation" required style="width:100%; padding:0.6rem 1rem; border:1px solid #ddd; border-radius:10px; font-size:0.9rem;" />
            </div>

            <div style="margin-bottom:1rem;">
                <label style="display:block; font-weight:500; margin-bottom:0.5rem;">Email</label>
                <input type="email" id="companyEmail" placeholder="info@acme.com" required style="width:100%; padding:0.6rem 1rem; border:1px solid #ddd; border-radius:10px; font-size:0.9rem;" />
            </div>

            <div style="margin-bottom:1rem;">
                <label style="display:block; font-weight:500; margin-bottom:0.5rem;">Location</label>
                <input type="text" id="companyLocation" placeholder="San Francisco, CA" required style="width:100%; padding:0.6rem 1rem; border:1px solid #ddd; border-radius:10px; font-size:0.9rem;" />
            </div>

            <div style="margin-bottom:1.5rem;">
                <label style="display:block; font-weight:500; margin-bottom:0.5rem;">Description</label>
                <textarea id="companyDescription" placeholder="Tell us about your company..." style="width:100%; padding:0.6rem 1rem; border:1px solid #ddd; border-radius:10px; font-size:0.9rem; min-height:100px; resize:vertical;"></textarea>
            </div>

            <div style="display:flex; gap:1rem;">
                <button type="submit" style="flex:1; background:#111; color:#fff; border:none; padding:0.7rem; border-radius:40px; font-weight:600; cursor:pointer;">Create</button>
                <button type="button" onclick="closeModal()" style="flex:1; background:transparent; border:1px solid #111; color:#111; padding:0.7rem; border-radius:40px; font-weight:600; cursor:pointer;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    const API_URL = 'http://localhost:8000/api';
    let allCompanies = [];

    // Check authentication
    if (!localStorage.getItem('token')) {
        window.location.href = '/auth/login';
    }

    async function loadCompanies() {
        try {
            const response = await fetch(`${API_URL}/companies`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success && data.data) {
                allCompanies = Array.isArray(data.data) ? data.data : [data.data];
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

            return `
                <div class="company-card">
                    <div class="company-logo">
                        ${initials}
                    </div>

                    <div class="company-name">${company.name || 'Untitled Company'}</div>

                    <span class="company-status ${status}">${statusLabel}</span>

                    <div class="company-meta">
                        <div class="company-meta-item">
                            <i class="fas fa-envelope"></i>
                            ${company.email || 'N/A'}
                        </div>
                        <div class="company-meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            ${company.location || 'N/A'}
                        </div>
                        <div class="company-meta-item">
                            <i class="fas fa-briefcase"></i>
                            ${company.industry || 'N/A'}
                        </div>
                    </div>

                    <div class="company-actions">
                        <button class="btn-action outlined" onclick="editCompany('${company.id}')">
                            <i class="fas fa-edit" style="font-size:0.75rem;"></i> Edit
                        </button>
                        <button class="btn-action" onclick="deleteCompany('${company.id}')">
                            <i class="fas fa-trash" style="font-size:0.75rem;"></i> Delete
                        </button>
                    </div>
                </div>
            `;
        }).join('');
    }

    function showEmpty() {
        const grid = document.getElementById('companiesGrid');
        grid.innerHTML = `
            <div class="empty-state" style="grid-column:1/-1;">
                <i class="fas fa-building"></i>
                <h3>No Companies Yet</h3>
                <p>Create your first company to start posting jobs.</p>
                <button class="btn-empty" onclick="showCreateModal()">
                    <i class="fas fa-plus"></i> Create Company
                </button>
            </div>
        `;
    }

    function showCreateModal() {
        document.getElementById('createModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('createModal').style.display = 'none';
        document.getElementById('createCompanyForm').reset();
    }

    async function submitCreateCompany(event) {
        event.preventDefault();

        const data = {
            name: document.getElementById('companyName').value,
            email: document.getElementById('companyEmail').value,
            location: document.getElementById('companyLocation').value,
            description: document.getElementById('companyDescription').value
        };

        try {
            const response = await fetch(`${API_URL}/companies`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.success) {
                alert('Company created successfully!');
                closeModal();
                loadCompanies();
            } else {
                alert('Error: ' + (result.message || 'Failed to create company'));
            }
        } catch (err) {
            console.error('Error:', err);
            alert('An error occurred while creating the company.');
        }
    }

    function editCompany(companyId) {
        alert('Edit company: ' + companyId + ' (Coming soon)');
    }

    async function deleteCompany(companyId) {
        if (!confirm('Are you sure you want to delete this company?')) return;

        try {
            const response = await fetch(`${API_URL}/companies/${companyId}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Content-Type': 'application/json',
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

    document.getElementById('logoutBtn').addEventListener('click', function() {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        window.location.href = '/auth/login';
    });

    document.addEventListener('DOMContentLoaded', loadCompanies);
</script>
</body>
</html>
