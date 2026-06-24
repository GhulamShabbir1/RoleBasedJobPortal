@extends('layouts.app')

@section('title', 'Admin Dashboard · jobboard')
@section('page_title', 'Dashboard')

@section('content')
<!-- ADMIN DASHBOARD (converted from provided HTML) -->
<div class="bg-background text-on-surface font-body-md overflow-hidden flex flex-col h-full">

    <!-- SideNavBar Anchor -->
    <aside class="docked fixed left-0 top-0 h-full w-sidebar_width bg-primary dark:bg-on-primary-fixed border-r border-outline-variant flex flex-col py-8 px-4 z-50">
        <div class="mb-12 px-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center">
                <span class="material-symbols-outlined text-primary text-2xl">work</span>
            </div>
            <div class="flex flex-col">
                <span class="font-display text-headline-md text-surface-container-lowest tracking-tight leading-none">jobboard</span>
                <span class="font-label-sm text-secondary-fixed opacity-60 text-[10px] uppercase tracking-widest mt-1">Admin Panel</span>
            </div>
        </div>

        <nav class="flex-1 space-y-2">
            <a class="relative flex items-center gap-4 px-4 py-3 rounded-lg text-surface-container-lowest bg-white/5 font-label-sm transition-all duration-150" href="#">
                <div class="absolute left-0 top-1/4 h-1/2 w-1 bg-white rounded-r-full"></div>
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
                <span>Dashboard</span>
            </a>

            <a class="flex items-center gap-4 px-4 py-3 rounded-lg text-secondary-fixed opacity-70 font-label-sm hover:text-surface-bright hover:bg-white/10 transition-colors" href="#">
                <span class="material-symbols-outlined">corporate_fare</span>
                <span>Companies</span>
            </a>

            <a class="flex items-center gap-4 px-4 py-3 rounded-lg text-secondary-fixed opacity-70 font-label-sm hover:text-surface-bright hover:bg-white/10 transition-colors" href="#">
                <span class="material-symbols-outlined">group</span>
                <span>Users</span>
            </a>

            <a class="flex items-center gap-4 px-4 py-3 rounded-lg text-secondary-fixed opacity-70 font-label-sm hover:text-surface-bright hover:bg-white/10 transition-colors" href="#">
                <span class="material-symbols-outlined">work_history</span>
                <span>Jobs</span>
            </a>

            <a class="flex items-center gap-4 px-4 py-3 rounded-lg text-secondary-fixed opacity-70 font-label-sm hover:text-surface-bright hover:bg-white/10 transition-colors" href="#">
                <span class="material-symbols-outlined">settings_suggest</span>
                <span>System Health</span>
            </a>
        </nav>

        <div class="mt-auto px-4 pt-8 border-t border-white/10">
            <button class="w-full bg-white text-primary font-label-sm py-3 px-4 rounded-full flex items-center justify-center gap-2 hover:bg-surface-bright transition-all active:scale-95 duration-150">
                <span class="material-symbols-outlined text-sm">add</span>
                Post a Job
            </button>
        </div>
    </aside>

    <!-- Main Content Shell -->
    <main class="ml-[280px] flex-1 flex flex-col h-full bg-[#FAFAFA] overflow-y-auto custom-scrollbar">
        <!-- TopNavBar Anchor -->
        <header class="sticky top-0 z-40 bg-white h-topbar_height border-b border-surface-container-highest shadow-sm flex justify-between items-center px-margin_desktop">
            <div class="flex items-center gap-6">
                <h1 class="font-headline-md text-headline-md text-primary">Overview</h1>
                <div class="flex items-center gap-2 bg-surface-container-low px-3 py-1 rounded-full">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    <span class="text-[11px] font-bold text-on-surface-variant uppercase tracking-wider">System Live</span>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <div class="hidden md:flex items-center bg-surface-container-low px-4 py-2 rounded-full w-64 focus-within:ring-2 ring-primary transition-all">
                    <span class="material-symbols-outlined text-outline text-xl">search</span>
                    <input class="bg-transparent border-none focus:ring-0 text-body-md w-full ml-2 placeholder:text-outline-variant" placeholder="Search analytics..." type="text"/>
                </div>

                <div class="flex items-center gap-4 border-l border-surface-container-highest pl-6">
                    <button class="text-on-secondary-fixed-variant hover:text-primary transition-colors relative">
                        <span class="material-symbols-outlined">notifications</span>
                        <span class="absolute top-0 right-0 w-2 h-2 bg-error rounded-full border-2 border-white"></span>
                    </button>

                    <button class="text-on-secondary-fixed-variant hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">settings</span>
                    </button>

                    <div class="flex items-center gap-3 ml-2 group cursor-pointer">
                        <div class="flex flex-col items-end">
                            <span class="font-label-sm text-primary leading-tight">Admin User</span>
                            <span class="text-[10px] bg-primary text-white px-2 py-0.5 rounded uppercase font-bold tracking-tighter">Super Admin</span>
                        </div>
                        <img class="w-10 h-10 rounded-full border-2 border-surface-container-highest group-hover:border-primary transition-all object-cover"
                             data-alt="A professional studio portrait of a modern executive in a minimalist architectural setting. High-key lighting, clean white background, monochromatic tones of black and white, conveying authority and premium SaaS design aesthetics. The lighting is soft but defined, highlighting a high-fidelity recruitment expert persona."
                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuCwmVIOUDUZJe4j9WCnOjJDuNBqJQAh-dC8A1oUp_o_cGPl16hEg7AonqtbfMmPf2Z7hXZTKksWvOpVRTbiMAw1IEErmJjCUELtE9E-RdGibkBI_oDXyGS-QOEyWzDian7-UoL7ayuQFRtn7rclf15_SvWyWnxLgBvg7LZ76SEKU5UpqnpneFsn6rdXT9odYjueJ_wrXX2CDikJ0HjRu9I6obFaGRRn2gCtuwK1x7O_Wj3okW18_cscdff43OkVaYpjILHv6yIO2Ns"/>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="p-margin_desktop space-y-8 max-w-container_max_width">

            <!-- Bento Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">

                <!-- Stat Card: Pending Companies -->
                <div class="premium-card p-8 flex flex-col justify-between h-48">
                    <div class="flex justify-between items-start">
                        <div class="w-12 h-12 rounded-2xl bg-surface-container-low flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-2xl">pending_actions</span>
                        </div>
                        <span class="text-xs font-bold text-error bg-error-container/30 px-2 py-1 rounded-lg">+12.5%</span>
                    </div>
                    <div>
                        <p class="text-outline text-sm font-medium mb-1">Pending Companies</p>
                        <h3 class="font-display text-4xl text-primary tracking-tight">42</h3>
                    </div>
                </div>

                <!-- Stat Card: Total Users -->
                <div class="premium-card p-8 flex flex-col justify-between h-48">
                    <div class="flex justify-between items-start">
                        <div class="w-12 h-12 rounded-2xl bg-surface-container-low flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-2xl">group</span>
                        </div>
                        <span class="text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded-lg">+8.2%</span>
                    </div>
                    <div>
                        <p class="text-outline text-sm font-medium mb-1">Total Users</p>
                        <h3 class="font-display text-4xl text-primary tracking-tight">12,482</h3>
                    </div>
                </div>

                <!-- Stat Card: Total Jobs -->
                <div class="premium-card p-8 flex flex-col justify-between h-48">
                    <div class="flex justify-between items-start">
                        <div class="w-12 h-12 rounded-2xl bg-surface-container-low flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-2xl">work_outline</span>
                        </div>
                        <span class="text-xs font-bold text-primary bg-primary-fixed px-2 py-1 rounded-lg">Stable</span>
                    </div>
                    <div>
                        <p class="text-outline text-sm font-medium mb-1">Total Jobs</p>
                        <h3 class="font-display text-4xl text-primary tracking-tight">3,105</h3>
                    </div>
                </div>

            </div>

            <!-- Health & Analytics Row -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">

                <!-- Platform Health Chart (Main) -->
                <div class="lg:col-span-2 premium-card p-8 flex flex-col">
                    <div class="flex justify-between items-center mb-10">
                        <div>
                            <h2 class="font-headline-md text-primary">Platform Health</h2>
                            <p class="text-outline text-sm">Response times &amp; API latency (Real-time)</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="px-3 py-1.5 rounded-lg border border-outline-variant text-xs font-bold hover:bg-surface-container-low transition-colors">24H</button>
                            <button class="px-3 py-1.5 rounded-lg bg-primary text-white text-xs font-bold transition-all shadow-md">7D</button>
                        </div>
                    </div>

                    <div class="flex-1 relative min-h-[300px] flex items-end justify-between gap-2 px-2">
                        <!-- Custom visual "chart" simulation -->
                        <div class="flex-1 bg-surface-container-low rounded-t-lg relative group h-[60%] hover:bg-primary transition-all duration-500">
                            <div class="absolute -top-8 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity bg-black text-white text-[10px] px-2 py-1 rounded">240ms</div>
                        </div>
                        <div class="flex-1 bg-surface-container-low rounded-t-lg relative group h-[45%] hover:bg-primary transition-all duration-500"></div>
                        <div class="flex-1 bg-surface-container-low rounded-t-lg relative group h-[70%] hover:bg-primary transition-all duration-500"></div>
                        <div class="flex-1 bg-surface-container-low rounded-t-lg relative group h-[55%] hover:bg-primary transition-all duration-500"></div>
                        <div class="flex-1 bg-surface-container-low rounded-t-lg relative group h-[90%] hover:bg-primary transition-all duration-500"></div>
                        <div class="flex-1 bg-surface-container-low rounded-t-lg relative group h-[65%] hover:bg-primary transition-all duration-500"></div>
                        <div class="flex-1 bg-surface-container-low rounded-t-lg relative group h-[80%] hover:bg-primary transition-all duration-500"></div>
                        <div class="flex-1 bg-surface-container-low rounded-t-lg relative group h-[40%] hover:bg-primary transition-all duration-500"></div>
                        <div class="flex-1 bg-surface-container-low rounded-t-lg relative group h-[75%] hover:bg-primary transition-all duration-500"></div>
                        <div class="flex-1 bg-surface-container-low rounded-t-lg relative group h-[60%] hover:bg-primary transition-all duration-500"></div>
                        <div class="flex-1 bg-surface-container-low rounded-t-lg relative group h-[85%] hover:bg-primary transition-all duration-500"></div>
                        <div class="flex-1 bg-surface-container-low rounded-t-lg relative group h-[50%] hover:bg-primary transition-all duration-500"></div>
                    </div>

                    <div class="flex justify-between mt-6 text-xs font-bold text-outline uppercase tracking-widest border-t border-surface-container-highest pt-6">
                        <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
                    </div>
                </div>

                <!-- Recent Activity Feed -->
                <div class="premium-card p-8 flex flex-col">
                    <h2 class="font-headline-md text-primary mb-8">System Activity</h2>
                    <div class="space-y-6 flex-1 overflow-y-auto custom-scrollbar pr-2">

                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full flex-shrink-0 bg-blue-50 flex items-center justify-center text-blue-600">
                                <span class="material-symbols-outlined text-lg">check_circle</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-primary">New Job Approved</p>
                                <p class="text-xs text-outline leading-relaxed mt-0.5">Senior Designer at 'DesignHub' was verified.</p>
                                <p class="text-[10px] text-outline-variant mt-1">2 mins ago</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full flex-shrink-0 bg-amber-50 flex items-center justify-center text-amber-600">
                                <span class="material-symbols-outlined text-lg">warning</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-primary">Verification Required</p>
                                <p class="text-xs text-outline leading-relaxed mt-0.5">'CloudScale' uploaded new tax documents.</p>
                                <p class="text-[10px] text-outline-variant mt-1">45 mins ago</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full flex-shrink-0 bg-red-50 flex items-center justify-center text-red-600">
                                <span class="material-symbols-outlined text-lg">report</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-primary">Suspicious Login</p>
                                <p class="text-xs text-outline leading-relaxed mt-0.5">Account ID #8842 flagged for unusual activity.</p>
                                <p class="text-[10px] text-outline-variant mt-1">2 hours ago</p>
                            </div>
                        </div>

                    </div>

                    <button class="mt-8 text-primary font-bold text-xs uppercase tracking-widest hover:translate-x-1 transition-transform flex items-center gap-2">
                        View Log <span class="material-symbols-outlined text-xs">arrow_forward</span>
                    </button>
                </div>

            </div>

            <!-- Management Section -->
            <div class="premium-card overflow-hidden">
                <div class="p-8 border-b border-surface-container-highest flex justify-between items-center bg-white">
                    <div>
                        <h2 class="font-headline-md text-primary">Pending Verifications</h2>
                        <p class="text-outline text-sm">Review applications from companies joining the portal.</p>
                    </div>
                    <button class="px-6 py-2 bg-primary text-white rounded-full text-sm font-bold shadow-sm hover:opacity-90 transition-all active:scale-95">Verify All</button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low/30">
                                <th class="px-8 py-5 text-xs font-bold text-outline uppercase tracking-widest">Company Name</th>
                                <th class="px-8 py-5 text-xs font-bold text-outline uppercase tracking-widest">Industry</th>
                                <th class="px-8 py-5 text-xs font-bold text-outline uppercase tracking-widest">Submitted Date</th>
                                <th class="px-8 py-5 text-xs font-bold text-outline uppercase tracking-widest text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-container-highest">

                            <tr class="hover:bg-surface-container-low transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center font-bold text-primary">G</div>
                                        <div>
                                            <p class="font-bold text-primary">Globalize Tech</p>
                                            <p class="text-xs text-outline">San Francisco, CA</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-3 py-1 bg-surface-container text-on-surface-variant rounded-full text-xs font-semibold">SaaS / Fintech</span>
                                </td>
                                <td class="px-8 py-6 text-sm text-outline">Oct 24, 2023</td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button class="w-9 h-9 rounded-full border border-outline-variant flex items-center justify-center hover:bg-white transition-colors" type="button">
                                            <span class="material-symbols-outlined text-sm">visibility</span>
                                        </button>
                                        <button class="w-9 h-9 rounded-full bg-primary text-white flex items-center justify-center shadow-md" type="button">
                                            <span class="material-symbols-outlined text-sm">check</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="hover:bg-surface-container-low transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center font-bold text-primary">H</div>
                                        <div>
                                            <p class="font-bold text-primary">Hyperion Labs</p>
                                            <p class="text-xs text-outline">London, UK</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-3 py-1 bg-surface-container text-on-surface-variant rounded-full text-xs font-semibold">AI / Robotics</span>
                                </td>
                                <td class="px-8 py-6 text-sm text-outline">Oct 25, 2023</td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button class="w-9 h-9 rounded-full border border-outline-variant flex items-center justify-center hover:bg-white transition-colors" type="button">
                                            <span class="material-symbols-outlined text-sm">visibility</span>
                                        </button>
                                        <button class="w-9 h-9 rounded-full bg-primary text-white flex items-center justify-center shadow-md" type="button">
                                            <span class="material-symbols-outlined text-sm">check</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="hover:bg-surface-container-low transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center font-bold text-primary">V</div>
                                        <div>
                                            <p class="font-bold text-primary">Vanguard Creative</p>
                                            <p class="text-xs text-outline">New York, NY</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-3 py-1 bg-surface-container text-on-surface-variant rounded-full text-xs font-semibold">Design Studio</span>
                                </td>
                                <td class="px-8 py-6 text-sm text-outline">Oct 26, 2023</td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button class="w-9 h-9 rounded-full border border-outline-variant flex items-center justify-center hover:bg-white transition-colors" type="button">
                                            <span class="material-symbols-outlined text-sm">visibility</span>
                                        </button>
                                        <button class="w-9 h-9 rounded-full bg-primary text-white flex items-center justify-center shadow-md" type="button">
                                            <span class="material-symbols-outlined text-sm">check</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="p-6 bg-white border-t border-surface-container-highest text-center">
                    <button class="text-outline text-xs font-bold uppercase tracking-widest hover:text-primary transition-colors" type="button">View All Applications</button>
                </div>
            </div>

        </div>

        <!-- Footer Decor -->
        <footer class="p-margin_desktop mt-auto opacity-40 text-[10px] uppercase tracking-[0.2em] font-bold text-outline">
            © 2023 jobboard recruitment ecosystem — core internal admin V2.4.1
        </footer>

    </main>

