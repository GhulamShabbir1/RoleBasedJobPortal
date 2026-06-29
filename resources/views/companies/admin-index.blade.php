@extends('layouts.app')

@section('title', 'Manage Companies - JobHub')

@section('content')
<div class="flex gap-6">
    <!-- Sidebar -->
    @include('components.admin-sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <div x-data="companiesPage()" x-init="loadCompanies()" class="space-y-6">
            <!-- Header -->
            <div>
                <button onclick="history.back()" class="flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition mb-4">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </button>
                <h1 class="text-3xl font-bold text-gray-900">Manage Companies</h1>
                <p class="text-gray-600 mt-1">Review and approve company registrations</p>
            </div>

            <!-- Filter Tabs -->
            <div class="bg-white rounded-lg shadow p-4 flex space-x-4">
                <button @click="filters.status = ''; loadCompanies()" :class="!filters.status && 'border-b-2 border-blue-600 text-blue-600'" class="pb-2 font-medium text-gray-700 hover:text-gray-900">
                    All <span class="text-xs bg-gray-200 rounded-full px-2 py-1 ml-1" x-text="stats.total"></span>
                </button>
                <button @click="filters.status = 'pending'; loadCompanies()" :class="filters.status === 'pending' && 'border-b-2 border-blue-600 text-blue-600'" class="pb-2 font-medium text-gray-700 hover:text-gray-900">
                    Pending <span class="text-xs bg-yellow-200 rounded-full px-2 py-1 ml-1" x-text="stats.pending"></span>
                </button>
                <button @click="filters.status = 'approved'; loadCompanies()" :class="filters.status === 'approved' && 'border-b-2 border-blue-600 text-blue-600'" class="pb-2 font-medium text-gray-700 hover:text-gray-900">
                    Approved <span class="text-xs bg-green-200 rounded-full px-2 py-1 ml-1" x-text="stats.approved"></span>
                </button>
                <button @click="filters.status = 'rejected'; loadCompanies()" :class="filters.status === 'rejected' && 'border-b-2 border-blue-600 text-blue-600'" class="pb-2 font-medium text-gray-700 hover:text-gray-900">
                    Rejected <span class="text-xs bg-red-200 rounded-full px-2 py-1 ml-1" x-text="stats.rejected"></span>
                </button>
            </div>

            <!-- Loading State -->
            <div x-show="loading" class="text-center py-12">
                <i class="fas fa-spinner fa-spin text-3xl text-blue-600"></i>
                <p class="text-gray-600 mt-2">Loading companies...</p>
            </div>

            <!-- Companies Grid -->
            <div x-show="!loading" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <template x-for="company in companies" :key="company.id">
            <div class="bg-white rounded-lg shadow p-6 space-y-4">
                <!-- Header -->
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900" x-text="company.name"></h3>
                        <p class="text-sm text-gray-600" x-text="company.city"></p>
                    </div>
                    <span :class="getStatusClass(company.status)" class="px-3 py-1 rounded-full text-xs font-medium" x-text="company.status.toUpperCase()"></span>
                </div>

                <!-- Info -->
                <div>
                    <p class="text-sm text-gray-700" x-text="company.description.substring(0, 100) + '...'"></p>
                </div>

                <!-- Details -->
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div>
                        <p class="text-gray-600">Owner</p>
                        <p class="font-medium text-gray-900" x-text="company.user?.name"></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Email</p>
                        <p class="font-medium text-gray-900" x-text="company.user?.email"></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Website</p>
                        <a :href="company.website" target="_blank" class="font-medium text-blue-600 hover:underline" x-text="company.website"></a>
                    </div>
                    <div>
                        <p class="text-gray-600">Registered</p>
                        <p class="font-medium text-gray-900" x-text="new Date(company.created_at).toLocaleDateString()"></p>
                    </div>
                </div>

                <!-- Actions (for pending companies) -->
                <div x-show="company.status === 'pending'" class="flex space-x-3 pt-4 border-t border-gray-200">
                    <button @click="approveCompany(company.id)" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                        <i class="fas fa-check mr-2"></i>Approve
                    </button>
                    <button @click="openRejectModal(company)" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                        <i class="fas fa-times mr-2"></i>Reject
                    </button>
                </div>

                <!-- View Details -->
                <div x-show="company.status !== 'pending'" class="flex space-x-3 pt-4 border-t border-gray-200">
                    <button @click="viewDetails(company)" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm font-medium">
                        <i class="fas fa-eye mr-2"></i>View Details
                    </button>
                </div>
            </div>
        </template>

        <div x-show="companies.length === 0" class="col-span-full text-center py-12 bg-gray-50 rounded-lg">
            <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
            <p class="text-gray-600">No companies found</p>
        </div>
    </div>

    <!-- Reject Modal -->
    <div x-show="showRejectModal" @click.away="showRejectModal = false" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
        <div class="bg-white rounded-lg shadow p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Reject Company</h3>

            <textarea
                x-model="rejectReason"
                placeholder="Reason for rejection..."
                rows="4"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none mb-4"
            ></textarea>

            <div class="flex space-x-3">
                <button @click="confirmReject()" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Confirm Reject
                </button>
                <button @click="showRejectModal = false" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function companiesPage() {
    return {
        companies: [],
        loading: false,
        filters: {
            status: ''
        },
        stats: {
            total: 0,
            pending: 0,
            approved: 0,
            rejected: 0
        },
        showRejectModal: false,
        selectedCompanyId: null,
        rejectReason: '',

        getStatusClass(status) {
            const classes = {
                'pending': 'bg-yellow-100 text-yellow-800',
                'approved': 'bg-green-100 text-green-800',
                'rejected': 'bg-red-100 text-red-800'
            };
            return classes[status] || 'bg-gray-100 text-gray-800';
        },

        async loadCompanies() {
            this.loading = true;
            try {
                const params = this.filters.status ? { status: this.filters.status } : {};
                const response = await axios.get('/api/companies', {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` },
                    params
                });

                if (response.data.success) {
                    this.companies = response.data.data;
                    this.loadStats();
                }
            } catch (error) {
                console.error('Error loading companies:', error);
            } finally {
                this.loading = false;
            }
        },

        async loadStats() {
            // Calculate stats from loaded companies
            this.stats = {
                total: this.companies.length,
                pending: this.companies.filter(c => c.status === 'pending').length,
                approved: this.companies.filter(c => c.status === 'approved').length,
                rejected: this.companies.filter(c => c.status === 'rejected').length
            };
        },

        async approveCompany(companyId) {
            if (confirm('Approve this company?')) {
                try {
                    const response = await axios.post(`/api/companies/${companyId}/approve`, {}, {
                        headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                    });

                    if (response.data.success) {
                        alert('Company approved successfully');
                        this.loadCompanies();
                    }
                } catch (error) {
                    alert(error.response?.data?.message || 'Failed to approve company');
                }
            }
        },

        openRejectModal(company) {
            this.selectedCompanyId = company.id;
            this.rejectReason = '';
            this.showRejectModal = true;
        },

        async confirmReject() {
            try {
                const response = await axios.post(`/api/companies/${this.selectedCompanyId}/reject`, {
                    reason: this.rejectReason
                }, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });

                if (response.data.success) {
                    alert('Company rejected successfully');
                    this.showRejectModal = false;
                    this.loadCompanies();
                }
            } catch (error) {
                alert(error.response?.data?.message || 'Failed to reject company');
            }
        },

        viewDetails(company) {
            alert(`Company: ${company.name}\nCity: ${company.city}\nWebsite: ${company.website}\nStatus: ${company.status}`);
        }
    }
}
</script>
        </div>
    </div>
</div>
@endsection
