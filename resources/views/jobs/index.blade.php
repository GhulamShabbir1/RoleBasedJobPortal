@extends('layouts.app')

@section('title', 'Browse Jobs - JobHub')

@section('content')
<div class="min-h-screen bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="jobsPage()" x-init="loadUserRole(); loadAppliedJobs(); loadJobs(); loadCategories()">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 tracking-tight">Find Your Next Opportunity</h1>
            <p class="text-gray-600 mt-2 text-lg">Explore thousands of job listings from top companies</p>
        </div>

        <!-- Featured Banner -->
        <div class="bg-gradient-to-r from-gray-900 to-gray-700 rounded-2xl p-6 mb-8 text-white">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold">🚀 10,000+ Jobs Available</h2>
                    <p class="text-gray-300 text-sm mt-1">Find your dream job today</p>
                </div>
                <div class="flex gap-3">
                    <span class="px-4 py-2 bg-white/10 rounded-lg text-sm backdrop-blur-sm">
                        <i class="fas fa-building mr-2"></i> 5,000+ Companies
                    </span>
                    <span class="px-4 py-2 bg-white/10 rounded-lg text-sm backdrop-blur-sm">
                        <i class="fas fa-users mr-2"></i> 50,000+ Candidates
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar: Filters -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6 sticky top-24">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Filters</h3>
                        <span class="text-xs text-gray-500" x-text="activeFiltersCount + ' active'"></span>
                    </div>

                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-search mr-2 text-gray-400"></i>Search
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input
                                type="text"
                                x-model="filters.search"
                                @input="applyFilters()"
                                placeholder="Job title or company..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                            >
                        </div>
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tag mr-2 text-gray-400"></i>Category
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-tag text-gray-400"></i>
                            </div>
                            <select
                                x-model="filters.category_id"
                                @change="applyFilters()"
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 appearance-none bg-white"
                            >
                                <option value="">All Categories</option>
                                <template x-for="cat in categories" :key="cat.id">
                                    <option :value="cat.id" x-text="cat.name"></option>
                                </template>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- City -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>City
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                            </div>
                            <select
                                x-model="filters.city"
                                @change="applyFilters()"
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 appearance-none bg-white"
                            >
                                <option value="">All Cities</option>
                                <option value="Lahore">Lahore</option>
                                <option value="Karachi">Karachi</option>
                                <option value="Islamabad">Islamabad</option>
                                <option value="Rawalpindi">Rawalpindi</option>
                                <option value="Faisalabad">Faisalabad</option>
                                <option value="Multan">Multan</option>
                                <option value="Peshawar">Peshawar</option>
                                <option value="Quetta">Quetta</option>
                                <option value="Hyderabad">Hyderabad</option>
                                <option value="Remote">Remote</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Job Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-briefcase mr-2 text-gray-400"></i>Job Type
                        </label>
                        <div class="space-y-2">
                            <template x-for="type in ['full_time', 'part_time', 'remote', 'contract', 'internship', 'freelance']" :key="type">
                                <label class="flex items-center cursor-pointer group">
                                    <input
                                        type="checkbox"
                                        :value="type"
                                        x-model="filters.job_type"
                                        @change="applyFilters()"
                                        class="rounded border-gray-300 text-gray-900 focus:ring-gray-900 transition-all duration-200"
                                    >
                                    <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors" x-text="type.replace('_', ' ').toUpperCase()"></span>
                                </label>
                            </template>
                        </div>
                    </div>

                    <!-- Salary Range -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-dollar-sign mr-2 text-gray-400"></i>Salary Range
                        </label>
                        <div class="space-y-2">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-400 font-medium">$</span>
                                </div>
                                <input
                                    type="number"
                                    x-model.number="filters.salary_min"
                                    @change="applyFilters()"
                                    placeholder="Min"
                                    min="0"
                                    class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                >
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-400 font-medium">$</span>
                                </div>
                                <input
                                    type="number"
                                    x-model.number="filters.salary_max"
                                    @change="applyFilters()"
                                    placeholder="Max"
                                    min="0"
                                    class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Reset Filters -->
                    <button @click="resetFilters()" class="w-full px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 hover:shadow-md flex items-center justify-center">
                        <i class="fas fa-redo mr-2"></i>Reset All Filters
                    </button>
                </div>
            </div>

            <!-- Main: Job Listings -->
            <div class="lg:col-span-3">
                <!-- Results Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div class="text-sm text-gray-600">
                        <span class="font-semibold text-gray-900" x-text="pagination.total || 0"></span> jobs found
                        <span x-show="filters.search || filters.category_id || filters.city || filters.job_type.length || filters.salary_min || filters.salary_max" class="text-gray-400">
                            with your filters
                        </span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-gray-500">Sort by:</span>
                        <select x-model="filters.sort" @change="applyFilters()" class="text-sm border border-gray-300 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none bg-white">
                            <option value="recent">Most Recent</option>
                            <option value="relevance">Relevance</option>
                            <option value="salary_high">Highest Salary</option>
                            <option value="salary_low">Lowest Salary</option>
                        </select>
                    </div>
                </div>

                <!-- Loading -->
                <div x-show="loading" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <div class="inline-block">
                        <i class="fas fa-spinner fa-spin text-4xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-600 mt-4">Loading jobs...</p>
                </div>

                <!-- Job Listings -->
                <div x-show="!loading" class="space-y-4">
                    <template x-for="job in jobs" :key="job.id">
                        <a :href="`/jobs/${job.id}`" class="block bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-gray-300 group">
                            <div class="p-6">
                                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-start gap-4">
                                            <!-- Company Logo Placeholder -->
                                            <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-gray-200 transition-colors">
                                                <i class="fas fa-building text-gray-500 text-2xl"></i>
                                            </div>
                                            <div>
                                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-gray-700 transition-colors" x-text="job.title"></h3>
                                                    <span class="px-2.5 py-0.5 bg-blue-50 text-blue-700 text-xs font-medium rounded-full border border-blue-100" x-text="job.job_type?.replace('_', ' ').toUpperCase() || 'N/A'"></span>
                                                    <span x-show="job.status === 'open'" class="px-2.5 py-0.5 bg-green-50 text-green-700 text-xs font-medium rounded-full border border-green-100">
                                                        <i class="fas fa-check-circle mr-1"></i>Active
                                                    </span>
                                                </div>
                                                <p class="text-gray-600 text-sm" x-text="job.company?.name || 'N/A'"></p>
                                            </div>
                                        </div>

                                        <p class="text-gray-700 text-sm mt-3 line-clamp-2" x-text="job.description || 'No description available'"></p>

                                        <div class="flex flex-wrap gap-2 mt-4">
                                            <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">
                                                <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>
                                                <span x-text="job.city || 'N/A'"></span>
                                            </span>
                                            <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">
                                                <i class="fas fa-tag mr-1 text-gray-400"></i>
                                                <span x-text="job.category?.name || 'N/A'"></span>
                                            </span>
                                            <template x-if="job.min_salary && job.max_salary">
                                                <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">
                                                    <i class="fas fa-dollar-sign mr-1 text-gray-400"></i>
                                                    <span x-text="'$' + job.min_salary + ' - $' + job.max_salary"></span>
                                                </span>
                                            </template>
                                            <template x-if="!job.min_salary && !job.max_salary">
                                                <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">
                                                    <i class="fas fa-dollar-sign mr-1 text-gray-400"></i>
                                                    <span>Negotiable</span>
                                                </span>
                                            </template>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-end gap-2 flex-shrink-0">
                                        <span class="text-xs text-gray-500">
                                            <i class="far fa-calendar-alt mr-1"></i>
                                            <span x-text="'Posted ' + timeAgo(job.created_at)"></span>
                                        </span>
                                        <span class="text-xs text-gray-500" x-show="job.deadline">
                                            <i class="far fa-clock mr-1"></i>
                                            <span x-text="job.deadline ? 'Deadline: ' + new Date(job.deadline).toLocaleDateString() : ''"></span>
                                        </span>
                                        <template x-if="isJobApplied(job.id)">
                                            <span class="inline-flex items-center px-3 py-1 bg-green-50 text-green-700 text-xs font-medium rounded-full border border-green-100">
                                                <i class="fas fa-check-circle mr-1"></i>Applied
                                            </span>
                                        </template>
                                        <template x-if="!isJobApplied(job.id)">
                                            <span class="inline-flex items-center text-sm font-medium text-gray-900 group-hover:text-gray-700 transition-colors">
                                                View Details
                                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                                            </span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </template>

                    <!-- No Jobs Found -->
                    <div x-show="jobs.length === 0" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-search text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No Jobs Found</h3>
                        <p class="text-gray-600">We couldn't find any jobs matching your criteria. Try adjusting your filters.</p>
                        <button @click="resetFilters()" class="mt-4 inline-flex items-center px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-all duration-200">
                            <i class="fas fa-times mr-2"></i>Clear All Filters
                        </button>
                    </div>
                </div>

                <!-- Pagination -->
                <div x-show="!loading && pagination.total > pagination.per_page" class="mt-8 flex items-center justify-between">
                    <p class="text-sm text-gray-500">
                        Showing <span x-text="((pagination.current_page - 1) * pagination.per_page) + 1"></span>
                        - <span x-text="Math.min(pagination.current_page * pagination.per_page, pagination.total)"></span>
                        of <span x-text="pagination.total"></span> jobs
                    </p>
                    <div class="flex items-center gap-2">
                        <button @click="previousPage()" :disabled="pagination.current_page === 1" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200">
                            <i class="fas fa-chevron-left mr-1"></i> Previous
                        </button>
                        <span class="px-4 py-2 text-sm text-gray-600 font-medium" x-text="`Page ${pagination.current_page} of ${Math.ceil(pagination.total / pagination.per_page)}`"></span>
                        <button @click="nextPage()" :disabled="pagination.current_page >= Math.ceil(pagination.total / pagination.per_page)" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200">
                            Next <i class="fas fa-chevron-right ml-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function jobsPage() {
    return {
        // defaults to avoid Alpine "not defined" evaluation errors
        selectedJob: null,
        showModal: false,
        jobs: [],
        categories: [],
        loading: false,
        userRole: null,
        appliedJobIds: new Set(), // Track applied jobs
        // Ensure these exist even if Alpine template evaluation happens early.
        selectedJob: null,
        showModal: false,
        filters: {
            search: '',
            category_id: '',
            city: '',
            job_type: [],
            salary_min: '',
            salary_max: '',
            sort: 'recent',
            page: 1
        },
        pagination: {
            current_page: 1,
            per_page: 10,
            total: 0
        },

        get activeFiltersCount() {
            let count = 0;
            if (this.filters.search) count++;
            if (this.filters.category_id) count++;
            if (this.filters.city) count++;
            if (this.filters.job_type.length) count++;
            if (this.filters.salary_min || this.filters.salary_max) count++;
            if (this.filters.sort !== 'recent') count++;
            return count;
        },

        isJobApplied(jobId) {
            return this.appliedJobIds.has(jobId);
        },

        timeAgo(date) {
            const now = new Date();
            const diff = Math.floor((now - new Date(date)) / 1000);
            if (diff < 60) return 'just now';
            if (diff < 3600) return Math.floor(diff / 60) + 'm ago';
            if (diff < 86400) return Math.floor(diff / 3600) + 'h ago';
            if (diff < 604800) return Math.floor(diff / 86400) + 'd ago';
            return new Date(date).toLocaleDateString();
        },

        loadUserRole() {
            const userStr = localStorage.getItem('user');
            if (userStr) {
                try {
                    const user = JSON.parse(userStr);
                    this.userRole = user.role;
                } catch (e) {}
            }
        },

        async loadAppliedJobs() {
            if (this.userRole !== 'candidate') return;

            try {
                const token = localStorage.getItem('token');
                const response = await axios.get('/api/candidate/applications', {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                if (response.data.status && Array.isArray(response.data.data)) {
                    this.appliedJobIds = new Set(response.data.data.map(app => app.job_id));
                    // Also add any recently applied jobs from sessionStorage
                    const recentlyApplied = JSON.parse(sessionStorage.getItem('appliedJobs') || '[]');
                    recentlyApplied.forEach(jobId => this.appliedJobIds.add(jobId));
                    // Clear sessionStorage after merging
                    sessionStorage.removeItem('appliedJobs');
                }
            } catch (error) {
                console.error('Error loading applied jobs:', error);
            }
        },

        async loadJobs() {
            this.loading = true;
            try {
                const params = {
                    title: this.filters.search,
                    category_id: this.filters.category_id,
                    city: this.filters.city,
                    job_type: this.filters.job_type.join(','),
                    salary_min: this.filters.salary_min,
                    salary_max: this.filters.salary_max,
                    sort: this.filters.sort,
                    page: this.filters.page
                };

                const response = await axios.get('/api/jobs', { params });
                if (response.data.status) {
                    const payload = response.data.data;
                    this.jobs = Array.isArray(payload) ? payload : (payload?.data ?? []);
                    this.pagination = {
                        current_page: response.data.data?.current_page ?? 1,
                        per_page: response.data.data?.per_page ?? 15,
                        total: response.data.data?.total ?? this.jobs.length
                    };
                }
            } catch (error) {
                console.error('Error loading jobs:', error);
                alert('Failed to load jobs. Please try again.');
            } finally {
                this.loading = false;
            }
        },

        async loadCategories() {
            try {
                const response = await axios.get('/api/categories');
                if (response.data.status) {
                    this.categories = response.data.data;
                }
            } catch (error) {
                console.error('Error loading categories:', error);
            }
        },

        applyFilters() {
            this.filters.page = 1;
            this.loadJobs();
        },

        resetFilters() {
            this.filters = {
                search: '',
                category_id: '',
                city: '',
                job_type: [],
                salary_min: '',
                salary_max: '',
                sort: 'recent',
                page: 1
            };
            this.loadJobs();
        },

        nextPage() {
            if (this.pagination.current_page < Math.ceil(this.pagination.total / this.pagination.per_page)) {
                this.filters.page++;
                this.loadJobs();
            }
        },

        previousPage() {
            if (this.filters.page > 1) {
                this.filters.page--;
                this.loadJobs();
            }
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const pageData = window.jobsPageInstance;
    if (pageData) {
        pageData.loadUserRole();
        pageData.loadAppliedJobs();
    }
});
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

    /* Sticky sidebar */
    .sticky {
        position: sticky;
        top: 100px;
    }

    /* Checkbox styling */
    input[type="checkbox"] {
        cursor: pointer;
        width: 16px;
        height: 16px;
    }

    input[type="checkbox"]:checked {
        background-color: #1a1a1a;
        border-color: #1a1a1a;
    }

    /* Featured banner animation */
    @keyframes shimmer {
        0% { background-position: -200% center; }
        100% { background-position: 200% center; }
    }

    .bg-gradient-to-r {
        background-size: 200% auto;
        animation: shimmer 3s ease-in-out infinite;
    }
</style>
@endsection
