@extends('layouts.app')

@section('title', 'Manage Companies - JobHub')

@section('content')
<div class="min-h-screen bg-white">
    <div class="flex gap-0">
        <!-- Sidebar -->
        @include('components.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto" x-data="companiesPage()" x-init="loadCompanies()">
                <div class="space-y-6">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <button onclick="history.back()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-all duration-200 hover:shadow-md mb-4">
                                <i class="fas fa-arrow-left mr-2"></i>Back
                            </button>
                            <h1 class="text-3xl font-bold text-gray-900">Manage Companies</h1>
                            <p class="text-gray-600 mt-1">Review, approve, and manage company registrations</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-building mr-1"></i> Total: <span x-text="companies.length"></span> companies
                            </span>
                            <button @click="loadCompanies()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 hover:shadow-md">
                                <i class="fas fa-redo mr-2"></i>Refresh
                            </button>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Total Companies</p>
                                    <p class="text-2xl font-bold text-gray-900" x-text="stats.total">0</p>
                                </div>
                                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-building text-gray-600"></i>
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
                                    <p class="text-sm text-gray-500">Approved</p>
                                    <p class="text-2xl font-bold text-green-600" x-text="stats.approved">0</p>
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
                            <button @click="filters.status = ''; loadCompanies()"
                                    :class="!filters.status ? 'bg-gray-900 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                    class="px-4 py-2 rounded-lg font-medium transition-all duration-200">
                                All
                                <span class="ml-1 px-2 py-0.5 text-xs rounded-full" :class="!filters.status ? 'bg-white/20 text-white' : 'bg-gray-300 text-gray-700'" x-text="stats.total"></span>
                            </button>
                            <button @click="filters.status = 'pending'; loadCompanies()"
                                    :class="filters.status === 'pending' ? 'bg-yellow-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                    class="px-4 py-2 rounded-lg font-medium transition-all duration-200">
                                <i class="fas fa-clock mr-1"></i>Pending
                                <span class="ml-1 px-2 py-0.5 text-xs rounded-full" :class="filters.status === 'pending' ? 'bg-white/20 text-white' : 'bg-gray-300 text-gray-700'" x-text="stats.pending"></span>
                            </button>
                            <button @click="filters.status = 'approved'; loadCompanies()"
                                    :class="filters.status === 'approved' ? 'bg-green-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                    class="px-4 py-2 rounded-lg font-medium transition-all duration-200">
                                <i class="fas fa-check-circle mr-1"></i>Approved
                                <span class="ml-1 px-2 py-0.5 text-xs rounded-full" :class="filters.status === 'approved' ? 'bg-white/20 text-white' : 'bg-gray-300 text-gray-700'" x-text="stats.approved"></span>
                            </button>
                            <button @click="filters.status = 'rejected'; loadCompanies()"
                                    :class="filters.status === 'rejected' ? 'bg-red-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                    class="px-4 py-2 rounded-lg font-medium transition-all duration-200">
                                <i class="fas fa-times-circle mr-1"></i>Rejected
                                <span class="ml-1 px-2 py-0.5 text-xs rounded-full" :class="filters.status === 'rejected' ? 'bg-white/20 text-white' : 'bg-gray-300 text-gray-700'" x-text="stats.rejected"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Search Bar -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-1 relative">
                                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input
                                    type="text"
                                    x-model="filters.search"
                                    @input="filterCompanies()"
                                    placeholder="Search companies by name, city, or owner..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                >
                            </div>
                            <button @click="filters.search = ''; filterCompanies()" class="px-4 py-2 text-gray-600 hover:text-gray-900 transition-colors">
                                <i class="fas fa-times mr-1"></i>Clear
                            </button>
                        </div>
                    </div>

                    <!-- Loading State -->
                    <div x-show="loading" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                        <div class="inline-block">
                            <i class="fas fa-spinner fa-spin text-4xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-600 mt-4">Loading companies...</p>
                    </div>

                    <!-- Companies Grid -->
                    <div x-show="!loading" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <template x-for="company in filteredCompanies" :key="company.id">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all duration-300 hover:border-gray-300 group">
                                <!-- Header -->
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                                                <i class="fas fa-building text-gray-600 text-xl"></i>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900" x-text="company.name"></h3>
                                                <p class="text-sm text-gray-500 flex items-center gap-1">
                                                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                                                    <span x-text="company.city || 'N/A'"></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <span :class="getStatusClass(company.status)" class="px-3 py-1 rounded-full text-xs font-medium">
                                        <i class="fas" :class="getStatusIcon(company.status)"></i>
                                        <span x-text="company.status.toUpperCase()"></span>
                                    </span>
                                </div>

                                <!-- Description -->
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600" x-text="company.description ? company.description.substring(0, 120) + (company.description.length > 120 ? '...' : '') : 'No description provided'"></p>
                                </div>

                                <!-- Details Grid -->
                                <div class="grid grid-cols-2 gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200 mb-4">
                                    <div>
                                        <p class="text-xs text-gray-500">Owner</p>
                                        <p class="font-medium text-gray-900 text-sm flex items-center gap-1">
                                            <i class="fas fa-user text-gray-400 text-xs"></i>
                                            <span x-text="company.user?.name || 'N/A'"></span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Email</p>
                                        <p class="font-medium text-gray-900 text-sm flex items-center gap-1">
                                            <i class="fas fa-envelope text-gray-400 text-xs"></i>
                                            <span x-text="company.user?.email || 'N/A'"></span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Website</p>
                                        <a :href="company.website" target="_blank" class="font-medium text-blue-600 hover:underline text-sm flex items-center gap-1" x-show="company.website">
                                            <i class="fas fa-globe text-gray-400 text-xs"></i>
                                            <span x-text="company.website"></span>
                                        </a>
                                        <span x-show="!company.website" class="text-sm text-gray-500">N/A</span>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Registered</p>
                                        <p class="font-medium text-gray-900 text-sm flex items-center gap-1">
                                            <i class="fas fa-calendar text-gray-400 text-xs"></i>
                                            <span x-text="new Date(company.created_at).toLocaleDateString()"></span>
                                        </p>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex flex-wrap gap-2 pt-4 border-t border-gray-200">
                                    <template x-if="company.status === 'pending'">
                                        <div class="flex gap-2 w-full">
                                            <button @click="approveCompany(company.id)" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-200 text-sm font-medium hover:shadow-md">
                                                <i class="fas fa-check mr-2"></i>Approve
                                            </button>
                                            <button @click="openRejectModal(company)" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200 text-sm font-medium hover:shadow-md">
                                                <i class="fas fa-times mr-2"></i>Reject
                                            </button>
                                        </div>
                                    </template>
                                    <template x-if="company.status !== 'pending'">
                                        <div class="flex gap-2 w-full">
                                            <button @click="viewDetails(company)" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm font-medium hover:shadow-md">
                                                <i class="fas fa-eye mr-2"></i>View Details
                                            </button>
                                            <button @click="toggleStatus(company.id, company.status === 'approved' ? 'rejected' : 'approved')" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm font-medium hover:shadow-md">
                                                <i class="fas" :class="company.status === 'approved' ? 'fa-times-circle text-red-600' : 'fa-check-circle text-green-600'"></i>
                                                <span x-text="company.status === 'approved' ? 'Revoke' : 'Approve'"></span>
                                            </button>
                                            <button @click="deleteCompany(company.id)" class="px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-all duration-200 text-sm font-medium hover:shadow-md">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <!-- Empty State -->
                        <div x-show="filteredCompanies.length === 0 && !loading" class="col-span-full">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-building text-4xl text-gray-400"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Companies Found</h3>
                                <p class="text-gray-600" x-text="filters.search ? 'No companies match your search criteria.' : 'There are no companies registered yet.'"></p>
                                <button @click="filters.search = ''; filters.status = ''; loadCompanies()" class="mt-4 inline-flex items-center px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-all duration-200">
                                    <i class="fas fa-times mr-2"></i>Clear Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div x-show="showRejectModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-transition style="display: none;">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full" @click.away="showRejectModal = false">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-900">Reject Company</h3>
            <button @click="showRejectModal = false" class="w-8 h-8 rounded-full hover:bg-gray-100 transition-colors flex items-center justify-center">
                <i class="fas fa-times text-gray-500"></i>
            </button>
        </div>

        <div class="p-6 space-y-4">
            <p class="text-sm text-gray-600">
                <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                Please provide a reason for rejecting this company.
            </p>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-comment mr-2"></i>Rejection Reason
                </label>
                <textarea
                    x-model="rejectReason"
                    placeholder="Explain why this company is being rejected..."
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 resize-none"
                ></textarea>
                <p class="text-xs text-gray-500 mt-1" x-text="(rejectReason?.length || 0) + '/500 characters'"></p>
            </div>
        </div>

        <div class="p-6 border-t border-gray-200 flex gap-3">
            <button @click="confirmReject()" :disabled="!rejectReason.trim()" class="flex-1 bg-red-600 hover:bg-red-700 disabled:bg-gray-400 text-white font-semibold py-2.5 px-4 rounded-lg transition-all duration-200 hover:shadow-lg disabled:cursor-not-allowed">
                <i class="fas fa-times mr-2"></i>Confirm Reject
            </button>
            <button @click="showRejectModal = false" class="flex-1 px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200">
                Cancel
            </button>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div x-show="showDetailsModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-transition style="display: none;">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto" @click.away="showDetailsModal = false">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between sticky top-0 bg-white z-10">
            <h3 class="text-xl font-bold text-gray-900">Company Details</h3>
            <button @click="showDetailsModal = false" class="w-8 h-8 rounded-full hover:bg-gray-100 transition-colors flex items-center justify-center">
                <i class="fas fa-times text-gray-500"></i>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-building text-gray-600 text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-xl font-bold text-gray-900" x-text="selectedCompany?.name"></h4>
                    <p class="text-gray-600" x-text="selectedCompany?.city || 'N/A'"></p>
                    <span :class="getStatusClass(selectedCompany?.status)" class="inline-block px-3 py-1 rounded-full text-xs font-medium mt-1">
                        <i class="fas" :class="getStatusIcon(selectedCompany?.status)"></i>
                        <span x-text="selectedCompany?.status?.toUpperCase()"></span>
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Owner</p>
                    <p class="font-medium text-gray-900" x-text="selectedCompany?.user?.name || 'N/A'"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium text-gray-900" x-text="selectedCompany?.user?.email || 'N/A'"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Website</p>
                    <a :href="selectedCompany?.website" target="_blank" class="text-blue-600 hover:underline" x-show="selectedCompany?.website">
                        <span x-text="selectedCompany?.website"></span>
                    </a>
                    <span x-show="!selectedCompany?.website" class="text-gray-500">N/A</span>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Phone</p>
                    <p class="font-medium text-gray-900" x-text="selectedCompany?.phone || 'N/A'"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Address</p>
                    <p class="font-medium text-gray-900" x-text="selectedCompany?.address || 'N/A'"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Registered</p>
                    <p class="font-medium text-gray-900" x-text="selectedCompany ? new Date(selectedCompany.created_at).toLocaleDateString() : ''"></p>
                </div>
            </div>

            <div>
                <p class="text-sm text-gray-500 font-medium">Description</p>
                <p class="text-gray-700 mt-1 p-3 bg-gray-50 rounded-lg" x-text="selectedCompany?.description || 'No description provided'"></p>
            </div>

            <div>
                <p class="text-sm text-gray-500 font-medium">Certification</p>
                <p class="text-gray-700 mt-1 p-3 bg-gray-50 rounded-lg" x-text="selectedCompany?.certification || 'No certification provided'"></p>
            </div>

            <div class="flex gap-3 pt-4 border-t border-gray-200">
                <button @click="showDetailsModal = false" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function companiesPage() {
    return {
        companies: [],
        filteredCompanies: [],
        loading: false,
        filters: {
            status: '',
            search: ''
        },
        stats: {
            total: 0,
            pending: 0,
            approved: 0,
            rejected: 0
        },
        showRejectModal: false,
        showDetailsModal: false,
        selectedCompanyId: null,
        selectedCompany: null,
        rejectReason: '',

        getStatusClass(status) {
            const classes = {
                'pending': 'bg-yellow-100 text-yellow-800 border-yellow-200',
                'approved': 'bg-green-100 text-green-800 border-green-200',
                'rejected': 'bg-red-100 text-red-800 border-red-200'
            };
            return classes[status] || 'bg-gray-100 text-gray-800 border-gray-200';
        },

        getStatusIcon(status) {
            const icons = {
                'pending': 'fa-clock',
                'approved': 'fa-check-circle',
                'rejected': 'fa-times-circle'
            };
            return icons[status] || 'fa-circle';
        },

        async loadCompanies() {
            this.loading = true;
            try {
                const params = {};
                if (this.filters.status) params.status = this.filters.status;

                const response = await axios.get('/api/companies', {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` },
                    params
                });

                if (response.data.success) {
                    this.companies = response.data.data;
                    this.filterCompanies();
                    this.updateStats();
                }
            } catch (error) {
                console.error('Error loading companies:', error);
                alert('Failed to load companies. Please try again.');
            } finally {
                this.loading = false;
            }
        },

        filterCompanies() {
            let filtered = [...this.companies];

            if (this.filters.search.trim()) {
                const search = this.filters.search.toLowerCase().trim();
                filtered = filtered.filter(company =>
                    company.name.toLowerCase().includes(search) ||
                    (company.city && company.city.toLowerCase().includes(search)) ||
                    (company.user?.name && company.user.name.toLowerCase().includes(search)) ||
                    (company.user?.email && company.user.email.toLowerCase().includes(search))
                );
            }

            this.filteredCompanies = filtered;
        },

        updateStats() {
            this.stats = {
                total: this.companies.length,
                pending: this.companies.filter(c => c.status === 'pending').length,
                approved: this.companies.filter(c => c.status === 'approved').length,
                rejected: this.companies.filter(c => c.status === 'rejected').length
            };
        },

        async approveCompany(companyId) {
            if (!confirm('Are you sure you want to approve this company?')) return;

            try {
                const response = await axios.post(`/api/companies/${companyId}/approve`, {}, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });

                if (response.data.success) {
                    await this.loadCompanies();
                    alert('Company approved successfully!');
                } else {
                    alert(response.data.message || 'Failed to approve company');
                }
            } catch (error) {
                alert(error.response?.data?.message || 'Failed to approve company');
            }
        },

        openRejectModal(company) {
            this.selectedCompanyId = company.id;
            this.rejectReason = '';
            this.showRejectModal = true;
        },

        async confirmReject() {
            if (!this.rejectReason.trim()) {
                alert('Please provide a reason for rejection');
                return;
            }

            try {
                const response = await axios.post(`/api/companies/${this.selectedCompanyId}/reject`, {
                    reason: this.rejectReason
                }, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });

                if (response.data.success) {
                    this.showRejectModal = false;
                    await this.loadCompanies();
                    alert('Company rejected successfully!');
                } else {
                    alert(response.data.message || 'Failed to reject company');
                }
            } catch (error) {
                alert(error.response?.data?.message || 'Failed to reject company');
            }
        },

        async toggleStatus(companyId, newStatus) {
            const action = newStatus === 'approved' ? 'approve' : 'reject';
            const message = newStatus === 'approved' ? 'approve' : 'reject';

            if (!confirm(`Are you sure you want to ${message} this company?`)) return;

            try {
                const response = await axios.post(`/api/companies/${companyId}/${action}`, {}, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });

                if (response.data.success) {
                    await this.loadCompanies();
                    alert(`Company ${message}d successfully!`);
                } else {
                    alert(response.data.message || `Failed to ${message} company`);
                }
            } catch (error) {
                alert(error.response?.data?.message || `Failed to ${message} company`);
            }
        },

        async deleteCompany(companyId) {
            if (!confirm('Are you sure you want to delete this company? This action cannot be undone.')) return;

            try {
                const response = await axios.delete(`/api/companies/${companyId}`, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });

                if (response.data.success) {
                    await this.loadCompanies();
                    alert('Company deleted successfully!');
                } else {
                    alert(response.data.message || 'Failed to delete company');
                }
            } catch (error) {
                alert(error.response?.data?.message || 'Failed to delete company');
            }
        },

        viewDetails(company) {
            this.selectedCompany = company;
            this.showDetailsModal = true;
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

    /* Modal Overlay */
    .backdrop-blur-sm {
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }
</style>
@endsection
