@extends('layouts.app')

@section('title', 'Job Details · jobboard')
@section('page_title', 'Job Details')

@section('content')
<div class="max-w-[1440px] mx-auto p-10 grid grid-cols-12 gap-8">

    <!-- Left Column: Job Info + Apply Form -->
    <div class="col-span-12 lg:col-span-8 space-y-8">

        <!-- Header Card -->
        <section class="bg-white rounded-[24px] p-8 border border-[#ECECEC] shadow-[0_4px_12px_rgba(0,0,0,0.02)] transition-shadow hover:shadow-[0_8px_24px_rgba(0,0,0,0.04)]">
            <div class="flex items-start justify-between mb-6">
                <div class="flex gap-6 items-center">
                    <div class="w-20 h-20 bg-surface-container rounded-2xl flex items-center justify-center border border-outline-variant overflow-hidden">
                        <div class="w-14 h-14 bg-surface-container"></div>
                        {{-- Replace with real logo image if available --}}
                    </div>
                    <div>
                        <h3 class="font-headline-lg text-headline-lg text-primary mb-1">Senior Product Designer</h3>
                        <p class="font-body-lg text-body-lg text-secondary">Linear Systems • Remote • Posted 2 days ago</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <span class="px-3 py-1 bg-[#E4E2E2] text-on-secondary-fixed-variant rounded-full font-label-sm text-label-sm">Full-time</span>
                    <span class="px-3 py-1 bg-primary-fixed text-on-primary-fixed rounded-full font-label-sm text-label-sm">$140k - $180k</span>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <h4 class="font-headline-md text-headline-md text-primary mb-3">About the Role</h4>
                    <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
                        We are looking for a Senior Product Designer to join our core product team. You will be responsible for defining the visual language and user experience of our next-generation productivity suite. This role requires a perfect balance of editorial sensibility and functional engineering-led design logic.
                    </p>
                </div>

                <div>
                    <h4 class="font-headline-md text-headline-md text-primary mb-3">Core Responsibilities</h4>
                    <ul class="space-y-3 font-body-lg text-body-lg text-on-surface-variant">
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary text-[18px] mt-1">check_circle</span>
                            Lead the design of high-impact features from discovery to high-fidelity implementation.
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary text-[18px] mt-1">check_circle</span>
                            Maintain and evolve our design system with a focus on "Quiet Luxury" aesthetic and accessibility.
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary text-[18px] mt-1">check_circle</span>
                            Collaborate closely with product managers and engineers to ship polished features weekly.
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary text-[18px] mt-1">check_circle</span>
                            Mentor junior designers and contribute to our growing design culture.
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-headline-md text-headline-md text-primary mb-3">Requirements</h4>
                    <ul class="space-y-3 font-body-lg text-body-lg text-on-surface-variant">
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary text-[18px] mt-1">fiber_manual_record</span>
                            5+ years of experience designing digital products at high-growth startups.
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary text-[18px] mt-1">fiber_manual_record</span>
                            Expert proficiency in Figma and prototyping tools like Framer or Protopie.
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary text-[18px] mt-1">fiber_manual_record</span>
                            Strong portfolio demonstrating editorial typography and minimalist UI systems.
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Application Form -->
        <section class="bg-white rounded-[24px] p-8 border border-[#ECECEC] shadow-[0_4px_12px_rgba(0,0,0,0.02)] transition-shadow hover:shadow-[0_8px_24px_rgba(0,0,0,0.04)] scroll-mt-24" id="apply-section">
            <h4 class="font-headline-md text-headline-md text-primary mb-8">Apply for this Position</h4>
            <form class="space-y-8" method="POST" action="#" id="applyForm">
                @csrf

                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="font-label-sm text-label-sm text-on-surface-variant">Full Name</label>
                        <input class="w-full bg-white border border-[#ECECEC] rounded-xl px-4 py-3 font-body-md text-body-md focus:border-primary focus:ring-0 transition-all outline-none" placeholder="Jane Doe" type="text" name="name" />
                    </div>
                    <div class="space-y-2">
                        <label class="font-label-sm text-label-sm text-on-surface-variant">Email Address</label>
                        <input class="w-full bg-white border border-[#ECECEC] rounded-xl px-4 py-3 font-body-md text-body-md focus:border-primary focus:ring-0 transition-all outline-none" placeholder="jane@example.com" type="email" name="email" />
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="font-label-sm text-label-sm text-on-surface-variant">Cover Letter</label>
                    <textarea class="w-full bg-white border border-[#ECECEC] rounded-xl px-4 py-3 font-body-md text-body-md focus:border-primary focus:ring-0 transition-all outline-none resize-none" placeholder="Tell us why you are a great fit..." rows="6" name="cover_letter"></textarea>
                </div>

                <div class="space-y-2">
                    <label class="font-label-sm text-label-sm text-on-surface-variant">Resume / CV</label>

                    <!-- Upload Drop Zone (mock) -->
                    <div
                        class="border-2 border-dashed border-[#ECECEC] rounded-2xl p-10 flex flex-col items-center justify-center gap-3 hover:border-primary hover:bg-surface-container-low transition-all cursor-pointer group"
                        id="resumeDropzone"
                        role="button"
                        tabindex="0"
                        aria-label="Upload resume"
                    >
                        <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center text-secondary group-hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[28px]">cloud_upload</span>
                        </div>
                        <div class="text-center">
                            <p class="font-body-md text-body-md text-primary font-semibold">Click to upload or drag and drop</p>
                            <p class="font-label-sm text-label-sm text-on-secondary-fixed-variant">PDF, DOCX (Max 10MB)</p>
                        </div>

                        <input type="file" class="hidden" id="resumeInput" accept="application/pdf,.doc,.docx" />
                        <div class="mt-3 text-sm text-secondary" id="resumeFileName"></div>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <button class="flex-1 bg-primary text-white py-4 rounded-full font-headline-md text-headline-md hover:bg-black/90 transition-all active:scale-[0.98]" type="submit">
                        Submit Application
                    </button>
                </div>
            </form>
        </section>

    </div>

    <!-- Right Column -->
    <div class="col-span-12 lg:col-span-4">
        <div class="sticky top-32 space-y-8">
            <!-- Quick Apply Card -->
            <div class="bg-white rounded-[24px] p-8 border border-[#ECECEC] shadow-[0_4px_12px_rgba(0,0,0,0.02)]">
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <span class="font-label-sm text-label-sm text-secondary-fixed-variant">Apply before</span>
                        <span class="font-body-md text-body-md text-primary font-bold">Oct 24, 2023</span>
                    </div>
                    <div class="w-full bg-surface-container rounded-full h-2">
                        <div class="bg-primary h-2 rounded-full w-2/3"></div>
                    </div>
                    <p class="font-label-sm text-label-sm text-on-surface-variant mt-2">67% of application window completed</p>
                </div>

                <a class="block w-full text-center bg-primary text-white py-4 rounded-full font-headline-md text-headline-md hover:bg-black/90 transition-all mb-4" href="#apply-section">Apply Now</a>

                <button class="w-full text-center border border-[#ECECEC] text-primary py-4 rounded-full font-headline-md text-headline-md hover:bg-surface-container-low transition-all flex items-center justify-center gap-2" type="button">
                    <span class="material-symbols-outlined text-[20px]">bookmark</span>
                    Save Job
                </button>
            </div>

            <!-- Meta Info Card -->
            <div class="bg-white rounded-[24px] p-8 border border-[#ECECEC] shadow-[0_4px_12px_rgba(0,0,0,0.02)] space-y-6">
                <h5 class="font-headline-md text-headline-md text-primary">Job Overview</h5>

                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="p-2 bg-surface-container rounded-lg text-primary">
                            <span class="material-symbols-outlined">calendar_today</span>
                        </div>
                        <div>
                            <p class="font-label-sm text-label-sm text-on-surface-variant">Date Posted</p>
                            <p class="font-body-md text-body-md text-primary font-semibold">October 12, 2023</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="p-2 bg-surface-container rounded-lg text-primary">
                            <span class="material-symbols-outlined">location_on</span>
                        </div>
                        <div>
                            <p class="font-label-sm text-label-sm text-on-surface-variant">Location</p>
                            <p class="font-body-md text-body-md text-primary font-semibold">London, UK (Remote)</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="p-2 bg-surface-container rounded-lg text-primary">
                            <span class="material-symbols-outlined">payments</span>
                        </div>
                        <div>
                            <p class="font-label-sm text-label-sm text-on-surface-variant">Salary Range</p>
                            <p class="font-body-md text-body-md text-primary font-semibold">$140,000 - $180,000</p>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-[#ECECEC]">
                    <h6 class="font-label-sm text-label-sm text-on-surface-variant mb-4">Required Skills</h6>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-surface-container-low text-primary rounded-full font-label-sm text-label-sm">Figma</span>
                        <span class="px-3 py-1 bg-surface-container-low text-primary rounded-full font-label-sm text-label-sm">Product Strategy</span>
                        <span class="px-3 py-1 bg-surface-container-low text-primary rounded-full font-label-sm text-label-sm">UI/UX</span>
                        <span class="px-3 py-1 bg-surface-container-low text-primary rounded-full font-label-sm text-label-sm">Prototyping</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="mt-20 border-t border-surface-container-highest p-10 text-center">
    <p class="font-label-sm text-label-sm text-on-secondary-fixed-variant">© 2023 jobboard. Designed with Quiet Luxury and Absolute Clarity.</p>
</footer>
@endsection

@push('scripts')
<script>
    // Smooth scroll to anchors (mock)
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (!target) return;
            target.scrollIntoView({ behavior: 'smooth' });
        });
    });

    // Floating effect for cards
    const cards = document.querySelectorAll('section, .sticky > div');
    cards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-4px)';
            card.style.transition = 'all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1)';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
        });
    });

    // Drag/drop upload mock
    const dz = document.getElementById('resumeDropzone');
    const input = document.getElementById('resumeInput');
    const fileName = document.getElementById('resumeFileName');

    if (dz && input) {
        const setHover = (on) => {
            if (on) {
                dz.classList.add('border-primary', 'bg-surface-container-low');
            } else {
                dz.classList.remove('border-primary', 'bg-surface-container-low');
            }
        };

        dz.addEventListener('click', () => input.click());
        dz.addEventListener('dragover', (e) => { e.preventDefault(); setHover(true); });
        dz.addEventListener('dragleave', () => setHover(false));
        dz.addEventListener('drop', (e) => {
            e.preventDefault();
            setHover(false);
            const file = e.dataTransfer.files && e.dataTransfer.files[0];
            if (!file) return;
            input.files = e.dataTransfer.files;
            fileName.textContent = `Selected: ${file.name}`;
        });

        input.addEventListener('change', () => {
            const file = input.files && input.files[0];
            if (!file) return;
            fileName.textContent = `Selected: ${file.name}`;
        });
    }

    // Prevent submit default for demo
    const applyForm = document.getElementById('applyForm');
    if (applyForm) {
        applyForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Submit Application mock: connect this form to your ApplyJob endpoint.');
        });
    }
</script>
@endpush

