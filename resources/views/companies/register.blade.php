@extends('layouts.app')

@section('title', 'Register Company · jobboard')
@section('page_title', 'Company Onboarding')

@section('content')
<div class="flex-grow p-gutter md:p-margin_desktop flex justify-center">
    <div class="w-full max-w-container_max_width flex flex-col md:flex-row gap-8">

        <!-- Left Column: Form Info & Visual -->
        <div class="md:w-1/3 flex flex-col gap-8">
            <div>
                <h2 class="font-headline-lg text-headline-lg mb-4">Register Your Company</h2>
                <p class="font-body-lg text-body-lg text-secondary">
                    Complete the details below to set up your corporate profile and start recruiting top-tier talent on jobboard.
                </p>
            </div>

            <div class="relative w-full aspect-[4/5] rounded-3xl overflow-hidden group">
                <img
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                    data-alt="A high-end, minimalist architectural shot of a corporate lobby featuring clean lines, marble surfaces, and a single sculptural plant. The color palette is strictly off-white, light grey, and deep charcoal. The lighting is diffused and natural, pouring in from a large window. The atmosphere is quiet, professional, and sophisticated."
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBhysoiEnwGTUTC3mG8fbUw_C_I9tf-d183fDyp1EgnmaQLuurLvx-J7iYOYFjv_9EvS-bWvQ4TtzomVGPbxCYiftoSUjyWgFQtueh4Uc4dlJszgGQzBsmYMW2061WfksVjkQRahyFVb972uCT6u1nCZ1R6Ojz2FWkLqdIxNm3gokY0SLpiU-QVRoMQ6J6AGl2wb6rMLsHsS9A7HRWf7lBUMEbFbeLVJSXAV8NDIw2uIECV_-KNl3nj646RgAOtUvF34XpgvZz92ZQ"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                <div class="absolute bottom-6 left-6 text-white">
                    <p class="font-label-sm text-label-sm opacity-80 mb-1">DESIGNED FOR LEADERS</p>
                    <h3 class="font-headline-md text-headline-md">Elite Workspace</h3>
                </div>
            </div>
        </div>

        <!-- Right Column: The Form -->
        <div class="md:w-2/3 bg-white p-8 md:p-12 rounded-[24px] border border-outline-variant/30 form-card-shadow">
            <form action="#" method="POST" enctype="multipart/form-data" class="space-y-10" id="companyRegisterForm">
                @csrf

                <!-- General Info Section -->
                <div class="space-y-6">
                    <h4 class="font-label-sm text-label-sm text-primary tracking-widest uppercase pb-2 border-b border-surface-container-highest">
                        Primary Information
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="font-label-sm text-label-sm text-secondary">Company Name</label>
                            <input class="bg-white border border-surface-container-highest rounded-lg p-3 font-body-md text-body-md focus:ring-0"
                                   placeholder="e.g. Acme Corp" type="text" name="name"/>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="font-label-sm text-label-sm text-secondary">Corporate Email</label>
                            <input class="bg-white border border-surface-container-highest rounded-lg p-3 font-body-md text-body-md focus:ring-0"
                                   placeholder="hr@acme.com" type="email" name="email"/>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="font-label-sm text-label-sm text-secondary">Industry</label>
                            <select class="bg-white border border-surface-container-highest rounded-lg p-3 font-body-md text-body-md focus:ring-0"
                                    name="industry">
                                <option>Technology &amp; Software</option>
                                <option>Finance &amp; Banking</option>
                                <option>Design &amp; Creative</option>
                                <option>Healthcare</option>
                                <option>Education</option>
                            </select>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="font-label-sm text-label-sm text-secondary">Global HQ Location</label>
                            <input class="bg-white border border-surface-container-highest rounded-lg p-3 font-body-md text-body-md focus:ring-0"
                                   placeholder="London, United Kingdom" type="text" name="location"/>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="font-label-sm text-label-sm text-secondary">Company Description</label>
                        <textarea class="bg-white border border-surface-container-highest rounded-lg p-3 font-body-md text-body-md focus:ring-0 resize-none"
                                  placeholder="Briefly describe your company's mission and culture..." rows="4" name="description"></textarea>
                    </div>
                </div>

                <!-- Upload Section -->
                <div class="space-y-6">
                    <h4 class="font-label-sm text-label-sm text-primary tracking-widest uppercase pb-2 border-b border-surface-container-highest">
                        Assets &amp; Compliance
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Logo Upload -->
                        <div class="flex flex-col gap-2">
                            <label class="font-label-sm text-label-sm text-secondary">Company Logo</label>
                            <label class="file-upload-zone border-2 border-dashed border-surface-container-highest rounded-2xl p-8 flex flex-col items-center justify-center text-center cursor-pointer" id="logoDropZone">
                                <span class="material-symbols-outlined text-4xl text-outline mb-3">add_photo_alternate</span>
                                <span class="font-body-md text-body-md font-semibold" data-label="logo">Drop Logo Here</span>
                                <span class="font-label-sm text-label-sm text-secondary mt-1">SVG, PNG or JPG (Max 5MB)</span>
                                <input class="hidden" type="file" name="logo" accept="image/png,image/jpeg,image/svg+xml"/>
                            </label>
                        </div>

                        <!-- Certificate Upload -->
                        <div class="flex flex-col gap-2">
                            <label class="font-label-sm text-label-sm text-secondary">Registration Certificate</label>
                            <label class="file-upload-zone border-2 border-dashed border-surface-container-highest rounded-2xl p-8 flex flex-col items-center justify-center text-center cursor-pointer" id="certDropZone">
                                <span class="material-symbols-outlined text-4xl text-outline mb-3">upload_file</span>
                                <span class="font-body-md text-body-md font-semibold" data-label="certificate">Drop Certificate</span>
                                <span class="font-label-sm text-label-sm text-secondary mt-1">PDF or Doc (Max 10MB)</span>
                                <input class="hidden" type="file" name="certificate" accept="application/pdf,.doc,.docx"/>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col md:flex-row gap-4 pt-6">
                    <button class="flex-grow bg-primary text-white py-4 rounded-full font-headline-md text-headline-md hover:bg-primary-container transition-all active:scale-95 duration-150 shadow-lg"
                            type="submit">
                        Complete Registration
                    </button>

                    <button class="md:w-1/3 border border-outline-variant bg-transparent text-primary py-4 rounded-full font-headline-md text-headline-md hover:bg-surface-container-low transition-all active:scale-95 duration-150"
                            type="button">
                        Save Draft
                    </button>
                </div>

                <p class="text-center font-label-sm text-label-sm text-secondary pt-4">
                    By proceeding, you agree to jobboard's
                    <a class="underline hover:text-primary" href="#">Terms of Service</a>
                    and
                    <a class="underline hover:text-primary" href="#">Privacy Policy</a>.
                </p>
            </form>
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
    .form-card-shadow {
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        transition: box-shadow 0.2s ease;
    }
    .form-card-shadow:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.04);
    }
    .file-upload-zone {
        transition: border-color 0.2s ease, background-color 0.2s ease;
    }
    .file-upload-zone:hover {
        border-color: #111111;
        background-color: #F5F5F5;
    }
    input:focus, textarea:focus, select:focus {
        outline: none;
        border-color: #111111 !important;
        border-width: 2px !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // Micro-interactions for file upload zones
    const dropZones = document.querySelectorAll('.file-upload-zone');
    dropZones.forEach(zone => {
        zone.addEventListener('dragover', (e) => {
            e.preventDefault();
            zone.classList.add('border-primary', 'bg-surface-container-low');
        });
        zone.addEventListener('dragleave', () => {
            zone.classList.remove('border-primary', 'bg-surface-container-low');
        });
        zone.addEventListener('drop', (e) => {
            e.preventDefault();
            zone.classList.remove('border-primary', 'bg-surface-container-low');
            const label = zone.querySelector('span[data-label]');
            if (label) {
                label.innerText = 'File Received';
                label.classList.add('text-primary');
            }
        });
        zone.addEventListener('click', () => {
            const input = zone.querySelector('input[type="file"]');
            if (input) input.click();
        });
    });

    // Form submission animation (mock)
    const form = document.getElementById('companyRegisterForm');
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            const submitBtn = form.querySelector('button[type="submit"]');
            if (!submitBtn) return;

            submitBtn.disabled = true;
            const original = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="flex items-center justify-center gap-2"><span class="material-symbols-outlined animate-spin">progress_activity</span> Processing...</span>';

            setTimeout(() => {
                submitBtn.innerHTML = 'Account Registered!';
                submitBtn.classList.remove('bg-primary');
                submitBtn.classList.add('bg-green-600');
            }, 1500);

            // If you connect this form to backend later, remove preventDefault() above.
            // setTimeout(() => (window.location.href = ''), 1500);
        });
    }
</script>
@endpush

