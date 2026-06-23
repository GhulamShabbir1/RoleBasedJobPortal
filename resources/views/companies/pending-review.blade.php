@extends('layouts.app')

@section('title', 'Pending Companies Review · jobboard')
@section('page_title', 'Pending Review')

@section('content')
<section class="p-margin_desktop max-w-container_max_width w-full mx-auto">
    <!-- Welcome/Stats Header -->
    <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card-ambient p-6 rounded-xl flex flex-col gap-1">
            <span class="font-label-sm text-label-sm text-on-secondary-fixed-variant uppercase">Total Pending</span>
            <span class="font-headline-lg text-headline-lg">24</span>
        </div>
        <div class="card-ambient p-6 rounded-xl flex flex-col gap-1">
            <span class="font-label-sm text-label-sm text-on-secondary-fixed-variant uppercase">Reviewed Today</span>
            <span class="font-headline-lg text-headline-lg">12</span>
        </div>
        <div class="card-ambient p-6 rounded-xl flex flex-col gap-1">
            <span class="font-label-sm text-label-sm text-on-secondary-fixed-variant uppercase">Avg. Response Time</span>
            <span class="font-headline-lg text-headline-lg">4.2h</span>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="card-ambient rounded-2xl overflow-hidden">
        <div class="px-6 py-5 border-b border-[#ECECEC] flex items-center justify-between">
            <h3 class="font-headline-md text-headline-md">Registration Queue</h3>
            <div class="flex gap-2">
                <button class="flex items-center gap-2 px-3 py-1.5 border border-[#ECECEC] rounded-full text-label-sm font-label-sm hover:bg-[#F5F5F5] transition-colors" type="button">
                    <span class="material-symbols-outlined text-[16px]">filter_list</span>
                    Filter
                </button>
                <button class="flex items-center gap-2 px-3 py-1.5 border border-[#ECECEC] rounded-full text-label-sm font-label-sm hover:bg-[#F5F5F5] transition-colors" type="button">
                    <span class="material-symbols-outlined text-[16px]">download</span>
                    Export
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-surface-container-low/50">
                        <th class="px-6 py-4 font-label-sm text-label-sm text-on-secondary-fixed-variant">Company Name</th>
                        <th class="px-6 py-4 font-label-sm text-label-sm text-on-secondary-fixed-variant">Industry</th>
                        <th class="px-6 py-4 font-label-sm text-label-sm text-on-secondary-fixed-variant">Email</th>
                        <th class="px-6 py-4 font-label-sm text-label-sm text-on-secondary-fixed-variant">Certificate</th>
                        <th class="px-6 py-4 font-label-sm text-label-sm text-on-secondary-fixed-variant">Status</th>
                        <th class="px-6 py-4 font-label-sm text-label-sm text-on-secondary-fixed-variant text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#ECECEC]">
                    @foreach([
                        ['initial'=>'N','name'=>'NexuSphere Tech','industry'=>'Information Tech','email'=>'verify@nexusphere.io','cert'=>'tax_cert_2024.pdf','status'=>'Pending'],
                        ['initial'=>'L','name'=>'Lumina Creative','industry'=>'Marketing & Design','email'=>'admin@lumina.design','cert'=>'business_license.pdf','status'=>'Pending'],
                        ['initial'=>'V','name'=>'Vanguard Logistics','industry'=>'Supply Chain','email'=>'ops@vanguard.com','cert'=>'iso_cert.pdf','status'=>'Pending'],
                        ['initial'=>'A','name'=>'Apex Financial','industry'=>'FinTech','email'=>'hr@apex-fin.com','cert'=>'banking_license.pdf','status'=>'Pending']
                    ] as $row)
                        <tr class="hover:bg-[#F5F5F5] transition-colors">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-lg bg-surface-container-low flex items-center justify-center font-bold text-primary">{{ $row['initial'] }}</div>
                                    <div>
                                        <div class="font-headline-md text-[15px] leading-none">{{ $row['name'] }}</div>
                                        <div class="font-label-sm text-[11px] opacity-50 mt-1">Applied</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 font-body-md text-body-md">{{ $row['industry'] }}</td>
                            <td class="px-6 py-5 font-body-md text-body-md text-on-surface-variant">{{ $row['email'] }}</td>
                            <td class="px-6 py-5">
                                <a class="flex items-center gap-2 text-primary hover:underline font-label-sm text-label-sm" href="#" type="button">
                                    <span class="material-symbols-outlined text-[18px]">attachment</span>
                                    {{ $row['cert'] }}
                                </a>
                            </td>
                            <td class="px-6 py-5">
                                <span class="px-3 py-1 bg-surface-container-high text-on-surface-variant rounded-full text-[12px] font-label-sm">{{ $row['status'] }}</span>
                            </td>
                            <td class="px-6 py-5 text-right space-x-2">
                                <button class="inline-flex items-center px-4 py-1.5 border border-primary text-primary rounded-full font-label-sm text-label-sm hover:bg-primary hover:text-white transition-all active:scale-95" type="button">Approve</button>
                                <button class="inline-flex items-center px-4 py-1.5 border border-error text-error rounded-full font-label-sm text-label-sm hover:bg-error hover:text-white transition-all active:scale-95" type="button">Reject</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 flex items-center justify-between bg-surface-container-low/30">
            <p class="font-label-sm text-label-sm opacity-50">Showing 1 to 4 of 24 entries</p>
            <div class="flex gap-1">
                <button class="p-2 border border-[#ECECEC] rounded-lg hover:bg-white transition-all opacity-50 cursor-not-allowed" type="button">
                    <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                </button>
                <button class="p-2 border border-[#ECECEC] rounded-lg hover:bg-white transition-all" type="button">
                    <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Contextual Insight (Bento feel) -->
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="card-ambient p-8 rounded-3xl relative overflow-hidden">
            <div class="relative z-10">
                <h4 class="font-headline-md text-headline-md mb-4">Verification Guidelines</h4>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary mt-0.5">verified_user</span>
                        <p class="font-body-md text-body-md">Verify that the tax certificate matches the registered company name exactly.</p>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary mt-0.5">mail</span>
                        <p class="font-body-md text-body-md">Check the domain of the email address against the official company website.</p>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary mt-0.5">security</span>
                        <p class="font-body-md text-body-md">Flag any applications from restricted or high-risk jurisdictions for manual review.</p>
                    </li>
                </ul>
            </div>
            <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-surface-container opacity-50 rounded-full blur-3xl"></div>
        </div>

        <div class="card-ambient rounded-3xl overflow-hidden group">
            <div class="h-48 relative">
                <img class="w-full h-full object-cover grayscale transition-all group-hover:grayscale-0 group-hover:scale-105 duration-700"
                     data-alt="A sophisticated abstract architectural photograph of a modern skyscraper's glass facade reflecting the morning sky. The image uses a cool-toned palette of light blues, greys, and crisp whites."
                     src="https://lh3.googleusercontent.com/aida-public/AB6AXuDeG04hgV5q3YTKlPXOdccOL9LfiyFTYaRVXyjq1y2twSpb5gzrnn-t-BNbnS73gahIbF0q6sYNTFyiL8lMf9YTCK3HnkThGWG-wqhtAO18gHjXcwLY0cvhKOGIZ_bkQ5IseZrgCyDiOh3Yv6RpfLD1LL476qzAye_yIvmcCF_Hi-THV8JThdS3himYiWQJqEBpjRwduAS8THi3PkSef0aI7ia-vQSRK1rhS5dA84PqHhkzo0HoT5hMYweZYmSGUMYg3rgQfDEAgZU"/>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute bottom-6 left-6 text-white">
                    <span class="font-label-sm text-[10px] uppercase tracking-widest opacity-80">Security Update</span>
                    <h4 class="font-headline-md text-headline-md">Enhanced KYC Protocols</h4>
                </div>
            </div>
            <div class="p-6">
                <p class="font-body-md text-body-md opacity-70 mb-4">We've updated our automated screening process. High-confidence registrations are now pre-sorted at the top of your queue.</p>
                <button class="text-primary font-label-sm text-label-sm flex items-center gap-1 hover:gap-2 transition-all" type="button">
                    Learn more <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </button>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .card-ambient {
        background-color: #FFFFFF;
        border: 1px solid #ECECEC;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        transition: box-shadow 0.2s ease-in-out;
    }
    .card-ambient:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.04);
    }
</style>
@endpush

@push('scripts')
<script>
    // Micro-interactions for buttons
    document.querySelectorAll('button').forEach(btn => {
        btn.addEventListener('mousedown', () => {
            btn.style.transform = 'scale(0.96)';
        });
        btn.addEventListener('mouseup', () => {
            btn.style.transform = 'scale(1)';
        });
        btn.addEventListener('mouseleave', () => {
            btn.style.transform = 'scale(1)';
        });
    });

    // Hover animation for table rows
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.addEventListener('mouseenter', () => {
            row.style.cursor = 'pointer';
        });
    });
</script>
@endpush

