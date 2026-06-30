@extends('layouts.app')

@section('title', 'Edit Job - JobHub')

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
            <div class="max-w-3xl mx-auto" x-data="jobEditForm()" x-init="loadCategories(); loadJob()">
                <div class="space-y-6">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <button onclick="history.back()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-all duration-200 hover:shadow-md mb-4">
                                <i class="fas fa-arrow-left mr-2"></i>Back
                            </button>
                            <h1 class="text-3xl font-bold text-gray-900">Edit Job Listing</h1>
                            <p class="text-gray-600 mt-1 flex items-center gap-2">
                                <i class="fas fa-circle text-[6px] text-gray-300"></i>
                                Update your job listing details
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-clock mr-1"></i>
                                <span x-text="new Date().toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })"></span>
                            </span>
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

                    <!-- Form -->
                    <form @submit.prevent="submitForm()" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
                        <!-- Job Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-briefcase mr-2 text-gray-400"></i>Job Title
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-briefcase text-gray-400"></i>
                                </div>
                                <input
                                    type="text"
                                    x-model="form.title"
                                    placeholder="e.g., Senior React Developer"
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                    required
                                    minlength="5"
                                    maxlength="100"
                                >
                            </div>
                            <p class="text-xs text-gray-500 mt-1" x-text="(form.title?.length || 0) + '/100 characters'"></p>
                        </div>

                        <!-- Job Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-align-left mr-2 text-gray-400"></i>Job Description
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                                    <i class="fas fa-align-left text-gray-400"></i>
                                </div>
                                <textarea
                                    x-model="form.description"
                                    placeholder="Describe the job, responsibilities, requirements, and benefits..."
                                    rows="6"
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 resize-y"
                                    required
                                    minlength="20"
                                ></textarea>
                            </div>
                            <p class="text-xs text-gray-500 mt-1" x-text="(form.description?.length || 0) + ' characters (minimum 20)'"></p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Category -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-tag mr-2 text-gray-400"></i>Category
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-tag text-gray-400"></i>
                                    </div>
                                    <select
                                        x-model="form.category_id"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 appearance-none bg-white"
                                        required
                                    >
                                        <option value="">Select Category</option>
                                        <template x-for="cat in categories" :key="cat.id">
                                            <option :value="cat.id" x-text="cat.name"></option>
                                        </template>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Job Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-clock mr-2 text-gray-400"></i>Job Type
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-clock text-gray-400"></i>
                                    </div>
                                    <select
                                        x-model="form.job_type"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 appearance-none bg-white"
                                        required
                                    >
                                        <option value="">Select Type</option>
                                        <option value="full_time">Full Time</option>
                                        <option value="part_time">Part Time</option>
                                        <option value="remote">Remote</option>
                                        <option value="contract">Contract</option>
                                        <option value="internship">Internship</option>
                                        <option value="freelance">Freelance</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- City -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>City
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    </div>
                                    <select
                                        x-model="form.city"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 appearance-none bg-white"
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
                                        <option value="Remote">Remote</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Vacancies -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-users mr-2 text-gray-400"></i>Vacancies
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-users text-gray-400"></i>
                                    </div>
                                    <input
                                        type="number"
                                        x-model.number="form.vacancies"
                                        placeholder="1"
                                        min="1"
                                        max="100"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                        required
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Salary Range -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-md font-semibold text-gray-900 mb-4">
                                <i class="fas fa-dollar-sign mr-2 text-gray-400"></i>Compensation
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Min Salary -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Minimum Salary
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-400 font-medium">$</span>
                                        </div>
                                        <input
                                            type="number"
                                            x-model.number="form.min_salary"
                                            placeholder="30000"
                                            min="0"
                                            step="1000"
                                            class="w-full pl-8 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                        >
                                    </div>
                                </div>

                                <!-- Max Salary -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Maximum Salary
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-400 font-medium">$</span>
                                        </div>
                                        <input
                                            type="number"
                                            x-model.number="form.max_salary"
                                            placeholder="50000"
                                            min="0"
                                            step="1000"
                                            class="w-full pl-8 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                        >
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Leave blank if you prefer to discuss compensation during interviews
                            </p>
                        </div>

                        <!-- Deadline -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-md font-semibold text-gray-900 mb-4">
                                <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>Application Deadline
                            </h3>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Deadline Date
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-alt text-gray-400"></i>
                                    </div>
                                    <input
                                        type="date"
                                        x-model="form.deadline"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                        required
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                            <button
                                type="submit"
                                :disabled="loading"
                                class="flex-1 relative overflow-hidden group bg-gray-900 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 hover:scale-[1.02] hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></span>
                                <span x-show="!loading">
                                    <i class="fas fa-save mr-2"></i>Update Job
                                </span>
                                <span x-show="loading">
                                    <i class="fas fa-spinner fa-spin mr-2"></i>Updating...
                                </span>
                            </button>
                            <button
                                type="button"
                                onclick="window.location.href='/employer/jobs'"
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
</div>

