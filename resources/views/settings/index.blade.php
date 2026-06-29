@extends('layouts.app')

@section('title', 'Settings - JobHub')

@section('content')
<div class="min-h-screen bg-white">
    <div class="max-w-4xl mx-auto" x-data="settingsPage()" x-init="loadSettings()">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Settings</h1>
                    <p class="text-gray-600 mt-1 flex items-center gap-2">
                        <i class="fas fa-circle text-[6px] text-gray-300"></i>
                        Manage your account preferences and privacy settings
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500">
                        <i class="fas fa-sync-alt mr-1"></i>
                        Last saved: <span x-text="lastSaved"></span>
                    </span>
                </div>
            </div>

            <!-- Loading State -->
            <div x-show="loading" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <div class="inline-block">
                    <i class="fas fa-spinner fa-spin text-4xl text-gray-400"></i>
                </div>
                <p class="text-gray-600 mt-4">Loading settings...</p>
            </div>

            <!-- Error Alert -->
            <div x-show="error" class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 flex items-start" x-transition>
                <i class="fas fa-exclamation-circle mr-3 mt-0.5 text-red-500"></i>
                <span x-text="error"></span>
            </div>

            <!-- Success Alert -->
            <div x-show="success" class="p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 flex items-start" x-transition>
                <i class="fas fa-check-circle mr-3 mt-0.5 text-green-500"></i>
                <span x-text="success"></span>
            </div>

            <!-- Settings Tabs -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" x-show="!loading">
                <div class="border-b border-gray-200">
                    <nav class="flex overflow-x-auto">
                        <button @click="activeTab = 'notifications'"
                                class="px-6 py-3 text-sm font-medium transition-colors relative"
                                :class="activeTab === 'notifications' ? 'text-gray-900 border-b-2 border-gray-900' : 'text-gray-500 hover:text-gray-700'">
                            <i class="fas fa-bell mr-2"></i>Notifications
                        </button>
                        <button @click="activeTab = 'privacy'"
                                class="px-6 py-3 text-sm font-medium transition-colors relative"
                                :class="activeTab === 'privacy' ? 'text-gray-900 border-b-2 border-gray-900' : 'text-gray-500 hover:text-gray-700'">
                            <i class="fas fa-shield-alt mr-2"></i>Privacy
                        </button>
                        <button @click="activeTab = 'security'"
                                class="px-6 py-3 text-sm font-medium transition-colors relative"
                                :class="activeTab === 'security' ? 'text-gray-900 border-b-2 border-gray-900' : 'text-gray-500 hover:text-gray-700'">
                            <i class="fas fa-lock mr-2"></i>Security
                        </button>
                        <button @click="activeTab = 'preferences'"
                                class="px-6 py-3 text-sm font-medium transition-colors relative"
                                :class="activeTab === 'preferences' ? 'text-gray-900 border-b-2 border-gray-900' : 'text-gray-500 hover:text-gray-700'">
                            <i class="fas fa-sliders-h mr-2"></i>Preferences
                        </button>
                    </nav>
                </div>

                <div class="p-6">
                    <!-- Notifications Tab -->
                    <div x-show="activeTab === 'notifications'" class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Notification Preferences</h3>
                            <p class="text-sm text-gray-500">Choose what notifications you want to receive</p>
                        </div>

                        <div class="space-y-4">
                            <!-- Email Notifications -->
                            <div class="flex items-start justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5">
                                        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-envelope text-blue-600"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Email Notifications</p>
                                        <p class="text-sm text-gray-600">Receive email updates about job applications and responses</p>
                                    </div>
                                </div>
                                <div class="relative inline-flex flex-shrink-0 h-6 w-11 rounded-full transition-colors duration-200 ease-in-out cursor-pointer ml-4"
                                     :class="settings.email_notifications ? 'bg-gray-900' : 'bg-gray-300'"
                                     @click="settings.email_notifications = !settings.email_notifications">
                                    <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow-lg transition duration-200 ease-in-out mt-0.5 ml-0.5"
                                          :class="settings.email_notifications ? 'translate-x-5' : 'translate-x-0'"></span>
                                </div>
                            </div>

                            <!-- Marketing Emails -->
                            <div class="flex items-start justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5">
                                        <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-bullhorn text-purple-600"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Marketing Emails</p>
                                        <p class="text-sm text-gray-600">Receive tips, news, and special offers from JobHub</p>
                                    </div>
                                </div>
                                <div class="relative inline-flex flex-shrink-0 h-6 w-11 rounded-full transition-colors duration-200 ease-in-out cursor-pointer ml-4"
                                     :class="settings.marketing_emails ? 'bg-gray-900' : 'bg-gray-300'"
                                     @click="settings.marketing_emails = !settings.marketing_emails">
                                    <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow-lg transition duration-200 ease-in-out mt-0.5 ml-0.5"
                                          :class="settings.marketing_emails ? 'translate-x-5' : 'translate-x-0'"></span>
                                </div>
                            </div>

                            <!-- Application Updates -->
                            <div class="flex items-start justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5">
                                        <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-file-check text-green-600"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Application Updates</p>
                                        <p class="text-sm text-gray-600">Get notified when your application status changes</p>
                                    </div>
                                </div>
                                <div class="relative inline-flex flex-shrink-0 h-6 w-11 rounded-full transition-colors duration-200 ease-in-out cursor-pointer ml-4"
                                     :class="settings.application_updates ? 'bg-gray-900' : 'bg-gray-300'"
                                     @click="settings.application_updates = !settings.application_updates">
                                    <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow-lg transition duration-200 ease-in-out mt-0.5 ml-0.5"
                                          :class="settings.application_updates ? 'translate-x-5' : 'translate-x-0'"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Privacy Tab -->
                    <div x-show="activeTab === 'privacy'" class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Privacy Settings</h3>
                            <p class="text-sm text-gray-500">Control your privacy and visibility</p>
                        </div>

                        <div class="space-y-4">
                            <!-- Profile Visibility -->
                            <div class="flex items-start justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5">
                                        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-user text-blue-600"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Public Profile</p>
                                        <p class="text-sm text-gray-600">Allow employers to view your profile and contact you</p>
                                    </div>
                                </div>
                                <div class="relative inline-flex flex-shrink-0 h-6 w-11 rounded-full transition-colors duration-200 ease-in-out cursor-pointer ml-4"
                                     :class="settings.profile_visibility ? 'bg-gray-900' : 'bg-gray-300'"
                                     @click="settings.profile_visibility = !settings.profile_visibility">
                                    <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow-lg transition duration-200 ease-in-out mt-0.5 ml-0.5"
                                          :class="settings.profile_visibility ? 'translate-x-5' : 'translate-x-0'"></span>
                                </div>
                            </div>

                            <!-- Show Email -->
                            <div class="flex items-start justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5">
                                        <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-envelope text-purple-600"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Show Email</p>
                                        <p class="text-sm text-gray-600">Display your email address on your public profile</p>
                                    </div>
                                </div>
                                <div class="relative inline-flex flex-shrink-0 h-6 w-11 rounded-full transition-colors duration-200 ease-in-out cursor-pointer ml-4"
                                     :class="settings.show_email ? 'bg-gray-900' : 'bg-gray-300'"
                                     @click="settings.show_email = !settings.show_email">
                                    <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow-lg transition duration-200 ease-in-out mt-0.5 ml-0.5"
                                          :class="settings.show_email ? 'translate-x-5' : 'translate-x-0'"></span>
                                </div>
                            </div>

                            <!-- Data Sharing -->
                            <div class="flex items-start justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5">
                                        <div class="w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-share-alt text-orange-600"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Data Sharing</p>
                                        <p class="text-sm text-gray-600">Allow JobHub to share anonymized data for analytics</p>
                                    </div>
                                </div>
                                <div class="relative inline-flex flex-shrink-0 h-6 w-11 rounded-full transition-colors duration-200 ease-in-out cursor-pointer ml-4"
                                     :class="settings.data_sharing ? 'bg-gray-900' : 'bg-gray-300'"
                                     @click="settings.data_sharing = !settings.data_sharing">
                                    <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow-lg transition duration-200 ease-in-out mt-0.5 ml-0.5"
                                          :class="settings.data_sharing ? 'translate-x-5' : 'translate-x-0'"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Tab -->
                    <div x-show="activeTab === 'security'" class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Security Settings</h3>
                            <p class="text-sm text-gray-500">Manage your account security</p>
                        </div>

                        <div class="space-y-4">
                            <!-- Two-Factor Authentication -->
                            <div class="flex items-start justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5">
                                        <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-shield-alt text-green-600"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Two-Factor Authentication</p>
                                        <p class="text-sm text-gray-600">Add an extra layer of security to your account</p>
                                    </div>
                                </div>
                                <div class="relative inline-flex flex-shrink-0 h-6 w-11 rounded-full transition-colors duration-200 ease-in-out cursor-pointer ml-4"
                                     :class="settings.two_factor ? 'bg-gray-900' : 'bg-gray-300'"
                                     @click="settings.two_factor = !settings.two_factor">
                                    <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow-lg transition duration-200 ease-in-out mt-0.5 ml-0.5"
                                          :class="settings.two_factor ? 'translate-x-5' : 'translate-x-0'"></span>
                                </div>
                            </div>

                            <!-- Session Management -->
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5">
                                        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-laptop text-blue-600"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900">Active Sessions</p>
                                        <p class="text-sm text-gray-600">You are currently logged in on 2 devices</p>
                                        <button class="mt-2 text-sm text-red-600 hover:text-red-700 transition-colors">
                                            <i class="fas fa-sign-out-alt mr-1"></i>Logout all other sessions
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Change Password Link -->
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5">
                                        <div class="w-10 h-10 bg-yellow-50 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-key text-yellow-600"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900">Change Password</p>
                                        <p class="text-sm text-gray-600">Update your password regularly for better security</p>
                                        <a href="{{ route('profile') }}" class="mt-2 inline-block text-sm text-gray-900 hover:underline font-medium">
                                            Go to Profile <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preferences Tab -->
                    <div x-show="activeTab === 'preferences'" class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">User Preferences</h3>
                            <p class="text-sm text-gray-500">Customize your JobHub experience</p>
                        </div>

                        <div class="space-y-4">
                            <!-- Language -->
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5">
                                        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-globe text-blue-600"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900">Language</p>
                                        <p class="text-sm text-gray-600">Choose your preferred language</p>
                                        <select x-model="settings.language" class="mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 bg-white">
                                            <option value="en">English</option>
                                            <option value="es">Spanish</option>
                                            <option value="fr">French</option>
                                            <option value="de">German</option>
                                            <option value="zh">Chinese</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Timezone -->
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5">
                                        <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-clock text-purple-600"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900">Timezone</p>
                                        <p class="text-sm text-gray-600">Set your local timezone</p>
                                        <select x-model="settings.timezone" class="mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 bg-white">
                                            <option value="UTC">UTC</option>
                                            <option value="America/New_York">Eastern Time</option>
                                            <option value="America/Chicago">Central Time</option>
                                            <option value="America/Denver">Mountain Time</option>
                                            <option value="America/Los_Angeles">Pacific Time</option>
                                            <option value="Europe/London">London</option>
                                            <option value="Europe/Paris">Paris</option>
                                            <option value="Asia/Karachi">Karachi</option>
                                            <option value="Asia/Dubai">Dubai</option>
                                            <option value="Asia/Tokyo">Tokyo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Job Alerts -->
                            <div class="flex items-start justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5">
                                        <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-bell text-green-600"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Job Alerts</p>
                                        <p class="text-sm text-gray-600">Receive alerts for new jobs matching your skills</p>
                                    </div>
                                </div>
                                <div class="relative inline-flex flex-shrink-0 h-6 w-11 rounded-full transition-colors duration-200 ease-in-out cursor-pointer ml-4"
                                     :class="settings.job_alerts ? 'bg-gray-900' : 'bg-gray-300'"
                                     @click="settings.job_alerts = !settings.job_alerts">
                                    <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow-lg transition duration-200 ease-in-out mt-0.5 ml-0.5"
                                          :class="settings.job_alerts ? 'translate-x-5' : 'translate-x-0'"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="pt-6 border-t border-gray-200 flex flex-col sm:flex-row gap-3">
                        <button @click="saveSettings()"
                                :disabled="saving"
                                class="flex-1 relative overflow-hidden group bg-gray-900 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 hover:scale-[1.02] hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                            <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></span>
                            <span x-show="!saving">
                                <i class="fas fa-save mr-2"></i>Save All Settings
                            </span>
                            <span x-show="saving">
                                <i class="fas fa-spinner fa-spin mr-2"></i>Saving...
                            </span>
                        </button>
                        <button @click="resetSettings()"
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200">
                            <i class="fas fa-undo mr-2"></i>Reset to Defaults
                        </button>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-red-50 border border-red-200 rounded-xl p-6" x-show="!loading">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-red-900">Danger Zone</h3>
                        <p class="text-sm text-red-700 mt-1">Deleting your account is permanent and cannot be undone.</p>
                        <div class="flex flex-wrap gap-3 mt-4">
                            <button @click="confirmDelete()" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200 hover:shadow-lg">
                                <i class="fas fa-trash mr-2"></i>Delete Account
                            </button>
                            <button @click="confirmDeactivate()" class="inline-flex items-center px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-all duration-200">
                                <i class="fas fa-pause mr-2"></i>Deactivate Account
                            </button>
                        </div>
                    </div>
                    <div class="hidden sm:block">
                        <i class="fas fa-exclamation-triangle text-4xl text-red-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function settingsPage() {
    return {
        activeTab: 'notifications',
        settings: {
            email_notifications: true,
            marketing_emails: false,
            application_updates: true,
            profile_visibility: true,
            show_email: false,
            data_sharing: true,
            two_factor: false,
            language: 'en',
            timezone: 'UTC',
            job_alerts: true
        },
        defaultSettings: {},
        loading: false,
        saving: false,
        error: '',
        success: '',
        lastSaved: 'Never',

        init() {
            this.defaultSettings = { ...this.settings };
            this.loadSettings();
        },

        async loadSettings() {
            this.loading = true;
            this.error = '';
            try {
                const token = localStorage.getItem('token');
                if (!token) return;

                // In a real app, fetch settings from API
                // For demo, we'll use localStorage
                const saved = localStorage.getItem('user_settings');
                if (saved) {
                    this.settings = { ...this.settings, ...JSON.parse(saved) };
                }
                this.lastSaved = new Date().toLocaleString();
            } catch (error) {
                console.error('Error loading settings:', error);
            } finally {
                this.loading = false;
            }
        },

        async saveSettings() {
            this.error = '';
            this.success = '';
            this.saving = true;

            try {
                // In a real app, save to API
                // For demo, save to localStorage
                localStorage.setItem('user_settings', JSON.stringify(this.settings));
                this.lastSaved = new Date().toLocaleString();
                this.success = 'Settings saved successfully!';

                setTimeout(() => {
                    this.success = '';
                }, 3000);
            } catch (error) {
                this.error = 'Failed to save settings. Please try again.';
            } finally {
                this.saving = false;
            }
        },

        resetSettings() {
            if (confirm('Are you sure you want to reset all settings to defaults?')) {
                this.settings = { ...this.defaultSettings };
                this.success = 'Settings reset to defaults';
                setTimeout(() => {
                    this.success = '';
                }, 3000);
            }
        },

        confirmDelete() {
            if (confirm('⚠️ Are you sure you want to delete your account? This cannot be undone.')) {
                if (confirm('This is your last chance. All your data will be permanently removed. Continue?')) {
                    if (confirm('Type "DELETE" to confirm')) {
                        // In a real app, call delete API
                        console.log('Account deleted');
                        localStorage.removeItem('token');
                        localStorage.removeItem('user');
                        localStorage.removeItem('user_settings');
                        window.location.href = '/auth/login';
                    }
                }
            }
        },

        confirmDeactivate() {
            if (confirm('Are you sure you want to deactivate your account? You can reactivate later.')) {
                // In a real app, call deactivate API
                console.log('Account deactivated');
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                window.location.href = '/auth/login';
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

    /* Toggle switch */
    .relative {
        transition: background-color 0.2s ease;
    }

    .relative .inline-block {
        transition: transform 0.2s ease;
    }

    /* Tab hover */
    .border-b-2 {
        transition: all 0.2s ease;
    }

    /* Danger zone hover */
    .hover\:shadow-lg:hover {
        transform: translateY(-2px);
    }
</style>
@endsection