</div>
@endsection

@push('styles')
<style>
    .premium-card {
        background: #FFFFFF;
        border: 1px solid #ECECEC;
        border-radius: 24px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .premium-card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
        transform: translateY(-2px);
    }

    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e2e2;
        border-radius: 10px;
    }

    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', loadAdminDashboardData);

    async function adminApiGet(path, auth = true) {
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

    async function loadAdminDashboardData() {
        try {
            const statsResponse = await fetch(`${API_URL}/dashboard/admin`, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Accept': 'application/json'
                }
            });
            const statsData = await statsResponse.json();
            const stats = statsData.data;

            // Update the stat cards with IDs we'll add
            const statCards = document.querySelectorAll('.premium-card');
            if (statCards[0]) { // Pending Companies
                statCards[0].querySelector('h3').textContent = stats.pendingCompanies;
            }
            if (statCards[1]) { // Total Users
                statCards[1].querySelector('h3').textContent = stats.totalUsers;
            }
            if (statCards[2]) { // Total Jobs
                statCards[2].querySelector('h3').textContent = stats.totalJobs;
            }

            // Keep the pending companies table
            const companies = await adminApiGet('/companies').catch(() => []);
            const pendingCompanies = companies.filter(company => company.status === 'pending');
            const tbody = document.querySelector('tbody.divide-y');
            if (tbody) {
                tbody.innerHTML = pendingCompanies.length ? pendingCompanies.map(company => `
                    <tr class="hover:bg-surface-container-low transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center font-bold text-primary">${(company.name || 'C').substring(0, 1).toUpperCase()}</div>
                                <div>
                                    <p class="font-bold text-primary">${company.name || 'Company'}</p>
                                    <p class="text-xs text-outline">${company.city || ''} ${company.country || ''}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6"><span class="px-3 py-1 bg-surface-container text-on-surface-variant rounded-full text-xs font-semibold">${company.industry || company.email || '-'}</span></td>
                        <td class="px-8 py-6 text-sm text-outline">${company.created_at ? new Date(company.created_at).toLocaleDateString() : '-'}</td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-3">
                                <button class="w-9 h-9 rounded-full bg-primary text-white flex items-center justify-center shadow-md" type="button" onclick="adminCompanyAction('${company.id}', 'approve')">
                                    <span class="material-symbols-outlined text-sm">check</span>
                                </button>
                                <button class="w-9 h-9 rounded-full border border-outline-variant flex items-center justify-center hover:bg-white transition-colors" type="button" onclick="adminCompanyAction('${company.id}', 'reject')">
                                    <span class="material-symbols-outlined text-sm">close</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                `).join('') : '<tr><td class="px-8 py-6 text-outline" colspan="4">No pending companies found.</td></tr>';
            }
        } catch (error) {
            console.error('Failed to load admin dashboard data', error);
        }
    }

    async function adminCompanyAction(companyId, action) {
        const response = await fetch(`${API_URL}/companies/${companyId}/${action}`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: action === 'reject' ? JSON.stringify({ rejection_reason: 'Rejected by admin' }) : JSON.stringify({}),
        });
        const data = await response.json();
        if (!response.ok || !data.success) {
            alert(data.message || `Failed to ${action} company`);
            return;
        }
        loadAdminDashboardData();
    }

    // Micro-interaction for Stat Cards
    document.querySelectorAll('.premium-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            const icon = card.querySelector('.material-symbols-outlined');
            if (icon) {
                icon.style.transform = 'scale(1.1) rotate(5deg)';
                icon.style.transition = 'transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
            }
        });
        card.addEventListener('mouseleave', () => {
            const icon = card.querySelector('.material-symbols-outlined');
            if (icon) {
                icon.style.transform = 'scale(1) rotate(0deg)';
            }
        });
    });

    // Simple real-time update simulation for Health Chart
    setInterval(() => {
        const bars = document.querySelectorAll('.flex-1.bg-surface-container-low.rounded-t-lg');
        const randomBar = bars[Math.floor(Math.random() * bars.length)];
        if (!randomBar) return;
        const currentHeight = parseInt(
            randomBar.style.height ||
            (randomBar.className.match(/h-\[(\d+)%\]/) ? randomBar.className.match(/h-\[(\d+)%\]/)[1] : 50)
        );
        const delta = (Math.random() - 0.5) * 10;
        const newHeight = Math.min(Math.max(currentHeight + delta, 20), 95);
        randomBar.style.height = `${newHeight}%`;
    }, 3000);
</script>
@endpush
