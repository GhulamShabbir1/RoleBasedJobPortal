@extends('layouts.app')

@section('title', 'Review Applications · jobboard')
@section('page_title', 'Applications')

@section('content')
<div class="p-margin_desktop max-w-[1440px] mx-auto w-full space-y-8">

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div class="space-y-1">
            <h1 class="font-headline-lg text-headline-lg text-primary">Applications</h1>
            <p class="text-on-surface-variant opacity-70 font-body-md text-body-md">
                Manage and review incoming candidate applications across all active job postings.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button class="flex items-center gap-2 px-5 py-2.5 bg-white border border-outline-variant rounded-full font-label-sm text-label-sm hover:bg-surface-container-low transition-all">
                <span class="material-symbols-outlined text-sm">filter_list</span>
                Filter
            </button>
            <button class="flex items-center gap-2 px-5 py-2.5 bg-primary text-white rounded-full font-label-sm text-label-sm hover:bg-opacity-90 transition-all">
                <span class="material-symbols-outlined text-sm">download</span>
                Export CSV
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-[24px] border border-surface-container shadow-[0_4px_12px_rgba(0,0,0,0.02)] hover:shadow-[0_8px_24px_rgba(0,0,0,0.04)] transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-full bg-surface-container-low flex items-center justify-center">
                    <span class="material-symbols-outlined text-on-surface">inbox</span>
                </div>
                <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">+12%</span>
            </div>
            <p class="text-on-surface-variant font-label-sm text-label-sm uppercase tracking-widest">Total Received</p>
            <h3 class="font-headline-lg text-headline-lg text-primary mt-1">1,248</h3>
        </div>

        <div class="bg-white p-6 rounded-[24px] border border-surface-container shadow-[0_4px_12px_rgba(0,0,0,0.02)] hover:shadow-[0_8px_24px_rgba(0,0,0,0.04)] transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-full bg-surface-container-low flex items-center justify-center">
                    <span class="material-symbols-outlined text-on-surface">pending_actions</span>
                </div>
                <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded-full">84 New</span>
            </div>
            <p class="text-on-surface-variant font-label-sm text-label-sm uppercase tracking-widest">Pending Review</p>
            <h3 class="font-headline-lg text-headline-lg text-primary mt-1">152</h3>
        </div>

        <div class="bg-white p-6 rounded-[24px] border border-surface-container shadow-[0_4px_12px_rgba(0,0,0,0.02)] hover:shadow-[0_8px_24px_rgba(0,0,0,0.04)] transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-full bg-surface-container-low flex items-center justify-center">
                    <span class="material-symbols-outlined text-on-surface" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                </div>
                <span class="text-xs font-bold text-on-surface-variant bg-surface-container px-2 py-1 rounded-full">Steady</span>
            </div>
            <p class="text-on-surface-variant font-label-sm text-label-sm uppercase tracking-widest">Hired This Month</p>
            <h3 class="font-headline-lg text-headline-lg text-primary mt-1">24</h3>
        </div>

        <div class="bg-primary text-white p-6 rounded-[24px] shadow-[0_8px_32px_rgba(0,0,0,0.1)] flex flex-col justify-between relative overflow-hidden">
            <div class="relative z-10">
                <p class="font-label-sm text-label-sm uppercase tracking-widest opacity-80">Campaign Health</p>
                <h3 class="font-headline-lg text-headline-lg mt-1">Optimal</h3>
            </div>

            <div class="relative z-10 mt-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">trending_up</span>
                <span class="text-xs">Exceeding quarterly targets by 8.4%</span>
            </div>

            <div class="absolute right-[-20px] bottom-[-20px] opacity-10">
                <span class="material-symbols-outlined text-[120px]">analytics</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[24px] border border-surface-container shadow-[0_4px_12px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="px-8 py-6 border-b border-surface-container flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h2 class="font-headline-md text-headline-md">Recent Applications</h2>
            <div class="flex gap-2">
                <button class="px-4 py-2 text-xs font-bold bg-surface-container-low text-primary rounded-lg" type="button">All</button>
                <button class="px-4 py-2 text-xs font-bold text-on-surface-variant hover:bg-surface-container-low rounded-lg transition-all" type="button">New</button>
                <button class="px-4 py-2 text-xs font-bold text-on-surface-variant hover:bg-surface-container-low rounded-lg transition-all" type="button">Archived</button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                <tr class="bg-surface-container-low/50">
                    <th class="px-8 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Candidate</th>
                    <th class="px-8 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Applied For</th>
                    <th class="px-8 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Date Applied</th>
                    <th class="px-8 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider text-center">Resume</th>
                    <th class="px-8 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Status</th>
                    <th class="px-8 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider"></th>
                </tr>
                </thead>

                <tbody class="divide-y divide-surface-container">
                <tr class="group hover:bg-surface-container-low/30 transition-colors">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center font-bold text-primary">ED</div>
                            <div class="flex flex-col">
                                <span class="font-body-md text-body-md font-semibold text-primary">Eleanor Davis</span>
                                <span class="text-xs text-on-surface-variant">San Francisco, CA</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5"><span class="font-body-md text-body-md">Senior Product Designer</span></td>
                    <td class="px-8 py-5"><span class="font-body-md text-body-md text-on-surface-variant">Oct 12, 2023</span></td>
                    <td class="px-8 py-5 text-center">
                        <a class="p-2 rounded-lg hover:bg-surface-container inline-flex items-center justify-center text-primary transition-all" href="#">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'wght' 300;">description</span>
                        </a>
                    </td>
                    <td class="px-8 py-5">
                        <select class="bg-surface-container-low border-none rounded-full px-4 py-1.5 font-label-sm text-label-sm focus:ring-1 focus:ring-primary appearance-none cursor-pointer">
                            <option class="text-orange-600" value="pending">Pending</option>
                            <option value="reviewed">Reviewed</option>
                            <option value="hired">Hired</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <button class="p-2 text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity" type="button">
                            <span class="material-symbols-outlined">more_vert</span>
                        </button>
                    </td>
                </tr>

                <tr class="group hover:bg-surface-container-low/30 transition-colors">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center font-bold text-primary">MK</div>
                            <div class="flex flex-col">
                                <span class="font-body-md text-body-md font-semibold text-primary">Marcus King</span>
                                <span class="text-xs text-on-surface-variant">Austin, TX</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5"><span class="font-body-md text-body-md">Frontend Architect</span></td>
                    <td class="px-8 py-5"><span class="font-body-md text-body-md text-on-surface-variant">Oct 11, 2023</span></td>
                    <td class="px-8 py-5 text-center">
                        <a class="p-2 rounded-lg hover:bg-surface-container inline-flex items-center justify-center text-primary transition-all" href="#">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'wght' 300;">description</span>
                        </a>
                    </td>
                    <td class="px-8 py-5">
                        <select class="bg-green-50 text-green-700 border-none rounded-full px-4 py-1.5 font-label-sm text-label-sm focus:ring-1 focus:ring-green-600 appearance-none cursor-pointer">
                            <option selected value="hired">Hired</option>
                            <option value="pending">Pending</option>
                            <option value="reviewed">Reviewed</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <button class="p-2 text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity" type="button">
                            <span class="material-symbols-outlined">more_vert</span>
                        </button>
                    </td>
                </tr>

                <tr class="group hover:bg-surface-container-low/30 transition-colors">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center font-bold text-primary">SL</div>
                            <div class="flex flex-col">
                                <span class="font-body-md text-body-md font-semibold text-primary">Sarah Lopez</span>
                                <span class="text-xs text-on-surface-variant">New York, NY</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5"><span class="font-body-md text-body-md">Marketing Director</span></td>
                    <td class="px-8 py-5"><span class="font-body-md text-body-md text-on-surface-variant">Oct 10, 2023</span></td>
                    <td class="px-8 py-5 text-center">
                        <a class="p-2 rounded-lg hover:bg-surface-container inline-flex items-center justify-center text-primary transition-all" href="#">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'wght' 300;">description</span>
                        </a>
                    </td>
                    <td class="px-8 py-5">
                        <select class="bg-blue-50 text-blue-700 border-none rounded-full px-4 py-1.5 font-label-sm text-label-sm focus:ring-1 focus:ring-blue-600 appearance-none cursor-pointer">
                            <option selected value="reviewed">Reviewed</option>
                            <option value="pending">Pending</option>
                            <option value="hired">Hired</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <button class="p-2 text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity" type="button">
                            <span class="material-symbols-outlined">more_vert</span>
                        </button>
                    </td>
                </tr>

                <tr class="group hover:bg-surface-container-low/30 transition-colors">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center font-bold text-primary">JT</div>
                            <div class="flex flex-col">
                                <span class="font-body-md text-body-md font-semibold text-primary">James Tan</span>
                                <span class="text-xs text-on-surface-variant">London, UK</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5"><span class="font-body-md text-body-md">Data Scientist</span></td>
                    <td class="px-8 py-5"><span class="font-body-md text-body-md text-on-surface-variant">Oct 09, 2023</span></td>
                    <td class="px-8 py-5 text-center">
                        <a class="p-2 rounded-lg hover:bg-surface-container inline-flex items-center justify-center text-primary transition-all" href="#">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'wght' 300;">description</span>
                        </a>
                    </td>
                    <td class="px-8 py-5">
                        <select class="bg-red-50 text-red-700 border-none rounded-full px-4 py-1.5 font-label-sm text-label-sm focus:ring-1 focus:ring-red-600 appearance-none cursor-pointer">
                            <option selected value="rejected">Rejected</option>
                            <option value="pending">Pending</option>
                            <option value="reviewed">Reviewed</option>
                            <option value="hired">Hired</option>
                        </select>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <button class="p-2 text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity" type="button">
                            <span class="material-symbols-outlined">more_vert</span>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="px-8 py-5 border-t border-surface-container flex items-center justify-between">
            <p class="font-label-sm text-label-sm text-on-surface-variant">Showing 1-10 of 152 results</p>
            <div class="flex items-center gap-1">
                <button class="p-2 hover:bg-surface-container-low rounded-lg transition-all disabled:opacity-30" disabled type="button">
                    <span class="material-symbols-outlined">chevron_left</span>
                </button>
                <button class="w-8 h-8 flex items-center justify-center bg-primary text-white text-xs font-bold rounded-lg" type="button">1</button>
                <button class="w-8 h-8 flex items-center justify-center hover:bg-surface-container text-xs font-bold rounded-lg transition-all" type="button">2</button>
                <button class="w-8 h-8 flex items-center justify-center hover:bg-surface-container text-xs font-bold rounded-lg transition-all" type="button">3</button>
                <button class="p-2 hover:bg-surface-container-low rounded-lg transition-all" type="button">
                    <span class="material-symbols-outlined">chevron_right</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Footer Context / Secondary Area -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-12">
        <div class="bg-surface-container-low p-8 rounded-[24px] flex flex-col justify-center border border-surface-container-highest">
            <h4 class="font-headline-md text-headline-md mb-2">Upcoming Interviews</h4>
            <p class="text-on-surface-variant font-body-md text-body-md mb-6">
                You have 4 interviews scheduled for today. Make sure to review the candidate briefs.
            </p>
            <button class="self-start px-6 py-2.5 bg-white border border-outline-variant rounded-full font-label-sm text-label-sm hover:border-primary hover:text-primary transition-all" type="button">
                View Calendar
            </button>
        </div>

        <div class="bg-white p-8 rounded-[24px] border border-surface-container flex gap-6 items-center shadow-[0_4px_12px_rgba(0,0,0,0.02)]">
            <div class="flex-1">
                <h4 class="font-headline-md text-headline-md mb-2">Automate Screening</h4>
                <p class="text-on-surface-variant font-body-md text-body-md">
                    Use our AI-powered screening tool to filter candidates based on custom parameters.
                </p>
            </div>
            <div class="w-24 h-24 flex-shrink-0 bg-primary-container text-on-primary-container rounded-2xl flex items-center justify-center">
                <span class="material-symbols-outlined text-[48px]">auto_awesome</span>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Micro-interactions for Status Dropdowns
    document.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', (e) => {
            const val = e.target.value;

            e.target.className = 'border-none rounded-full px-4 py-1.5 font-label-sm text-label-sm focus:ring-1 appearance-none cursor-pointer';

            if (val === 'pending') e.target.classList.add('bg-surface-container-low', 'text-on-surface-variant');
            if (val === 'reviewed') e.target.classList.add('bg-blue-50', 'text-blue-700');
            if (val === 'hired') e.target.classList.add('bg-green-50', 'text-green-700');
            if (val === 'rejected') e.target.classList.add('bg-red-50', 'text-red-700');
        });
    });

    // Hover animation for sidebar items
    const navItems = document.querySelectorAll('aside nav a');
    navItems.forEach(item => {
        item.addEventListener('mouseenter', () => {
            if (!item.classList.contains('bg-white/5')) {
                item.style.transform = 'translateX(4px)';
            }
        });
        item.addEventListener('mouseleave', () => {
            item.style.transform = 'translateX(0)';
        });
    });
</script>
@endpush

