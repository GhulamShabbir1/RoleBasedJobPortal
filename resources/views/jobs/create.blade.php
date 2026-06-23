@extends('layouts.app')

@section('title', 'Post a Job · jobboard')
@section('page_title', 'Post a Job')

@section('content')
<main class="ml-[280px] flex-1 md:ml-[280px] bg-[#FAFAFA] min-h-screen">
    <!-- Form Content -->
    <div class="max-w-[1000px] mx-auto p-margin_desktop pb-24">
        <div class="bg-white rounded-[24px] p-8 md:p-12 card-shadow border border-[#ECECEC]">
            <div class="mb-10">
                <h2 class="font-headline-md text-headline-md text-primary mb-2">Job Details</h2>
                <p class="font-body-md text-body-md text-secondary">Fill out the information below to create a new job listing for candidates.</p>
            </div>

            <form class="space-y-8" method="POST" action="#" id="postJobForm" enctype="multipart/form-data">
                @csrf

                <!-- Top Row: Approved Companies & Title -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="font-label-sm text-label-sm uppercase tracking-widest text-secondary block" for="category_id">Category</label>
                        <select class="form-input w-full p-4 rounded-xl border border-[#ECECEC] bg-white text-body-md" id="category_id" name="category_id" required>
                            <option value="">Loading categories...</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="font-label-sm text-label-sm uppercase tracking-widest text-secondary block" for="title">Job Title</label>
                        <input class="form-input w-full p-4 rounded-xl border border-[#ECECEC] bg-white text-body-md" id="title" name="title" placeholder="e.g. Senior Product Designer" type="text" />
                    </div>
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <label class="font-label-sm text-label-sm uppercase tracking-widest text-secondary block" for="description">Job Description</label>
                    <textarea class="form-input w-full p-4 rounded-xl border border-[#ECECEC] bg-white text-body-md resize-none" id="description" name="description" placeholder="Provide a detailed overview of the role..." rows="6"></textarea>
                </div>

                <!-- Requirements -->
                <div class="space-y-2">
                    <label class="font-label-sm text-label-sm uppercase tracking-widest text-secondary block" for="requirements">Key Requirements</label>
                    <textarea class="form-input w-full p-4 rounded-xl border border-[#ECECEC] bg-white text-body-md resize-none" id="requirements" name="requirements" placeholder="List the essential skills and experience..." rows="4"></textarea>
                </div>

                <!-- Metadata Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="space-y-2">
                        <label class="font-label-sm text-label-sm uppercase tracking-widest text-secondary block" for="city">City</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">location_on</span>
                            <input class="form-input w-full p-4 pl-12 rounded-xl border border-[#ECECEC] bg-white text-body-md" id="city" name="city" placeholder="New York, NY" type="text" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="font-label-sm text-label-sm uppercase tracking-widest text-secondary block" for="job_type">Job Type</label>
                        <select class="form-input w-full p-4 rounded-xl border border-[#ECECEC] bg-white text-body-md" id="job_type" name="job_type">
                            <option value="full_time">Full-time</option>
                            <option value="part_time">Part-time</option>
                            <option value="contract">Contract</option>
                            <option value="temporary">Temporary</option>
                            <option value="internship">Internship</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="font-label-sm text-label-sm uppercase tracking-widest text-secondary block" for="min_salary">Min Salary</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">payments</span>
                            <input class="form-input w-full p-4 pl-12 rounded-xl border border-[#ECECEC] bg-white text-body-md" id="min_salary" name="min_salary" placeholder="80000" type="number" min="0" />
                        </div>
                    </div>
                </div>

                <!-- Deadline & Final Action -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="space-y-2">
                        <label class="font-label-sm text-label-sm uppercase tracking-widest text-secondary block" for="max_salary">Max Salary</label>
                        <input class="form-input w-full p-4 rounded-xl border border-[#ECECEC] bg-white text-body-md" id="max_salary" name="max_salary" placeholder="120000" type="number" min="0" />
                    </div>
                    <div class="space-y-2">
                        <label class="font-label-sm text-label-sm uppercase tracking-widest text-secondary block" for="vacancies">Vacancies</label>
                        <input class="form-input w-full p-4 rounded-xl border border-[#ECECEC] bg-white text-body-md" id="vacancies" name="vacancies" value="1" type="number" min="1" />
                    </div>
                    <div class="space-y-2">
                        <label class="font-label-sm text-label-sm uppercase tracking-widest text-secondary block" for="status">Status</label>
                        <select class="form-input w-full p-4 rounded-xl border border-[#ECECEC] bg-white text-body-md" id="status" name="status">
                            <option value="open">Open</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-end justify-between gap-8 pt-8 border-t border-[#ECECEC]">
                    <div class="w-full md:w-1/2 space-y-2">
                        <label class="font-label-sm text-label-sm uppercase tracking-widest text-secondary block" for="deadline">Application Deadline</label>
                        <input class="form-input w-full p-4 rounded-xl border border-[#ECECEC] bg-white text-body-md" id="deadline" name="deadline" type="date" />
                    </div>

                    <div class="flex gap-4 w-full md:w-auto">
                        <button class="flex-1 md:flex-none px-10 py-4 text-[#111111] border border-[#ECECEC] font-bold rounded-full hover:bg-surface-container-low transition-all" type="button">Save Draft</button>
                        <button class="flex-1 md:flex-none px-12 py-4 bg-[#111111] text-white font-bold rounded-full transition-transform active:scale-95" type="submit">Post Job</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Preview Card -->
        <div class="mt-12 p-8 bg-[#F3F3F3] rounded-[24px] border border-dashed border-outline-variant">
            <div class="flex items-center gap-4 mb-4">
                <span class="material-symbols-outlined text-secondary">visibility</span>
                <span class="font-label-sm text-label-sm uppercase tracking-widest text-secondary">Listing Preview</span>
            </div>

            <div class="flex items-start justify-between">
                <div>
                    <h3 class="font-headline-md text-headline-md text-primary" id="preview-title">Senior Product Designer</h3>
                    <div class="flex flex-wrap gap-2 mt-4">
                        <span class="bg-[#e4e2e2] text-secondary text-[12px] px-3 py-1 rounded-full font-semibold">Full-time</span>
                        <span class="bg-[#e4e2e2] text-secondary text-[12px] px-3 py-1 rounded-full font-semibold">New York</span>
                        <span class="bg-[#e4e2e2] text-secondary text-[12px] px-3 py-1 rounded-full font-semibold">$120k - $150k</span>
                    </div>
                </div>

                <div class="w-12 h-12 bg-white rounded-lg border border-[#ECECEC] flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary">auto_awesome</span>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection

@push('scripts')
<script>
    // Simple reactive preview logic
    const titleInput = document.querySelector('#postJobForm input[name="title"]');
    const previewTitle = document.getElementById('preview-title');

    if (titleInput && previewTitle) {
        titleInput.addEventListener('input', (e) => {
            previewTitle.textContent = e.target.value || "Senior Product Designer";
        });
    }

    // Micro-interactions for form focus
    document.querySelectorAll('#postJobForm .form-input').forEach(input => {
        input.addEventListener('focus', () => {
            const label = input.closest('.space-y-2')?.querySelector('label');
            if (label) label.style.color = '#111111';
        });
        input.addEventListener('blur', () => {
            const label = input.closest('.space-y-2')?.querySelector('label');
            if (label) label.style.color = '';
        });
    });

    document.addEventListener('DOMContentLoaded', loadCategories);

    async function loadCategories() {
        const categorySelect = document.getElementById('category_id');
        try {
            const response = await fetch(`${API_URL}/categories`, {
                headers: { 'Accept': 'application/json' }
            });
            const data = await response.json();
            const categories = data?.data?.data || data?.data || [];
            categorySelect.innerHTML = '<option value="">Select a Category</option>' + categories.map(category => `
                <option value="${category.id}">${category.name}</option>
            `).join('');
        } catch (error) {
            categorySelect.innerHTML = '<option value="">Failed to load categories</option>';
        }
    }

    document.getElementById('postJobForm').addEventListener('submit', async (event) => {
        event.preventDefault();
        const submitButton = event.target.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.textContent = 'Posting...';

        try {
            const response = await fetch(`${API_URL}/jobs`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    title: document.getElementById('title').value,
                    description: document.getElementById('description').value,
                    category_id: document.getElementById('category_id').value,
                    job_type: document.getElementById('job_type').value,
                    city: document.getElementById('city').value,
                    min_salary: document.getElementById('min_salary').value || null,
                    max_salary: document.getElementById('max_salary').value || null,
                    vacancies: document.getElementById('vacancies').value || 1,
                    status: document.getElementById('status').value,
                    deadline: document.getElementById('deadline').value || null,
                }),
            });
            const data = await response.json();
            if (!response.ok || !data.success) {
                throw new Error(data.message || 'Failed to create job');
            }
            alert('Job created successfully.');
            window.location.href = '/jobs';
        } catch (error) {
            alert(error.message);
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = 'Post Job';
        }
    });
</script>
@endpush
