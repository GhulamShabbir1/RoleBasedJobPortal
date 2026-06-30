@extends('layouts.app')

@section('title', 'My Jobs - JobHub')

@section('content')
<div class="min-h-screen bg-white">
    <div class="flex gap-0">
        <!-- Sidebar -->
        @include('components.employer-sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto" x-data="employerJobsPage()" x-init="loadJobs()">
                <div class="space-y-6">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <button onclick="history.back()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-all duration-200 hover:shadow-md mb-4">
                                <i class="fas fa-arrow-left mr-2"></i>Back
                            </button>
                            <h1 class="text-3xl font-bold text-gray-900">My Jobs</h1>
                            <p class="text-gray-600 mt-1 flex items-center gap-2">
                                <i class="fas fa-circle text-[6px] text-gray-300"></i>
                                Manage and track all your job postings
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-briefcase mr-1"></i> Total: <span x-text="jobs.length"></span> jobs
                            </span>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Total Jobs</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1" x-text="stats.total"></p>
                                </div>
                                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-briefcase text-gray-600"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Active</p>
                                    <p class="text-2xl font-bold text-green-600 mt-1" x-text="stats.active"></p>
                                </div>
                                <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Closed</p>
                                    <p class="text-2xl font-bold text-gray-600 mt-1" x-text="stats.closed"></p>
                                </div>
                                <div class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-lock text-gray-600"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Applications</p>
                                    <p class="text-2xl font-bold text-blue-600 mt-1" x-text="stats.total_applications"></p>
                                </div>
                                <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-file-check text-blue-600"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter & Search -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-1 relative">
                                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input
                                    type="text"
                                    x-model="search"
                                    @input="applyFilters()"
                                    placeholder="Search by job title or location..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                >
                            </div>
                            <div class="flex gap-2">
                                <select
                                    x-model="filters.status"
                                    @change="applyFilters()"
                                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 bg-white"
                                >
                                    <option value="">All Status</option>
                                    <option value="open">Active</option>
                                    <option value="closed">Closed</option>
                                </select>
                                <button @click="resetFilters()" class="px-4 py-2 text-gray-600 hover:text-gray-900 transition-colors">
                                    <i class="fas fa-times mr-1"></i>Clear
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Loading State -->
                    <div x-show="loading" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                        <div class="inline-block">
                            <i class="fas fa-spinner fa-spin text-4xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-600 mt-4">Loading your jobs...</p>
                    </div>

                    <!-- Jobs List -->
                    <div x-show="!loading" class="space-y-4">
                        <template x-for="job in filteredJobs" :key="job.id">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all duration-300 hover:border-gray-300">
                                <!-- Header -->
                                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-start gap-4">
                                            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-briefcase text-gray-500 text-xl"></i>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900 hover:text-gray-700 transition-colors" x-text="job.title"></h3>
                                                <div class="flex flex-wrap items-center gap-3 mt-1">
                                                    <span class="text-sm text-gray-600">
                                                        <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>
                                                        <span x-text="job.city || 'N/A'"></span>
                                                    </span>
                                                    <span class="text-sm text-gray-600">
                                                        <i class="fas fa-clock mr-1 text-gray-400"></i>
                                                        <span x-text="job.job_type?.replace('_', ' ').toUpperCase() || 'N/A'"></span>
                                                    </span>
                                                    <span class="text-sm text-gray-600">
                                                        <i class="fas fa-tag mr-1 text-gray-400"></i>
                                                        <span x-text="job.category?.name || 'N/A'"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span :class="job.status === 'open' ? 'bg-green-100 text-green-800 border-green-200' : 'bg-gray-100 text-gray-800 border-gray-200'" class="px-3 py-1 rounded-full text-xs font-medium border">
                                            <i class="fas" :class="job.status === 'open' ? 'fa-check-circle' : 'fa-lock'"></i>
                                            <span x-text="job.status.toUpperCase()"></span>
                                        </span>
                                        <span class="text-xs text-gray-500" x-text="new Date(job.created_at).toLocaleDateString()"></span>
                                    </div>
                                </div>

                                <!-- Description -->
                                <p class="text-gray-600 text-sm mt-4 line-clamp-2" x-text="job.description"></p>

                                <!-- Job Details Grid -->
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <div>
                                        <p class="text-xs text-gray-500">Applications</p>
                                        <p class="font-semibold text-gray-900 text-sm flex items-center gap-1">
                                            <span class="inline-block px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs" x-text="job.applications_count || 0"></span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Vacancies</p>
                                        <p class="font-semibold text-gray-900 text-sm" x-text="job.vacancies || 'N/A'"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Salary Range</p>
                                        <p class="font-semibold text-gray-900 text-sm" x-text="job.min_salary && job.max_salary ? `$${job.min_salary} - $${job.max_salary}` : 'Negotiable'"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Deadline</p>
                                        <p class="font-semibold text-gray-900 text-sm" :class="new Date(job.deadline) < new Date() ? 'text-red-600' : ''" x-text="new Date(job.deadline).toLocaleDateString()"></p>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-gray-200">
                                    <a :href="`/jobs/${job.id}`" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm font-medium hover:shadow-md">
                                        <i class="fas fa-eye mr-2"></i>View
                                    </a>
                                    <a :href="`/jobs/${job.id}/edit`" x-show="job.status === 'open'" class="inline-flex items-center px-4 py-2 border border-blue-300 text-blue-600 rounded-lg hover:bg-blue-50 transition-all duration-200 text-sm font-medium hover:shadow-md">
                                        <i class="fas fa-edit mr-2"></i>Edit
                                    </a>
                                    <button @click="toggleStatus(job.id, job.status === 'open' ? 'close' : 'open')" class="inline-flex items-center px-4 py-2 border border-yellow-300 text-yellow-600 rounded-lg hover:bg-yellow-50 transition-all duration-200 text-sm font-medium hover:shadow-md">
                                        <i class="fas" :class="job.status === 'open' ? 'fa-lock' : 'fa-unlock'"></i>
                                        <span class="ml-2" x-text="job.status === 'open' ? 'Close' : 'Reopen'"></span>
                                    </button>
                                    <button @click="deleteJob(job.id)" class="inline-flex items-center px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-all duration-200 text-sm font-medium hover:shadow-md">
                                        <i class="fas fa-trash mr-2"></i>Delete
                                    </button>
                                    <a :href="`/applications?job_id=${job.id}`" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm font-medium hover:shadow-md">
                                        <i class="fas fa-users mr-2"></i>Applications
                                        <span class="ml-1 inline-block px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs" x-text="job.applications_count || 0"></span>
                                    </a>
                                </div>
                            </div>
                        </template>

                        <!-- Empty State -->
                        <div x-show="filteredJobs.length === 0" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-briefcase text-4xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2" x-text="search || filters.status ? 'No matching jobs found' : 'No jobs posted yet'"></h3>
                            <p class="text-gray-600" x-text="search || filters.status ? 'Try adjusting your search filters' : 'Start your hiring journey by posting your first job'"></p>
                            <div class="mt-4 flex flex-col sm:flex-row gap-3 justify-center">
                                <button x-show="search || filters.status" @click="resetFilters()" class="inline-flex items-center px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200">
                                    <i class="fas fa-times mr-2"></i>Clear Filters
                                </button>
                                <a href="{{ route('jobs.create') }}" class="inline-flex items-center px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-all duration-200">
                                    <i class="fas fa-plus mr-2"></i>Post Your First Job
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function employerJobsPage() {
    return {
        jobs: [],
        filteredJobs: [],
        search: '',
        filters: {
            status: ''
        },
        stats: {
            total: 0,
            active: 0,
            closed: 0,
            total_applications: 0
        },
        loading: false,

        async loadJobs() {
            this.loading = true;
            try {
                const token = localStorage.getItem('token');
                if (!token) {
                    window.location.href = '/auth/login';
                    return;
                }

                const response = await axios.get('/api/employer/jobs', {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                if (response.data.success) {
                    this.jobs = response.data.data;
                    this.applyFilters();
                    this.updateStats();
                }
            } catch (error) {
                console.error('Error loading jobs:', error);
                alert('Failed to load your jobs. Please try again.');
            } finally {
                this.loading = false;
            }
        },

        applyFilters() {
            let filtered = [...this.jobs];

            // Search filter
            if (this.search.trim()) {
                const search = this.search.toLowerCase().trim();
                filtered = filtered.filter(job =>
                    job.title.toLowerCase().includes(search) ||
                    (job.city && job.city.toLowerCase().includes(search))
                );
            }

            // Status filter
            if (this.filters.status) {
                filtered = filtered.filter(job => job.status === this.filters.status);
            }

            this.filteredJobs = filtered;
        },

        resetFilters() {
            this.search = '';
            this.filters.status = '';
            this.applyFilters();
        },

        updateStats() {
            const total = this.jobs.length;
            const active = this.jobs.filter(j => j.status === 'open').length;
            const closed = this.jobs.filter(j => j.status === 'closed').length;
            const total_applications = this.jobs.reduce((sum, j) => sum + (j.applications_count || 0), 0);

            this.stats = { total, active, closed, total_applications };
        },

        async toggleStatus(jobId, action) {
            const message = action === 'close' ? 'close' : 'reopen';
            if (!confirm(`Are you sure you want to ${message} this job posting?`)) return;

            try {
                const response = await axios.post(`/api/employer/jobs/${jobId}/${action}`, {}, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });

                if (response.data.success) {
                    this.loadJobs();
                    alert(`Job ${message}d successfully`);
                } else {
                    alert(response.data.message || `Failed to ${message} job`);
                }
            } catch (error) {
                alert(error.response?.data?.message || `Failed to ${message} job`);
            }
        },

        async deleteJob(jobId) {
            if (!confirm('Are you sure you want to delete this job? This action cannot be undone.')) return;

            try {
                const response = await axios.delete(`/api/employer/jobs/${jobId}`, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });

                if (response.data.success) {
                    this.loadJobs();
                    alert('Job deleted successfully');
                } else {
                    alert(response.data.message || 'Failed to delete job');
                }
            } catch (error) {
                alert(error.response?.data?.message || 'Failed to delete job');
            }
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

    /* Line clamp for description */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Smooth transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }

    /* Stats card hover */
    .hover\:shadow-md:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
</style>
@endsection
