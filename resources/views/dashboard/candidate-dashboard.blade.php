@extends('layouts.app')

@section('title', 'Candidate Dashboard · jobboard')
@section('page_title', 'Candidate Dashboard')
@section('page_subtitle', '· overview')

@section('content')
<div class="p-10 max-w-[1440px] w-full mx-auto space-y-10">

    <!-- Bento Stat Grid -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Stat Card 1 -->
        <div class="bg-white p-8 rounded-[24px] border border-[#ECECEC] stat-card-shadow flex flex-col justify-between h-[200px] group overflow-hidden relative">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-surface-container-low rounded-full scale-0 group-hover:scale-100 transition-transform duration-500 opacity-50"></div>
            <div>
                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest mb-1">Available Jobs</p>
                <h3 class="font-display text-[42px] text-primary">1,284</h3>
            </div>
            <div class="flex items-center gap-2 text-[#008A5E]">
                <span class="material-symbols-outlined text-[18px]">trending_up</span>
                <span class="font-label-sm text-label-sm">+12% this week</span>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white p-8 rounded-[24px] border border-[#ECECEC] stat-card-shadow flex flex-col justify-between h-[200px] group overflow-hidden relative">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-surface-container-low rounded-full scale-0 group-hover:scale-100 transition-transform duration-500 opacity-50"></div>
            <div>
                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest mb-1">Applications Submitted</p>
                <h3 class="font-display text-[42px] text-primary">24</h3>
            </div>
            <div class="flex items-center gap-2 text-on-surface-variant">
                <span class="material-symbols-outlined text-[18px]">schedule</span>
                <span class="font-label-sm text-label-sm">4 pending review</span>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white p-8 rounded-[24px] border border-[#ECECEC] stat-card-shadow flex flex-col justify-between h-[200px] group overflow-hidden relative">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-surface-container-low rounded-full scale-0 group-hover:scale-100 transition-transform duration-500 opacity-50"></div>
            <div>
                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest mb-1">Profile Views</p>
                <h3 class="font-display text-[42px] text-primary">492</h3>
            </div>
            <div class="flex items-center gap-2 text-primary">
                <span class="material-symbols-outlined text-[18px]">visibility</span>
                <span class="font-label-sm text-label-sm">Top 5% in category</span>
            </div>
        </div>
    </section>

    <!-- Main Dashboard Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- Recent Activity Feed (List) -->
        <div class="lg:col-span-8 space-y-6">

            <div class="flex items-center justify-between">
                <h4 class="font-headline-md text-headline-md text-primary">Recent Activity</h4>
                <button class="text-primary font-label-sm text-label-sm underline underline-offset-4 hover:opacity-70 transition-opacity" type="button">View All</button>
            </div>

            <div class="bg-white rounded-[24px] border border-[#ECECEC] overflow-hidden">

                <!-- Activity Row 1 -->
                <div class="flex items-center justify-between p-6 hover:bg-[#F5F5F5] transition-colors border-b border-[#ECECEC]">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-surface-container-low rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">apartment</span>
                        </div>
                        <div>
                            <p class="font-body-md text-body-md text-primary font-semibold">Application Received: Linear</p>
                            <p class="font-label-sm text-label-sm text-on-surface-variant">Your application for 'Senior UI Designer' is being reviewed.</p>
                        </div>
                    </div>
                    <span class="font-label-sm text-[11px] text-on-surface-variant whitespace-nowrap ml-4">2h ago</span>
                </div>

                <!-- Activity Row 2 -->
                <div class="flex items-center justify-between p-6 hover:bg-[#F5F5F5] transition-colors border-b border-[#ECECEC]">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-surface-container-low rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">mail</span>
                        </div>
                        <div>
                            <p class="font-body-md text-body-md text-primary font-semibold">Message from Stripe</p>
                            <p class="font-label-sm text-label-sm text-on-surface-variant">"We'd love to schedule a preliminary call regarding..."</p>
                        </div>
                    </div>
                    <span class="font-label-sm text-[11px] text-on-surface-variant whitespace-nowrap ml-4">5h ago</span>
                </div>

                <!-- Activity Row 3 -->
                <div class="flex items-center justify-between p-6 hover:bg-[#F5F5F5] transition-colors border-b border-[#ECECEC]">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-surface-container-low rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">bookmark</span>
                        </div>
                        <div>
                            <p class="font-body-md text-body-md text-primary font-semibold">New Match: Figma</p>
                            <p class="font-label-sm text-label-sm text-on-surface-variant">A new 'Product Lead' role matches your profile preferences.</p>
                        </div>
                    </div>
                    <span class="font-label-sm text-[11px] text-on-surface-variant whitespace-nowrap ml-4">Yesterday</span>
                </div>

                <!-- Activity Row 4 -->
                <div class="flex items-center justify-between p-6 hover:bg-[#F5F5F5] transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-surface-container-low rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">verified_user</span>
                        </div>
                        <div>
                            <p class="font-body-md text-body-md text-primary font-semibold">Identity Verified</p>
                            <p class="font-label-sm text-label-sm text-on-surface-variant">Your professional credentials have been successfully validated.</p>
                        </div>
                    </div>
                    <span class="font-label-sm text-[11px] text-on-surface-variant whitespace-nowrap ml-4">2d ago</span>
                </div>

            </div>
        </div>

        <!-- Right Column: Personal Branding / Quick Actions -->
        <div class="lg:col-span-4 space-y-8">

            <div class="bg-[#111111] text-white p-8 rounded-[24px] relative overflow-hidden">
                <div class="relative z-10">
                    <h5 class="font-headline-md text-headline-md mb-2">Upgrade to Pro</h5>
                    <p class="font-body-md text-body-md opacity-70 mb-6">Get 3x more visibility and direct messaging with top-tier hiring managers.</p>
                    <button class="bg-white text-black px-6 py-3 rounded-full font-label-sm text-label-sm w-full hover:bg-opacity-90 transition-all" type="button">Go Premium</button>
                </div>
                <div class="absolute -bottom-8 -right-8 w-32 h-32 bg-white/10 rounded-full blur-3xl"></div>
            </div>

            <!-- Profile Completeness Card -->
            <div class="bg-white p-8 rounded-[24px] border border-[#ECECEC] stat-card-shadow">
                <div class="flex items-center justify-between mb-6">
                    <h5 class="font-label-sm text-label-sm text-primary uppercase tracking-widest">Profile Strength</h5>
                    <span class="text-primary font-bold">85%</span>
                </div>

                <div class="w-full bg-surface-container-low h-1.5 rounded-full mb-8 overflow-hidden">
                    <div class="bg-primary h-full w-[85%] rounded-full"></div>
                </div>

                <ul class="space-y-4">
                    <li class="flex items-center gap-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-green-500 text-[20px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                        <span class="font-body-md text-body-md">Contact information</span>
                    </li>
                    <li class="flex items-center gap-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-green-500 text-[20px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                        <span class="font-body-md text-body-md">Experience &amp; Education</span>
                    </li>
                    <li class="flex items-center gap-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-outline-variant text-[20px]">circle</span>
                        <span class="font-body-md text-body-md">Portfolio projects (2+ needed)</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Horizontal Section: Featured Opportunities -->
    <section class="space-y-6">
        <div class="flex items-center justify-between">
            <h4 class="font-headline-md text-headline-md text-primary">Recommended for You</h4>
            <div class="flex gap-2">
                <button class="p-2 border border-[#ECECEC] rounded-full hover:bg-white transition-all" type="button"><span class="material-symbols-outlined">chevron_left</span></button>
                <button class="p-2 border border-[#ECECEC] rounded-full hover:bg-white transition-all" type="button"><span class="material-symbols-outlined">chevron_right</span></button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            <!-- Job Card 1 -->
            <div class="bg-white p-6 rounded-[24px] border border-[#ECECEC] stat-card-shadow group cursor-pointer">
                <div class="flex items-start justify-between mb-6">
                    <div class="w-14 h-14 bg-surface-container-low rounded-2xl flex items-center justify-center overflow-hidden border border-[#ECECEC]">
                        <img class="w-8 h-8 object-contain" data-alt="Company logo" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBaZGHMn3PZAy-z_hCju254OkeNmWmUqLYzV_aindUyyJS-LJux8q6BhhgoIonkk3-ZmV2S7HNlo8vj1X1d48YpK75dUolP11yxBK9wxqtoUYhTpKvowPKXt1DUjijS0vImnvvABvlPxrECHaN2ppJoxczQHJ26iwxbX1Ew4GpRAcZX7kUBINOkHnCdtyDpFve3WknxLkruGaIWycmFBLZpEoCS8uX1ujrWYQh7pbYddUGbN03df66-5jwkUZLMuB---k07rmDyuX0" />
                    </div>
                    <span class="bg-[#F0FDF4] text-[#166534] px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider">New</span>
                </div>

                <h6 class="font-headline-md text-headline-md text-primary group-hover:underline underline-offset-4 decoration-2">Lead Product Designer</h6>
                <p class="font-body-md text-body-md text-on-surface-variant mb-6">NextGen Systems • Remote</p>
                <div class="flex items-center gap-4 flex-wrap">
                    <span class="bg-surface-container-low text-on-surface-variant px-3 py-1.5 rounded-full text-[11px] font-semibold">$140k - $180k</span>
                    <span class="bg-surface-container-low text-on-surface-variant px-3 py-1.5 rounded-full text-[11px] font-semibold">Full-time</span>
                </div>
            </div>

            <!-- Job Card 2 -->
            <div class="bg-white p-6 rounded-[24px] border border-[#ECECEC] stat-card-shadow group cursor-pointer">
                <div class="flex items-start justify-between mb-6">
                    <div class="w-14 h-14 bg-surface-container-low rounded-2xl flex items-center justify-center overflow-hidden border border-[#ECECEC]">
                        <img class="w-8 h-8 object-contain" data-alt="Company logo" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDUA1yn9Qm5WMzHkDVlntj6Rt8iQZSsmv2wCXzSyUfTCvQeA3oC_v1-O-DgKW_uWjfzgT36K0ge_w7qEERrFBkA9Jn4z8sCVkZx2Rxdol5871WlWZesHbETayHDlxAonT6XOCq7tvhRBSP7bIodubXbii360YLKWvS3F4YkQfRDq-v3eY5iL1_89j_DCzHrFM3IcDJ5hdRqnrGJJv2egopVL8zhAzqFbOqPk5fvJcPeJgBN-fpgO2vy27LLqlo76xb0obaPqiiIO5A" />
                    </div>
                    <button class="text-on-surface-variant hover:text-primary transition-colors" type="button"><span class="material-symbols-outlined">bookmark</span></button>
                </div>

                <h6 class="font-headline-md text-headline-md text-primary group-hover:underline underline-offset-4 decoration-2">Senior Brand strategist</h6>
                <p class="font-body-md text-body-md text-on-surface-variant mb-6">Summit Creative • New York, NY</p>
                <div class="flex items-center gap-4 flex-wrap">
                    <span class="bg-surface-container-low text-on-surface-variant px-3 py-1.5 rounded-full text-[11px] font-semibold">$120k - $160k</span>
                    <span class="bg-surface-container-low text-on-surface-variant px-3 py-1.5 rounded-full text-[11px] font-semibold">Contract</span>
                </div>
            </div>

            <!-- Job Card 3 -->
            <div class="bg-white p-6 rounded-[24px] border border-[#ECECEC] stat-card-shadow group cursor-pointer">
                <div class="flex items-start justify-between mb-6">
                    <div class="w-14 h-14 bg-surface-container-low rounded-2xl flex items-center justify-center overflow-hidden border border-[#ECECEC]">
                        <img class="w-8 h-8 object-contain" data-alt="Company logo" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDrGLsiA0XC5PmCXwAE-jO20D0chk-NOb7HD4CZ0IpZ5hhrp5eXNj-iWufhNbx5cVi8Acl-oC5-uAYVg1OqRQxgQo9ErD3SBzUHf0xMjF4Jj1b4thx4BnnVqSXVppPGcH2hqbsO1x0C06bnBOaT6fsrU-wayO1eylrzA77l6TkUhkGfkaRX7k6kb7PmL4ch-JhaJnD2pVQ_prJN3ATFQ4uEqWWBPodhXGVCkqVl6a75qqUxObIE6XW91a77lgWRD8ZYGwBHVVgN230" />
                    </div>
                    <button class="text-on-surface-variant hover:text-primary transition-colors" type="button"><span class="material-symbols-outlined">bookmark</span></button>
                </div>

                <h6 class="font-headline-md text-headline-md text-primary group-hover:underline underline-offset-4 decoration-2">UX Researcher</h6>
                <p class="font-body-md text-body-md text-on-surface-variant mb-6">Velocity AI • London, UK</p>
                <div class="flex items-center gap-4 flex-wrap">
                    <span class="bg-surface-container-low text-on-surface-variant px-3 py-1.5 rounded-full text-[11px] font-semibold">£90k - £120k</span>
                    <span class="bg-surface-container-low text-on-surface-variant px-3 py-1.5 rounded-full text-[11px] font-semibold">Hybrid</span>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .stat-card-shadow {
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        transition: box-shadow 0.3s ease;
    }
    .stat-card-shadow:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.04);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', loadCandidateDashboardData);

    async function apiGet(path, auth = false) {
        const headers = { 'Accept': 'application/json' };
        if (auth) {
            headers.Authorization = `Bearer ${localStorage.getItem('token')}`;
        }
        const response = await fetch(`${API_URL}${path}`, { headers });
        const data = await response.json();
        if (!response.ok || data.success === false) {
            throw new Error(data.message || `Failed to load ${path}`);
        }
        const items = data.data?.data || data.data || [];
        return Array.isArray(items) ? items : [items];
    }

    async function loadCandidateDashboardData() {
        try {
            const [jobs, applications] = await Promise.all([
                apiGet('/jobs'),
                apiGet('/applications', true).catch(() => []),
            ]);

            const statValues = document.querySelectorAll('section.grid h3.font-display');
            if (statValues[0]) statValues[0].textContent = jobs.length;
            if (statValues[1]) statValues[1].textContent = applications.length;

            const pendingCount = applications.filter(application => (application.status || 'pending') === 'pending').length;
            const appSubText = statValues[1]?.closest('div.bg-white')?.querySelector('.flex.items-center.gap-2 span:last-child');
            if (appSubText) appSubText.textContent = `${pendingCount} pending review`;
        } catch (error) {
            console.error('Failed to load candidate dashboard data', error);
        }
    }

    // Search bar focus effect (best-effort)
    const searchInput = document.querySelector('input[type="text"]');
    if (searchInput) {
        searchInput.addEventListener('focus', () => {
            searchInput.classList.add('w-80', 'bg-white', 'ring-1', 'ring-[#ECECEC]');
        });
        searchInput.addEventListener('blur', () => {
            searchInput.classList.remove('w-80', 'bg-white', 'ring-1', 'ring-[#ECECEC]');
        });
    }
</script>
@endpush
