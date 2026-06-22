<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Job Board · Monochrome</title>
    <!-- Font Awesome (optional, for icons) -->
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

        .activity-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1.5rem;
        }

        .activity-item {
            text-align: center;
            padding: 0.5rem 0;
        }

        .activity-item .number {
            font-size: 2.2rem;
            font-weight: 600;
            color: #111;
            line-height: 1.2;
        }

        .activity-item .desc {
            font-size: 0.9rem;
            color: #555;
            margin-top: 0.1rem;
        }

        .divider-light {
            border: none;
            height: 1px;
            background: #ececec;
            margin: 1.8rem 0;
        }

        /* ---------- RECENT ACTIVITY (mock) ---------- */
        .recent-list {
            list-style: none;
            margin-top: 0.8rem;
        }
        .recent-list li {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.7rem 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.95rem;
        }
        .recent-list li:last-child {
            border-bottom: none;
        }
        .recent-list .badge {
            background: #111;
            color: #fff;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.2rem 0.7rem;
            border-radius: 40px;
            letter-spacing: 0.02em;
        }
        .recent-list .time {
            margin-left: auto;
            color: #777;
            font-size: 0.8rem;
        }

        /* ---------- UTILITIES ---------- */
        .text-muted {
            color: #777;
        }
        .mt-2 {
            margin-top: 1.5rem;
        }

        /* ---------- RESPONSIVE ---------- */
        @media (max-width: 820px) {
            .app {
                grid-template-columns: 1fr;
            }
            .sidebar {
                position: relative;
                height: auto;
                padding: 1.2rem 0;
                border-right: none;
                border-bottom: 1px solid #2a2a2a;
            }
            .sidebar-brand {
                padding: 0 1.5rem 1rem;
                margin-bottom: 0.5rem;
            }
            .sidebar-nav {
                flex-direction: row;
                flex-wrap: wrap;
                padding: 0 1rem;
                gap: 0.2rem;
            }
            .sidebar-nav a {
                padding: 0.4rem 0.8rem;
                font-size: 0.85rem;
            }
            .sidebar-footer {
                border-top: none;
                padding: 0.8rem 1.5rem;
            }
            .btn-logout {
                width: auto;
                padding: 0.4rem 1.2rem;
            }
            .main {
                padding: 1.5rem;
            }
            .topbar {
                flex-direction: column;
                align-items: start;
            }
            .card-grid {
                grid-template-columns: 1fr 1fr;
            }
            .activity-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 480px) {
            .card-grid {
                grid-template-columns: 1fr;
            }
            .activity-grid {
                grid-template-columns: 1fr 1fr;
            }
            .stat-card {
                padding: 1.2rem;
            }
            .topbar h2 {
                font-size: 1.4rem;
            }
        }

        /* small extras */
        .badge-outline {
            border: 1px solid #ccc;
            border-radius: 40px;
            padding: 0.2rem 0.9rem;
            font-size: 0.75rem;
            font-weight: 500;
            color: #333;
        }
        .flex {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
<div class="app">

    <!-- SIDEBAR · monochrome -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h1>job<span>board</span></h1>
        </div>

        <nav class="sidebar-nav">
            <a href="#" class="active"><i class="fas fa-chart-pie"></i> Dashboard</a>
            <a href="#"><i class="fas fa-search"></i> Jobs</a>
            <a href="#"><i class="fas fa-file-alt"></i> Applications</a>
            <a href="#"><i class="fas fa-building"></i> Companies</a>
            <a href="#"><i class="fas fa-user"></i> Profile</a>
            <a href="#"><i class="fas fa-cog"></i> Settings</a>
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
                Dashboard
                <small>· overview</small>
            </h2>
            <div class="user-badge">
                <div class="avatar" id="avatarDisplay">J</div>
                <div class="user-meta">
                    <strong id="userNameDisplay">John Doe</strong>
                    <span id="userRoleDisplay">Candidate</span>
                </div>
            </div>
        </div>

        <!-- STAT CARDS (monochrome) -->
        <div class="card-grid">
            <div class="stat-card">
                <div class="icon"><i class="fas fa-briefcase"></i></div>
                <div class="label">Active jobs</div>
                <div class="value" id="activeJobs">12</div>
                <div class="sub">matching your profile</div>
                <a href="#" class="action-link">Browse jobs →</a>
            </div>
            <div class="stat-card">
                <div class="icon"><i class="fas fa-pen-fancy"></i></div>
                <div class="label">Applications</div>
                <div class="value" id="totalApplications">3</div>
                <div class="sub">submitted</div>
                <a href="#" class="action-link">View all →</a>
            </div>
            <div class="stat-card">
                <div class="icon"><i class="fas fa-city"></i></div>
                <div class="label">Companies</div>
                <div class="value" id="totalCompanies">25</div>
                <div class="sub">hiring now</div>
                <a href="#" class="action-link">Explore →</a>
            </div>
        </div>

        <!-- ACTIVITY SECTION -->
        <div class="activity-section">
            <h3>Your activity</h3>
            <div class="activity-grid">
                <div class="activity-item">
                    <div class="number" id="viewsCount">142</div>
                    <div class="desc">Profile views</div>
                </div>
                <div class="activity-item">
                    <div class="number" id="interviews">7</div>
                    <div class="desc">Interviews</div>
                </div>
                <div class="activity-item">
                    <div class="number" id="saved">18</div>
                    <div class="desc">Saved jobs</div>
                </div>
                <div class="activity-item">
                    <div class="number" id="messages">9</div>
                    <div class="desc">Messages</div>
                </div>
            </div>

            <hr class="divider-light" />

            <!-- recent activity mock -->
            <div class="flex" style="justify-content:space-between;">
                <span style="font-weight:500; color:#111;">Recent activity</span>
                <span class="badge-outline">last 7 days</span>
            </div>
            <ul class="recent-list">
                <li>
                    <span class="badge">Applied</span>
                    Senior Frontend Developer · <span class="text-muted">GitHub</span>
                    <span class="time">2h ago</span>
                </li>
                <li>
                    <span class="badge">Saved</span>
                    Product Designer · <span class="text-muted">Figma</span>
                    <span class="time">yesterday</span>
                </li>
                <li>
                    <span class="badge">Interview</span>
                    Backend Engineer · <span class="text-muted">Stripe</span>
                    <span class="time">3d ago</span>
                </li>
                <li>
                    <span class="badge">Viewed</span>
                    DevOps Lead · <span class="text-muted">AWS</span>
                    <span class="time">4d ago</span>
                </li>
            </ul>
        </div>

        <!-- subtle footer note -->
        <div style="font-size:0.8rem; color:#aaa; margin-top:1rem; border-top:1px solid #ececec; padding-top:1.2rem; display:flex; justify-content:space-between;">
            <span>© 2026 jobboard · monochrome</span>
            <span><i class="fas fa-circle" style="font-size:0.4rem; vertical-align:middle; color:#888;"></i> all good</span>
        </div>
    </main>
</div>

<!-- JavaScript (minimal, keeps the monochrome spirit) -->
<script>
    (function() {
        // --- mock data (simulate user from localStorage) ---
        const defaultUser = {
            name: 'John Doe',
            role: 'candidate',
            avatar: 'J'
        };

        // try to read from localStorage, else use default
        let storedUser = null;
        try {
            const raw = localStorage.getItem('user');
            if (raw) storedUser = JSON.parse(raw);
        } catch (_) { /* ignore */ }

        const user = storedUser || defaultUser;

        // display user
        document.getElementById('userNameDisplay').textContent = user.name || 'John Doe';
        document.getElementById('userRoleDisplay').textContent = (user.role || 'candidate').charAt(0).toUpperCase() + (user.role || 'candidate').slice(1);
        const avatarEl = document.getElementById('avatarDisplay');
        if (user.name) {
            avatarEl.textContent = user.name.charAt(0).toUpperCase();
        }

        // --- dashboard numbers (static mock, but can be dynamic) ---
        // you can replace these with real API data later
        document.getElementById('activeJobs').textContent = '12';
        document.getElementById('totalApplications').textContent = '3';
        document.getElementById('totalCompanies').textContent = '25';
        document.getElementById('viewsCount').textContent = '142';
        document.getElementById('interviews').textContent = '7';
        document.getElementById('saved').textContent = '18';
        document.getElementById('messages').textContent = '9';

        // --- logout handler ---
        document.getElementById('logoutBtn').addEventListener('click', function(e) {
            e.preventDefault();
            // clear local storage and redirect
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            // if you have a login page:
            // window.location.href = '/auth/login';
            alert('Logged out (demo) — redirect to login.');
            // for demo we just reload and reset to default user
            localStorage.removeItem('user');
            window.location.reload();
        });

        // --- navigation links (demo) ---
        document.querySelectorAll('.sidebar-nav a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                // remove active from all, add to current
                document.querySelectorAll('.sidebar-nav a').forEach(a => a.classList.remove('active'));
                this.classList.add('active');
                // simple feedback
                const label = this.textContent.trim();
                alert(`Navigation: ${label} (coming soon)`);
            });
        });

        // action links (cards)
        document.querySelectorAll('.action-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                alert('Action: ' + this.textContent.trim());
            });
        });

        // 'Browse jobs' / 'View all' etc are handled above via .action-link

        console.log('Monochrome job board ready.');
    })();
</script>
</body>
</html>