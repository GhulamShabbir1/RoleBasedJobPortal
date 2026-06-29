@extends('layouts.app')

@section('title', 'Manage Categories - JobHub')

@section('content')
<div class="min-h-screen bg-white">
    <div class="flex gap-0">
        <!-- Sidebar -->
        @include('components.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto" x-data="categoriesPage()" x-init="loadCategories()">
                <div class="space-y-6">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <button onclick="history.back()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-all duration-200 hover:shadow-md mb-4">
                                <i class="fas fa-arrow-left mr-2"></i>Back
                            </button>
                            <h1 class="text-3xl font-bold text-gray-900">Manage Categories</h1>
                            <p class="text-gray-600 mt-1">Organize and manage job categories for your platform</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-tags mr-1"></i> Total: <span x-text="categories.length"></span> categories
                            </span>
                            <button @click="loadCategories()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 hover:shadow-md">
                                <i class="fas fa-redo mr-2"></i>Refresh
                            </button>
                            <button @click="openAddModal()" class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center transition-all duration-200 hover:shadow-lg hover:scale-105">
                                <i class="fas fa-plus mr-2"></i>Add Category
                            </button>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Total Categories</p>
                                    <p class="text-2xl font-bold text-gray-900" x-text="categories.length">0</p>
                                </div>
                                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-tags text-gray-600"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Total Jobs</p>
                                    <p class="text-2xl font-bold text-gray-900" x-text="totalJobs">0</p>
                                </div>
                                <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-briefcase text-blue-600"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Active Categories</p>
                                    <p class="text-2xl font-bold text-green-600" x-text="activeCategories">0</p>
                                </div>
                                <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Categories with Jobs</p>
                                    <p class="text-2xl font-bold text-purple-600" x-text="categoriesWithJobs">0</p>
                                </div>
                                <div class="w-10 h-10 bg-purple-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-folder-open text-purple-600"></i>
                                </div>
                            </div>
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
                                    @input="filterCategories()"
                                    placeholder="Search categories by name or description..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                                >
                            </div>
                            <div class="flex gap-2">
                                <button @click="filters.search = ''; filterCategories()" class="px-4 py-2 text-gray-600 hover:text-gray-900 transition-colors">
                                    <i class="fas fa-times mr-1"></i>Clear
                                </button>
                                <button @click="sortBy = sortBy === 'name' ? '-name' : 'name'" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm">
                                    <i class="fas fa-sort mr-1"></i>
                                    Sort by Name
                                    <span x-text="sortBy === 'name' ? '↑' : sortBy === '-name' ? '↓' : ''"></span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Loading State -->
                    <div x-show="loading" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                        <div class="inline-block">
                            <i class="fas fa-spinner fa-spin text-4xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-600 mt-4">Loading categories...</p>
                    </div>

                    <!-- Categories Grid -->
                    <div x-show="!loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <template x-for="category in filteredCategories" :key="category.id">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all duration-300 hover:border-gray-300 group">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                                                <i class="fas fa-tag text-gray-600"></i>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900" x-text="category.name"></h3>
                                                <p class="text-sm text-gray-500 mt-0.5" x-text="category.description || 'No description'"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <button @click="editCategory(category)" class="p-2 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-all duration-200" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button @click="deleteCategory(category.id)" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-briefcase text-gray-400"></i>
                                            <span class="text-sm text-gray-600">
                                                <span class="font-semibold text-gray-900" x-text="category.jobs_count || 0"></span> jobs
                                            </span>
                                        </div>
                                        <span class="text-xs px-2 py-1 rounded-full" :class="category.jobs_count > 0 ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500'">
                                            <span x-text="category.jobs_count > 0 ? 'Active' : 'Inactive'"></span>
                                        </span>
                                    </div>
                                    <!-- Progress Bar for Jobs -->
                                    <div class="mt-2 w-full h-1 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-gray-700 rounded-full transition-all duration-500" :style="{ width: Math.min((category.jobs_count / maxJobs) * 100, 100) + '%' }"></div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Empty State -->
                        <div x-show="filteredCategories.length === 0 && !loading" class="col-span-full">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-tags text-4xl text-gray-400"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Categories Found</h3>
                                <p class="text-gray-600" x-text="filters.search ? 'No categories match your search criteria.' : 'Start by creating your first category.'"></p>
                                <button @click="openAddModal()" class="mt-4 inline-flex items-center px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-all duration-200">
                                    <i class="fas fa-plus mr-2"></i>Create Category
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-transition style="display: none;">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full" @click.away="closeModal()">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-900" x-text="editingId ? 'Edit Category' : 'Add New Category'"></h3>
            <button @click="closeModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 transition-colors flex items-center justify-center">
                <i class="fas fa-times text-gray-500"></i>
            </button>
        </div>

        <form @submit.prevent="saveCategory()" class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-tag mr-2"></i>Category Name
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tag text-gray-400"></i>
                    </div>
                    <input
                        type="text"
                        x-model="form.name"
                        placeholder="e.g., Technology, Finance, Healthcare"
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                        required
                        minlength="2"
                        maxlength="50"
                    >
                </div>
                <p class="text-xs text-gray-500 mt-1">2-50 characters, unique name</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-align-left mr-2"></i>Description
                </label>
                <div class="relative">
                    <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                        <i class="fas fa-align-left text-gray-400"></i>
                    </div>
                    <textarea
                        x-model="form.description"
                        placeholder="Brief description of the category (optional)"
                        rows="3"
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 resize-none"
                        maxlength="200"
                    ></textarea>
                </div>
                <p class="text-xs text-gray-500 mt-1" x-text="(form.description?.length || 0) + '/200 characters'"></p>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-3 pt-4 border-t border-gray-200">
                <button
                    type="submit"
                    :disabled="saving || !form.name.trim()"
                    class="flex-1 relative overflow-hidden group bg-gray-900 text-white font-semibold py-2.5 px-4 rounded-lg transition-all duration-300 hover:scale-[1.02] hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></span>
                    <span x-show="!saving">
                        <i class="fas fa-save mr-2"></i>Save Category
                    </span>
                    <span x-show="saving">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Saving...
                    </span>
                </button>
                <button
                    type="button"
                    @click="closeModal()"
                    class="flex-1 px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200"
                >
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function categoriesPage() {
    return {
        categories: [],
        filteredCategories: [],
        loading: false,
        saving: false,
        showModal: false,
        editingId: null,
        sortBy: 'name',
        filters: {
            search: ''
        },
        form: {
            name: '',
            description: ''
        },

        get totalJobs() {
            return this.categories.reduce((sum, cat) => sum + (cat.jobs_count || 0), 0);
        },

        get activeCategories() {
            return this.categories.filter(cat => (cat.jobs_count || 0) > 0).length;
        },

        get categoriesWithJobs() {
            return this.categories.filter(cat => (cat.jobs_count || 0) > 0).length;
        },

        get maxJobs() {
            const max = Math.max(...this.categories.map(cat => cat.jobs_count || 0));
            return max || 1;
        },

        async loadCategories() {
            this.loading = true;
            try {
                const response = await axios.get('/api/categories', {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });

                if (response.data.success) {
                    this.categories = response.data.data;
                    this.filterCategories();
                }
            } catch (error) {
                console.error('Error loading categories:', error);
                alert('Failed to load categories. Please try again.');
            } finally {
                this.loading = false;
            }
        },

        filterCategories() {
            let filtered = [...this.categories];

            // Search filter
            if (this.filters.search.trim()) {
                const search = this.filters.search.toLowerCase().trim();
                filtered = filtered.filter(cat =>
                    cat.name.toLowerCase().includes(search) ||
                    (cat.description && cat.description.toLowerCase().includes(search))
                );
            }

            // Sort
            if (this.sortBy === 'name') {
                filtered.sort((a, b) => a.name.localeCompare(b.name));
            } else if (this.sortBy === '-name') {
                filtered.sort((a, b) => b.name.localeCompare(a.name));
            }

            this.filteredCategories = filtered;
        },

        openAddModal() {
            this.editingId = null;
            this.form = { name: '', description: '' };
            this.showModal = true;
            // Focus the input after modal opens
            setTimeout(() => {
                const input = document.querySelector('input[x-model="form.name"]');
                if (input) input.focus();
            }, 100);
        },

        editCategory(category) {
            this.editingId = category.id;
            this.form = {
                name: category.name,
                description: category.description || ''
            };
            this.showModal = true;
            setTimeout(() => {
                const input = document.querySelector('input[x-model="form.name"]');
                if (input) input.focus();
            }, 100);
        },

        closeModal() {
            this.showModal = false;
            this.editingId = null;
            this.form = { name: '', description: '' };
            this.saving = false;
        },

        async saveCategory() {
            if (!this.form.name.trim()) {
                alert('Please enter a category name');
                return;
            }

            this.saving = true;
            try {
                let response;
                if (this.editingId) {
                    response = await axios.put(`/api/categories/${this.editingId}`, this.form, {
                        headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                    });
                } else {
                    response = await axios.post('/api/categories', this.form, {
                        headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                    });
                }

                if (response.data.success) {
                    this.closeModal();
                    await this.loadCategories();
                    // Show success message
                    alert(this.editingId ? 'Category updated successfully!' : 'Category created successfully!');
                } else {
                    alert(response.data.message || 'Failed to save category');
                }
            } catch (error) {
                if (error.response?.status === 422) {
                    const errors = error.response.data.errors;
                    const message = Object.values(errors).flat().join(', ');
                    alert(message);
                } else {
                    alert(error.response?.data?.message || 'Failed to save category');
                }
            } finally {
                this.saving = false;
            }
        },

        async deleteCategory(categoryId) {
            const category = this.categories.find(c => c.id === categoryId);
            if (!category) return;

            const jobCount = category.jobs_count || 0;
            let message = `Delete category "${category.name}"?`;
            if (jobCount > 0) {
                message += `\n\n⚠️ Warning: This category has ${jobCount} job(s) associated with it. Deleting it will affect these jobs.`;
            }

            if (!confirm(message)) return;

            try {
                const response = await axios.delete(`/api/categories/${categoryId}`, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });

                if (response.data.success) {
                    await this.loadCategories();
                    alert('Category deleted successfully');
                } else {
                    alert(response.data.message || 'Failed to delete category');
                }
            } catch (error) {
                alert(error.response?.data?.message || 'Failed to delete category');
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

    /* Modal Overlay */
    .backdrop-blur-sm {
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }

    /* Card hover effects */
    .group:hover .group-hover\\:opacity-100 {
        opacity: 1;
    }
</style>
@endsection
