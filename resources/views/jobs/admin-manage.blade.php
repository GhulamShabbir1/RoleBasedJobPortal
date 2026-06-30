@extends('layouts.app')

@section('title', 'Manage Jobs - JobHub')

@section('content')
<div class="min-h-screen bg-white">
    <div class="flex gap-0">
        <!-- Sidebar -->
        @include('components.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto" x-data="adminJobsPage()" x-init="loadJobs()">
                <div class="space-y-6">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <button onclick="history.back()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-all duration-200 hover:shadow-md mb-4">
                                <i class="fas fa-arrow-left mr-2"></i>Back
                            </button>
                            <h1 class="text-3xl font-bold text-gray-900">Manage Jobs</h1>
                            <p class="text-gray-600 mt-1">View and manage all job postings across the platform</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-briefcase mr-1"></i> Total: <span x-text="jobs.length"></span> jobs
                            </span>
                            <button @click="loadJobs()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 hover:shadow-md">
                                <i class="fas fa-redo mr-2"></i>Refresh
                            </button>
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
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Open</p>
                                    <p class="text-2xl font-bold text-green-600 mt-1" x-text="stats.open"></p>
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
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Total Applications</p>
                                    <p class="text-2xl font-bold text-blue-600 mt-1" x-text="stats.total_applications"></p>
                                </div>
                                <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-file-check text-blue-600"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search & Filter Bar -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-1 relative">
                                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input
                                    type="text"
                                    x-model="search"
                                    @input="applyFilters()"
                                    placeholder="Search by job title, company, or city..."
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
                                    <option value="open">Open</option>
                                    <option value="closed">Closed</option>
                                </select>
                                <select
                                    x-model="filters.job_type"
                                    @change="applyFilters()"
                                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 bg-white"
                                >
                                    <option value="">All Types</option>
                                    <option value="full-time">Full Time</option>
                                    <option value="part-time">Part Time</option>
                                    <option value="remote">Remote</option>
                                    <option value="freelance">Freelance</option>
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
                        <p class="text-gray-600 mt-4">Loading jobs...</p>
                    </div>

                    <!-- Jobs Table -->
                    <div x-show="!loading" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Job Title</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Company</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Location</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Applications</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Deadline</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <template x-for="job in jobs" :key="job.id">
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-briefcase text-gray-500 text-xs"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900" x-text="job.title"></p>
                                                        <p class="text-xs text-gray-500" x-text="job.job_type ? job.job_type.replace('_', ' ').toUpperCase() : 'N/A'"></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-6 h-6 bg-gray-100 rounded flex items-center justify-center">
                                                        <i class="fas fa-building text-gray-500 text-xs"></i>
                                                    </div>
                                                    <span class="text-sm text-gray-600" x-text="job.company?.name || 'N/A'"></span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="text-sm text-gray-600">
                                                    <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                                                    <span x-text="job.city || 'N/A'"></span>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span :class="job.status === 'open' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'" class="px-3 py-1 rounded-full text-xs font-medium">
                                                    <i class="fas" :class="job.status === 'open' ? 'fa-check-circle' : 'fa-lock'"></i>
                                                    <span x-text="job.status.toUpperCase()"></span>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-medium cursor-pointer hover:bg-blue-100 transition" @click="viewApplications(job.id)" title="Click to view applications">
                                                    <i class="fas fa-users mr-1"></i>
                                                    <span x-text="(job.applications && job.applications.length) || 0"></span>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="text-sm text-gray-600" :class="new Date(job.deadline) < new Date() ? 'text-red-600' : ''">
                                                    <i class="fas fa-calendar-alt mr-1"></i>
                                                    <span x-text="new Date(job.deadline).toLocaleDateString()"></span>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-2">
                                                    <button @click="toggleJobStatus(job)" :title="job.status === 'open' ? 'Close job' : 'Reopen job'" class="p-1.5 rounded-lg transition-colors" :class="job.status === 'open' ? 'text-yellow-400 hover:text-yellow-600 hover:bg-yellow-50' : 'text-green-400 hover:text-green-600 hover:bg-green-50'">
                                                        <i class="fas" :class="job.status === 'open' ? 'fa-lock' : 'fa-unlock'"></i>
                                                    </button>
                                                    <button @click="viewJob(job)" class="p-1.5 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button @click="deleteJob(job.id)" class="p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>

                                    <tr x-show="jobs.length === 0">
                                        <td colspan="7" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                                    <i class="fas fa-briefcase text-2xl text-gray-400"></i>
                                                </div>
                                                <p class="text-gray-500 font-medium">No jobs found</p>
                                                <p class="text-sm text-gray-400 mt-1">Try adjusting your search filters</p>
                                                <button @click="resetFilters()" class="mt-3 text-sm text-gray-600 hover:text-gray-900 underline">
                                                    Clear filters
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div x-show="!loading && jobs.length > 0" class="flex items-center justify-between">
                        <p class="text-sm text-gray-500">
                            Showing <span x-text="jobs.length"></span> jobs
                        </p>
                        <div class="flex items-center gap-2">
                            <button @click="previousPage()" :disabled="page === 1" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200">
                                <i class="fas fa-chevron-left mr-1"></i> Previous
                            </button>
                            <span class="px-4 py-2 text-sm text-gray-600 font-medium" x-text="`Page ${page}`"></span>
                            <button @click="nextPage()" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200">
                                Next <i class="fas fa-chevron-right ml-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Job Details Modal -->
<div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-transition>
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto" @click.away="showModal = false">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between sticky top-0 bg-white z-10">
            <h3 class="text-xl font-bold text-gray-900">Job Details</h3>
            <button @click="showModal = false" class="w-8 h-8 rounded-full hover:bg-gray-100 transition-colors flex items-center justify-center">
                <i class="fas fa-times text-gray-500"></i>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-briefcase text-gray-600 text-2xl"></i>
                </div>
                <div class="flex-1">
                    <h4 class="text-xl font-bold text-gray-900" x-text="selectedJob?.title"></h4>
                    <p class="text-gray-600" x-text="selectedJob?.company?.name"></p>
                    <div class="flex flex-wrap items-center gap-3 mt-1">
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            <span x-text="selectedJob?.city"></span>
                        </span>
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-clock mr-1"></i>
                            <span x-text="selectedJob?.job_type?.replace('_', ' ').toUpperCase()"></span>
                        </span>
                        <span :class="selectedJob?.status === 'open' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'" class="px-3 py-1 rounded-full text-xs font-medium">
                            <span x-text="selectedJob?.status?.toUpperCase()"></span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 p-4 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-xs text-gray-500">Salary Range</p>
                    <p class="font-medium text-gray-900" x-text="selectedJob?.min_salary && selectedJob?.max_salary ? `$${selectedJob.min_salary} - $${selectedJob.max_salary}` : 'Not specified'"></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Vacancies</p>
                    <p class="font-medium text-gray-900" x-text="selectedJob?.vacancies || 'N/A'"></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Posted</p>
                    <p class="font-medium text-gray-900" x-text="selectedJob ? new Date(selectedJob.created_at).toLocaleDateString() : ''"></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Deadline</p>
                    <p class="font-medium text-gray-900" :class="selectedJob && new Date(selectedJob.deadline) < new Date() ? 'text-red-600' : ''" x-text="selectedJob ? new Date(selectedJob.deadline).toLocaleDateString() : ''"></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Applications</p>
                    <p class="font-medium text-gray-900" x-text="selectedJob?.applications_count || 0"></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Category</p>
                    <p class="font-medium text-gray-900" x-text="selectedJob?.category?.name || 'N/A'"></p>
                </div>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-900 mb-2">Description</p>
                <div class="p-4 bg-gray-50 rounded-lg max-h-40 overflow-y-auto">
                    <p class="text-gray-700 whitespace-pre-line" x-text="selectedJob?.description"></p>
                </div>
            </div>

            <div class="flex gap-3 pt-4 border-t border-gray-200">
                <button @click="showModal = false" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200">
                    Close
                </button>
                <button @click="toggleJobStatus(selectedJob)" class="flex-1 px-4 py-2 transition-all duration-200" :class="selectedJob?.status === 'open' ? 'bg-yellow-600 hover:bg-yellow-700 text-white' : 'bg-green-600 hover:bg-green-700 text-white'">
                    <i class="fas mr-2" :class="selectedJob?.status === 'open' ? 'fa-lock' : 'fa-unlock'"></i>
                    <span x-text="selectedJob?.status === 'open' ? 'Close Job' : 'Reopen Job'"></span>
                </button>
                <button @click="deleteJob(selectedJob?.id)" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200">
                    <i class="fas fa-trash mr-2"></i>Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function adminJobsPage() {
    return {
        jobs: [],
        search: '',
        page: 1,
        showModal: false,
        selectedJob: null,
        filters: {
            status: '',
            job_type: ''
        },
        stats: {
            total: 0,
            open: 0,
            closed: 0,
            total_applications: 0
        },
        loading: false,

        async loadJobs() {
            this.loading = true;
            try {
                const params = {
                    title: this.search,
                    status: this.filters.status,
                    job_type: this.filters.job_type,
                    page: this.page
                };

                const response = await axios.get('/api/admin/jobs', {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` },
                    params
                });

                if (response.data.success) {
                    this.jobs = response.data.data;
                    this.updateStats();
                }
            } catch (error) {
                console.error('Error loading jobs:', error);
                alert('Failed to load jobs. Please try again.');
            } finally {
                this.loading = false;
            }
        },

        updateStats() {
            const total = this.jobs.length;
            const open = this.jobs.filter(j => j.status === 'open').length;
            const closed = this.jobs.filter(j => j.status === 'closed').length;
            const total_applications = this.jobs.reduce((sum, j) => sum + ((j.applications && j.applications.length) || 0), 0);

            this.stats = { total, open, closed, total_applications };
        },

        applyFilters() {
            this.page = 1;
            this.loadJobs();
        },

        resetFilters() {
            this.search = '';
            this.filters.status = '';
            this.filters.job_type = '';
            this.page = 1;
            this.loadJobs();
        },

        viewJob(job) {
            this.selectedJob = job;
            this.showModal = true;
        },

        async closeJob(jobId) {
            if (!jobId) return;
            if (!confirm('Are you sure you want to close this job posting?')) return;

            try {
                const response = await axios.post(`/api/admin/jobs/${jobId}/close`, {}, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });

                if (response.data.success) {
                    this.showModal = false;
                    this.loadJobs();
                    alert('Job closed successfully');
                } else {
                    alert(response.data.message || 'Failed to close job');
                }
            } catch (error) {
                alert(error.response?.data?.message || 'Failed to close job');
            }
        },

        async toggleJobStatus(job) {
            if (!job || !job.id) return;

            const currentStatus = job.status;
            const newStatus = currentStatus === 'open' ? 'closed' : 'open';
            const action = newStatus === 'open' ? 'Reopen' : 'Close';

            if (!confirm(`${action} this job posting?`)) return;

            try {
                const response = await axios.put(`/api/admin/jobs/${job.id}/status`, {
                    status: newStatus
                }, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });

                if (response.data.success) {
                    this.showModal = false;
                    this.loadJobs();
                    alert(`Job ${newStatus} successfully`);
                } else {
                    alert(response.data.message || `Failed to ${newStatus} job`);
                }
            } catch (error) {
                // Try the close endpoint if status endpoint fails
                if (newStatus === 'closed') {
                    this.closeJob(job.id);
                } else {
                    alert(error.response?.data?.message || `Failed to ${action} job`);
                }
            }
        },

        async deleteJob(jobId) {
            if (!jobId) return;
            if (!confirm('Are you sure you want to delete this job? This action cannot be undone.')) return;

            try {
                const response = await axios.delete(`/api/admin/jobs/${jobId}`, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });

                if (response.data.success) {
                    this.showModal = false;
                    this.loadJobs();
                    alert('Job deleted successfully');
                } else {
                    alert(response.data.message || 'Failed to delete job');
                }
            } catch (error) {
                alert(error.response?.data?.message || 'Failed to delete job');
            }
        },

        nextPage() {
            this.page++;
            this.loadJobs();
        },

        previousPage() {
            if (this.page > 1) {
                this.page--;
                this.loadJobs();
            }
        },

        viewApplications(jobId) {
            // Navigate to applications view for this job
            window.location.href = `/admin/jobs/${jobId}/applications`;
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

    /* Table hover */
    .hover\:bg-gray-50:hover {
        background-color: #f9fafb;
        transition: background-color 0.2s ease;
    }

    /* Modal overlay */
    .backdrop-blur-sm {
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }

    /* Stats card hover */
    .hover\:shadow-md:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }

    /* Smooth transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }
</style>
@endsection
