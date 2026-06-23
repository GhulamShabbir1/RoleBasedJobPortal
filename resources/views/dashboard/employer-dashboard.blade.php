@extends('layouts.app')

@section('title', 'Employer Dashboard · jobboard')
@section('page_title', 'Employer')

@section('content')
<section class="max-w-[1440px] mx-auto p-margin_desktop">
    <div class="mb-10">
        <h1 class="font-headline-lg text-headline-lg text-primary mb-2">Welcome back, James.</h1>
        <p class="font-body-lg text-body-lg text-secondary">Here is what is happening with your recruitment pipeline today.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter mb-12">
        <div class="ambient-card rounded-[24px] p-6 flex flex-col justify-between overflow-hidden relative group">
            <div class="z-10">
                <div class="flex items-center justify-between mb-4">
                    <span class="font-label-sm text-label-sm text-secondary uppercase tracking-widest">Your Active Jobs</span>
                    <div class="w-10 h-10 rounded-xl bg-surface-container-low flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-colors duration-300">
                        <span class="material-symbols-outlined text-[20px]">assignment</span>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="font-display text-[40px] font-bold text-primary leading-none">12</span>
                    <span class="text-success-600 font-label-sm text-[12px] text-[#10B981] flex items-center">
                        <span class="material-symbols-outlined text-[16px]">arrow_upward</span>
                        2
                    </span>
                </div>
            </div>
            <div class="mt-6">
                <div class="w-full bg-surface-container rounded-full h-1.5">
                    <div class="bg-primary h-1.5 rounded-full" style="width: 65%;"></div>
                </div>
                <p class="mt-2 font-label-sm text-label-sm text-outline">65% of monthly quota reached</p>
            </div>
        </div>

        <div class="ambient-card rounded-[24px] p-6 flex flex-col justify-between overflow-hidden relative group">
            <div class="z-10">
                <div class="flex items-center justify-between mb-4">
                    <span class="font-label-sm text-label-sm text-secondary uppercase tracking-widest">Total Applications Received</span>
                    <div class="w-10 h-10 rounded-xl bg-surface-container-low flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-colors duration-300">
                        <span class="material-symbols-outlined text-[20px]">group</span>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="font-display text-[40px] font-bold text-primary leading-none">842</span>
                    <span class="text-success-600 font-label-sm text-[12px] text-[#10B981] flex items-center">
                        <span class="material-symbols-outlined text-[16px]">arrow_upward</span>
                        14%
                    </span>
                </div>
            </div>
            <div class="mt-6 flex gap-1">
                <div class="h-8 flex-1 bg-surface-container-low rounded-sm"></div>
                <div class="h-10 flex-1 bg-surface-container-low rounded-sm"></div>
                <div class="h-6 flex-1 bg-surface-container-low rounded-sm"></div>
                <div class="h-12 flex-1 bg-primary rounded-sm"></div>
                <div class="h-9 flex-1 bg-surface-container-low rounded-sm"></div>
            </div>
        </div>

        <div class="ambient-card bg-primary rounded-[24px] p-6 text-white flex flex-col justify-between shadow-lg">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="font-label-sm text-label-sm opacity-60 uppercase tracking-widest">Avg. Time to Hire</span>
                    <span class="material-symbols-outlined text-white/40">timer</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="font-display text-[40px] font-bold text-white leading-none">18</span>
                    <span class="font-body-md text-body-md opacity-80">days</span>
                </div>
            </div>
            <div class="mt-6">
                <button class="w-full py-2.5 bg-white/10 hover:bg-white/20 rounded-full font-label-sm text-label-sm transition-all border border-white/5">
                    View Trends
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
        <div class="lg:col-span-2 ambient-card rounded-[24px] overflow-hidden">
            <div class="px-8 py-6 border-b border-surface-container-highest flex items-center justify-between">
                <h3 class="font-headline-md text-headline-md text-primary">Recent Candidate Applicants</h3>
                <a class="text-primary font-label-sm text-label-sm border-b border-primary hover:opacity-70 transition-opacity" href="#">View All Applications</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="text-left bg-surface-container-low">
                            <th class="px-8 py-4 font-label-sm text-label-sm text-outline uppercase tracking-wider">Candidate</th>
                            <th class="px-8 py-4 font-label-sm text-label-sm text-outline uppercase tracking-wider">Position</th>
                            <th class="px-8 py-4 font-label-sm text-label-sm text-outline uppercase tracking-wider">Status</th>
                            <th class="px-8 py-4 font-label-sm text-label-sm text-outline uppercase tracking-wider">Applied</th>
                            <th class="px-8 py-4 font-label-sm text-label-sm text-outline uppercase tracking-wider"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container-highest">
                        <tr class="hover:bg-surface-container-low transition-colors cursor-pointer group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <img class="w-10 h-10 rounded-full object-cover" data-alt="Close-up studio portrait of a confident female software engineer in her late 20s. She has a modern tech-professional look with a warm smile. Soft cinematic lighting with a neutral, clean white studio background. The style is crisp, high-end, and editorial, matching a premium recruitment portal aesthetic." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDiwikSyLG4abE62_8OpiD_PeBiOIyXPOD4cknXbEzZmVe34wxb_MJHQDL1kjWJlqij-2rYF47NnnR51H6ZEuiZHQexq9yVNPO1xHnEASaZiVxDAtdLMV24QYEG27uTQEuLm4PLChvC9xM3ROJSTEsIGH2EMP6_57hz6DlAr9Xoe2llqDIMKBjBR6CLqhuJE8fgza7hHtXEwGPdwWHgBWQFezTH844-3cB9rTsoKWE8-FhHwmrVqmTZXb39gNW9jsfOQD40Lo5FgII" />
                                    <div>
                                        <p class="font-body-md text-body-md font-semibold text-primary">Elena Rodriguez</p>
                                        <p class="text-[12px] text-outline">elena.r@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <p class="font-body-md text-body-md text-on-surface">Senior Product Designer</p>
                            </td>
                            <td class="px-8 py-5">
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-[11px] font-bold uppercase tracking-wider">In Review</span>
                            </td>
                            <td class="px-8 py-5">
                                <p class="font-body-md text-body-md text-secondary">2 hours ago</p>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors">chevron_right</span>
                            </td>
                        </tr>

                        <tr class="hover:bg-surface-container-low transition-colors cursor-pointer group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <img class="w-10 h-10 rounded-full object-cover" data-alt="Professional headshot of a focused male backend developer in his 30s. He has a clean-shaven, minimalist aesthetic, wearing a simple high-quality navy blue tee. Soft, balanced studio lighting with a light grey background. High-fidelity photography style consistent with luxury corporate branding." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCaeFMIwciyys2Egs5Uuca4BcSCE2xQQPfAmLd4GfdzOpvHvC5ZoC1myCEA1th_cUsdv_m_06mT5g3ZPMLcZMskMRydGxsfNwoNOGbjpj7Ybu2QT0Zenr9rndTtk7A_R5Uw6QGAKXg-1jlpmtdD7cM2EPf5C6iAHTWSv04AcXGg-DhVsUxHu-8v3guj5MfHGsitnjH25xE08SQJk3Y4PfTymSkp3-mKqFmnj9s_lQJflLd9LqoUb-cdx24CUaIDZTcN2g6qo7dl5yg" />
                                    <div>
                                        <p class="font-body-md text-body-md font-semibold text-primary">Marcus Thorne</p>
                                        <p class="text-[12px] text-outline">m.thorne@dev.co</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <p class="font-body-md text-body-md text-on-surface">Lead Dev Ops Engineer</p>
                            </td>
                            <td class="px-8 py-5">
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-50 text-yellow-700 text-[11px] font-bold uppercase tracking-wider">Shortlisted</span>
                            </td>
                            <td class="px-8 py-5">
                                <p class="font-body-md text-body-md text-secondary">5 hours ago</p>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors">chevron_right</span>
                            </td>
                        </tr>

                        <tr class="hover:bg-surface-container-low transition-colors cursor-pointer group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <img class="w-10 h-10 rounded-full object-cover" data-alt="Portrait of a professional Asian woman in her early 30s, Marketing Director profile. Elegant business casual attire, soft natural window lighting, clean office interior in the background. High contrast, sharp detail, premium SaaS directory visual style." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDkDapxzYTs6bhmbyFOLiipUJyvaaFopVYN43_FZPyG_IOc9gCw15MxSlce3blWs1gEosyqX52J9kLm3eBng7DghwYaRQsKzTBVxkYV7qkBAGrxJ7iVbSXhInq0zmFl_arkwnt_DTpNdaW43PzOR74rkVua2HvKVl8w9yksj0HvbcCDyYQAbnwbZBvRrzBzryKW6JduFyr5NiwM0mmffyW6Gli_i0iFU7OubEwvNZ3wpFLsst5fVVi7XU_Ija_tr-ppZsxGoCmWiD8" />
                                    <div>
                                        <p class="font-body-md text-body-md font-semibold text-primary">Sarah Chen</p>
                                        <p class="text-[12px] text-outline">sarah.chen@global.net</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <p class="font-body-md text-body-md text-on-surface">Head of Growth</p>
                            </td>
                            <td class="px-8 py-5">
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-50 text-green-700 text-[11px] font-bold uppercase tracking-wider">Interviewed</span>
                            </td>
                            <td class="px-8 py-5">
                                <p class="font-body-md text-body-md text-secondary">Yesterday</p>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors">chevron_right</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            <div class="ambient-card rounded-[24px] p-6">
                <h4 class="font-headline-md text-headline-md text-primary mb-6">Upcoming Interviews</h4>
                <div class="space-y-4">
                    <div class="flex gap-4 p-3 rounded-xl hover:bg-surface-container-low transition-all cursor-pointer border border-transparent hover:border-outline-variant">
                        <div class="w-12 h-12 rounded-lg bg-surface-container-highest flex flex-col items-center justify-center text-primary">
                            <span class="text-[10px] font-bold uppercase">Oct</span>
                            <span class="text-[16px] font-bold">24</span>
                        </div>
                        <div>
                            <p class="font-body-md text-body-md font-semibold text-primary leading-tight">Elena Rodriguez</p>
                            <p class="text-[12px] text-outline">Final Culture Fit • 10:30 AM</p>
                        </div>
                    </div>
                    <div class="flex gap-4 p-3 rounded-xl hover:bg-surface-container-low transition-all cursor-pointer border border-transparent hover:border-outline-variant">
                        <div class="w-12 h-12 rounded-lg bg-surface-container-highest flex flex-col items-center justify-center text-primary">
                            <span class="text-[10px] font-bold uppercase">Oct</span>
                            <span class="text-[16px] font-bold">25</span>
                        </div>
                        <div>
                            <p class="font-body-md text-body-md font-semibold text-primary leading-tight">Marcus Thorne</p>
                            <p class="text-[12px] text-outline">Technical Assessment • 2:00 PM</p>
                        </div>
                    </div>
                </div>

                <button class="w-full mt-6 py-2.5 border border-outline-variant rounded-full font-label-sm text-label-sm text-primary hover:bg-primary hover:text-white transition-all">
                    View Calendar
                </button>
            </div>

            <div class="relative overflow-hidden rounded-[24px] bg-primary-container p-6 text-white min-h-[200px] flex flex-col justify-end">
                <div class="relative z-10">
                    <h4 class="font-headline-md text-headline-md mb-2">Need more reach?</h4>
                    <p class="font-body-md text-body-md text-white/70 mb-4">Boost your job postings to reach 10x more relevant candidates.</p>
                    <button class="bg-white text-primary px-6 py-2 rounded-full font-label-sm text-label-sm font-bold hover:scale-105 transition-transform">
                        Boost Postings
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .ambient-card {
        background: #ffffff;
        border: 1px solid #ECECEC;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        transition: box-shadow 0.2s ease, transform 0.2s ease;
    }
    .ambient-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.04);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', loadEmployerDashboardData);

    async function employerApiGet(path) {
        const response = await fetch(`${API_URL}${path}`, {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'Accept': 'application/json',
            },
        });
        const data = await response.json();
        if (!response.ok || data.success === false) {
            throw new Error(data.message || `Failed to load ${path}`);
        }
        const items = data.data?.data || data.data || [];
        return Array.isArray(items) ? items : [items];
    }

    async function loadEmployerDashboardData() {
        try {
            const [jobs, applications] = await Promise.all([
                employerApiGet('/jobs').catch(() => []),
                employerApiGet('/applications').catch(() => []),
            ]);

            const statNumbers = document.querySelectorAll('.font-display.text-\\[40px\\]');
            if (statNumbers[0]) statNumbers[0].textContent = jobs.length;
            if (statNumbers[1]) statNumbers[1].textContent = applications.length;

            const tbody = document.querySelector('tbody.divide-y');
            if (tbody && applications.length) {
                tbody.innerHTML = applications.slice(0, 5).map(application => `
                    <tr class="hover:bg-surface-container-low transition-colors cursor-pointer group">
                        <td class="px-8 py-5">
                            <div>
                                <p class="font-body-md text-body-md font-semibold text-primary">${application.candidate_name || application.user?.name || 'Candidate'}</p>
                                <p class="text-[12px] text-outline">${application.user?.email || application.email || '-'}</p>
                            </div>
                        </td>
                        <td class="px-8 py-5"><p class="font-body-md text-body-md text-on-surface">${application.job_title || application.job?.title || 'Job'}</p></td>
                        <td class="px-8 py-5"><span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-[11px] font-bold uppercase tracking-wider">${application.status || 'pending'}</span></td>
                        <td class="px-8 py-5"><p class="font-body-md text-body-md text-secondary">${application.created_at ? new Date(application.created_at).toLocaleDateString() : '-'}</p></td>
                        <td class="px-8 py-5 text-right"><span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors">chevron_right</span></td>
                    </tr>
                `).join('');
            }
        } catch (error) {
            console.error('Failed to load employer dashboard data', error);
        }
    }

    document.querySelectorAll('.ambient-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-2px)';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
        });
    });

    const navLinks = document.querySelectorAll('aside nav a');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            navLinks.forEach(l => {
                l.classList.remove('text-surface-container-lowest', 'border-l-4', 'border-surface-container-lowest', 'bg-white/5');
                l.classList.add('text-secondary-fixed', 'opacity-70');
            });
            link.classList.remove('text-secondary-fixed', 'opacity-70');
            link.classList.add('text-surface-container-lowest', 'border-l-4', 'border-surface-container-lowest', 'bg-white/5');
        });
    });
</script>
@endpush
