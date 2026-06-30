@extends('layouts.app')

@section('title', 'Manage Users - JobHub')

@section('content')
<div class="min-h-screen bg-white flex flex-col">
    <div class="flex gap-0 flex-1">
        <!-- Sidebar -->
        @include('components.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col bg-gray-50">
            <div class="flex-1 overflow-y-auto p-8">
                <div class="max-w-7xl mx-auto" x-data="usersPage()" x-init="loadUsers()">
                <div class="space-y-6">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <button onclick="history.back()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-all duration-200 hover:shadow-md mb-4">
                                <i class="fas fa-arrow-left mr-2"></i>Back
                            </button>
                            <h1 class="text-3xl font-bold text-gray-900">Manage Users</h1>
                            <p class="text-gray-600 mt-1 flex items-center gap-2">
                                <i class="fas fa-circle text-[6px] text-gray-300"></i>
                                View and manage all system users
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-users mr-1"></i> Total: <span x-text="users.length"></span> users
                            </span>
                            <button @click="loadUsers()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 hover:shadow-md">
                                <i class="fas fa-redo mr-2"></i>Refresh
                            </button>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Total Users</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1" x-text="stats.total"></p>
                                </div>
                                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-users text-gray-600"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Admins</p>
                                    <p class="text-2xl font-bold text-purple-600 mt-1" x-text="stats.admins"></p>
                                </div>
                                <div class="w-10 h-10 bg-purple-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user-shield text-purple-600"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Employers</p>
                                    <p class="text-2xl font-bold text-blue-600 mt-1" x-text="stats.employers"></p>
                                </div>
                                <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-building text-blue-600"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Candidates</p>
                                    <p class="text-2xl font-bold text-green-600 mt-1" x-text="stats.candidates"></p>
                                </div>
                                <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user-graduate text-green-600"></i>
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
                                    placeholder="Search by name or email..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                >
                            </div>
                            <div class="flex gap-2">
                                <select
                                    x-model="filters.role"
                                    @change="applyFilters()"
                                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 bg-white"
                                >
                                    <option value="">All Roles</option>
                                    <option value="admin">Admin</option>
                                    <option value="employer">Employer</option>
                                    <option value="candidate">Candidate</option>
                                </select>
                                <select
                                    x-model="filters.status"
                                    @change="applyFilters()"
                                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 bg-white"
                                >
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
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
                        <p class="text-gray-600 mt-4">Loading users...</p>
                    </div>

                    <!-- Users Table -->
                    <div x-show="!loading" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Joined</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <template x-for="user in filteredUsers" :key="user.id">
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <img :src="`https://ui-avatars.com/api/?name=${user.name}&background=1a1a1a&color=fff&size=32`"
                                                         :alt="user.name"
                                                         class="w-8 h-8 rounded-full ring-2 ring-gray-200">
                                                    <span class="text-sm font-medium text-gray-900" x-text="user.name"></span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600" x-text="user.email"></td>
                                            <td class="px-6 py-4 text-sm">
                                                <span :class="getRoleClass(user.role)" class="px-3 py-1 rounded-full text-xs font-medium">
                                                    <i class="fas" :class="getRoleIcon(user.role)"></i>
                                                    <span x-text="user.role.toUpperCase()"></span>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm">
                                                <span :class="user.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" class="px-3 py-1 rounded-full text-xs font-medium">
                                                    <i class="fas" :class="user.is_active ? 'fa-check-circle' : 'fa-ban'"></i>
                                                    <span x-text="user.is_active ? 'ACTIVE' : 'INACTIVE'"></span>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600" x-text="new Date(user.created_at).toLocaleDateString()"></td>
                                            <td class="px-6 py-4 text-sm">
                                                <div class="flex items-center gap-2">
                                                    <button @click="toggleStatus(user)" :title="user.is_active ? 'Deactivate user' : 'Activate user'" class="p-1.5 rounded-lg transition-colors" :class="user.is_active ? 'text-yellow-400 hover:text-yellow-600 hover:bg-yellow-50' : 'text-green-400 hover:text-green-600 hover:bg-green-50'">
                                                        <i class="fas" :class="user.is_active ? 'fa-ban' : 'fa-check'"></i>
                                                    </button>
                                                    <button @click="editUser(user)" class="p-1.5 text-blue-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button @click="deleteUser(user.id)" class="p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>

                                    <tr x-show="filteredUsers.length === 0">
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                                    <i class="fas fa-users text-2xl text-gray-400"></i>
                                                </div>
                                                <p class="text-gray-500 font-medium">No users found</p>
                                                <p class="text-sm text-gray-400 mt-1" x-text="search || filters.role || filters.status ? 'Try adjusting your search filters' : 'There are no users registered yet'"></p>
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
                    <div x-show="!loading && filteredUsers.length > 0" class="flex items-center justify-between">
                        <p class="text-sm text-gray-500">
                            Showing <span x-text="filteredUsers.length"></span> of <span x-text="users.length"></span> users
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

            <!-- User Edit Modal -->
            <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-transition style="display: none;">
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto" @click.away="showModal = false">
                    <div class="p-6 border-b border-gray-200 flex items-center justify-between sticky top-0 bg-white z-10">
                        <h3 class="text-xl font-bold text-gray-900">Edit User</h3>
                        <button @click="showModal = false" class="w-8 h-8 rounded-full hover:bg-gray-100 transition-colors flex items-center justify-center">
                            <i class="fas fa-times text-gray-500"></i>
                        </button>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Avatar -->
                        <div class="flex items-center gap-4">
                            <img :src="`https://ui-avatars.com/api/?name=${selectedUser?.name}&background=1a1a1a&color=fff&size=64`"
                                 :alt="selectedUser?.name"
                                 class="w-16 h-16 rounded-full ring-4 ring-gray-200">
                            <div>
                                <h4 class="text-xl font-bold text-gray-900" x-text="selectedUser?.name"></h4>
                                <p class="text-gray-600" x-text="selectedUser?.email"></p>
                            </div>
                        </div>

                        <!-- Edit Form -->
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">Name</label>
                                <input type="text" x-model="editForm.name" placeholder="Full name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">Email</label>
                                <input type="email" x-model="editForm.email" placeholder="Email address" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">Role</label>
                                <select x-model="editForm.role" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all bg-white">
                                    <option value="admin">Admin</option>
                                    <option value="employer">Employer</option>
                                    <option value="candidate">Candidate</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">Status</label>
                                <div class="flex items-center gap-3 p-3 border border-gray-300 rounded-lg bg-gray-50">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" x-model="editForm.is_active" class="w-4 h-4 cursor-pointer">
                                        <span class="ml-2 text-sm" :class="editForm.is_active ? 'text-green-600 font-medium' : 'text-red-600 font-medium'" x-text="editForm.is_active ? 'ACTIVE - User can login' : 'INACTIVE - User blocked'"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3 pt-4 border-t border-gray-200">
                            <button @click="showModal = false" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200">
                                Cancel
                            </button>
                            <button @click="saveUserChanges()" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200">
                                <i class="fas fa-save mr-2"></i>Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function usersPage() {
    return {
        users: [],
        filteredUsers: [],
        search: '',
        page: 1,
        showModal: false,
        selectedUser: null,
        editForm: {
            name: '',
            email: '',
            role: 'candidate',
            is_active: true
        },
        filters: {
            role: '',
            status: ''
        },
        stats: {
            total: 0,
            admins: 0,
            employers: 0,
            candidates: 0
        },
        loading: false,

        getRoleClass(role) {
            const classes = {
                'admin': 'bg-purple-100 text-purple-800',
                'employer': 'bg-blue-100 text-blue-800',
                'candidate': 'bg-green-100 text-green-800'
            };
            return classes[role] || 'bg-gray-100 text-gray-800';
        },

        getRoleIcon(role) {
            const icons = {
                'admin': 'fa-user-shield',
                'employer': 'fa-building',
                'candidate': 'fa-user-graduate'
            };
            return icons[role] || 'fa-user';
        },

        async loadUsers() {
            this.loading = true;
            try {
                const token = localStorage.getItem('token');
                if (!token) {
                    window.location.href = '/auth/login';
                    return;
                }

                const params = {
                    search: this.search,
                    role: this.filters.role,
                    status: this.filters.status,
                    page: this.page
                };

                const response = await axios.get('/api/users/filter', {
                    headers: { 'Authorization': `Bearer ${token}` },
                    params
                });

                if (response.data.success) {
                    this.users = response.data.data;
                    this.applyFilters();
                    this.updateStats();
                } else {
                    alert(response.data.message || 'Failed to load users');
                }
            } catch (error) {
                if (error.response?.status === 401) {
                    window.location.href = '/auth/login';
                } else {
                    console.error('Error loading users:', error);
                    alert('Failed to load users. Please try again.');
                }
            } finally {
                this.loading = false;
            }
        },

        applyFilters() {
            let filtered = [...this.users];

            if (this.search.trim()) {
                const search = this.search.toLowerCase().trim();
                filtered = filtered.filter(user =>
                    user.name.toLowerCase().includes(search) ||
                    user.email.toLowerCase().includes(search)
                );
            }

            if (this.filters.role) {
                filtered = filtered.filter(user => user.role === this.filters.role);
            }

            if (this.filters.status) {
                const status = this.filters.status;
                if (status === 'active') {
                    filtered = filtered.filter(user => user.is_active === true);
                } else if (status === 'inactive') {
                    filtered = filtered.filter(user => user.is_active === false);
                }
            }

            this.filteredUsers = filtered;
        },

        updateStats() {
            const total = this.users.length;
            const admins = this.users.filter(u => u.role === 'admin').length;
            const employers = this.users.filter(u => u.role === 'employer').length;
            const candidates = this.users.filter(u => u.role === 'candidate').length;

            this.stats = { total, admins, employers, candidates };
        },

        resetFilters() {
            this.search = '';
            this.filters.role = '';
            this.filters.status = '';
            this.page = 1;
            this.applyFilters();
            this.loadUsers();
        },

        viewUser(user) {
            this.selectedUser = user;
            this.showModal = true;
        },

        editUser(user) {
            this.selectedUser = user;
            this.editForm = {
                name: user.name,
                email: user.email,
                role: user.role,
                is_active: user.is_active ?? true
            };
            this.showModal = true;
        },

        async saveUserChanges() {
            if (!this.selectedUser?.id) return;

            if (!this.editForm.name.trim() || !this.editForm.email.trim()) {
                alert('Name and email are required');
                return;
            }

            try {
                const response = await axios.put(`/api/users/${this.selectedUser.id}`, {
                    name: this.editForm.name,
                    email: this.editForm.email,
                    role: this.editForm.role,
                    is_active: this.editForm.is_active
                }, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });

                if (response.data.success) {
                    this.showModal = false;
                    this.loadUsers();
                    alert('User updated successfully');
                } else {
                    alert(response.data.message || 'Failed to update user');
                }
            } catch (error) {
                alert(error.response?.data?.message || 'Failed to update user');
                console.error('Error updating user:', error);
            }
        },

        async toggleStatus(user) {
            if (!user?.id) return;
            const newStatus = !user.is_active;
            const action = newStatus ? 'activate' : 'deactivate';

            if (!confirm(`Are you sure you want to ${action} this user?`)) return;

            try {
                const response = await axios.put(`/api/users/${user.id}/status`, {
                    is_active: newStatus
                }, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });

                if (response.data.success) {
                    this.showModal = false;
                    this.loadUsers();
                    alert(`User ${action}d successfully`);
                } else {
                    alert(response.data.message || `Failed to ${action} user`);
                }
            } catch (error) {
                alert(error.response?.data?.message || `Failed to ${action} user`);
            }
        },

        async deleteUser(userId) {
            if (!userId) return;
            if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) return;

            try {
                const response = await axios.delete(`/api/users/${userId}`, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });

                if (response.data.success) {
                    this.showModal = false;
                    this.loadUsers();
                    alert('User deleted successfully');
                } else {
                    alert(response.data.message || 'Failed to delete user');
                }
            } catch (error) {
                alert(error.response?.data?.message || 'Failed to delete user');
            }
        },

        nextPage() {
            this.page++;
            this.loadUsers();
        },

        previousPage() {
            if (this.page > 1) {
                this.page--;
                this.loadUsers();
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

    /* Avatar ring */
    .ring-2 {
        transition: all 0.3s ease;
    }
</style>
@endsection
