<!-- Admin Module Sidebar -->
<div class="w-64 bg-white border-r border-gray-200 min-h-screen sticky top-0 flex flex-col shadow-sm">
    <!-- Brand / Logo -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gray-900 rounded-xl flex items-center justify-center">
                <i class="fas fa-shield-alt text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900 tracking-tight">Admin Panel</h2>
                <p class="text-xs text-gray-500">Manage your platform</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="flex-1 p-4 overflow-y-auto">
        <div class="mb-4">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-3">Main Menu</p>
            <nav class="space-y-1">
                <!-- Dashboard -->
                <a href="<?php echo e(route('dashboard.admin')); ?>"
                   class="flex items-center px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group <?php echo e(request()->routeIs('dashboard.admin') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : ''); ?>">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 <?php echo e(request()->routeIs('dashboard.admin') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200'); ?>">
                        <i class="fas fa-chart-line text-sm <?php echo e(request()->routeIs('dashboard.admin') ? 'text-white' : 'text-gray-500'); ?>"></i>
                    </div>
                    <span class="font-medium">Dashboard</span>
                    <span class="ml-auto text-xs <?php echo e(request()->routeIs('dashboard.admin') ? 'text-white/50' : 'text-gray-400'); ?>">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </a>

                <!-- Users Management -->
                <a href="<?php echo e(route('users.manage')); ?>"
                   class="flex items-center px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group <?php echo e(request()->routeIs('users.manage') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : ''); ?>">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 <?php echo e(request()->routeIs('users.manage') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200'); ?>">
                        <i class="fas fa-users text-sm <?php echo e(request()->routeIs('users.manage') ? 'text-white' : 'text-gray-500'); ?>"></i>
                    </div>
                    <span class="font-medium">Users</span>
                    <span class="ml-auto text-xs <?php echo e(request()->routeIs('users.manage') ? 'text-white/50' : 'text-gray-400'); ?>">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </a>

                <!-- Companies -->
                <a href="<?php echo e(route('page.admin.companies.index')); ?>"
                   class="flex items-center px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group <?php echo e(request()->routeIs('page.admin.companies.index') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : ''); ?>">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 <?php echo e(request()->routeIs('page.admin.companies.index') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200'); ?>">
                        <i class="fas fa-building text-sm <?php echo e(request()->routeIs('page.admin.companies.index') ? 'text-white' : 'text-gray-500'); ?>"></i>
                    </div>
                    <span class="font-medium">Companies</span>
                    <span class="ml-auto text-xs <?php echo e(request()->routeIs('page.admin.companies.index') ? 'text-white/50' : 'text-gray-400'); ?>">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </a>

                <!-- Categories -->
                <a href="<?php echo e(route('admin.categories.manage')); ?>"
                   class="flex items-center px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group <?php echo e(request()->routeIs('admin.categories.manage') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : ''); ?>">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 <?php echo e(request()->routeIs('admin.categories.manage') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200'); ?>">
                        <i class="fas fa-tags text-sm <?php echo e(request()->routeIs('admin.categories.manage') ? 'text-white' : 'text-gray-500'); ?>"></i>
                    </div>
                    <span class="font-medium">Categories</span>
                    <span class="ml-auto text-xs <?php echo e(request()->routeIs('admin.categories.manage') ? 'text-white/50' : 'text-gray-400'); ?>">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </a>

                <!-- Jobs -->
                <a href="<?php echo e(route('admin.jobs.manage')); ?>"
                   class="flex items-center px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group <?php echo e(request()->routeIs('admin.jobs.manage') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : ''); ?>">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 <?php echo e(request()->routeIs('admin.jobs.manage') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200'); ?>">
                        <i class="fas fa-briefcase text-sm <?php echo e(request()->routeIs('admin.jobs.manage') ? 'text-white' : 'text-gray-500'); ?>"></i>
                    </div>
                    <span class="font-medium">Jobs</span>
                    <span class="ml-auto text-xs <?php echo e(request()->routeIs('admin.jobs.manage') ? 'text-white/50' : 'text-gray-400'); ?>">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </a>

                <!-- Applications -->
                <a href="<?php echo e(route('page.admin.applications.index')); ?>"
                   class="flex items-center px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group <?php echo e(request()->routeIs('page.admin.applications.index') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : ''); ?>">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 <?php echo e(request()->routeIs('page.admin.applications.index') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200'); ?>">
                        <i class="fas fa-inbox text-sm <?php echo e(request()->routeIs('page.admin.applications.index') ? 'text-white' : 'text-gray-500'); ?>"></i>
                    </div>
                    <span class="font-medium">Applications</span>
                    <span class="ml-auto text-xs <?php echo e(request()->routeIs('page.admin.applications.index') ? 'text-white/50' : 'text-gray-400'); ?>">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </a>
            </nav>
        </div>

        <!-- Quick Stats Section -->
        <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Quick Stats</p>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Total Users</span>
                    <span class="text-sm font-bold text-gray-900" id="totalUsers">—</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Pending Companies</span>
                    <span class="text-sm font-bold text-yellow-600" id="pendingCompanies">—</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Active Jobs</span>
                    <span class="text-sm font-bold text-green-600" id="activeJobs">—</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer / User Info -->
    <div class="p-4 border-t border-gray-200">
        <div class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 transition-all duration-200 cursor-pointer">
            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-gray-500"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate"><?php echo e(auth()->user()->name ?? 'Admin'); ?></p>
                <p class="text-xs text-gray-500 truncate"><?php echo e(auth()->user()->email ?? 'admin@jobhub.com'); ?></p>
            </div>
            <button @click="logout()" class="text-gray-400 hover:text-red-500 transition-colors" title="Logout">
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

                // Fetch users count
                const usersResponse = await axios.get('/api/users', {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                if (usersResponse.data.status) {
                    const usersData = usersResponse.data.data;
                    const users = Array.isArray(usersData) ? usersData : (usersData?.data || []);
                    document.getElementById('totalUsers').textContent = users.length || 0;
                }

                // Fetch companies
                const companiesResponse = await axios.get('/api/companies', {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                if (companiesResponse.data.status) {
                    const companiesData = companiesResponse.data.data;
                    const companies = Array.isArray(companiesData) ? companiesData : (companiesData?.data || []);
                    const pending = companies.filter(c => c.status === 'pending').length;
                    document.getElementById('pendingCompanies').textContent = pending;
                }

                // Fetch jobs
                const jobsResponse = await axios.get('/api/jobs', {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                if (jobsResponse.data.status) {
                    const jobsData = jobsResponse.data.data;
                    const jobs = Array.isArray(jobsData) ? jobsData : (jobsData?.data || []);
                    const active = jobs.filter(j => j.status !== 'closed').length;
                    document.getElementById('activeJobs').textContent = active;
                }
            } catch (error) {
                console.error('Error fetching stats:', error);
            }
        }

        // Update stats immediately and every 30 seconds
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

    #totalUsers, #pendingCompanies, #activeJobs {
        animation: shimmer 2s ease-in-out infinite;
    }
</style>
<?php /**PATH C:\xampp\htdocs\Job Recuitment System\recruitment-portal\resources\views/components/admin-sidebar.blade.php ENDPATH**/ ?>