<script>
function jobEditForm() {
    // Get job ID from URL
    const pathParts = window.location.pathname.split('/');
    const jobId = pathParts[pathParts.length - 1];

    return {
        jobId: jobId,
        form: {
            title: '',
            description: '',
            category_id: '',
            job_type: '',
            city: '',
            min_salary: '',
            max_salary: '',
            vacancies: 1,
            deadline: ''
        },
        categories: [],
        loading: false,
        error: '',
        success: '',

        async loadCategories() {
            try {
                const response = await axios.get('/api/categories');
                if (response.data.success) {
                    this.categories = response.data.data;
                }
            } catch (error) {
                console.error('Error loading categories:', error);
            }
        },

        async loadJob() {
            try {
                const token = localStorage.getItem('token');
                if (!token) {
                    window.location.href = '/auth/login';
                    return;
                }

                const response = await axios.get(`/api/employer/jobs/${this.jobId}`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                if (response.data.success) {
                    const job = response.data.data;
                    this.form = {
                        title: job.title,
                        description: job.description,
                        category_id: job.category_id,
                        job_type: job.job_type,
                        city: job.city,
                        min_salary: job.min_salary,
                        max_salary: job.max_salary,
                        vacancies: job.vacancies,
                        deadline: job.deadline ? job.deadline.split('T')[0] : ''
                    };
                } else {
                    this.error = response.data.message || 'Failed to load job details';
                    setTimeout(() => {
                        window.location.href = '/employer/jobs';
                    }, 1500);
                }
            } catch (error) {
                console.error('Error loading job:', error);
                this.error = 'Failed to load job details';
            }
        },

        async submitForm() {
            this.error = '';
            this.success = '';

            // Validation
            if (!this.form.title || this.form.title.length < 5) {
                this.error = 'Please enter a job title (minimum 5 characters)';
                return;
            }

            if (!this.form.description || this.form.description.length < 20) {
                this.error = 'Please enter a job description (minimum 20 characters)';
                return;
            }

            if (!this.form.category_id) {
                this.error = 'Please select a category';
                return;
            }

            if (!this.form.job_type) {
                this.error = 'Please select a job type';
                return;
            }

            if (!this.form.city) {
                this.error = 'Please select a city';
                return;
            }

            if (!this.form.vacancies || this.form.vacancies < 1) {
                this.error = 'Please enter a valid number of vacancies (minimum 1)';
                return;
            }

            if (!this.form.deadline) {
                this.error = 'Please select a deadline date';
                return;
            }

            // Check if min salary > max salary
            if (this.form.min_salary && this.form.max_salary && this.form.min_salary > this.form.max_salary) {
                this.error = 'Minimum salary cannot be greater than maximum salary';
                return;
            }

            this.loading = true;

            try {
                const token = localStorage.getItem('token');
                if (!token) {
                    window.location.href = '/auth/login';
                    return;
                }

                const response = await axios.put(`/api/employer/jobs/${this.jobId}`, this.form, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (response.data.success) {
                    this.success = 'Job updated successfully! Redirecting...';
                    setTimeout(() => {
                        window.location.href = '/employer/jobs';
                    }, 1500);
                } else {
                    this.error = response.data.message || 'Failed to update job';
                }
            } catch (error) {
                if (error.response?.status === 401) {
                    window.location.href = '/auth/login';
                } else if (error.response?.data?.errors) {
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

    /* Input focus */
    input:focus, textarea:focus, select:focus {
        box-shadow: 0 0 0 3px rgba(17, 24, 39, 0.1);
    }

    /* Number input arrows */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endsection
