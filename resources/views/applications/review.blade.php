@extends('layouts.app')

@section('title', 'Review Applications - JobHub')

@section('content')
<div class="min-h-screen bg-white">
    <div class="flex gap-0">
        <!-- Sidebar - Determine role dynamically -->
        @php
            $userRole = auth()->user()?->role ?? 'employer';
        @endphp

        @if($userRole === 'admin')
            @include('components.admin-sidebar')
        @else
            @include('components.employer-sidebar')
        @endif

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto" x-data="applicationsPage()" x-init="loadApplications()">
                <div class="space-y-6">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <button onclick="history.back()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-all duration-200 hover:shadow-md mb-4">
                                <i class="fas fa-arrow-left mr-2"></i>Back
                            </button>
                            <h1 class="text-3xl font-bold text-gray-900">Review Applications</h1>
                            <p class="text-gray-600 mt-1">Review, evaluate, and manage incoming applications</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-sync-alt mr-1"></i> Last updated: <span x-text="new Date().toLocaleTimeString()"></span>
                            </span>
                            <button @click="loadApplications()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 hover:shadow-md">
                                <i class="fas fa-redo mr-2"></i>Refresh
                            </button>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Total</p>
                                    <p class="text-2xl font-bold text-gray-900" x-text="stats.total">0</p>
                                </div>
                                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-file-check text-gray-600"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Pending</p>
                                    <p class="text-2xl font-bold text-yellow-600" x-text="stats.pending">0</p>
                                </div>
                                <div class="w-10 h-10 bg-yellow-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-clock text-yellow-600"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Under Review</p>
                                    <p class="text-2xl font-bold text-orange-600" x-text="stats.reviewed">0</p>
                                </div>
                                <div class="w-10 h-10 bg-orange-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-search text-orange-600"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Accepted</p>
                                    <p class="text-2xl font-bold text-green-600" x-text="stats.accepted">0</p>
                                </div>
                                <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Rejected</p>
                                    <p class="text-2xl font-bold text-red-600" x-text="stats.rejected">0</p>
                                </div>
                                <div class="w-10 h-10 bg-red-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-times-circle text-red-600"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Tabs -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        <div class="flex flex-wrap gap-2">
                            <button @click="filters.status = ''; loadApplications()"
                                    :class="!filters.status ? 'bg-gray-900 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                    class="px-4 py-2 rounded-lg font-medium transition-all duration-200">
                                All
                                <span class="ml-1 px-2 py-0.5 text-xs rounded-full" :class="!filters.status ? 'bg-white/20 text-white' : 'bg-gray-300 text-gray-700'" x-text="stats.total"></span>
                            </button>
                            <button @click="filters.status = 'pending'; loadApplications()"
                                    :class="filters.status === 'pending' ? 'bg-yellow-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                    class="px-4 py-2 rounded-lg font-medium transition-all duration-200">
                                <i class="fas fa-clock mr-1"></i>Pending
                                <span class="ml-1 px-2 py-0.5 text-xs rounded-full" :class="filters.status === 'pending' ? 'bg-white/20 text-white' : 'bg-gray-300 text-gray-700'" x-text="stats.pending"></span>
                            </button>
                            <button @click="filters.status = 'reviewed'; loadApplications()"
                                    :class="filters.status === 'reviewed' ? 'bg-orange-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                    class="px-4 py-2 rounded-lg font-medium transition-all duration-200">
                                <i class="fas fa-search mr-1"></i>Under Review
                                <span class="ml-1 px-2 py-0.5 text-xs rounded-full" :class="filters.status === 'reviewed' ? 'bg-white/20 text-white' : 'bg-gray-300 text-gray-700'" x-text="stats.reviewed"></span>
                            </button>
                            <button @click="filters.status = 'accepted'; loadApplications()"
                                    :class="filters.status === 'accepted' ? 'bg-green-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                    class="px-4 py-2 rounded-lg font-medium transition-all duration-200">
                                <i class="fas fa-check-circle mr-1"></i>Accepted
                                <span class="ml-1 px-2 py-0.5 text-xs rounded-full" :class="filters.status === 'accepted' ? 'bg-white/20 text-white' : 'bg-gray-300 text-gray-700'" x-text="stats.accepted"></span>
                            </button>
                            <button @click="filters.status = 'rejected'; loadApplications()"
                                    :class="filters.status === 'rejected' ? 'bg-red-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                    class="px-4 py-2 rounded-lg font-medium transition-all duration-200">
                                <i class="fas fa-times-circle mr-1"></i>Rejected
                                <span class="ml-1 px-2 py-0.5 text-xs rounded-full" :class="filters.status === 'rejected' ? 'bg-white/20 text-white' : 'bg-gray-300 text-gray-700'" x-text="stats.rejected"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Search & Filter Bar -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-1 relative">
                                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input
                                    type="text"
                                    x-model="filters.search"
                                    @input="loadApplications()"
                                    placeholder="Search by candidate name, job title, or email..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                >
                            </div>
                            <select x-model="filters.job_id" @change="loadApplications()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 bg-white">
                                <option value="">All Jobs</option>
                                <template x-for="job in jobs" :key="job.id">
                                    <option :value="job.id" x-text="job.title"></option>
                                </template>
                            </select>
                            <button @click="filters.search = ''; filters.job_id = ''; loadApplications()" class="px-4 py-2 text-gray-600 hover:text-gray-900 transition-colors">
                                <i class="fas fa-times mr-1"></i>Clear Filters
                            </button>
                        </div>
                    </div>

                    <!-- Loading State -->
                    <div x-show="loading" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                        <div class="inline-block">
                            <i class="fas fa-spinner fa-spin text-4xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-600 mt-4">Loading applications...</p>
                    </div>

                    <!-- Applications List -->
                    <div x-show="!loading" class="space-y-4">
                        <template x-for="app in applications" :key="app.id">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all duration-300 hover:border-gray-300">
                                <!-- Header -->
                                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-start gap-4">
                                            <!-- Candidate Avatar -->
                                            <div class="w-14 h-14 bg-gradient-to-br from-gray-700 to-gray-900 rounded-xl flex items-center justify-center flex-shrink-0 text-white font-bold text-xl"
                                                 x-text="getInitials(app.candidate?.name)">
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900" x-text="app.candidate?.name"></h3>
                                                <p class="text-sm text-gray-600" x-text="app.candidate?.email"></p>
                                                <div class="flex flex-wrap items-center gap-3 mt-2">
                                                    <span class="text-xs text-gray-500">
                                                        <i class="fas fa-briefcase mr-1"></i>
                                                        <span x-text="app.job?.title"></span>
                                                    </span>
                                                    <span class="text-xs text-gray-500">
                                                        <i class="fas fa-building mr-1"></i>
                                                        <span x-text="app.job?.company?.name"></span>
                                                    </span>
                                                    <span class="text-xs text-gray-500">
                                                        <i class="fas fa-calendar-alt mr-1"></i>
                                                        Applied: <span x-text="new Date(app.applied_at).toLocaleDateString()"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span :class="getStatusClass(app.status)" class="px-3 py-1 rounded-full text-xs font-medium">
                                            <i class="fas" :class="getStatusIcon(app.status)"></i>
                                            <span x-text="app.status.toUpperCase()"></span>
                                        </span>
                                    </div>
                                </div>

                                <!-- Application Details -->
                                <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <div>
                                        <p class="text-gray-500 text-xs">Cover Letter</p>
                                        <p class="font-medium text-gray-900 text-sm" x-text="app.cover_letter ? '✅ Yes' : '❌ No'"></p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 text-xs">Resume</p>
                                        <p class="font-medium text-gray-900 text-sm" x-text="app.resume_path ? '✅ Uploaded' : '❌ Not uploaded'"></p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 text-xs">Experience</p>
                                        <p class="font-medium text-gray-900 text-sm" x-text="app.candidate?.experience || 'N/A'"></p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 text-xs">Location</p>
                                        <p class="font-medium text-gray-900 text-sm" x-text="app.candidate?.city || 'N/A'"></p>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="mt-4 pt-4 border-t border-gray-200 flex flex-wrap gap-3">
                                    <button @click="viewApplication(app)" class="inline-flex items-center px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-all duration-200 text-sm font-medium hover:shadow-md">
                                        <i class="fas fa-eye mr-2"></i>View Details
                                    </button>
                                    <a :href="app.resume_path" target="_blank" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm font-medium hover:shadow-md">
                                        <i class="fas fa-download mr-2"></i>Resume
                                    </a>
                                    <button @click="updateStatus(app.id, 'reviewed')" x-show="app.status === 'pending'" class="inline-flex items-center px-4 py-2 border border-orange-300 text-orange-600 rounded-lg hover:bg-orange-50 transition-all duration-200 text-sm font-medium hover:shadow-md">
                                        <i class="fas fa-search mr-2"></i>Mark Reviewed
                                    </button>
                                    <button @click="updateStatus(app.id, 'accepted')" x-show="app.status !== 'accepted' && app.status !== 'rejected'" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-200 text-sm font-medium hover:shadow-md">
                                        <i class="fas fa-check mr-2"></i>Accept
                                    </button>
                                    <button @click="updateStatus(app.id, 'rejected')" x-show="app.status !== 'rejected' && app.status !== 'accepted'" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200 text-sm font-medium hover:shadow-md">
                                        <i class="fas fa-times mr-2"></i>Reject
                                    </button>
                                    <button @click="sendMessage(app.candidate)" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm font-medium hover:shadow-md">
                                        <i class="fas fa-envelope mr-2"></i>Message
                                    </button>
                                </div>
                            </div>
                        </template>

                        <!-- Empty State -->
                        <div x-show="applications.length === 0" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-inbox text-4xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Applications Found</h3>
                            <p class="text-gray-600">There are no applications matching your current filters.</p>
                            <button @click="filters.search = ''; filters.job_id = ''; loadApplications()" class="mt-4 inline-flex items-center px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-all duration-200">
                                <i class="fas fa-times mr-2"></i>Clear Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Application Details Modal -->
