<!-- Employer Module Sidebar -->
<div class="w-64 bg-white border-r border-gray-200 min-h-screen sticky top-0 flex flex-col shadow-sm">
    <!-- Brand / Logo -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gray-900 rounded-xl flex items-center justify-center">
                <i class="fas fa-building text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900 tracking-tight">Employer Panel</h2>
                <p class="text-xs text-gray-500">Hire top talent</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="flex-1 p-4 overflow-y-auto">
        <div class="mb-4">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-3">Main Menu</p>
            <nav class="space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('dashboard.employer') }}"
                   class="flex items-center px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('dashboard.employer') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : '' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('dashboard.employer') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200' }}">
                        <i class="fas fa-chart-line text-sm {{ request()->routeIs('dashboard.employer') ? 'text-white' : 'text-gray-500' }}"></i>
                    </div>
                    <span class="font-medium">Dashboard</span>
                    <span class="ml-auto text-xs {{ request()->routeIs('dashboard.employer') ? 'text-white/50' : 'text-gray-400' }}">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </a>

                <!-- Company Management -->
                <a href="{{ route('employer.company') }}"
                   class="flex items-center px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('employer.company', 'companies.create', 'companies.edit') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : '' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('employer.company', 'companies.create', 'companies.edit') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200' }}">
                        <i class="fas fa-building text-sm {{ request()->routeIs('employer.company', 'companies.create', 'companies.edit') ? 'text-white' : 'text-gray-500' }}"></i>
                    </div>
                    <span class="font-medium">Company</span>
                    <span class="ml-auto text-xs {{ request()->routeIs('employer.company', 'companies.create', 'companies.edit') ? 'text-white/50' : 'text-gray-400' }}">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </a>

                <!-- Jobs Management -->
                <a href="{{ route('employer.jobs') }}"
                   class="flex items-center px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('employer.jobs', 'jobs.create') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : '' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('employer.jobs', 'jobs.create') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200' }}">
                        <i class="fas fa-briefcase text-sm {{ request()->routeIs('employer.jobs', 'jobs.create') ? 'text-white' : 'text-gray-500' }}"></i>
                    </div>
                    <span class="font-medium">Jobs</span>
                    <span class="ml-auto text-xs {{ request()->routeIs('employer.jobs', 'jobs.create') ? 'text-white/50' : 'text-gray-400' }}">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </a>

                <!-- Applications -->
                <a href="{{ route('page.applications.review') }}"
                   class="flex items-center px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('page.applications.review') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : '' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('page.applications.review') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200' }}">
                        <i class="fas fa-inbox text-sm {{ request()->routeIs('page.applications.review') ? 'text-white' : 'text-gray-500' }}"></i>
                    </div>
                    <span class="font-medium">Applications</span>
                    <span class="ml-auto text-xs {{ request()->routeIs('page.applications.review') ? 'text-white/50' : 'text-gray-400' }}">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </a>

                <!-- Divider -->
                <div class="my-4 border-t border-gray-200"></div>

                <!-- Post a Job (Quick Action) -->
                <a href="{{ route('jobs.create') }}"
                   class="flex items-center px-4 py-3 rounded-xl bg-gray-900 text-white hover:bg-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl group">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 bg-white/10">
                        <i class="fas fa-plus-circle text-sm text-white"></i>
                    </div>
                    <span class="font-medium">Post a Job</span>
                    <span class="ml-auto text-xs text-white/50">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </a>
            </nav>
        </div>

        <!-- Quick Stats Section -->
        <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Quick Stats</p>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Total Jobs</span>
                    <span class="text-sm font-bold text-gray-900" id="totalJobs">—</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Active Jobs</span>
                    <span class="text-sm font-bold text-green-600" id="activeJobs">—</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Applications</span>
                    <span class="text-sm font-bold text-blue-600" id="totalApplications">—</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Pending Reviews</span>
                    <span class="text-sm font-bold text-yellow-600" id="pendingReviews">—</span>
                </div>
            </div>
        </div>

        <!-- Company Status -->
        <div class="mt-4 p-4 bg-white rounded-xl border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Company Status</p>
                <span class="px-2 py-1 text-xs rounded-full" id="companyStatusBadge">
                    <span id="companyStatusText">Not Set</span>
                </span>
            </div>
            <div class="flex items-center gap-2 text-xs text-gray-500">
                <i class="fas fa-info-circle"></i>
                <span id="companyStatusMessage">Complete your company profile</span>
            </div>
            <a href="{{ route('employer.company') }}" class="mt-2 text-xs text-gray-900 hover:underline font-medium block">
                        <i class="fas fa-edit mr-1"></i>Update Company
                    </a>
        </div>
    </div>

    <!-- Footer / User Info -->
    <div class="p-4 border-t border-gray-200">
        <div class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 transition-all duration-200 cursor-pointer">
            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-gray-500"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name ?? 'Employer' }}</p>
                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email ?? 'employer@jobhub.com' }}</p>
            </div>
