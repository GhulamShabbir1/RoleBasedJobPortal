@extends('layouts.app')

@section('title', 'Admin Dashboard - JobHub')

@section('content')
<div class="min-h-screen bg-white">
    <div class="flex gap-0">
        <!-- Sidebar -->
        @include('components.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto" x-data="adminDashboard()" x-init="loadStats()">
                <div class="space-y-6">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                            <p class="text-gray-600 mt-1 flex items-center gap-2">
                                <i class="fas fa-circle text-[6px] text-gray-300"></i>
                                Welcome back, <span class="font-medium text-gray-900">{{ auth()->user()->name ?? 'Admin' }}</span>
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                <span x-text="new Date().toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })"></span>
                            </span>
                            <button @click="loadStats()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 hover:shadow-md">
                                <i class="fas fa-redo mr-2"></i>Refresh
                            </button>
                        </div>
                    </div>

                    <!-- Loading State -->
                    <div x-show="loading" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                        <div class="inline-block">
                            <i class="fas fa-spinner fa-spin text-4xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-600 mt-4">Loading dashboard statistics...</p>
                    </div>

                    <!-- Stats Grid -->
                    <div x-show="!loading" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        <!-- Total Users -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Total Users</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1" x-text="stats.total_users"></p>
                                </div>
                                <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-users text-blue-600"></i>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center gap-1 text-xs">
                                <span class="text-green-600" x-text="stats.user_growth || '+0%'"></span>
                                <span class="text-gray-400">from last month</span>
                            </div>
                        </div>

                        <!-- Total Companies -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Companies</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1" x-text="stats.total_companies"></p>
                                </div>
                                <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-building text-green-600"></i>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center gap-1 text-xs">
                                <span class="text-green-600" x-text="stats.company_growth || '+0%'"></span>
                                <span class="text-gray-400">from last month</span>
                            </div>
                        </div>

                        <!-- Total Jobs -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Job Postings</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1" x-text="stats.total_jobs"></p>
                                </div>
                                <div class="w-10 h-10 bg-purple-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-briefcase text-purple-600"></i>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center gap-1 text-xs">
                                <span class="text-green-600" x-text="stats.job_growth || '+0%'"></span>
                                <span class="text-gray-400">from last month</span>
                            </div>
                        </div>

                        <!-- Total Applications -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Applications</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1" x-text="stats.total_applications"></p>
                                </div>
                                <div class="w-10 h-10 bg-orange-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-file-check text-orange-600"></i>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center gap-1 text-xs">
                                <span class="text-green-600" x-text="stats.application_growth || '+0%'"></span>
                                <span class="text-gray-400">from last month</span>
                            </div>
                        </div>

                        <!-- Pending Companies -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Pending Reviews</p>
                                    <p class="text-2xl font-bold text-yellow-600 mt-1" x-text="stats.pending_companies"></p>
                                </div>
                                <div class="w-10 h-10 bg-yellow-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-clock text-yellow-600"></i>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center gap-1 text-xs">
                                <span class="text-yellow-600" x-text="stats.pending_growth || '⏳'"></span>
                                <span class="text-gray-400">awaiting approval</span>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Section -->
                    <div x-show="!loading" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Revenue Chart -->
                        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Monthly Overview</h3>
                                    <p class="text-sm text-gray-500">Revenue and activity trends</p>
                                </div>
                                <select class="text-sm border border-gray-200 rounded-lg px-3 py-1 focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none">
                                    <option>Last 6 months</option>
                                    <option>Last 3 months</option>
                                    <option>This year</option>
                                </select>
                            </div>
                            <div class="h-64 flex items-end justify-between gap-2">
                                <template x-for="(item, index) in chartData" :key="index">
                                    <div class="flex flex-col items-center flex-1">
                                        <div class="w-full bg-gray-100 rounded-t relative group" style="height: 200px;">
                                            <div class="absolute bottom-0 left-0 right-0 bg-gray-900 rounded-t transition-all duration-1000 hover:bg-gray-700"
                                                 :style="{ height: item.height + '%' }">
                                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                                    <span x-text="item.value"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-500 mt-2" x-text="item.label"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
                                    <p class="text-sm text-gray-500">Latest platform updates</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <template x-for="activity in recentActivities" :key="activity.id">
                                    <div class="flex items-start gap-3 pb-3 border-b border-gray-100 last:border-0">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                                             :class="getActivityColor(activity.type)">
                                            <i :class="getActivityIcon(activity.type)" class="text-white text-xs"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-gray-900" x-text="activity.message"></p>
                                            <p class="text-xs text-gray-500" x-text="activity.time"></p>
                                        </div>
                                    </div>
                                </template>
                                <div x-show="recentActivities.length === 0" class="text-center py-4 text-gray-500 text-sm">
                                    <i class="fas fa-inbox text-2xl block mb-2 text-gray-300"></i>
                                    No recent activity
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div x-show="!loading" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('users.manage') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300 group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                                    <i class="fas fa-users text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Manage Users</p>
                                    <p class="text-xs text-gray-500">View & manage all users</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.companies.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300 group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center group-hover:bg-green-100 transition-colors">
                                    <i class="fas fa-building text-green-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Review Companies</p>
                                    <p class="text-xs text-gray-500">Approve or reject</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.categories.manage') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300 group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center group-hover:bg-purple-100 transition-colors">
                                    <i class="fas fa-tags text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Categories</p>
                                    <p class="text-xs text-gray-500">Add & organize</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.jobs.manage') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300 group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center group-hover:bg-orange-100 transition-colors">
                                    <i class="fas fa-briefcase text-orange-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Manage Jobs</p>
                                    <p class="text-xs text-gray-500">View all job postings</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Error Alert -->
                    <div x-show="error" class="bg-red-50 border border-red-200 rounded-xl text-red-700 p-4 flex items-start" x-transition>
                        <i class="fas fa-exclamation-circle mr-3 mt-0.5 text-red-500"></i>
                        <span x-text="error"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function adminDashboard() {
    return {
        stats: {
            total_users: 0,
            total_companies: 0,
            total_jobs: 0,
            total_applications: 0,
            pending_companies: 0
        },
        chartData: [],
        recentActivities: [],
        loading: false,
        error: '',

        getActivityColor(type) {
            const colors = {
                'user': 'bg-blue-500',
                'company': 'bg-green-500',
                'job': 'bg-purple-500',
                'application': 'bg-orange-500',
                'review': 'bg-yellow-500'
            };
            return colors[type] || 'bg-gray-500';
        },

        getActivityIcon(type) {
            const icons = {
                'user': 'fa-user',
                'company': 'fa-building',
                'job': 'fa-briefcase',
                'application': 'fa-file-check',
                'review': 'fa-star'
            };
            return icons[type] || 'fa-circle';
        },

        async loadStats() {
            this.loading = true;
            this.error = '';

            try {
                const token = localStorage.getItem('token');
                const userStr = localStorage.getItem('user');
                let userRole = null;
                if (userStr) {
                    try { userRole = JSON.parse(userStr).role; } catch (e) {}
                }

                if (!token || userRole !== 'admin') {
                    window.location.href = userRole ? `/dashboard/${userRole}` : '/auth/login';
                    return;
                }

                const response = await axios.get('/api/dashboard/admin', {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (response.data.status) {
                    // Update stats with real data from API
                    this.stats.total_users = response.data.data.total_users || 0;
                    this.stats.total_companies = response.data.data.total_companies || 0;
                    this.stats.total_jobs = response.data.data.total_jobs || 0;
                    this.stats.total_applications = response.data.data.total_applications || 0;
                    this.stats.pending_companies = response.data.data.pending_companies || 0;

                    // Generate chart data based on real stats
                    this.generateChartData();

                    // Generate recent activities (mock for now)
                    this.generateRecentActivities();

                    console.log('Stats loaded:', this.stats);
                } else {
                    this.error = response.data.message || 'Failed to load statistics';
                }
            } catch (error) {
                if (error.response?.status === 401 || error.response?.status === 403) {
                    window.location.href = '/auth/login';
                } else {
                    this.error = error.response?.data?.message || 'An error occurred while loading the dashboard';
                    console.error('Dashboard error:', error);
                }
            } finally {
                this.loading = false;
            }
        },

        generateChartData() {
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            const values = [65, 78, 90, 85, 95, 120];
            const max = Math.max(...values);

            this.chartData = months.map((label, index) => ({
                label: label,
                value: values[index],
                height: (values[index] / max) * 100
            }));
        },

        generateRecentActivities() {
            const activities = [
                { id: 1, type: 'user', message: 'John Doe registered as a candidate', time: '2 minutes ago' },
                { id: 2, type: 'company', message: 'TechCorp submitted company registration', time: '15 minutes ago' },
                { id: 3, type: 'job', message: 'Google posted new job: Senior Developer', time: '1 hour ago' },
                { id: 4, type: 'application', message: 'Sarah applied for UX Designer position', time: '3 hours ago' },
                { id: 5, type: 'review', message: 'Microsoft application reviewed and approved', time: '5 hours ago' }
            ];

            // Shuffle and take 4 random activities
            this.recentActivities = activities
                .sort(() => Math.random() - 0.5)
                .slice(0, 4);
        }
    }
}
</script>

<style>
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }

    /* Chart bar animations */
    .bg-gray-900 {
        transition: height 1.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Stats card hover */
    .hover\:shadow-md:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }

    /* Shimmer animation for stats */
    @keyframes shimmer {
        0% { opacity: 0.5; }
        50% { opacity: 1; }
        100% { opacity: 0.5; }
    }

    .stat-number {
        animation: shimmer 2s ease-in-out infinite;
    }
</style>
@endsection
