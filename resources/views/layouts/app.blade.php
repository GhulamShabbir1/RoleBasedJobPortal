<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Job Board')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    @vite('resources/css/app.css')


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

        /* ---------- LAYOUT ---------- */
        .app {
            display: grid;
            grid-template-columns: 260px 1fr;
            min-height: 100vh;
        }

        /* ---------- SIDEBAR (black/white) ---------- */
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
            text-decoration: none;
            display: block;
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
        .sidebar-nav a:hover i {
            color: #fff;
        }

        .sidebar-nav a.active {
            background: #2a2a2a;
            color: #fff;
            font-weight: 500;
        }
        .sidebar-nav a.active i {
            color: #fff;
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

        /* ---------- MAIN CONTENT ---------- */
        .main {
            background: #fafafa;
            padding: 2rem 2.5rem;
            min-height: 100vh;
        }

        /* TOP BAR */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.2rem;
            margin-bottom: 2.5rem;
        }

        .topbar h2 {
            font-size: 1.8rem;
            font-weight: 600;
            letter-spacing: -0.02em;
            color: #111;
        }
        .topbar h2 small {
            font-weight: 400;
            font-size: 1rem;
            color: #555;
            margin-left: 0.5rem;
        }

        .user-badge {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: #fff;
            padding: 0.3rem 1rem 0.3rem 0.3rem;
            border-radius: 60px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            border: 1px solid #e6e6e6;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #111;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.1rem;
            text-transform: uppercase;
        }

        .user-meta {
            display: flex;
            flex-direction: column;
            line-height: 1.3;
        }
        .user-meta strong {
            font-weight: 600;
            color: #111;
        }
        .user-meta span {
            font-size: 0.8rem;
            color: #666;
        }

        /* UTILITIES */
        .text-muted { color: #777; }
        .mt-2 { margin-top: 1.5rem; }
        .mb-2 { margin-bottom: 1.5rem; }
        
        .btn {
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
        .btn:hover { background: #2a2a2a; transform: scale(1.02); }
        .btn.outlined {
            background: transparent;
            border: 1px solid #111;
            color: #111;
        }
        .btn.outlined:hover { background: #111; color: #fff; }
        
        .form-group {
            margin-bottom: 1.2rem;
        }
        .form-group label {
            display: block;
            font-weight: 500;
            font-size: 0.9rem;
            color: #222;
            margin-bottom: 0.5rem;
        }
        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #fcfcfc;
            font-size: 0.9rem;
            transition: border-color 0.2s;
            font-family: inherit;
        }
        .form-control:focus {
            outline: none;
            border-color: #111;
            background: #fff;
        }
        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .card {
            background: #fff;
            border: 1px solid #ececec;
            border-radius: 16px;
            padding: 1.8rem;
            transition: all 0.25s;
        }

        /* ---------- RESPONSIVE ---------- */
        @media (max-width: 820px) {
            .app { grid-template-columns: 1fr; }
            .sidebar {
                position: relative;
                height: auto;
                padding: 1.2rem 0;
                border-right: none;
                border-bottom: 1px solid #2a2a2a;
            }
            .sidebar-brand { padding: 0 1.5rem 1rem; margin-bottom: 0.5rem; }
            .sidebar-nav { flex-direction: row; flex-wrap: wrap; padding: 0 1rem; gap: 0.2rem; }
            .sidebar-nav a { padding: 0.4rem 0.8rem; font-size: 0.85rem; }
            .sidebar-footer { border-top: none; padding: 0.8rem 1.5rem; }
            .btn-logout { width: auto; padding: 0.4rem 1.2rem; }
            .main { padding: 1.5rem; }
            .topbar { flex-direction: column; align-items: start; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="app">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <a href="/" class="sidebar-brand">
            <h1>job<span>board</span></h1>
        </a>

        <nav class="sidebar-nav" id="sidebarNav">
            <!-- Populated by JS based on role -->
        </nav>

        <div class="sidebar-footer">
            <button class="btn-logout" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="main">

        <!-- TOP BAR -->
        <div class="topbar">
            <h2>
                @yield('page_title', 'Dashboard')
                <small>@yield('page_subtitle', '')</small>
            </h2>
            <div class="user-badge">
                <div class="avatar" id="globalAvatarDisplay">U</div>
                <div class="user-meta">
                    <strong id="globalUserNameDisplay">User</strong>
                    <span id="globalUserRoleDisplay">Role</span>
                </div>
            </div>
        </div>

        @yield('content')

        <!-- subtle footer note -->
        <div style="font-size:0.8rem; color:#aaa; margin-top:3rem; border-top:1px solid #ececec; padding-top:1.2rem; display:flex; justify-content:space-between;">
            <span>© 2026 jobboard · monochrome</span>
            <span><i class="fas fa-circle" style="font-size:0.4rem; vertical-align:middle; color:#888;"></i> all good</span>
        </div>
    </main>
</div>

<script>
    const API_URL = 'http://localhost:8000/api';
    
    // Auth Check
    if (!localStorage.getItem('token')) {
        window.location.href = '/auth/login';
    }

    // Load User
    let currentUser = {};
    try {
        currentUser = JSON.parse(localStorage.getItem('user')) || {};
    } catch (e) {
        currentUser = {};
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Render Topbar
        document.getElementById('globalUserNameDisplay').textContent = currentUser.name || 'Unknown User';
        document.getElementById('globalUserRoleDisplay').textContent = (currentUser.role || 'user').toUpperCase();
        if(currentUser.name) {
            document.getElementById('globalAvatarDisplay').textContent = currentUser.name.charAt(0).toUpperCase();
        }

        // Render Sidebar (with employer gating based on company status)
        const nav = document.getElementById('sidebarNav');
        const role = currentUser.role || 'candidate';
        const currentPath = window.location.pathname;

        let myCompanyStatus = 'none';
        async function loadMyCompanyStatus() {
            if (role !== 'employer') return;
            try {
                const response = await fetch(`${API_URL}/employer/my-company-status`, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')}`,
                        'Accept': 'application/json',
                    },
                });
                const data = await response.json();
                if (response.ok && data.success && data.data) {
                    myCompanyStatus = (data.data.status || 'none').toLowerCase();
                }
            } catch (e) {
                // If check fails, keep default (none) to be safe
                console.warn('Failed to load company status', e);
            }
        }

        const links = [
            { href: '/dashboard', icon: 'fa-chart-pie', text: 'Dashboard', roles: ['admin', 'employer', 'candidate'] },
            { href: '/jobs', icon: 'fa-search', text: 'Browse Jobs', roles: ['candidate', 'admin'] },

            // Employer-only: hide until company is approved
            { href: '/jobs/create', icon: 'fa-plus-circle', text: 'Post a Job', roles: ['employer'], gate: 'approved' },
            { href: '/applications', icon: 'fa-file-alt', text: 'Applications', roles: ['admin', 'employer', 'candidate'] },
            { href: '/companies', icon: 'fa-building', text: 'Companies', roles: ['admin', 'candidate'] },

            // Employer: always allow company onboarding page
            { href: '/companies/create', icon: 'fa-briefcase', text: 'My Company', roles: ['employer'] },

            { href: '/users', icon: 'fa-users-cog', text: 'Manage Users', roles: ['admin'] },
            { href: '/profile', icon: 'fa-user', text: 'Profile', roles: ['admin', 'employer', 'candidate'] },
        ];

        async function renderNav() {
            await loadMyCompanyStatus();

            nav.innerHTML = links
                .filter(link => link.roles.includes(role))
                .filter(link => {
                    if (link.gate !== 'approved') return true;
                    // company statuses: 'approved' | 'pending' | 'rejected' | 'none'
                    return myCompanyStatus === 'approved';
                })
                .map(link => `
                    <a href="${link.href}" class="${currentPath === link.href ? 'active' : ''}">
                        <i class="fas ${link.icon}"></i> ${link.text}
                    </a>
                `).join('');

            // If employer tries to access /jobs/create while pending, show a banner
            if (role === 'employer' && myCompanyStatus !== 'approved' && window.location.pathname === '/jobs/create') {
                const banner = document.createElement('div');
                banner.style.cssText = 'margin-bottom:16px;padding:14px 16px;background:#fff3cd;border:1px solid #ffeeba;border-radius:12px;color:#664d03;';
                banner.innerHTML = `<strong>Company approval required.</strong> Your company is <b>${myCompanyStatus}</b>. You can’t post jobs until admin approves your company.`;
                document.body.prepend(banner);
            }
        }

        renderNav();

        // Logout

        document.getElementById('logoutBtn').addEventListener('click', async () => {
            try {
                await fetch(`${API_URL}/auth/logout`, {
                    method: 'POST',
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });
            } catch(e) {}
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            window.location.href = '/auth/login';
        });
    });
</script>
@stack('scripts')
</body>
</html>
