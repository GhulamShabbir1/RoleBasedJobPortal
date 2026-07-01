@extends('layouts.app')

@section('title', 'Employer Dashboard - JobHub')

@section('content')
<div class="min-h-screen bg-white">
    <div class="flex gap-0">
        <!-- Sidebar -->
        @include('components.employer-sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto" x-data="employerDashboard()" x-init="loadStats()">
                <div class="space-y-6">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                            <p class="text-gray-600 mt-1 flex items-center gap-2">
                                <i class="fas fa-circle text-[6px] text-gray-300"></i>
                                Welcome back, <span class="font-medium text-gray-900">{{ auth()->user()->name ?? 'Employer' }}</span>
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                <span x-text="new Date().toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })"></span>
                            </span>
                        </div>
                    </div>

                    <!-- Company Status Alert -->
                    <div x-show="!loading && !companyApproved" class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mt-0.5"></i>
                        <div class="flex-1">
                            <p class="font-semibold text-yellow-900">Waiting for Company Approval</p>
                            <p class="text-yellow-700 text-sm mt-1">Your company is still pending admin approval. You won't be able to post jobs until it's approved.</p>
                        </div>
                        <a href="{{ route('companies.create') }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-all duration-200 text-sm whitespace-nowrap">
                            Update Company
                        </a>
                    </div>

                    <!-- Loading State -->
                    <div x-show="loading" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                        <div class="inline-block">
                            <i class="fas fa-spinner fa-spin text-4xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-600 mt-4">Loading your dashboard...</p>
                    </div>

                    <!-- Stats Grid -->
                    <div x-show="!loading" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <!-- Active Jobs -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Active Jobs</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1" x-text="stats.active_jobs || 0"></p>
                                </div>
                                <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-briefcase text-blue-600"></i>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center gap-1 text-xs">
                                <span class="text-blue-600">📊</span>
                                <span class="text-gray-400">Open positions</span>
                            </div>
                        </div>

                        <!-- Total Applications -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Applications</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1" x-text="stats.total_applications || 0"></p>
                                </div>
                                <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-file-check text-green-600"></i>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center gap-1 text-xs">
                                <span class="text-green-600">📨</span>
                                <span class="text-gray-400">Total received</span>
                            </div>
                        </div>

                        <!-- Pending Applications -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Pending Review</p>
                                    <p class="text-2xl font-bold text-yellow-600 mt-1" x-text="stats.pending_applications || 0"></p>
                                </div>
                                <div class="w-10 h-10 bg-yellow-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-clock text-yellow-600"></i>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center gap-1 text-xs">
                                <span class="text-yellow-600">⏳</span>
                                <span class="text-gray-400">Need attention</span>
                            </div>
                        </div>

                        <!-- Accepted Applications -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Accepted</p>
                                    <p class="text-2xl font-bold text-green-600 mt-1" x-text="stats.accepted_applications || 0"></p>
                                </div>
                                <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center gap-1 text-xs">
                                <span class="text-green-600">✅</span>
                                <span class="text-gray-400">Hired candidates</span>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Section -->
                    <div x-show="!loading" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Application Trends Chart -->
                        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Application Trends</h3>
                                    <p class="text-sm text-gray-500">Monthly application statistics</p>
                                </div>
                                <span class="text-sm text-gray-500" x-text="'Total: ' + (stats.total_applications || 0)"></span>
                            </div>
                            <div class="h-64 flex items-end justify-between gap-2">
                                <template x-for="(item, index) in trendData" :key="index">
                                    <div class="flex flex-col items-center flex-1">
                                        <div class="w-full bg-gray-100 rounded-t-lg relative group" style="height: 200px;">
                                            <div class="absolute bottom-0 left-0 right-0 bg-gray-900 rounded-t-lg transition-all duration-1000 hover:bg-gray-700"
                                                 :style="{ height: item.percentage + '%' }">
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

                        <!-- Quick Stats & Actions -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Quick Stats</h3>
                                    <p class="text-sm text-gray-500">At a glance</p>
                                </div>
                                <i class="fas fa-chart-pie text-gray-400 text-xl"></i>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <span class="text-sm text-gray-600">Jobs Posted</span>
                                    <span class="text-sm font-bold text-gray-900" x-text="stats.total_jobs || 0"></span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <span class="text-sm text-gray-600">Total Views</span>
                                    <span class="text-sm font-bold text-gray-900" x-text="stats.total_views || 0"></span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <span class="text-sm text-gray-600">Response Rate</span>
                                    <span class="text-sm font-bold text-green-600" x-text="stats.response_rate || '0%'"></span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <span class="text-sm text-gray-600">Avg. Time to Hire</span>
                                    <span class="text-sm font-bold text-blue-600" x-text="stats.avg_hire_time || 'N/A'"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Applications -->
                    <div x-show="!loading && recentApplications.length > 0" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Recent Applications</h3>
                                <p class="text-sm text-gray-500">Latest candidates who applied</p>
                            </div>
                            <a href="{{ route('page.applications.review') }}" class="text-sm text-gray-900 hover:underline font-medium">
                                View All <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                        <div class="space-y-3">
                            <template x-for="app in recentApplications" :key="app.id">
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-bold text-gray-600" x-text="getInitials(app.candidate_name)"></span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900" x-text="app.candidate_name"></p>
                                            <p class="text-xs text-gray-500" x-text="app.job_title"></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="text-xs px-2 py-1 rounded-full" :class="getStatusClass(app.status)">
                                            <span x-text="app.status.toUpperCase()"></span>
                                        </span>
                                        <span class="text-xs text-gray-400" x-text="app.applied_at"></span>
                                        <a :href="`/applications/${app.id}`" class="text-blue-600 hover:text-blue-800 text-xs">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Company Information -->
                    <div x-show="!loading" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Company Information</h3>
                                <p class="text-sm text-gray-500">Your company profile details</p>
                            </div>
                            <a href="{{ route('employer.company') }}" class="text-sm text-gray-900 hover:underline font-medium">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-xs text-gray-500">Company Name</p>
                                <p class="text-sm font-medium text-gray-900 mt-1" x-text="companyInfo.name || 'Not registered'"></p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-xs text-gray-500">Status</p>
                                <div class="mt-1">
                                    <span :class="companyInfo.status === 'approved' ? 'bg-green-100 text-green-800' : companyInfo.status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'" class="px-3 py-1 rounded-full text-sm font-medium" x-text="companyInfo.status ? companyInfo.status.charAt(0).toUpperCase() + companyInfo.status.slice(1) : 'N/A'"></span>
                                </div>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-xs text-gray-500">Location</p>
                                <p class="text-sm font-medium text-gray-900 mt-1" x-text="companyInfo.city || 'N/A'"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div x-show="!loading" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('employer.jobs') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300 group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                                    <i class="fas fa-briefcase text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">My Jobs</p>
                                    <p class="text-xs text-gray-500">Manage postings</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('page.applications.review') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300 group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center group-hover:bg-green-100 transition-colors">
                                    <i class="fas fa-inbox text-green-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Applications</p>
                                    <p class="text-xs text-gray-500">Review candidates</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('jobs.create') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300 group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center group-hover:bg-purple-100 transition-colors">
                                    <i class="fas fa-plus-circle text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Post Job</p>
                                    <p class="text-xs text-gray-500">Create new listing</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('employer.company') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300 group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-yellow-50 rounded-lg flex items-center justify-center group-hover:bg-yellow-100 transition-colors">
                                    <i class="fas fa-building text-yellow-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Company</p>
                                    <p class="text-xs text-gray-500">Update profile</p>
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
function employerDashboard() {
    return {
        stats: {
            active_jobs: 0,
            total_applications: 0,
            pending_applications: 0,
            accepted_applications: 0,
            total_jobs: 0,
            total_views: 0,
            response_rate: '0%',
            avg_hire_time: 'N/A'
        },
        companyInfo: {
            name: '',
            status: '',
            city: ''
        },
        companyApproved: false,
        recentApplications: [],
        trendData: [],
        loading: false,
        error: '',

        getInitials(name) {
            if (!name) return '?';
            return name.split(' ').map(word => word[0]).join('').toUpperCase().slice(0, 2);
        },

        getStatusClass(status) {
            const classes = {
                'pending': 'bg-yellow-100 text-yellow-800',
                'reviewed': 'bg-orange-100 text-orange-800',
                'accepted': 'bg-green-100 text-green-800',
                'rejected': 'bg-red-100 text-red-800'
            };
            return classes[status] || 'bg-gray-100 text-gray-800';
        },

        async loadStats() {
            this.loading = true;
            this.error = '';

            try {
                const userStr = localStorage.getItem('user');
                let userRole = null;
                if (userStr) {
                    try { userRole = JSON.parse(userStr).role; } catch (e) {}
                }

                if (userRole !== 'employer') {
                    window.location.href = userRole ? `/dashboard/${userRole}` : '/auth/login';
                    return;
                }

                const token = localStorage.getItem('token');
                const authHeaders = {
                    headers: { Authorization: `Bearer ${token}` }
                };

                // Load dashboard stats
                const statsResponse = await axios.get('/api/dashboard/employer', authHeaders);

                if (statsResponse.data.status) {
                    this.stats = { ...this.stats, ...statsResponse.data.data };
                    this.generateTrendData();
                }

                // Load company status
                const companyResponse = await axios.get('/api/employer/my-company-status', authHeaders);

                if (companyResponse.data.status) {
                    this.companyInfo = companyResponse.data.data.company || {};
                    this.companyApproved = companyResponse.data.data.status === 'approved';
                }

                // Load recent applications
                const appsResponse = await axios.get('/api/employer/applications', {
                    ...authHeaders,
                    params: { limit: 5 }
                });

                if (appsResponse.data.status) {
                    this.recentApplications = appsResponse.data.data.map(app => ({
                        id: app.id,
                        candidate_name: app.candidate?.name || 'Unknown Candidate',
                        job_title: app.job?.title || 'Unknown Job',
                        status: app.status,
                        applied_at: new Date(app.applied_at).toLocaleDateString()
                    }));
                }

            } catch (error) {
                if (error.response?.status === 401 || error.response?.status === 403) {
                    window.location.href = '/auth/login';
                } else {
                    console.error('Error loading dashboard:', error);
                    this.error = error.response?.data?.message || 'Failed to load dashboard data';
                }
            } finally {
                this.loading = false;
            }
        },

        generateTrendData() {
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            const values = [12, 19, 15, 22, 18, 25];
            const max = Math.max(...values);

            this.trendData = months.map((label, index) => ({
                label: label,
                value: values[index],
                percentage: (values[index] / max) * 100
            }));
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
