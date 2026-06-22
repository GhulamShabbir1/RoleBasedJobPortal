<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Applications · Job Board</title>
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

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #fff;
            padding: 1.2rem;
            border-radius: 12px;
            border: 1px solid #ececec;
            text-align: center;
        }

        .stat-card .number {
            font-size: 1.8rem;
            font-weight: 600;
            color: #111;
        }

        .stat-card .label {
            font-size: 0.85rem;
            color: #666;
            margin-top: 0.3rem;
        }

        .filters {
            background: #fff;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 2rem;
            border: 1px solid #ececec;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .filters select {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fcfcfc;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .filters select:focus {
            outline: none;
            border-color: #111;
        }

        .applications-list {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        .app-item {
            background: #fff;
            border: 1px solid #ececec;
            border-radius: 16px;
            padding: 1.8rem;
            transition: all 0.2s;
        }

        .app-item:hover {
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            border-color: #ccc;
        }

        .app-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }

        .app-title h3 {
            font-size: 1.15rem;
            font-weight: 600;
            color: #111;
            margin-bottom: 0.3rem;
        }

        .app-company {
            color: #666;
            font-size: 0.95rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.4rem 1rem;
            border-radius: 40px;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.01em;
        }

        .status-badge.pending {
            background: #f9f5f0;
            color: #b5651d;
        }

        .status-badge.accepted {
            background: #e8f5e9;
            color: #2a7a2a;
        }

        .status-badge.rejected {
            background: #f8e0e0;
            color: #b33;
        }

        .app-meta {
            display: flex;
            gap: 1.5rem;
            margin: 1rem 0;
            flex-wrap: wrap;
            font-size: 0.9rem;
            color: #666;
        }

        .app-meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .app-meta-item i {
            color: #888;
        }

        .app-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.2rem;
            padding-top: 1rem;
            border-top: 1px solid #f0f0f0;
        }

        .app-date {
            font-size: 0.85rem;
            color: #999;
        }

        .btn-action {
            background: #111;
            color: #fff;
            border: none;
            padding: 0.5rem 1.4rem;
            border-radius: 40px;
            font-weight: 500;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
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
            }

            .app-footer {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .main {
                padding: 1.5rem;
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
            <a href="/applications" class="active"><i class="fas fa-file-alt"></i> Applications</a>
            <a href="/companies"><i class="fas fa-building"></i> Companies</a>
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
            <h2>My Applications</h2>
        </div>

        <!-- STATS -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="number" id="totalApps">0</div>
                <div class="label">Total</div>
            </div>
            <div class="stat-card">
                <div class="number" id="pendingApps">0</div>
                <div class="label">Pending</div>
            </div>
            <div class="stat-card">
                <div class="number" id="acceptedApps">0</div>
                <div class="label">Accepted</div>
            </div>
            <div class="stat-card">
                <div class="number" id="rejectedApps">0</div>
                <div class="label">Rejected</div>
            </div>
        </div>

        <!-- FILTERS -->
        <div class="filters">
            <select id="statusFilter" onchange="filterApplications()">
                <option value="">All statuses</option>
                <option value="pending">Pending</option>
                <option value="accepted">Accepted</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>

        <!-- APPLICATIONS LIST -->
        <div class="applications-list" id="appList">
            <div class="empty-state">
                <div class="loading-spinner" style="margin: 0 auto; margin-bottom: 1rem;"></div>
                <p>Loading applications...</p>
            </div>
        </div>
    </main>
</div>

<script>
    const API_URL = 'http://localhost:8000/api';
    let allApplications = [];

    // Check authentication
    if (!localStorage.getItem('token')) {
        window.location.href = '/auth/login';
    }

    async function loadApplications() {
        try {
            const response = await fetch(`${API_URL}/applications`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success && data.data) {
                allApplications = Array.isArray(data.data) ? data.data : [data.data];
                displayApplications(allApplications);
                updateStats();
            } else {
                showEmpty();
            }
        } catch (err) {
            console.error('Error loading applications:', err);
            showEmpty('Failed to load applications.');
        }
    }

    function displayApplications(apps) {
        const appList = document.getElementById('appList');

        if (apps.length === 0) {
            showEmpty('No applications found.');
            return;
        }

        appList.innerHTML = apps.map(app => {
            const statusClass = app.status || 'pending';
            const statusLabel = statusClass.charAt(0).toUpperCase() + statusClass.slice(1);
            const appliedDate = new Date(app.created_at).toLocaleDateString();

            return `
                <div class="app-item">
                    <div class="app-header">
                        <div class="app-title">
                            <h3>${app.job_title || 'Untitled Position'}</h3>
                            <div class="app-company">
                                <i class="fas fa-building" style="margin-right:0.4rem;"></i>
                                ${app.company_name || 'Unknown Company'}
                            </div>
                        </div>
                        <span class="status-badge ${statusClass}">${statusLabel}</span>
                    </div>

                    <div class="app-meta">
                        <div class="app-meta-item">
                            <i class="fas fa-calendar"></i>
                            Applied: ${appliedDate}
                        </div>
                        <div class="app-meta-item">
                            <i class="fas fa-briefcase"></i>
                            ${app.job_type || 'Full-time'}
                        </div>
                    </div>

                    <div class="app-footer">
                        <div class="app-date">
                            Application ID: ${app.id}
                        </div>
                        <button class="btn-action" onclick="viewApplication('${app.id}')">
                            <i class="fas fa-eye" style="margin-right:0.4rem;"></i> View Details
                        </button>
                    </div>
                </div>
            `;
        }).join('');
    }

    function updateStats() {
        const total = allApplications.length;
        const pending = allApplications.filter(a => a.status === 'pending' || !a.status).length;
        const accepted = allApplications.filter(a => a.status === 'accepted').length;
        const rejected = allApplications.filter(a => a.status === 'rejected').length;

        document.getElementById('totalApps').textContent = total;
        document.getElementById('pendingApps').textContent = pending;
        document.getElementById('acceptedApps').textContent = accepted;
        document.getElementById('rejectedApps').textContent = rejected;
    }

    function filterApplications() {
        const status = document.getElementById('statusFilter').value;
        const filtered = status
            ? allApplications.filter(app => (app.status || 'pending') === status)
            : allApplications;
        displayApplications(filtered);
    }

    function showEmpty(message = 'No applications found.') {
        const appList = document.getElementById('appList');
        appList.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>No Applications</h3>
                <p>${message}</p>
            </div>
        `;
    }

    function viewApplication(appId) {
        alert('View application details: ' + appId + ' (Coming soon)');
    }

    document.getElementById('logoutBtn').addEventListener('click', function() {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        window.location.href = '/auth/login';
    });

    document.addEventListener('DOMContentLoaded', loadApplications);
</script>
</body>
</html>
