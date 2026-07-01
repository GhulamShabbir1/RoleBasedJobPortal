@extends('layouts.app')

@section('title', 'My Applications - JobHub')

@section('content')
<div class="min-h-screen bg-white">
    <div class="flex gap-0">
        <!-- Sidebar -->
        @include('components.candidate-sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-gray-50 min-h-screen" x-data="myApplicationsPage()" x-init="loadApplications()">
            <div class="max-w-7xl mx-auto space-y-6">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <button onclick="history.back()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-all duration-200 hover:shadow-md mb-4">
                            <i class="fas fa-arrow-left mr-2"></i>Back
                        </button>
                        <h1 class="text-3xl font-bold text-gray-900">My Applications</h1>
                        <p class="text-gray-600 mt-1">Track and manage all your job applications in one place</p>
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

                <!-- Loading State -->
                <div x-show="loading" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <div class="inline-block">
                        <i class="fas fa-spinner fa-spin text-4xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-600 mt-4">Loading your applications...</p>
                </div>

                <!-- Applications List -->
                <div x-show="!loading" class="space-y-4">
                    <template x-for="app in applications" :key="app.id">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all duration-300 hover:border-gray-300">
                            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-start gap-4">
                                        <!-- Company Logo Placeholder -->
                                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-building text-gray-400 text-xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 hover:text-blue-600 transition-colors" x-text="app.job?.title"></h3>
                                            <p class="text-sm text-gray-600 mt-1" x-text="app.job?.company?.name"></p>
                                            <div class="flex flex-wrap items-center gap-3 mt-2">
                                                <span class="text-xs text-gray-500">
                                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                                    <span x-text="app.job?.city"></span>
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    <i class="fas fa-briefcase mr-1"></i>
                                                    <span x-text="app.job?.job_type?.replace('_', ' ').toUpperCase()"></span>
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

                            <p class="text-gray-700 text-sm mt-4" x-text="app.job?.description?.substring(0, 200) + (app.job?.description?.length > 200 ? '...' : '')"></p>

                            <!-- Salary Range -->
                            <div x-show="app.job?.min_salary && app.job?.max_salary" class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <p class="text-sm text-gray-700">
                                    <i class="fas fa-dollar-sign mr-2 text-gray-500"></i>
                                    <span class="font-medium">Salary Range:</span>
                                    <span x-text="`$${app.job?.min_salary} - $${app.job?.max_salary}`"></span>
                                    <span class="text-gray-500 text-xs ml-2">(per year)</span>
                                </p>
                            </div>

                            <!-- Actions -->
                            <div class="mt-4 pt-4 border-t border-gray-200 flex flex-wrap gap-3">
                                <a :href="`/jobs/${app.job?.id}`" class="inline-flex items-center px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-all duration-200 text-sm font-medium hover:shadow-md">
                                    <i class="fas fa-eye mr-2"></i>View Job
                                </a>
                                <button @click="viewCompany(app.job?.company)" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm font-medium hover:shadow-md">
                                    <i class="fas fa-building mr-2"></i>Company
                                </button>
                                <button @click="viewApplicationDetails(app.id)" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm font-medium hover:shadow-md">
                                    <i class="fas fa-file-alt mr-2"></i>Details
                                </button>
                                <button @click="withdrawApplication(app.id)" x-show="app.status === 'pending'" class="inline-flex items-center px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-all duration-200 text-sm font-medium hover:shadow-md">
                                    <i class="fas fa-times mr-2"></i>Withdraw
                                </button>
                                <button @click="downloadResume(app.id)" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm font-medium hover:shadow-md">
                                    <i class="fas fa-download mr-2"></i>Resume
                                </button>
                            </div>
                        </div>
                    </template>

                    <!-- Empty State -->
                    <div x-show="applications.length === 0" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-file-check text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No Applications Yet</h3>
                        <p class="text-gray-600 mb-6">You haven't applied to any jobs yet. Start your job search today!</p>
                        <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-all duration-200 hover:shadow-lg">
                            <i class="fas fa-search mr-2"></i>Browse Jobs
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Application Details Modal -->
<div x-show="showDetailsModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-transition>
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-900">Application Details</h3>
            <button @click="showDetailsModal = false" class="w-8 h-8 rounded-full hover:bg-gray-100 transition-colors flex items-center justify-center">
                <i class="fas fa-times text-gray-500"></i>
            </button>
        </div>
        <div class="p-6 space-y-4">
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
                <div>
                    <p class="text-sm text-gray-500">Job Type</p>
                    <p class="font-medium text-gray-900" x-text="selectedApp?.job?.job_type?.replace('_', ' ').toUpperCase()"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Location</p>
                    <p class="font-medium text-gray-900" x-text="selectedApp?.job?.city"></p>
                </div>
            </div>
            <div>
                <p class="text-sm text-gray-500">Cover Letter</p>
                <p class="text-gray-700 mt-1 p-3 bg-gray-50 rounded-lg" x-text="selectedApp?.cover_letter || 'No cover letter provided'"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Job Description</p>
                <p class="text-gray-700 mt-1 p-3 bg-gray-50 rounded-lg" x-text="selectedApp?.job?.description"></p>
            </div>
        </div>
        <div class="p-6 border-t border-gray-200 flex justify-end">
            <button @click="showDetailsModal = false" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                Close
            </button>
        </div>
    </div>
</div>

<script>
function myApplicationsPage() {
    return {
        applications: [],
        loading: false,
        showDetailsModal: false,
        selectedApp: null,
        filters: {
            status: ''
        },
        stats: {
            total: 0,
            pending: 0,
            reviewed: 0,
            accepted: 0,
            rejected: 0
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
                const params = this.filters.status ? { status: this.filters.status } : {};
                const response = await axios.get('/api/candidate/applications', {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` },
                    params
                });

                if (response.data.status) {
                    this.applications = response.data.data;
                    this.updateStats();
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

        async withdrawApplication(appId) {
            if (confirm('Are you sure you want to withdraw this application? This action cannot be undone.')) {
                try {
                    const response = await axios.delete(`/api/applications/${appId}`, {
                        headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                    });

                    if (response.data.status) {
                        this.loadApplications();
                        // Show success feedback
                        alert('Application withdrawn successfully');
                    }
                } catch (error) {
                    alert(error.response?.data?.message || 'Failed to withdraw application');
                }
            }
        },

        viewCompany(company) {
            if (!company) return;
            alert(`🏢 ${company.name}\n📍 ${company.city || 'N/A'}\n🌐 ${company.website || 'N/A'}\n📞 ${company.phone || 'N/A'}`);
        },

        viewApplicationDetails(appId) {
            this.selectedApp = this.applications.find(a => a.id === appId);
            this.showDetailsModal = true;
        },

        async downloadResume(appId) {
            try {
                const response = await axios.get(`/api/candidate/resumes/download/${appId}`, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` },
                    responseType: 'blob'
                });

                // Create download link
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `resume_${appId}.pdf`);
                document.body.appendChild(link);
                link.click();
                link.remove();
            } catch (error) {
                alert('Failed to download resume. Please try again.');
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
</style>
</div>
</div>
@endsection