<div x-show="showDetailsModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-transition>
    <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between sticky top-0 bg-white z-10">
            <h3 class="text-xl font-bold text-gray-900">Application Details</h3>
            <button @click="showDetailsModal = false" class="w-8 h-8 rounded-full hover:bg-gray-100 transition-colors flex items-center justify-center">
                <i class="fas fa-times text-gray-500"></i>
            </button>
        </div>
        <div class="p-6 space-y-6">
            <!-- Candidate Info -->
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-gradient-to-br from-gray-700 to-gray-900 rounded-xl flex items-center justify-center text-white font-bold text-2xl"
                     x-text="getInitials(selectedApp?.candidate?.name)">
                </div>
                <div>
                    <h4 class="text-xl font-bold text-gray-900" x-text="selectedApp?.candidate?.name"></h4>
                    <p class="text-gray-600" x-text="selectedApp?.candidate?.email"></p>
                    <p class="text-sm text-gray-500" x-text="selectedApp?.candidate?.phone"></p>
                </div>
            </div>

            <!-- Application Info -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Job Title</p>
                    <p class="font-medium text-gray-900" x-text="selectedApp?.job?.title"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Company</p>
                    <p class="font-medium text-gray-900" x-text="selectedApp?.job?.company?.name"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="font-medium" :class="getStatusClass(selectedApp?.status)" x-text="selectedApp?.status?.toUpperCase()"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Applied Date</p>
                    <p class="font-medium text-gray-900" x-text="selectedApp ? new Date(selectedApp.applied_at).toLocaleDateString() : ''"></p>
                </div>
            </div>

            <!-- Cover Letter -->
            <div>
                <p class="text-sm text-gray-500 font-medium">Cover Letter</p>
                <div class="mt-2 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-gray-700" x-text="selectedApp?.cover_letter || 'No cover letter provided'"></p>
                </div>
            </div>

            <!-- Candidate Details -->
            <div>
                <p class="text-sm text-gray-500 font-medium">Candidate Information</p>
                <div class="mt-2 grid grid-cols-2 gap-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div>
                        <p class="text-xs text-gray-500">Experience</p>
                        <p class="font-medium text-gray-900" x-text="selectedApp?.candidate?.experience || 'N/A'"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Education</p>
                        <p class="font-medium text-gray-900" x-text="selectedApp?.candidate?.education || 'N/A'"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Skills</p>
                        <p class="font-medium text-gray-900" x-text="selectedApp?.candidate?.skills || 'N/A'"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Portfolio</p>
                        <a :href="selectedApp?.candidate?.portfolio_url" target="_blank" class="text-blue-600 hover:underline" x-show="selectedApp?.candidate?.portfolio_url">
                            View Portfolio
                        </a>
                        <p class="text-gray-500" x-show="!selectedApp?.candidate?.portfolio_url">N/A</p>
                    </div>
                </div>
            </div>

            <!-- Job Description -->
            <div>
                <p class="text-sm text-gray-500 font-medium">Job Description</p>
                <div class="mt-2 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-gray-700" x-text="selectedApp?.job?.description"></p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200">
                <button @click="updateStatus(selectedApp?.id, 'accepted')" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-200">
                    <i class="fas fa-check mr-2"></i>Accept Application
                </button>
                <button @click="updateStatus(selectedApp?.id, 'rejected')" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200">
                    <i class="fas fa-times mr-2"></i>Reject Application
                </button>
                <button @click="showDetailsModal = false" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function applicationsPage() {
    return {
        applications: [],
        jobs: [],
        loading: false,
        showDetailsModal: false,
        selectedApp: null,
        filters: {
            status: '',
            search: '',
            job_id: ''
        },
        stats: {
            total: 0,
            pending: 0,
            reviewed: 0,
            accepted: 0,
            rejected: 0
        },

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

        getStatusIcon(status) {
            const icons = {
                'pending': 'fa-clock',
                'reviewed': 'fa-search',
                'accepted': 'fa-check-circle',
                'rejected': 'fa-times-circle'
            };
            return icons[status] || 'fa-circle';
        },

        async loadApplications() {
            this.loading = true;
            try {
                const params = {};
                if (this.filters.status) params.status = this.filters.status;
                if (this.filters.search) params.search = this.filters.search;
                if (this.filters.job_id) params.job_id = this.filters.job_id;

                const response = await axios.get('/api/employer/applications', {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` },
                    params
                });

                if (response.data.status) {
                    this.applications = response.data.data;
                    this.updateStats();
                }

                // Load jobs for filter
                const jobsResponse = await axios.get('/api/employer/jobs', {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });

                if (jobsResponse.data.status) {
                    this.jobs = jobsResponse.data.data;
                }
            } catch (error) {
                console.error('Error loading applications:', error);
                alert('Failed to load applications. Please try again.');
            } finally {
                this.loading = false;
            }
        },

        updateStats() {
            this.stats = {
                total: this.applications.length,
                pending: this.applications.filter(a => a.status === 'pending').length,
                reviewed: this.applications.filter(a => a.status === 'reviewed').length,
                accepted: this.applications.filter(a => a.status === 'accepted').length,
                rejected: this.applications.filter(a => a.status === 'rejected').length
            };
        },

        async updateStatus(appId, status) {
            if (!confirm(`Are you sure you want to ${status} this application?`)) return;

            try {
                const response = await axios.put(`/api/employer/applications/${appId}/review`, {
                    status: status
                }, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });

                if (response.data.status) {
                    this.loadApplications();
                    this.showDetailsModal = false;
                    // Show success feedback
                    alert(`Application ${status} successfully!`);
                }
            } catch (error) {
                alert(error.response?.data?.message || 'Failed to update application');
            }
        },

        viewApplication(app) {
            this.selectedApp = app;
            this.showDetailsModal = true;
        },

        sendMessage(candidate) {
            if (!candidate) return;
            const subject = encodeURIComponent('Job Application Update - JobHub');
            const body = encodeURIComponent(`Dear ${candidate.name},\n\nI hope this email finds you well. We have reviewed your application and would like to discuss next steps.\n\nBest regards,\nHiring Team\nJobHub`);
            window.location.href = `mailto:${candidate.email}?subject=${subject}&body=${body}`;
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

    /* Smooth Transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
</style>
@endsection
