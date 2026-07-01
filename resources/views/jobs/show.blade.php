@extends('layouts.app')

@section('title', 'Job Details - JobHub')

@section('content')
<div class="min-h-screen bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="jobShowPage()" x-init="init()">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <button onclick="history.back()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-all duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </button>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('jobs.index') }}" class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition-all duration-200">
                    Browse Jobs
                </a>
            </div>
        </div>

        <!-- Loading -->
        <div x-show="loading" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <div class="inline-block">
                <i class="fas fa-spinner fa-spin text-4xl text-gray-400"></i>
            </div>
            <p class="text-gray-600 mt-4">Loading job details...</p>
        </div>

        <!-- Error -->
        <div x-show="error" class="bg-red-50 border border-red-200 rounded-xl p-4 text-red-700 flex items-start" x-cloak>
            <i class="fas fa-exclamation-circle mr-3 mt-0.5 text-red-500"></i>
            <div class="flex-1">
                <p class="font-medium">Error</p>
                <p class="text-sm">${error}</p>
            </div>
        </div>

        <!-- Content -->
        <div x-show="!loading && !error" class="space-y-6" x-cloak>
            <!-- Header Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-7">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-briefcase text-gray-600 text-2xl"></i>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900" x-text="job?.title || 'Job'></h1>

                                <p class="text-gray-600 mt-1" x-text="job?.company_name ? ('Company: ' + job.company_name) : (job?.company?.name || 'Company')"></p>

                                <div class="flex flex-wrap items-center gap-2 mt-3">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                        <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                                        <span x-text="job?.city || 'N/A'"></span>
                                    </span>

                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                        <i class="fas fa-briefcase mr-2 text-blue-400"></i>
                                        <span x-text="(job?.job_type ? job.job_type.replace('_',' ').toUpperCase() : 'N/A')"></span>
                                    </span>

                                    <span :class="job?.status === 'open' ? 'bg-green-50 text-green-800 border-green-100' : 'bg-gray-100 text-gray-800 border-gray-200'" class="px-3 py-1 rounded-full text-xs font-medium border">
                                        <span x-text="(job?.status || 'open').toUpperCase()"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <template x-if="job?.status === 'open' && (userRole === 'candidate' || !userRole) && !hasApplied">
                                <button @click="openApplyModal()" :disabled="applying"
                                    class="px-5 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    <span x-text="applying ? 'Applying...' : 'Apply Now'"></span>
                                </button>
                            </template>
                            <template x-if="hasApplied">
                                <span class="inline-flex items-center px-5 py-3 bg-green-50 text-green-700 text-sm font-medium rounded-lg border border-green-100">
                                    <i class="fas fa-check-circle mr-2"></i>Applied
                                </span>
                            </template>
                            <div class="text-right">
                                <p class="text-xs text-gray-500">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    <span x-text="job?.created_at ? 'Posted ' + new Date(job.created_at).toLocaleDateString() : ''"></span>
                                </p>
                                <p class="text-xs text-gray-500" x-show="job?.deadline">
                                    <i class="far fa-clock mr-1"></i>
                                    <span x-text="job?.deadline ? 'Deadline: ' + new Date(job.deadline).toLocaleDateString() : ''"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Salary</p>
                    <p class="mt-2 text-gray-900 font-semibold" x-text="salaryText()"></p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Vacancies</p>
                    <p class="mt-2 text-gray-900 font-semibold" x-text="job?.vacancies ?? 'N/A'"></p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Category</p>
                    <p class="mt-2 text-gray-900 font-semibold" x-text="job?.category?.name || job?.category_name || 'N/A'"></p>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-7">
                <h2 class="text-xl font-semibold text-gray-900 mb-3">Job Description</h2>
                <div class="bg-gray-50 rounded-xl border border-gray-200 p-5">
                    <p class="text-gray-800 whitespace-pre-line" x-text="job?.description || 'No description available'"></p>
                </div>
            </div>

            <!-- Apply Form (optional, minimal - uses file upload if available elsewhere) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-7">
                <h2 class="text-xl font-semibold text-gray-900 mb-3">Quick Apply</h2>
                <p class="text-sm text-gray-600 mb-4">Use the Apply button to submit your application.</p>
                <p class="text-xs text-gray-500">Note: This project currently applies via API and expects resume upload elsewhere in your workflow.</p>
            </div>
        </div>

        <!-- Apply Modal -->
        <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" @click="showModal = false"></div>

            <!-- Modal Content -->
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden transform transition-all p-6 space-y-6"
                     @click.stop>
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                        <h3 class="text-xl font-bold text-gray-900">
                            <i class="fas fa-paper-plane mr-2 text-gray-500"></i>Apply for Job
                        </h3>
                        <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>

                    <div x-show="modalError" class="p-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm flex items-start">
                        <i class="fas fa-exclamation-circle mr-2 mt-0.5 text-red-500"></i>
                        <span x-text="modalError"></span>
                    </div>

                    <div class="space-y-4">
                        <!-- Resume Upload -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Upload Resume <span class="text-red-500">*</span>
                            </label>
                            <label class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-xl p-6 cursor-pointer hover:border-gray-500 transition-all hover:bg-gray-50">
                                <div class="text-center">
                                    <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-600 font-medium">Click to select resume</p>
                                    <p class="text-xs text-gray-500">PDF, DOC, DOCX up to 5MB</p>
                                    <p x-show="resumeFile" class="text-sm text-green-600 font-medium mt-2">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        <span x-text="resumeFile ? resumeFile.name : ''"></span>
                                    </p>
                                </div>
                                <input type="file" accept=".pdf,.doc,.docx" @change="handleResumeSelect($event)" class="hidden">
                            </label>
                        </div>

                        <!-- Cover Letter -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Cover Letter <span class="text-xs font-normal text-gray-500">(Optional)</span>
                            </label>
                            <textarea x-model="coverLetter" placeholder="Write a brief cover letter..." rows="4"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all resize-none"></textarea>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                        <button @click="submitApplication()" :disabled="applying"
                                class="flex-1 bg-gray-900 hover:bg-gray-800 text-white font-semibold py-3 px-6 rounded-xl transition-all hover:scale-[1.02] hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                            <span x-show="!applying">
                                <i class="fas fa-paper-plane mr-2"></i>Submit Application
                            </span>
                            <span x-show="applying">
                                <i class="fas fa-spinner fa-spin mr-2"></i>Applying...
                            </span>
                        </button>
                        <button @click="showModal = false" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-all">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function jobShowPage() {
    return {
        job: null,
        loading: true,
        applying: false,
        error: '',
        userRole: null,
        showModal: false,
        modalError: '',
        resumeFile: null,
        coverLetter: '',
        hasApplied: false, // Track if already applied

        init() {
            this.loadUserRole();
            this.fetchJob();
            this.checkIfApplied();
        },

        loadUserRole() {
            const userStr = localStorage.getItem('user');
            if (userStr) {
                try {
                    const user = JSON.parse(userStr);
                    this.userRole = user.role;
                } catch (e) {}
            }
        },

        async checkIfApplied() {
            if (this.userRole !== 'candidate') return;

            try {
                const parts = window.location.pathname.split('/').filter(Boolean);
                const jobId = parseInt(parts[parts.length - 1]);

                const token = localStorage.getItem('token');
                const response = await axios.get('/api/candidate/applications', {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                if (response.data.status && Array.isArray(response.data.data)) {
                    this.hasApplied = response.data.data.some(app => app.job_id === jobId);
                }
            } catch (error) {
                console.error('Error checking if applied:', error);
            }
        },

        salaryText() {
            if (this.job?.min_salary && this.job?.max_salary) {
                return '$' + this.job.min_salary + ' - $' + this.job.max_salary;
            }
            if (this.job?.min_salary || this.job?.max_salary) {
                return (this.job.min_salary ? '$' + this.job.min_salary : 'Negotiable') + ' - ' + (this.job.max_salary ? '$' + this.job.max_salary : '');
            }
            return 'Negotiable';
        },

        async fetchJob() {
            this.loading = true;
            this.error = '';

            try {
                // Current job id from URL: /jobs/{id}
                const parts = window.location.pathname.split('/').filter(Boolean);
                const id = parts[parts.length - 1];

                const response = await axios.get('/api/jobs/' + id);
                if (!response.data?.status) {
                    throw new Error(response.data?.message || 'Failed to load job');
                }

                // Your API might return:
                // - data: { ...job } OR data: [ { ...job } ]
                const payload = response.data.data;
                if (Array.isArray(payload)) {
                    this.job = payload[0] || null;
                } else {
                    this.job = payload || null;
                }

                if (!this.job) {
                    throw new Error('Job not found');
                }
            } catch (e) {
                console.error(e);
                this.error = e?.message || 'Failed to load job';
            } finally {
                this.loading = false;
            }
        },

        openApplyModal() {
            if (!this.userRole) {
                window.location.href = '/auth/login';
                return;
            }
            if (this.userRole !== 'candidate') {
                alert('Only candidates can apply for jobs');
                return;
            }
            this.showModal = true;
            this.modalError = '';
            this.resumeFile = null;
            this.coverLetter = '';
        },

        handleResumeSelect(event) {
            const file = event.target.files[0];
            if (file) {
                this.resumeFile = file;
            }
        },

        async submitApplication() {
            this.modalError = '';
            if (!this.resumeFile) {
                this.modalError = 'Please upload your resume';
                return;
            }

            this.applying = true;

            try {
                const formData = new FormData();
                formData.append('job_id', this.job.id);
                formData.append('resume', this.resumeFile);
                if (this.coverLetter) {
                    formData.append('cover_letter', this.coverLetter);
                }

                const token = localStorage.getItem('token');
                const response = await axios.post('/api/candidate/jobs/' + this.job.id + '/apply', formData, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'multipart/form-data'
                    }
                });

                if (response.data?.status) {
                    this.showModal = false;
                    this.hasApplied = true; // Mark as applied
                    alert('Application submitted successfully!');
                    // Store applied job ID in sessionStorage to mark as applied on return
                    const appliedJobs = JSON.parse(sessionStorage.getItem('appliedJobs') || '[]');
                    appliedJobs.push(this.job.id);
                    sessionStorage.setItem('appliedJobs', JSON.stringify(appliedJobs));
                    // Redirect back to jobs list after 1 second
                    setTimeout(() => {
                        window.location.href = '/jobs';
                    }, 1000);
                } else {
                    this.modalError = response.data?.message || 'Failed to submit application';
                }
            } catch (e) {
                console.error(e);
                this.modalError = e?.response?.data?.message || e?.response?.data?.errors?.resume?.[0] || 'Failed to submit application';
            } finally {
                this.applying = false;
            }
        }
    }
}
</script>
@endsection

