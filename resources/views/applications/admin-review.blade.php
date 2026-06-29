@extends('layouts.app')

@section('title', 'All Applications - Admin | JobHub')

@section('content')
<div class="min-h-screen bg-white">
    <div class="flex gap-0">
        <!-- Sidebar -->
        @include('components.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto" x-data="adminApplicationsPage()" x-init="loadApplications()">
                <div class="space-y-6">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <button onclick="history.back()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-all duration-200 hover:shadow-md mb-4">
                                <i class="fas fa-arrow-left mr-2"></i>Back
                            </button>
                            <h1 class="text-3xl font-bold text-gray-900">All Applications</h1>
                            <p class="text-gray-600 mt-1">Monitor and manage all job applications across the platform</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-file-alt mr-1"></i> Total: <span x-text="stats.total"></span> applications
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
                                    <i class="fas fa-file-alt text-gray-600"></i>
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

                    <!-- Filters -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        <div class="flex flex-wrap gap-3 items-center">
                            <div class="flex-1 min-w-[200px]">
                                <input x-model="filters.search" @input.debounce.400ms="loadApplications()"
                                    type="text" placeholder="Search by candidate name or job title..."
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none">
                            </div>
                            <select x-model="filters.status" @change="loadApplications()"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 outline-none bg-white">
                                <option value="">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="reviewed">Under Review</option>
                                <option value="accepted">Accepted</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <button @click="filters.search=''; filters.status=''; loadApplications()"
                                class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 text-sm transition-all duration-200">
                                <i class="fas fa-times mr-1"></i>Clear
                            </button>
                        </div>
                    </div>

                    <!-- Loading State -->
                    <div x-show="loading" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                        <i class="fas fa-spinner fa-spin text-4xl text-gray-400"></i>
                        <p class="text-gray-600 mt-4">Loading applications...</p>
                    </div>

                    <!-- Empty State -->
                    <div x-show="!loading && applications.length === 0" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                        <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-600">No applications found.</p>
                    </div>

                    <!-- Applications Table -->
                    <div x-show="!loading && applications.length > 0" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Candidate</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Job Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Company</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Applied</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                <template x-for="app in applications" :key="app.id">
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-full bg-gray-900 text-white flex items-center justify-center text-sm font-bold flex-shrink-0"
                                                     x-text="getInitials(app.candidate?.name || app.user?.name)"></div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900" x-text="app.candidate?.name || app.user?.name || 'N/A'"></p>
                                                    <p class="text-xs text-gray-500" x-text="app.candidate?.email || app.user?.email || ''"></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900" x-text="app.job?.title || 'N/A'"></td>
                                        <td class="px-6 py-4 text-sm text-gray-600" x-text="app.job?.company?.name || 'N/A'"></td>
                                        <td class="px-6 py-4">
                                            <span :class="getStatusClass(app.status)"
                                                  class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium">
                                                <i class="fas" :class="getStatusIcon(app.status)"></i>
                                                <span x-text="app.status?.toUpperCase()"></span>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500" x-text="app.created_at ? new Date(app.created_at).toLocaleDateString() : ''"></td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <button @click="viewApplication(app)"
                                                    class="p-1.5 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button @click="updateStatus(app.id, 'accepted')"
                                                    x-show="app.status !== 'accepted'"
                                                    class="p-1.5 text-green-400 hover:text-green-700 hover:bg-green-50 rounded-lg transition-colors" title="Accept">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button @click="updateStatus(app.id, 'rejected')"
                                                    x-show="app.status !== 'rejected'"
                                                    class="p-1.5 text-red-400 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" title="Reject">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                <button @click="deleteApplication(app.id)"
                                                    class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Application Detail Modal -->
                <div x-show="showDetailsModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-transition style="display: none;">
                    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto" @click.away="showDetailsModal = false">
                        <div class="p-6 border-b border-gray-200 flex items-center justify-between sticky top-0 bg-white z-10">
                            <h3 class="text-xl font-bold text-gray-900">Application Details</h3>
                            <button @click="showDetailsModal = false" class="w-8 h-8 rounded-full hover:bg-gray-100 transition-colors flex items-center justify-center">
                                <i class="fas fa-times text-gray-500"></i>
                            </button>
                        </div>
                        <div class="p-6 space-y-5">
                            <!-- Candidate Info -->
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-full bg-gray-900 text-white flex items-center justify-center text-lg font-bold flex-shrink-0"
                                     x-text="getInitials(selectedApp?.candidate?.name || selectedApp?.user?.name)"></div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900" x-text="selectedApp?.candidate?.name || selectedApp?.user?.name"></h4>
                                    <p class="text-sm text-gray-500" x-text="selectedApp?.candidate?.email || selectedApp?.user?.email"></p>
                                    <span :class="getStatusClass(selectedApp?.status)" class="inline-block mt-1 px-3 py-1 rounded-full text-xs font-medium"
                                          x-text="selectedApp?.status?.toUpperCase()"></span>
                                </div>
                            </div>

                            <!-- Job Info -->
                            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 space-y-2">
                                <p class="text-xs font-semibold text-gray-500 uppercase">Job Details</p>
                                <p class="font-medium text-gray-900" x-text="selectedApp?.job?.title"></p>
                                <p class="text-sm text-gray-600" x-text="selectedApp?.job?.company?.name"></p>
                                <p class="text-sm text-gray-500" x-text="selectedApp?.job?.location"></p>
                            </div>

                            <!-- Cover Letter -->
                            <div x-show="selectedApp?.cover_letter">
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Cover Letter</p>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <p class="text-sm text-gray-700" x-text="selectedApp?.cover_letter"></p>
                                </div>
                            </div>

                            <!-- Applied Date -->
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-xs text-gray-500">Application ID</p>
                                    <p class="font-medium text-gray-900 text-xs" x-text="selectedApp?.id"></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Applied On</p>
                                    <p class="font-medium text-gray-900" x-text="selectedApp?.created_at ? new Date(selectedApp.created_at).toLocaleDateString() : ''"></p>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200">
                                <button @click="updateStatus(selectedApp?.id, 'accepted')"
                                    x-show="selectedApp?.status !== 'accepted'"
                                    class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-200 text-sm">
                                    <i class="fas fa-check mr-2"></i>Accept
                                </button>
                                <button @click="updateStatus(selectedApp?.id, 'rejected')"
                                    x-show="selectedApp?.status !== 'rejected'"
                                    class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200 text-sm">
                                    <i class="fas fa-times mr-2"></i>Reject
                                </button>
                                <button @click="showDetailsModal = false"
                                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function adminApplicationsPage() {
    return {
        applications: [],
        loading: false,
        showDetailsModal: false,
        selectedApp: null,
        filters: {
            status: '',
            search: ''
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
            return name.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2);
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

                const response = await axios.get('/api/admin/applications', {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` },
                    params
                });

                if (response.data.success) {
                    const data = response.data.data;
                    this.applications = Array.isArray(data) ? data : (data?.data || []);
                    this.updateStats();
                }
            } catch (error) {
                console.error('Error loading applications:', error);
                if (error.response?.status === 403) {
                    alert('Access denied. Admin privileges required.');
                } else {
                    alert('Failed to load applications. Please try again.');
                }
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
            if (!appId) return;
            if (!confirm(`Are you sure you want to ${status} this application?`)) return;

            try {
                const response = await axios.put(`/api/admin/applications/${appId}`, {
                    status: status
                }, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });

                if (response.data.success) {
                    this.showDetailsModal = false;
                    await this.loadApplications();
                    alert(`Application ${status} successfully!`);
                }
            } catch (error) {
                alert(error.response?.data?.message || 'Failed to update application');
            }
        },

        async deleteApplication(appId) {
            if (!appId) return;
            if (!confirm('Are you sure you want to delete this application? This cannot be undone.')) return;

            try {
                const response = await axios.delete(`/api/admin/applications/${appId}`, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });

                if (response.data.success) {
                    this.showDetailsModal = false;
                    await this.loadApplications();
                }
            } catch (error) {
                alert(error.response?.data?.message || 'Failed to delete application');
            }
        },

        viewApplication(app) {
            this.selectedApp = app;
            this.showDetailsModal = true;
        }
    };
}
</script>
@endsection
