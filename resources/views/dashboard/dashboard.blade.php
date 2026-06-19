<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Recruitment Portal</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            line-height: 1.6;
            color: #333;
        }

        .layout {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }

        /* Sidebar Navigation */
        .sidebar {
            background: #2c3e50;
            color: white;
            padding: 2rem 0;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 250px;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 1rem;
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .sidebar-nav {
            list-style: none;
        }

        .sidebar-nav a {
            display: block;
            padding: 1rem 2rem;
            color: #ecf0f1;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: rgba(102, 126, 234, 0.2);
            border-left-color: #667eea;
            color: white;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            border-top: 1px solid rgba(255,255,255,0.1);
            padding: 1rem 2rem;
        }

        .logout-btn {
            width: 100%;
            padding: 0.8rem;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: #c0392b;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 2rem;
        }

        /* Header/Navbar */
        .header {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 2rem;
            color: #2c3e50;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .user-name {
            text-align: right;
        }

        .user-name p {
            font-weight: bold;
            color: #2c3e50;
        }

        .user-role {
            font-size: 0.9rem;
            color: #667eea;
        }

        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .dashboard-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .card-title {
            font-size: 1.3rem;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .card-value {
            font-size: 2rem;
            color: #667eea;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .card-description {
            color: #666;
            font-size: 0.95rem;
        }

        /* Stats Section */
        .stats-section {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }

        .stats-section h2 {
            margin-bottom: 1.5rem;
            color: #2c3e50;
            font-size: 1.5rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            color: #667eea;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #666;
            font-size: 0.95rem;
        }

        /* Quick Actions */
        .quick-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #ecf0f1;
            color: #2c3e50;
        }

        .btn-secondary:hover {
            background: #bdc3c7;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .sidebar-footer {
                position: relative;
                bottom: auto;
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="layout">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>💼 Portal</h2>
            </div>
            <nav class="sidebar-nav">
                <a href="/dashboard" class="active">📊 Dashboard</a>
                <a href="#" id="navLink_jobs">🔍 Jobs</a>
                <a href="#" id="navLink_applications">📝 Applications</a>
                <a href="#" id="navLink_companies">🏢 Companies</a>
                <a href="#" id="navLink_profile">👤 Profile</a>
                <a href="#" id="navLink_settings">⚙️ Settings</a>
            </nav>
            <div class="sidebar-footer">
                <button class="logout-btn" onclick="logout()">Logout</button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <div class="header">
                <h1 id="welcomeMessage">Welcome to Dashboard</h1>
                <div class="user-info">
                    <div class="user-avatar" id="userAvatar">J</div>
                    <div class="user-name">
                        <p id="userName">John Doe</p>
                        <p class="user-role" id="userRole">Candidate</p>
                    </div>
                </div>
            </div>

            <!-- Dashboard Cards -->
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <div class="card-icon">🔍</div>
                    <div class="card-title">Active Jobs</div>
                    <div class="card-value" id="activeJobs">0</div>
                    <div class="card-description">Jobs matching your profile</div>
                    <div class="quick-actions">
                        <a href="#" class="btn btn-primary">Browse Jobs</a>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-icon">📝</div>
                    <div class="card-title">Applications</div>
                    <div class="card-value" id="totalApplications">0</div>
                    <div class="card-description">Jobs you've applied to</div>
                    <div class="quick-actions">
                        <a href="#" class="btn btn-primary">View Applications</a>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-icon">🏢</div>
                    <div class="card-title">Companies</div>
                    <div class="card-value" id="totalCompanies">0</div>
                    <div class="card-description">Companies hiring now</div>
                    <div class="quick-actions">
                        <a href="#" class="btn btn-primary">Explore</a>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="stats-section">
                <h2>Your Activity</h2>
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number" id="viewsCount">0</div>
                        <div class="stat-label">Profile Views</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" id="interviews">0</div>
                        <div class="stat-label">Interviews</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" id="saved">0</div>
                        <div class="stat-label">Saved Jobs</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" id="messages">0</div>
                        <div class="stat-label">Messages</div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const API_URL = 'http://localhost:8000/api';

        // Check authentication
        function checkAuth() {
            const token = localStorage.getItem('token');
            if (!token) {
                window.location.href = '/auth/login';
                return false;
            }
            return token;
        }

        // Load user data
        function loadUserData() {
            const user = JSON.parse(localStorage.getItem('user'));
            if (user) {
                document.getElementById('userName').textContent = user.name;
                document.getElementById('userRole').textContent = user.role.charAt(0).toUpperCase() + user.role.slice(1);
                document.getElementById('userAvatar').textContent = user.name.charAt(0).toUpperCase();
                document.getElementById('welcomeMessage').textContent = `Welcome, ${user.name}!`;

                // Set dashboard content based on role
                loadRoleDashboard(user.role);
            }
        }

        // Load role-specific dashboard
        function loadRoleDashboard(role) {
            if (role === 'candidate') {
                // Show candidate-specific content
                document.getElementById('activeJobs').textContent = '12';
                document.getElementById('totalApplications').textContent = '3';
                document.getElementById('totalCompanies').textContent = '25';
            } else if (role === 'employer') {
                // Show employer-specific content
                document.getElementById('activeJobs').textContent = 'Posted';
                document.getElementById('totalApplications').textContent = 'Received';
                document.getElementById('totalCompanies').textContent = 'Your Company';
            } else if (role === 'admin') {
                // Show admin-specific content
                document.getElementById('activeJobs').textContent = 'Manage';
                document.getElementById('totalApplications').textContent = 'Review';
                document.getElementById('totalCompanies').textContent = 'Verify';
            }
        }

        // Logout function
        function logout() {
            const token = checkAuth();
            if (!token) return;

            fetch(`${API_URL}/auth/logout`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            }).then(() => {
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                window.location.href = '/auth/login';
            }).catch(error => {
                console.error('Logout error:', error);
                // Clear storage anyway
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                window.location.href = '/auth/login';
            });
        }

        // Initialize
        window.addEventListener('load', () => {
            if (checkAuth()) {
                loadUserData();
            }
        });

        // Handle navigation
        document.getElementById('navLink_jobs')?.addEventListener('click', (e) => {
            e.preventDefault();
            alert('Jobs page - Coming soon!');
        });

        document.getElementById('navLink_applications')?.addEventListener('click', (e) => {
            e.preventDefault();
            alert('Applications page - Coming soon!');
        });

        document.getElementById('navLink_companies')?.addEventListener('click', (e) => {
            e.preventDefault();
            alert('Companies page - Coming soon!');
        });

        document.getElementById('navLink_profile')?.addEventListener('click', (e) => {
            e.preventDefault();
            alert('Profile page - Coming soon!');
        });

        document.getElementById('navLink_settings')?.addEventListener('click', (e) => {
            e.preventDefault();
            alert('Settings page - Coming soon!');
        });
    </script>
</body>
</html>
