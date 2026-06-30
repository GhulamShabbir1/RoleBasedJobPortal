@extends('layouts.app')

@section('title', 'Edit My Profile - JobHub')

@section('content')
<div class="min-h-screen bg-white">
    <div class="flex gap-0">
        <!-- Sidebar -->
        @include('components.candidate-sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-gray-50 min-h-screen">
            <div class="max-w-4xl mx-auto" x-data="candidateProfileForm()" x-init="loadProfile()">
                <div class="space-y-6">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Edit My Profile</h1>
                            <p class="text-gray-600 mt-1">Update your profile information</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-check-circle mr-1 text-green-500"></i> Profile Completion: <span x-text="getCompletionPercentage() + '%'"></span>
                            </span>
                        </div>
                    </div>

                    <!-- Profile Completion Progress -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                    <span>Profile Completion</span>
                                    <span x-text="getCompletionPercentage() + '%'"></span>
                                </div>
                                <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-gray-700 to-gray-900 rounded-full transition-all duration-500" :style="{ width: getCompletionPercentage() + '%' }"></div>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900" x-text="getCompletionPercentage() + '%'"></div>
                        </div>
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

                    <!-- Loading State -->
                    <div x-show="loading" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                        <div class="inline-block">
                            <i class="fas fa-spinner fa-spin text-4xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-600 mt-4">Loading your profile...</p>
                    </div>

                    <!-- Form -->
                    <form @submit.prevent="submitForm()" x-show="!loading" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
                        <!-- Personal Information Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-user mr-2 text-gray-500"></i>Personal Information
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name (Read-only) -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-user mr-2"></i>Full Name
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                        <input
                                            type="text"
                                            :value="userName"
                                            disabled
                                            class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-gray-600 cursor-not-allowed"
                                        >
                                    </div>
                                </div>

                                <!-- Email (Read-only) -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-envelope mr-2"></i>Email Address
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-envelope text-gray-400"></i>
                                        </div>
                                        <input
                                            type="email"
                                            :value="userEmail"
                                            disabled
                                            class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-gray-600 cursor-not-allowed"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-address-card mr-2 text-gray-500"></i>Contact Information
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Phone -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-phone mr-2"></i>Phone Number
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-phone text-gray-400"></i>
                                        </div>
                                        <input
                                            type="tel"
                                            x-model="form.phone"
                                            placeholder="+92 3XX XXXXXXX"
                                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                            required
                                        >
                                    </div>
                                </div>

                                <!-- City -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-map-marker-alt mr-2"></i>City
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-map-marker-alt text-gray-400"></i>
                                        </div>
                                        <select
                                            x-model="form.city"
                                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 appearance-none bg-white"
                                            required
                                        >
                                            <option value="">Select City</option>
                                            <option value="Lahore">Lahore</option>
                                            <option value="Karachi">Karachi</option>
                                            <option value="Islamabad">Islamabad</option>
                                            <option value="Rawalpindi">Rawalpindi</option>
                                            <option value="Faisalabad">Faisalabad</option>
                                            <option value="Multan">Multan</option>
                                            <option value="Peshawar">Peshawar</option>
                                            <option value="Quetta">Quetta</option>
                                            <option value="Hyderabad">Hyderabad</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class="fas fa-chevron-down text-gray-400"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Skills Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-semibold text-gray-900">
                                    <i class="fas fa-star mr-2 text-gray-500"></i>Skills
                                    <span class="text-sm font-normal text-gray-500">(Add your key skills)</span>
                                </h2>
                                <span class="text-sm text-gray-500" x-text="form.skills.length + ' skills'"></span>
                            </div>
                            <div class="space-y-3">
                                <div class="flex gap-2">
                                    <div class="flex-1 relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-plus-circle text-gray-400"></i>
                                        </div>
                                        <input
                                            type="text"
                                            x-model="newSkill"
                                            placeholder="Add a skill (e.g., React, Python, etc.)"
                                            @keyup.enter="addSkill()"
                                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                        >
                                    </div>
                                    <button type="button" @click="addSkill()" class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-all duration-200 hover:shadow-md whitespace-nowrap">
                                        <i class="fas fa-plus mr-1"></i>Add
                                    </button>
                                </div>

                                <div class="flex flex-wrap gap-2 min-h-[40px] p-2 bg-gray-50 rounded-lg border border-gray-200">
                                    <template x-for="(skill, index) in form.skills" :key="index">
                                        <span class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-200 text-gray-700 rounded-full text-sm shadow-sm hover:shadow-md transition-all duration-200">
                                            <i class="fas fa-tag mr-1.5 text-gray-400"></i>
                                            <span x-text="skill"></span>
                                            <button type="button" @click="removeSkill(index)" class="ml-2 text-gray-400 hover:text-red-500 transition-colors">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </span>
                                    </template>
                                    <template x-if="form.skills.length === 0">
                                        <span class="text-gray-400 text-sm">No skills added yet. Start typing above!</span>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Professional Information Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-briefcase mr-2 text-gray-500"></i>Professional Information
                            </h2>

                            <!-- Experience -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-briefcase mr-2"></i>Work Experience
                                    <span class="text-red-500">*</span>
                                </label>
                                <textarea
                                    x-model="form.experience"
                                    placeholder="Tell us about your work experience..."
                                    rows="4"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 resize-y"
                                    required
                                ></textarea>
                                <p class="text-xs text-gray-500 mt-1">Include your previous roles, companies, and key achievements</p>
                            </div>

                            <!-- Education -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-graduation-cap mr-2"></i>Education
                                </label>
                                <textarea
                                    x-model="form.education"
                                    placeholder="Your educational background..."
                                    rows="3"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 resize-y"
                                ></textarea>
                            </div>
                        </div>

                        <!-- Resume Upload Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-file-alt mr-2 text-gray-500"></i>Resume / CV
                            </h2>
                            <div class="space-y-3">
                                <!-- Current Resume -->
                                <div x-show="form.resume_url" class="p-3 bg-green-50 border border-green-200 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <i class="fas fa-file-pdf text-2xl text-green-600"></i>
                                            <div>
                                                <p class="font-medium text-gray-900">Current Resume</p>
                                                <p class="text-sm text-gray-600" x-text="form.resume_url.split('/').pop() || 'Resume.pdf'"></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <a :href="form.resume_url" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a :href="form.resume_url" download class="text-green-600 hover:text-green-800 text-sm font-medium flex items-center gap-1">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Upload New Resume -->
                                <label class="flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg p-8 cursor-pointer hover:border-gray-500 transition-all duration-200 hover:bg-gray-50"
                                    @dragover.prevent="dragOver = true"
                                    @dragleave.prevent="dragOver = false"
                                    @drop.prevent="handleFileDrop($event)"
                                    :class="dragOver ? 'border-gray-500 bg-gray-50' : ''"
                                >
                                    <div class="text-center">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <i class="fas fa-cloud-upload-alt text-2xl text-gray-400"></i>
                                        </div>
                                        <p class="text-gray-600 font-medium">Drag and drop or click to upload</p>
                                        <p class="text-xs text-gray-500 mt-1">PDF, DOC, DOCX up to 10MB</p>
                                        <p x-show="form.resume && form.resume.name" class="text-sm text-green-600 mt-2">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            <span x-text="form.resume ? form.resume.name : ''"></span>
                                        </p>
                                    </div>
                                    <input
                                        type="file"
                                        accept=".pdf,.doc,.docx"
                                        @change="handleFileSelect($event)"
                                        class="hidden"
                                        id="resume-upload"
                                    >
                                </label>
                            </div>
                        </div>

                        <!-- Submit Section -->
                        <div class="flex items-center gap-4 pt-4">
                            <button
                                type="submit"
                                :disabled="loading"
                                class="flex-1 relative overflow-hidden group bg-gray-900 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 hover:scale-[1.02] hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></span>
                                <span x-show="!loading">
                                    <i class="fas fa-save mr-2"></i>Update Profile
                                </span>
                                <span x-show="loading">
                                    <i class="fas fa-spinner fa-spin mr-2"></i>Updating...
                                </span>
                            </button>
                            <button type="button" @click="resetForm()" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200">
                                <i class="fas fa-undo mr-2"></i>Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function candidateProfileForm() {
    return {
        form: {
            phone: '',
            city: '',
            skills: [],
            experience: '',
            education: '',
            resume: null,
            resume_url: '',
            profile_id: null
        },
        newSkill: '',
        loading: false,
        error: '',
        success: '',
        dragOver: false,
        userName: '{{ auth()->user()->name ?? "" }}',
        userEmail: '{{ auth()->user()->email ?? "" }}',

        getCompletionPercentage() {
            const fields = [
                this.form.phone,
                this.form.city,
                this.form.skills.length > 0,
                this.form.experience,
                this.form.education,
                this.form.resume_url || this.form.resume
            ];
            const filled = fields.filter(f => f).length;
            return Math.round((filled / fields.length) * 100);
        },

        async loadProfile() {
            this.loading = true;
            try {
                const response = await axios.get('/api/candidate/profiles/me', {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });

                if (response.data.success && response.data.data) {
                    const data = response.data.data;
                    this.form = {
                        phone: data.phone || '',
                        city: data.city || '',
                        skills: data.skills ? data.skills.split(',').map(s => s.trim()).filter(s => s) : [],
                        experience: data.experience || '',
                        education: data.education || '',
                        resume: null,
                        resume_url: data.resume_url || '',
                        profile_id: data.id || null
                    };
                } else {
                    this.error = 'Failed to load profile. Redirecting to create profile...';
                    setTimeout(() => {
                        window.location.href = '/candidate/profile/create';
                    }, 2000);
                }
            } catch (error) {
                // 404 is expected when no profile exists - redirect to create
                if (error.response?.status === 404) {
                    setTimeout(() => {
                        window.location.href = '/candidate/profile/create';
                    }, 500);
                } else {
                    console.error('Error loading profile:', error);
                    this.error = 'Error loading profile. Please try again.';
                }
            } finally {
                this.loading = false;
            }
        },

        addSkill() {
            if (this.newSkill.trim() && !this.form.skills.includes(this.newSkill.trim())) {
                this.form.skills.push(this.newSkill.trim());
                this.newSkill = '';
            }
        },

        removeSkill(index) {
            this.form.skills.splice(index, 1);
        },

        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                this.form.resume = file;
                this.success = `File "${file.name}" selected for upload`;
                setTimeout(() => this.success = '', 3000);
            }
        },

        handleFileDrop(event) {
            this.dragOver = false;
            const files = event.dataTransfer.files;
            if (files.length) {
                this.form.resume = files[0];
                this.success = `File "${files[0].name}" selected for upload`;
                setTimeout(() => this.success = '', 3000);
            }
        },

        resetForm() {
            if (confirm('Are you sure you want to reset the form?')) {
                this.loadProfile();
                this.error = '';
                this.success = '';
                this.newSkill = '';
            }
        },

        async submitForm() {
            this.error = '';
            this.success = '';

            // Check if profile exists
            if (!this.form.profile_id) {
                this.error = 'No profile found. Please create a profile first.';
                setTimeout(() => {
                    window.location.href = '/candidate/profile/create';
                }, 2000);
                return;
            }

            // Validation
            if (!this.form.phone) {
                this.error = 'Please enter your phone number';
                return;
            }
            if (!this.form.city) {
                this.error = 'Please select your city';
                return;
            }
            if (!this.form.experience) {
                this.error = 'Please enter your work experience';
                return;
            }

            this.loading = true;

            try {
                const formData = new FormData();
                formData.append('phone', this.form.phone);
                formData.append('city', this.form.city);
                formData.append('skills', this.form.skills.join(','));
                formData.append('experience', this.form.experience);
                formData.append('education', this.form.education || '');

                if (this.form.resume) {
                    formData.append('resume', this.form.resume);
                }

                formData.append('_method', 'PUT');
                const response = await axios.post(`/api/candidate/profiles/${this.form.profile_id}`, formData, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')}`,
                        'Content-Type': 'multipart/form-data'
                    }
                });

                if (response.data.success) {
                    this.success = 'Profile updated successfully!';
                    // Update resume_url if new file was uploaded
                    if (response.data.data?.resume_url) {
                        this.form.resume_url = response.data.data.resume_url;
                    }
                    this.form.resume = null;
                    setTimeout(() => {
                        window.location.href = '/dashboard/candidate';
                    }, 2000);
                } else {
                    this.error = response.data.message || 'Failed to update profile';
                }
            } catch (error) {
                const errors = error.response?.data?.errors;
                if (errors) {
                    this.error = Object.values(errors).flat().join(', ');
                } else {
                    this.error = error.response?.data?.message || 'An error occurred. Please try again.';
                }
            } finally {
                this.loading = false;
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

    /* Smooth Transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }

    /* File input styling */
    input[type="file"] {
        cursor: pointer;
    }

    /* Drag and drop highlight */
    .border-dashed {
        transition: all 0.3s ease;
    }
</style>
@endsection