<button type="button" onclick="window.dispatchEvent(new CustomEvent('app-logout'))" class="text-gray-400 hover:text-red-500 transition-colors" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
        </div>
    </div>
</div>

<script>
    // Fetch and update quick stats
    document.addEventListener('DOMContentLoaded', function() {
        async function updateStats() {
            try {
                const token = localStorage.getItem('token');
                if (!token) return;
                
                const authHeaders = {
                    headers: { Authorization: `Bearer ${token}` }
                };

                // Fetch jobs (employer-specific)
                const jobsResponse = await axios.get('/api/employer/jobs', authHeaders);

                if (jobsResponse.data.status) {
                    const jobs = jobsResponse.data.data;
                    const total = jobs.length;
                    const active = jobs.filter(j => j.status !== 'closed').length;

                    document.getElementById('totalJobs').textContent = total;
                    document.getElementById('activeJobs').textContent = active;
                }

                // Fetch applications
                const appsResponse = await axios.get('/api/employer/applications', authHeaders);

                if (appsResponse.data.status) {
                    const apps = appsResponse.data.data;
                    const total = apps.length;
                    const pending = apps.filter(a => a.status === 'pending').length;

                    document.getElementById('totalApplications').textContent = total;
                    document.getElementById('pendingReviews').textContent = pending;
                }

                // Fetch company status
                const companyResponse = await axios.get('/api/employer/my-company-status', authHeaders);

                if (companyResponse.data.status) {
                    const responseData = companyResponse.data.data;
                    const company = responseData.company;
                    const badge = document.getElementById('companyStatusBadge');
                    const text = document.getElementById('companyStatusText');
                    const message = document.getElementById('companyStatusMessage');

                    if (company && company.id) {
                        text.textContent = responseData.status?.toUpperCase() || 'PENDING';
                        badge.className = 'px-2 py-1 text-xs rounded-full ' + getStatusClass(responseData.status);
                        message.textContent = responseData.status === 'approved' ? 'Your company is active' : 'Your company is pending approval';
                    } else {
                        text.textContent = 'NOT SET';
                        badge.className = 'px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600';
                        message.textContent = 'Complete your company profile';
                    }
                }
            } catch (error) {
                console.error('Error fetching stats:', error);
            }
        }

        function getStatusClass(status) {
            const classes = {
                'pending': 'bg-yellow-100 text-yellow-800',
                'approved': 'bg-green-100 text-green-800',
                'rejected': 'bg-red-100 text-red-800'
            };
            return classes[status] || 'bg-gray-100 text-gray-600';
        }

        // Update immediately and every 30 seconds
        updateStats();
        setInterval(updateStats, 30000);
    });
</script>

<style>
    /* Smooth scrolling for the sidebar */
    .overflow-y-auto {
        scrollbar-width: thin;
        scrollbar-color: #d1d5db transparent;
    }

    .overflow-y-auto::-webkit-scrollbar {
        width: 4px;
    }

    .overflow-y-auto::-webkit-scrollbar-track {
        background: transparent;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb {
        background-color: #d1d5db;
        border-radius: 20px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background-color: #9ca3af;
    }

    /* Active state animation */
    .bg-gray-900 {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Hover effects for nav items */
    .group:hover .w-8.h-8 {
        transition: all 0.3s ease;
    }

    /* Quick stats shimmer effect */
    @keyframes shimmer {
        0% { opacity: 0.5; }
        50% { opacity: 1; }
        100% { opacity: 0.5; }
    }

    #totalJobs, #activeJobs, #totalApplications, #pendingReviews {
        animation: shimmer 2s ease-in-out infinite;
    }

    /* Post a Job button pulse */
    @keyframes pulse-border {
        0%, 100% { box-shadow: 0 0 0 0 rgba(17, 24, 39, 0.2); }
        50% { box-shadow: 0 0 0 8px rgba(17, 24, 39, 0); }
    }

    .bg-gray-900 {
        animation: pulse-border 2s infinite;
    }
</style>
