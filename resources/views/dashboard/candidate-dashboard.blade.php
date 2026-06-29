@extends('layouts.app')

@section('title', 'Candidate Dashboard - JobHub')

@section('content')
<div class="min-h-screen bg-white">
    <div class="flex gap-0">
        <!-- Sidebar -->
        @include('components.candidate-sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto" x-data="candidateDashboard()" x-init="loadStats()">
                <div class="space-y-6">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                            <p class="text-gray-600 mt-1 flex items-center gap-2">
                                <i class="fas fa-circle text-[6px] text-gray-300"></i>
                                Welcome back, <span class="font-medium text-gray-900">{{ auth()->user()->name ?? 'Candidate' }}</span>
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                <span x-text="new Date().toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })"></span>
                            </span>
                            <a href="{{ route('jobs.index') }}" class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center transition-all duration-200 hover:shadow-lg hover:scale-105">
                                <i class="fas fa-search mr-2"></i>Browse Jobs
                            </a>
                            <button @click="loadStats()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 hover:shadow-md">
                                <i class="fas fa-redo mr-2"></i>Refresh
                            </button>
                        </div>
                    </div>

                    <!-- Profile Completion Alert -->
                    <div x-show="!loading && profileCompletion < 100" class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mt-0.5"></i>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-yellow-800">Complete Your Profile</p>
                            <p class="text-sm text-yellow-700">Your profile is <span x-text="profileCompletion + '%'"></span> complete. <a href="{{ route('candidate.profile.create') }}" class="font-medium underline hover:no-underline">Update now</a> to get noticed by employers.</p>
                        </div>
                        <div class="w-32">
                            <div class="w-full h-2 bg-yellow-200 rounded-full overflow-hidden">
                                <div class="h-full bg-yellow-600 rounded-full transition-all duration-1000" :style="{ width: profileCompletion + '%' }"></div>
                            </div>
                        </div>
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
                        <!-- Total Applications -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Applications</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1" x-text="stats.total_applications || 0"></p>
                                </div>
                                <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-file-check text-blue-600"></i>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center gap-1 text-xs">
                                <span class="text-blue-600">📊</span>
                                <span class="text-gray-400">Total applications sent</span>
                            </div>
                        </div>

                        <!-- Pending Applications -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Pending</p>
                                    <p class="text-2xl font-bold text-yellow-600 mt-1" x-text="stats.pending_applications || 0"></p>
                                </div>
                                <div class="w-10 h-10 bg-yellow-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-clock text-yellow-600"></i>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center gap-1 text-xs">
                                <span class="text-yellow-600">⏳</span>
                                <span class="text-gray-400">Awaiting review</span>
                            </div>
                        </div>

                        <!-- Reviewed Applications -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Under Review</p>
                                    <p class="text-2xl font-bold text-orange-600 mt-1" x-text="stats.reviewed_applications || 0"></p>
                                </div>
                                <div class="w-10 h-10 bg-orange-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-eye text-orange-600"></i>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center gap-1 text-xs">
                                <span class="text-orange-600">👁️</span>
                                <span class="text-gray-400">Being reviewed</span>
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
                                <span class="text-gray-400">Offer received</span>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Section -->
                    <div x-show="!loading" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Application Status Chart -->
                        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Application Status</h3>
                                    <p class="text-sm text-gray-500">Overview of your applications</p>
                                </div>
                                <span class="text-sm text-gray-500" x-text="'Total: ' + (stats.total_applications || 0)"></span>
                            </div>
                            <div class="h-64 flex items-end justify-between gap-3">
                                <template x-for="(item, index) in statusData" :key="index">
                                    <div class="flex flex-col items-center flex-1">
                                        <div class="w-full bg-gray-100 rounded-t-lg relative group" style="height: 200px;">
                                            <div class="absolute bottom-0 left-0 right-0 rounded-t-lg transition-all duration-1000 hover:brightness-110"
                                                 :style="{ height: item.percentage + '%', background: item.color }">
                                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                                    <span x-text="item.value"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-500 mt-2" x-text="item.label"></span>
                                        <span class="text-xs font-semibold text-gray-700" x-text="item.value"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Quick Stats & Tips -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Quick Tips</h3>
                                    <p class="text-sm text-gray-500">Boost your chances</p>
                                </div>
                                <i class="fas fa-lightbulb text-yellow-500 text-xl"></i>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-start gap-3 p-3 bg-blue-50 rounded-lg">
                                    <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <i class="fas fa-check text-white text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Complete your profile</p>
                                        <p class="text-xs text-gray-600">80% more likely to get noticed</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3 p-3 bg-green-50 rounded-lg">
                                    <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <i class="fas fa-check text-white text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Apply to relevant jobs</p>
                                        <p class="text-xs text-gray-600">Tailor your applications</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3 p-3 bg-purple-50 rounded-lg">
                                    <div class="w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <i class="fas fa-check text-white text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Follow up</p>
                                        <p class="text-xs text-gray-600">Send a thank you note</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3 p-3 bg-yellow-50 rounded-lg">
                                    <div class="w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <i class="fas fa-check text-white text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Update your resume</p>
                                        <p class="text-xs text-gray-600">Keep it current</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Applications -->
                    <div x-show="!loading && recentApplications.length > 0" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Recent Applications</h3>
                                <p class="text-sm text-gray-500">Your latest job applications</p>
                            </div>
                            <a href="{{ route('applications.mine') }}" class="text-sm text-gray-900 hover:underline font-medium">
                                View All <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                        <div class="space-y-3">
                            <template x-for="app in recentApplications" :key="app.id">
                                <div x-show="app && app.id" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-briefcase text-gray-500"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900" x-text="app.job_title || 'Job'"></p>
                                            <p class="text-xs text-gray-500" x-text="app.company_name || 'Company'"></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="text-xs px-2 py-1 rounded-full" :class="getStatusClass(app.status)">
                                            <span x-text="(app.status || 'pending').toUpperCase()"></span>
                                        </span>
                                        <span class="text-xs text-gray-400" x-text="app.applied_at || 'N/A'"></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div x-show="!loading" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('jobs.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300 group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                                    <i class="fas fa-search text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Find Jobs</p>
                                    <p class="text-xs text-gray-500">Browse opportunities</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('applications.mine') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300 group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center group-hover:bg-green-100 transition-colors">
                                    <i class="fas fa-file-check text-green-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">My Applications</p>
                                    <p class="text-xs text-gray-500">Track status</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('candidate.profile.create') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300 group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center group-hover:bg-purple-100 transition-colors">
                                    <i class="fas fa-user text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">My Profile</p>
                                    <p class="text-xs text-gray-500">Update your info</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('jobs.index') }}?saved=true" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200 hover:border-gray-300 group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-yellow-50 rounded-lg flex items-center justify-center group-hover:bg-yellow-100 transition-colors">
                                    <i class="fas fa-bookmark text-yellow-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Saved Jobs</p>
                                    <p class="text-xs text-gray-500">Your favorites</p>
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
function candidateDashboard() {
    return {
        stats: {
            total_applications: 0,
            pending_applications: 0,
            reviewed_applications: 0,
            accepted_applications: 0
        },
        recentApplications: [],
        profileCompletion: 0,
        statusData: [],
        loading: false,
        error: '',

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
                const token = localStorage.getItem('token');
                const userStr = localStorage.getItem('user');
                let userRole = null;
                if (userStr) {
                    try { userRole = JSON.parse(userStr).role; } catch (e) {}
                }

                if (!token || userRole !== 'candidate') {
                    window.location.href = userRole ? `/dashboard/${userRole}` : '/auth/login';
                    return;
                }

                // Load dashboard stats
                try {
                    const statsResponse = await axios.get('/api/dashboard/candidate');

                    if (statsResponse.data.success) {
                        this.stats = statsResponse.data.data || {
                            total_applications: 0,
                            pending_applications: 0,
                            reviewed_applications: 0,
                            accepted_applications: 0
                        };
                        this.generateStatusData();
                    }
                } catch (statsError) {
                    console.error('Error loading stats:', statsError);
                    this.stats = {
                        total_applications: 0,
                        pending_applications: 0,
                        reviewed_applications: 0,
                        accepted_applications: 0
                    };
                    this.generateStatusData();
                }

                // Load recent applications
                try {
                    const appsResponse = await axios.get('/api/candidate/applications', {
                        params: { limit: 5 }
                    });

                    if (appsResponse.data.success && Array.isArray(appsResponse.data.data)) {
                        this.recentApplications = appsResponse.data.data
                            .filter(app => app && app.id) // Filter out null/undefined entries
                            .map(app => ({
                                id: app.id,
                                job_title: app.job?.title || 'Unknown Job',
                                company_name: app.job?.company?.name || 'Unknown Company',
                                status: app.status || 'pending',
                                applied_at: app.applied_at ? new Date(app.applied_at).toLocaleDateString() : 'N/A'
                            }));
                    }
                } catch (appsError) {
                    console.error('Error loading applications:', appsError);
                    this.recentApplications = [];
                }

                // Load profile completion
                try {
                    const profileResponse = await axios.get('/api/candidate/profiles/me');

                    if (profileResponse.data.success && profileResponse.data.data) {
                        const profile = profileResponse.data.data;
                        const fields = [
                            profile.phone,
                            profile.city,
                            profile.skills,
                            profile.experience,
                            profile.education,
                            profile.resume_url
                        ];
                        const filled = fields.filter(f => f).length;
                        this.profileCompletion = Math.round((filled / fields.length) * 100);
                    } else {
                        this.profileCompletion = 0;
                    }
                } catch (profileError) {
                    console.error('Error loading profile:', profileError);
                    this.profileCompletion = 0;
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

        generateStatusData() {
            const total = this.stats.total_applications || 1;
            this.statusData = [
                {
                    label: 'Pending',
                    value: this.stats.pending_applications || 0,
                    percentage: ((this.stats.pending_applications || 0) / total) * 100,
                    color: '#f59e0b'
                },
                {
                    label: 'Review',
                    value: this.stats.reviewed_applications || 0,
                    percentage: ((this.stats.reviewed_applications || 0) / total) * 100,
                    color: '#f97316'
                },
                {
                    label: 'Accepted',
                    value: this.stats.accepted_applications || 0,
                    percentage: ((this.stats.accepted_applications || 0) / total) * 100,
                    color: '#22c55e'
                },
                {
                    label: 'Rejected',
                    value: this.stats.rejected_applications || 0,
                    percentage: ((this.stats.rejected_applications || 0) / total) * 100,
                    color: '#ef4444'
                }
            ];
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
    .rounded-t-lg {
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
