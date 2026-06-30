@extends('layouts.app')

@section('title', 'Manage Company - JobHub')

@section('content')
<div class="min-h-screen bg-white">
    <div class="flex gap-0">
        <!-- Sidebar -->
        @include('components.employer-sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-gray-50 min-h-screen">
            <div class="max-w-4xl mx-auto" x-data="employerCompanyPage()" x-init="loadCompany()">
                <div class="space-y-6">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <button onclick="history.back()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-all duration-200 hover:shadow-md mb-4">
                                <i class="fas fa-arrow-left mr-2"></i>Back
                            </button>
                            <h1 class="text-3xl font-bold text-gray-900">My Company</h1>
                            <p class="text-gray-600 mt-1">Manage your company profile here</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button @click="loadCompany()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 hover:shadow-md">
                                <i class="fas fa-redo mr-2"></i>Refresh
                            </button>
                        </div>
                    </div>

                    <!-- Loading State -->
                    <div x-show="loading" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                        <div class="inline-block">
                            <i class="fas fa-spinner fa-spin text-4xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-600 mt-4">Loading your company...</p>
                    </div>

                    <!-- No Company State (Show Form) -->
                    <div x-show="!loading && !company" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                        <div class="text-center mb-8">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-building text-gray-400 text-4xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Create Your Company Profile</h2>
                            <p class="text-gray-600">Fill in the details below to register your company</p>
                        </div>
                        <form @submit.prevent="createCompany()" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-building mr-1"></i>Company Name <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        x-model="form.name"
                                        placeholder="Enter company name"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                        required
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-envelope mr-1"></i>Company Email <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        x-model="form.email"
                                        placeholder="Enter company email"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                        required
                                    >
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-map-marker-alt mr-1"></i>City <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        x-model="form.city"
                                        placeholder="Enter city"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                        required
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-phone mr-1"></i>Phone
                                    </label>
                                    <input
                                        type="text"
                                        x-model="form.phone"
                                        placeholder="Enter phone number"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-globe mr-1"></i>Website
                                </label>
                                <input
                                    type="url"
                                    x-model="form.website"
                                    placeholder="https://yourcompany.com"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                >
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-map-marker-alt mr-1"></i>State
                                    </label>
                                    <input
                                        type="text"
                                        x-model="form.state"
                                        placeholder="Enter state"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-globe-americas mr-1"></i>Country
                                    </label>
                                    <input
                                        type="text"
                                        x-model="form.country"
                                        placeholder="Enter country"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-map mr-1"></i>Address
                                    </label>
                                    <input
                                        type="text"
                                        x-model="form.address"
                                        placeholder="Enter address"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-file-alt mr-1"></i>Description <span class="text-red-500">*</span>
                                </label>
                                <textarea
                                    x-model="form.description"
                                    placeholder="Tell us about your company"
                                    rows="4"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 resize-none"
                                    required
                                ></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-image mr-1"></i>Company Logo
                                    </label>
                                    <input
                                        type="file"
                                        @change="handleLogoUpload($event)"
                                        accept="image/*"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                    >
                                    <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF (Max 5MB)</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-certificate mr-1"></i>Certification
                                    </label>
                                    <input
                                        type="file"
                                        @change="handleCertUpload($event)"
                                        accept=".pdf,.jpg,.jpeg,.png"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                    >
                                    <p class="text-xs text-gray-500 mt-1">PDF, JPG, PNG (Max 10MB)</p>
                                </div>
                            </div>

                            <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                                <button
                                    type="submit"
                                    :disabled="saving"
                                    class="px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl disabled:bg-gray-400 disabled:cursor-not-allowed"
                                >
                                    <i class="fas fa-check mr-2"></i>
                                    <span x-text="saving ? 'Saving...' : 'Create Company'"></span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Company Exists State (Show Details + Edit Button) -->
                    <div x-show="!loading && company" class="space-y-6">
                        <!-- Company Header Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                        <div class="flex flex-col md:flex-row gap-8">
                            <div class="flex-shrink-0">
                                <div class="w-32 h-32 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden">
                                    <img x-show="company.logo" :src="company.logo ? '/storage/' + company.logo : ''" class="w-full h-full object-cover" alt="Company Logo">
                                    <i x-show="!company.logo" class="fas fa-building text-gray-400 text-4xl"></i>
                                </div>
                            </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-4 mb-4">
                                        <h2 class="text-2xl font-bold text-gray-900" x-text="company.name"></h2>
                                        <span :class="getStatusClass(company.status)" class="px-3 py-1 rounded-full text-xs font-medium">
                                            <span x-text="company.status?.toUpperCase() || 'PENDING'"></span>
                                        </span>
                                    </div>
                                    <p class="text-gray-600 mb-4" x-text="company.description"></p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                        <div class="flex items-center gap-2 text-gray-600">
                                            <i class="fas fa-map-marker-alt text-gray-400"></i>
                                            <span x-text="company.city || 'N/A'"></span>
                                        </div>
                                        <div class="flex items-center gap-2 text-gray-600">
                                            <i class="fas fa-phone text-gray-400"></i>
                                            <span x-text="company.phone || 'N/A'"></span>
                                        </div>
                                        <div class="flex items-center gap-2 text-gray-600">
                                            <i class="fas fa-globe text-gray-400"></i>
                                            <a x-show="company.website" :href="company.website" target="_blank" class="text-blue-600 hover:underline" x-text="company.website"></a>
                                            <span x-show="!company.website">N/A</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-gray-600">
                                            <i class="fas fa-calendar text-gray-400"></i>
                                            <span x-text="company.created_at ? new Date(company.created_at).toLocaleDateString() : 'N/A'"></span>
                                        </div>
                                    </div>
                                    <div class="mt-6 flex gap-4">
                                        <button @click="showEditForm = true" class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-all duration-200 shadow-md hover:shadow-lg">
                                            <i class="fas fa-edit mr-2"></i>Edit Company
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Company Form (Modal/Inline) -->
                        <div x-show="showEditForm" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-xl font-bold text-gray-900">Edit Company Details</h2>
                                <button @click="showEditForm = false; resetForm()" class="text-gray-400 hover:text-gray-600 transition-colors">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>
                            <form @submit.prevent="updateCompany()" class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-building mr-1"></i>Company Name <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            x-model="form.name"
                                            placeholder="Enter company name"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                            required
                                        >
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-envelope mr-1"></i>Company Email <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="email"
                                            x-model="form.email"
                                            placeholder="Enter company email"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                            required
                                        >
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-map-marker-alt mr-1"></i>City <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            x-model="form.city"
                                            placeholder="Enter city"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                            required
                                        >
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-phone mr-1"></i>Phone
                                        </label>
                                        <input
                                            type="text"
                                            x-model="form.phone"
                                            placeholder="Enter phone number"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                        >
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-globe mr-1"></i>Website
                                    </label>
                                    <input
                                        type="url"
                                        x-model="form.website"
                                        placeholder="https://yourcompany.com"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                    >
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-map-marker-alt mr-1"></i>State
                                        </label>
                                        <input
                                            type="text"
                                            x-model="form.state"
                                            placeholder="Enter state"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                        >
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-globe-americas mr-1"></i>Country
                                        </label>
                                        <input
                                            type="text"
                                            x-model="form.country"
                                            placeholder="Enter country"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                        >
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-map mr-1"></i>Address
                                        </label>
                                        <input
                                            type="text"
                                            x-model="form.address"
                                            placeholder="Enter address"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                        >
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-file-alt mr-1"></i>Description <span class="text-red-500">*</span>
                                    </label>
                                    <textarea
                                        x-model="form.description"
                                        placeholder="Tell us about your company"
                                        rows="4"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 resize-none"
                                        required
                                    ></textarea>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-image mr-1"></i>Update Logo
                                        </label>
                                        <input
                                            type="file"
                                            @change="handleLogoUpload($event)"
                                            accept="image/*"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                        >
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-certificate mr-1"></i>Update Certification
                                        </label>
                                        <input
                                            type="file"
                                            @change="handleCertUpload($event)"
                                            accept=".pdf,.jpg,.jpeg,.png"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                        >
                                    </div>
                                </div>

                                <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                                    <button type="button" @click="showEditForm = false; resetForm()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200">
                                        Cancel
                                    </button>
                                    <button
                                        type="submit"
                                        :disabled="saving"
                                        class="px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl disabled:bg-gray-400 disabled:cursor-not-allowed"
                                    >
                                        <i class="fas fa-check mr-2"></i>
                                        <span x-text="saving ? 'Updating...' : 'Update Company'"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function employerCompanyPage() {
    return {
        company: null,
        loading: false,
        saving: false,
        showEditForm: false,
        form: {
            name: '',
            email: '',
            city: '',
            phone: '',
            website: '',
            address: '',
            state: '',
            country: '',
            description: '',
            logo: null,
            certificate: null
        },

        getStatusClass(status) {
            const classes = {
                'pending': 'bg-yellow-100 text-yellow-800',
                'approved': 'bg-green-100 text-green-800',
                'rejected': 'bg-red-100 text-red-800'
            };
            return classes[status] || 'bg-gray-100 text-gray-800';
        },

        async loadCompany() {
            this.loading = true;
            try {
                const authHeaders = {
                    headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
                };
                const response = await axios.get('/api/employer/my-company-status', authHeaders);

                if (response.data.success) {
                    const statusData = response.data.data;
                    // Extract company from nested structure
                    if (statusData.company_found && statusData.company) {
                        this.company = statusData.company;
                        this.fillForm();
                    } else {
                        this.company = null;
                    }
                } else {
                    this.company = null;
                }
            } catch (error) {
                console.error('Error loading company:', error);
                this.company = null;
            } finally {
                this.loading = false;
            }
        },

        fillForm() {
            if (!this.company) return;
            this.form = {
                name: this.company.name || '',
                email: this.company.email || '',
                city: this.company.city || '',
                phone: this.company.phone || '',
                website: this.company.website || '',
                address: this.company.address || '',
                state: this.company.state || '',
                country: this.company.country || '',
                description: this.company.description || '',
                logo: null,
                certificate: null
            };
        },

        resetForm() {
            this.fillForm();
        },

        handleLogoUpload(event) {
            this.form.logo = event.target.files[0];
        },

        handleCertUpload(event) {
            this.form.certificate = event.target.files[0];
        },

        async createCompany() {
            this.saving = true;
            try {
                // Validate files are selected
                if (!this.form.logo) {
                    alert('Company logo is required');
                    this.saving = false;
                    return;
                }
                if (!this.form.certificate) {
                    alert('Company certificate is required');
                    this.saving = false;
                    return;
                }

                const formData = new FormData();
                formData.append('name', this.form.name);
                formData.append('email', this.form.email);
                formData.append('city', this.form.city);
                formData.append('description', this.form.description);
                if (this.form.phone) formData.append('phone', this.form.phone);
                if (this.form.website) formData.append('website', this.form.website);
                if (this.form.address) formData.append('address', this.form.address);
                if (this.form.state) formData.append('state', this.form.state);
                if (this.form.country) formData.append('country', this.form.country);
                formData.append('logo', this.form.logo);
                formData.append('certificate', this.form.certificate);

                console.log('Creating company with:', {
                    name: this.form.name,
                    email: this.form.email,
                    city: this.form.city,
                    hasLogo: !!this.form.logo,
                    hasCertificate: !!this.form.certificate
                });

                const response = await axios.post('/api/employer/companies', formData, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')}`,
                        'Content-Type': 'multipart/form-data'
                    }
                });

                if (response.data.success) {
                    alert('Company created successfully!');
                    await this.loadCompany();
                } else {
                    alert(response.data.message || 'Failed to create company');
                }
            } catch (error) {
                console.error('Error creating company:', error);
                console.error('Error details:', error.response?.data);
                alert(error.response?.data?.message || 'Failed to create company');
            } finally {
                this.saving = false;
            }
        },

        async updateCompany() {
            this.saving = true;
            try {
                const formData = new FormData();
                formData.append('name', this.form.name);
                formData.append('email', this.form.email);
                formData.append('city', this.form.city);
                formData.append('description', this.form.description);
                if (this.form.phone) formData.append('phone', this.form.phone);
                if (this.form.website) formData.append('website', this.form.website);
                if (this.form.address) formData.append('address', this.form.address);
                if (this.form.state) formData.append('state', this.form.state);
                if (this.form.country) formData.append('country', this.form.country);
                if (this.form.logo) formData.append('logo', this.form.logo);
                if (this.form.certificate) formData.append('certificate', this.form.certificate);
                formData.append('_method', 'PUT');

                const response = await axios.post(`/api/employer/companies/${this.company.id}`, formData, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    }
                });

                if (response.data.success) {
                    alert('Company updated successfully!');
                    this.showEditForm = false;
                    await this.loadCompany();
                } else {
                    alert(response.data.message || 'Failed to update company');
                }
            } catch (error) {
                console.error('Error updating company:', error);
                alert(error.response?.data?.message || 'Failed to update company');
            } finally {
                this.saving = false;
            }
        }
    }
}
</script>
@endsection
