@extends('layouts.app')

@section('title', 'My Profile - JobHub')

@section('content')
<div class="min-h-screen bg-white">
    <div class="max-w-4xl mx-auto" x-data="profilePage()" x-init="loadProfile()">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
                    <p class="text-gray-600 mt-1 flex items-center gap-2">
                        <i class="fas fa-circle text-[6px] text-gray-300"></i>
                        Manage your account settings and preferences
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500">
                        <i class="fas fa-clock mr-1"></i>
                        Last updated: <span x-text="new Date().toLocaleString()"></span>
                    </span>
                </div>
            </div>

            <!-- Loading State -->
            <div x-show="loading" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <div class="inline-block">
                    <i class="fas fa-spinner fa-spin text-4xl text-gray-400"></i>
                </div>
                <p class="text-gray-600 mt-4">Loading profile...</p>
            </div>

            <!-- Profile Card -->
            <div x-show="!loading && !editMode" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-all duration-200">
                <!-- Cover Image -->
                <div class="bg-gradient-to-r from-gray-700 to-gray-900 h-32 relative">
                    <div class="absolute inset-0 bg-black/20"></div>
                    <div class="absolute bottom-0 left-0 right-0 px-6 pb-4">
                        <div class="flex items-end justify-between">
                            <div class="flex items-end gap-4">
                                <!-- Avatar -->
                                <div class="relative -mb-8">
                                    <img :src="`https://ui-avatars.com/api/?name=${profile.name}&background=1a1a1a&color=fff&size=96`"
                                         :alt="profile.name"
                                         class="w-24 h-24 rounded-full border-4 border-white shadow-lg hover:scale-105 transition-transform duration-300">
                                    <div class="absolute bottom-0 right-0 w-6 h-6 bg-green-500 border-2 border-white rounded-full"></div>
                                </div>
                                <div class="pb-2">
                                    <h2 class="text-2xl font-bold text-white" x-text="profile.name"></h2>
                                    <p class="text-gray-300 text-sm" x-text="profile.email"></p>
                                </div>
                            </div>
                            <div class="pb-2 flex gap-2">
                                <span class="px-3 py-1 bg-white/10 backdrop-blur-sm text-white text-xs font-semibold rounded-full border border-white/20">
                                    <i class="fas fa-user mr-1"></i>
                                    <span x-text="profile.role?.toUpperCase()"></span>
                                </span>
                                <button @click="toggleEditMode()" class="px-4 py-2 bg-white text-gray-900 rounded-lg hover:bg-gray-100 transition-all duration-200 hover:shadow-lg text-sm font-medium">
                                    <i class="fas fa-edit mr-2"></i>Edit Profile
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Details -->
                <div class="px-6 pt-12 pb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Information -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Personal Information</h3>
                            <div class="space-y-3">
                                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                                    <i class="fas fa-user text-gray-400 mt-0.5"></i>
                                    <div>
                                        <p class="text-xs text-gray-500">Full Name</p>
                                        <p class="text-sm font-medium text-gray-900" x-text="profile.name"></p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                                    <i class="fas fa-envelope text-gray-400 mt-0.5"></i>
                                    <div>
                                        <p class="text-xs text-gray-500">Email Address</p>
                                        <p class="text-sm font-medium text-gray-900" x-text="profile.email"></p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                                    <i class="fas fa-briefcase text-gray-400 mt-0.5"></i>
                                    <div>
                                        <p class="text-xs text-gray-500">Role</p>
                                        <p class="text-sm font-medium text-gray-900" x-text="profile.role?.toUpperCase()"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Account Information -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Account Information</h3>
                            <div class="space-y-3">
                                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                                    <i class="fas fa-calendar-alt text-gray-400 mt-0.5"></i>
                                    <div>
                                        <p class="text-xs text-gray-500">Member Since</p>
                                        <p class="text-sm font-medium text-gray-900" x-text="profile.created_at ? new Date(profile.created_at).toLocaleDateString() : 'N/A'"></p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                                    <i class="fas fa-clock text-gray-400 mt-0.5"></i>
                                    <div>
                                        <p class="text-xs text-gray-500">Last Login</p>
                                        <p class="text-sm font-medium text-gray-900" x-text="profile.last_login ? new Date(profile.last_login).toLocaleDateString() : 'N/A'"></p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3 p-3 bg-green-50 rounded-lg border border-green-200">
                                    <i class="fas fa-shield-alt text-green-500 mt-0.5"></i>
                                    <div>
                                        <p class="text-xs text-green-600">Account Status</p>
                                        <p class="text-sm font-medium text-green-700">Active</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex flex-wrap gap-3">
                            <a href="#" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm">
                                <i class="fas fa-bell mr-2"></i>Notifications
                            </a>
                            <a href="#" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm">
                                <i class="fas fa-shield-alt mr-2"></i>Security
                            </a>
                            <a href="#" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm">
                                <i class="fas fa-download mr-2"></i>Export Data
                            </a>
                            <button @click="deleteAccount()" class="inline-flex items-center px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-all duration-200 text-sm">
                                <i class="fas fa-trash mr-2"></i>Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div x-show="editMode && !loading" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Edit Profile</h3>
                        <p class="text-sm text-gray-500">Update your personal information</p>
                    </div>
                    <button @click="toggleEditMode()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <!-- Error Alert -->
                <div x-show="error" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 flex items-start" x-transition>
                    <i class="fas fa-exclamation-circle mr-3 mt-0.5 text-red-500"></i>
                    <span x-text="error"></span>
                </div>

                <!-- Success Alert -->
                <div x-show="success" class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 flex items-start" x-transition>
                    <i class="fas fa-check-circle mr-3 mt-0.5 text-green-500"></i>
                    <span x-text="success"></span>
                </div>

                <form @submit.prevent="updateProfile()" class="space-y-6">
                    <!-- Basic Information -->
                    <div class="border-b border-gray-200 pb-6">
                        <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Basic Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user mr-2 text-gray-400"></i>Full Name
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input
                                        type="text"
                                        x-model="editForm.name"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                        required
                                    >
                                </div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-envelope mr-2 text-gray-400"></i>Email Address
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input
                                        type="email"
                                        x-model="editForm.email"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                        required
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Change Password Section -->
                    <div>
                        <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Change Password</h4>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-lock mr-2 text-gray-400"></i>Current Password
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <input
                                        type="password"
                                        x-model="editForm.current_password"
                                        placeholder="Leave blank if not changing password"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                    >
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Required only if changing password</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-key mr-2 text-gray-400"></i>New Password
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-key text-gray-400"></i>
                                        </div>
                                        <input
                                            type="password"
                                            x-model="editForm.new_password"
                                            placeholder="Leave blank if not changing"
                                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                        >
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-check-circle mr-2 text-gray-400"></i>Confirm Password
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-check-circle text-gray-400"></i>
                                        </div>
                                        <input
                                            type="password"
                                            x-model="editForm.confirm_password"
                                            placeholder="Confirm new password"
                                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Password Match Indicator -->
                            <div x-show="editForm.new_password || editForm.confirm_password" class="flex items-center gap-2">
                                <i class="fas" :class="editForm.new_password === editForm.confirm_password && editForm.new_password ? 'fa-check-circle text-green-500' : 'fa-times-circle text-red-500'"></i>
                                <span class="text-sm" :class="editForm.new_password === editForm.confirm_password && editForm.new_password ? 'text-green-600' : 'text-red-600'">
                                    <span x-text="editForm.new_password === editForm.confirm_password && editForm.new_password ? 'Passwords match' : editForm.confirm_password ? 'Passwords do not match' : 'Confirm your password'"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                        <button
                            type="submit"
                            :disabled="loading"
                            class="flex-1 relative overflow-hidden group bg-gray-900 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 hover:scale-[1.02] hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></span>
                            <span x-show="!loading">
                                <i class="fas fa-save mr-2"></i>Save Changes
                            </span>
                            <span x-show="loading">
                                <i class="fas fa-spinner fa-spin mr-2"></i>Saving...
                            </span>
                        </button>

                        <button
                            type="button"
                            @click="toggleEditMode()"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200"
                        >
                            <i class="fas fa-times mr-2"></i>Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function profilePage() {
    return {
        profile: {},
        editForm: {},
        loading: false,
        editMode: false,
        error: '',
        success: '',

        async loadProfile() {
            this.loading = true;
            this.error = '';
            try {
                const token = localStorage.getItem('token');
                if (!token) {
                    window.location.href = '/auth/login';
                    return;
                }

                const response = await axios.get('/api/profile', {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                if (response.data.status) {
                    this.profile = response.data.data;
                    this.editForm = {
                        name: response.data.data.name,
                        email: response.data.data.email,
                        current_password: '',
                        new_password: '',
                        confirm_password: ''
                    };
                } else {
                    this.error = response.data.message || 'Failed to load profile';
                }
            } catch (error) {
                if (error.response?.status === 401) {
                    window.location.href = '/auth/login';
                } else {
                    this.error = error.response?.data?.message || 'Failed to load profile';
                }
            } finally {
                this.loading = false;
            }
        },

        toggleEditMode() {
            this.editMode = !this.editMode;
            this.error = '';
            this.success = '';
            if (this.editMode) {
                this.editForm = {
                    name: this.profile.name,
                    email: this.profile.email,
                    current_password: '',
                    new_password: '',
                    confirm_password: ''
                };
            }
        },

        async updateProfile() {
            this.error = '';
            this.success = '';

            // Validate passwords match
            if (this.editForm.new_password && this.editForm.new_password !== this.editForm.confirm_password) {
                this.error = 'New passwords do not match';
                return;
            }

            // Validate password length
            if (this.editForm.new_password && this.editForm.new_password.length < 8) {
                this.error = 'New password must be at least 8 characters';
                return;
            }

            // If changing password, current password is required
            if (this.editForm.new_password && !this.editForm.current_password) {
                this.error = 'Please enter your current password to change it';
                return;
            }

            this.loading = true;
            try {
                const data = {
                    name: this.editForm.name,
                    email: this.editForm.email
                };

                if (this.editForm.new_password) {
                    data.current_password = this.editForm.current_password;
                    data.password = this.editForm.new_password;
                    data.password_confirmation = this.editForm.confirm_password;
                }

                const token = localStorage.getItem('token');
                const response = await axios.put(`/api/users/${this.profile.id}`, data, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                if (response.data.status) {
                    this.profile = response.data.data;
                    this.success = 'Profile updated successfully!';
                    this.editMode = false;

                    // Update user in localStorage
                    localStorage.setItem('user', JSON.stringify(response.data.data));

                    // Show success and reload after delay
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    this.error = response.data.message || 'Failed to update profile';
                }
            } catch (error) {
                if (error.response?.data?.errors) {
                    const errors = error.response.data.errors;
                    this.error = Object.values(errors).flat().join(', ');
                } else if (error.response?.data?.message) {
                    this.error = error.response.data.message;
                } else {
                    this.error = 'An error occurred. Please try again.';
                }
            } finally {
                this.loading = false;
            }
        },

        async deleteAccount() {
            if (!confirm('Are you sure you want to delete your account? This action cannot be undone and all your data will be permanently removed.')) {
                return;
            }

            if (!confirm('Please confirm again: All your data including applications, jobs, and profile information will be deleted.')) {
                return;
            }

            try {
                const token = localStorage.getItem('token');
                const response = await axios.delete(`/api/users/${this.profile.id}`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                if (response.data.status) {
                    localStorage.removeItem('token');
                    localStorage.removeItem('user');
                    alert('Account deleted successfully');
                    window.location.href = '/auth/login';
                } else {
                    alert(response.data.message || 'Failed to delete account');
                }
            } catch (error) {
                alert(error.response?.data?.message || 'Failed to delete account');
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

    /* Smooth transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }

    /* Avatar hover */
    .hover\:scale-105:hover {
        transform: scale(1.05);
    }

    /* Cover image gradient */
    .bg-gradient-to-r {
        background-size: 200% 200%;
        animation: gradientShift 4s ease-in-out infinite;
    }

    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    /* Online status dot */
    .bg-green-500 {
        box-shadow: 0 0 0 2px white;
    }
</style>
@endsection
