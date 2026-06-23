@extends('layouts.app')

@section('title', 'My Applications · jobboard')
@section('page_title', 'Applications')

@section('content')
<div class="p-margin_desktop max-w-container_max_width w-full mx-auto space-y-8 flex-grow">

    <!-- Quick Stats Bento-ish Header -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="glass-card p-6 rounded-2xl flex flex-col justify-between">
            <span class="font-label-sm text-label-sm text-secondary uppercase tracking-widest">Total Sent</span>
            <div class="flex items-end justify-between mt-4">
                <span class="font-display text-display text-primary leading-none" style="font-size: 32px;">48</span>
                <span class="text-emerald-600 text-body-md flex items-center font-semibold">
                    <span class="material-symbols-outlined text-sm" data-icon="trending_up">trending_up</span>
                    12%
                </span>
            </div>
        </div>

        <div class="glass-card p-6 rounded-2xl flex flex-col justify-between border-l-4 border-primary">
            <span class="font-label-sm text-label-sm text-secondary uppercase tracking-widest">Active Jobs</span>
            <div class="flex items-end justify-between mt-4">
                <span class="font-display text-display text-primary leading-none" style="font-size: 32px;">12</span>
                <span class="text-secondary text-body-md">On track</span>
            </div>
        </div>

        <div class="glass-card p-6 rounded-2xl flex flex-col justify-between">
            <span class="font-label-sm text-label-sm text-secondary uppercase tracking-widest">Interviews</span>
            <div class="flex items-end justify-between mt-4">
                <span class="font-display text-display text-primary leading-none" style="font-size: 32px;">04</span>
                <span class="text-primary text-body-md font-semibold">Next: Tue</span>
            </div>
        </div>

        <div class="glass-card p-6 rounded-2xl flex flex-col justify-between bg-on-primary-fixed text-surface-container-lowest">
            <span class="font-label-sm text-label-sm opacity-60 uppercase tracking-widest">Hire Rate</span>
            <div class="flex items-end justify-between mt-4">
                <span class="font-display text-display text-white leading-none" style="font-size: 32px;">8%</span>
                <span class="material-symbols-outlined opacity-40" data-icon="bolt">bolt</span>
            </div>
        </div>
    </div>

    <!-- Main Table Section -->
    <section class="glass-card rounded-2xl overflow-hidden flex flex-col">
        <div class="px-8 py-6 border-b border-surface-container-highest flex justify-between items-center">
            <div>
                <h3 class="font-headline-md text-headline-md text-primary">All Applications</h3>
                <p class="font-body-md text-body-md text-secondary">Manage and track your active job applications</p>
            </div>
            <div class="flex items-center gap-2">
                <button class="flex items-center gap-2 px-4 py-2 rounded-full border border-outline-variant font-label-sm text-label-sm hover:bg-surface-container-low transition-all" type="button">
                    <span class="material-symbols-outlined text-[18px]" data-icon="filter_list">filter_list</span>
                    Filter
                </button>
                <button class="flex items-center gap-2 px-4 py-2 rounded-full border border-outline-variant font-label-sm text-label-sm hover:bg-surface-container-low transition-all" type="button">
                    <span class="material-symbols-outlined text-[18px]" data-icon="download">download</span>
                    Export
                </button>
            </div>
        </div>

        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low/50">
                        <th class="px-8 py-4 font-label-sm text-label-sm text-secondary border-b border-surface-container-highest">JOB TITLE</th>
                        <th class="px-8 py-4 font-label-sm text-label-sm text-secondary border-b border-surface-container-highest">COMPANY</th>
                        <th class="px-8 py-4 font-label-sm text-label-sm text-secondary border-b border-surface-container-highest">APPLIED DATE</th>
                        <th class="px-8 py-4 font-label-sm text-label-sm text-secondary border-b border-surface-container-highest">STATUS</th>
                        <th class="px-8 py-4 font-label-sm text-label-sm text-secondary border-b border-surface-container-highest text-right">ACTION</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container-highest">
                    @foreach([
                        ['title'=>'Principal UX Designer','meta'=>'Full-time • Remote','company'=>'Luminary Studio','companyBadge'=>'LS','date'=>'Oct 12, 2025','status'=>'Hired','statusClass'=>'bg-emerald-50 text-emerald-700 border border-emerald-100'],
                        ['title'=>'Design Systems Engineer','meta'=>'Contract • Hybrid','company'=>'Vortex Systems','companyBadge'=>'VX','date'=>'Oct 14, 2025','status'=>'Reviewed','statusClass'=>'bg-indigo-50 text-indigo-700 border border-indigo-100'],
                        ['title'=>'Senior Product Manager','meta'=>'Full-time • NYC','company'=>'Aura Network','companyBadge'=>'AN','date'=>'Oct 18, 2025','status'=>'Pending','statusClass'=>'bg-amber-50 text-amber-700 border border-amber-100'],
                        ['title'=>'Lead Brand Designer','meta'=>'Full-time • Remote','company'=>'Epoch','companyBadge'=>'EP','date'=>'Oct 05, 2025','status'=>'Rejected','statusClass'=>'bg-rose-50 text-rose-700 border border-rose-100'],
                        ['title'=>'UX Researcher','meta'=>'Contract • Remote','company'=>'Zenith Media','companyBadge'=>'ZM','date'=>'Sep 28, 2025','status'=>'Reviewed','statusClass'=>'bg-indigo-50 text-indigo-700 border border-indigo-100']
                    ] as $row)
                        <tr class="hover:bg-surface-container-low/30 transition-colors group">
                            <td class="px-8 py-5">
                                <p class="font-headline-md text-[15px] text-primary">{{ $row['title'] }}</p>
                                <p class="text-[12px] text-secondary">{{ $row['meta'] }}</p>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-md bg-sky-100 flex items-center justify-center text-sky-700 font-bold text-[10px]">{{ $row['companyBadge'] }}</div>
                                    <span class="font-body-md text-on-surface">{{ $row['company'] }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-body-md text-secondary">{{ $row['date'] }}</td>
                            <td class="px-8 py-5">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[12px] font-semibold {{ $row['statusClass'] }}">{{ $row['status'] }}</span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <button class="material-symbols-outlined text-outline hover:text-primary transition-colors" data-icon="more_horiz" type="button">more_horiz</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-8 py-4 border-t border-surface-container-highest flex justify-between items-center bg-surface-container-low/20">
            <p class="text-body-md text-secondary">Showing 5 of 48 applications</p>
            <div class="flex items-center gap-1">
                <button class="w-8 h-8 flex items-center justify-center rounded-md hover:bg-surface-container-low text-secondary transition-all" type="button">
                    <span class="material-symbols-outlined text-[20px]" data-icon="chevron_left">chevron_left</span>
                </button>
                <button class="w-8 h-8 flex items-center justify-center rounded-md bg-primary text-white font-label-sm text-label-sm transition-all" type="button">1</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-md hover:bg-surface-container-low text-secondary font-label-sm text-label-sm transition-all" type="button">2</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-md hover:bg-surface-container-low text-secondary font-label-sm text-label-sm transition-all" type="button">3</button>
                <span class="px-2 text-outline">...</span>
                <button class="w-8 h-8 flex items-center justify-center rounded-md hover:bg-surface-container-low text-secondary transition-all" type="button">
                    <span class="material-symbols-outlined text-[20px]" data-icon="chevron_right">chevron_right</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Bottom Insight Card -->
    <div class="flex flex-col lg:flex-row gap-6 mt-8">
        <div class="flex-[2] glass-card p-8 rounded-3xl relative overflow-hidden">
            <div class="relative z-10">
                <h4 class="font-headline-md text-headline-md text-primary mb-2">Maximize your hiring potential</h4>
                <p class="font-body-lg text-body-lg text-secondary max-w-lg mb-6">Complete your skills assessment to jump to the top of reviewer queues. Candidates with badges are 3x more likely to be interviewed.</p>
                <button class="bg-primary text-white px-6 py-3 rounded-full font-label-sm text-label-sm hover:scale-[1.02] active:scale-95 transition-all shadow-lg" type="button">
                    Take Skills Test
                </button>
            </div>
            <div class="absolute -right-10 -bottom-10 opacity-5 pointer-events-none">
                <span class="material-symbols-outlined" data-icon="verified" style="font-size: 240px;">verified</span>
            </div>
        </div>

        <div class="flex-1 glass-card p-8 rounded-3xl bg-secondary-container/50 flex flex-col justify-center">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white">
                    <span class="material-symbols-outlined" data-icon="tips_and_updates">tips_and_updates</span>
                </div>
                <h4 class="font-headline-md text-[18px] text-primary">Daily Tip</h4>
            </div>
            <p class="font-body-md text-body-md text-on-surface">Personalizing your cover letter for 'Vortex Systems' could increase your chances by 40% based on their recent hiring trends.</p>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(8px);
        border: 1px solid #ECECEC;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .glass-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.04);
    }
</style>
@endpush

@push('scripts')
<script>
    // Micro-interaction for hover states on rows
    document.querySelectorAll('tr').forEach(row => {
        row.addEventListener('mouseenter', () => {
            row.style.transform = 'translateX(4px)';
        });
        row.addEventListener('mouseleave', () => {
            row.style.transform = 'translateX(0)';
        });
    });

    // Search bar animation
    const searchInput = document.querySelector('input[type="text"]');
    searchInput?.addEventListener('focus', () => {
        if (searchInput.parentElement) {
            searchInput.parentElement.classList.add('w-80');
            searchInput.parentElement.classList.remove('w-64');
        }
    });
    searchInput?.addEventListener('blur', () => {
        if (searchInput.parentElement) {
            searchInput.parentElement.classList.add('w-64');
            searchInput.parentElement.classList.remove('w-80');
        }
    });
</script>
@endpush

