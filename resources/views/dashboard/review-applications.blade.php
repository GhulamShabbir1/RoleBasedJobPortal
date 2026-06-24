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

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6" id="stats-container">
        <div class="bg-white p-6 rounded-[24px] border border-surface-container shadow-[0_4px_12px_rgba(0,0,0,0.02)] hover:shadow-[0_8px_24px_rgba(0,0,0,0.04)] transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-full bg-surface-container-low flex items-center justify-center">
                    <span class="material-symbols-outlined text-on-surface">inbox</span>
                </div>
            </div>
            <p class="text-on-surface-variant font-label-sm text-label-sm uppercase tracking-widest">Total Received</p>
            <h3 class="font-headline-lg text-headline-lg text-primary mt-1" id="total-applications">0</h3>
        </div>

        <div class="bg-white p-6 rounded-[24px] border border-surface-container shadow-[0_4px_12px_rgba(0,0,0,0.02)] hover:shadow-[0_8px_24px_rgba(0,0,0,0.04)] transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-full bg-surface-container-low flex items-center justify-center">
                    <span class="material-symbols-outlined text-on-surface">pending_actions</span>
                </div>
            </div>
            <p class="text-on-surface-variant font-label-sm text-label-sm uppercase tracking-widest">Pending Review</p>
            <h3 class="font-headline-lg text-headline-lg text-primary mt-1" id="pending-applications">0</h3>
        </div>

        <div class="bg-white p-6 rounded-[24px] border border-surface-container shadow-[0_4px_12px_rgba(0,0,0,0.02)] hover:shadow-[0_8px_24px_rgba(0,0,0,0.04)] transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-full bg-surface-container-low flex items-center justify-center">
                    <span class="material-symbols-outlined text-on-surface" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                </div>
            </div>
            <p class="text-on-surface-variant font-label-sm text-label-sm uppercase tracking-widest">Accepted This Month</p>
            <h3 class="font-headline-lg text-headline-lg text-primary mt-1" id="accepted-applications">0</h3>
        </div>

        <div class="bg-white p-6 rounded-[24px] border border-surface-container shadow-[0_4px_12px_rgba(0,0,0,0.02)] hover:shadow-[0_8px_24px_rgba(0,0,0,0.04)] transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-full bg-surface-container-low flex items-center justify-center">
                    <span class="material-symbols-outlined text-on-surface">edit</span>
                </div>
            </div>
            <p class="text-on-surface-variant font-label-sm text-label-sm uppercase tracking-widest">Reviewed</p>
            <h3 class="font-headline-lg text-headline-lg text-primary mt-1" id="reviewed-applications">0</h3>
        </div>
    </div>

    <div class="bg-white rounded-[24px] border border-surface-container shadow-[0_4px_12px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="px-8 py-6 border-b border-surface-container flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h2 class="font-headline-md text-headline-md">Recent Applications</h2>
            <div class="flex gap-2">
                <button class="px-4 py-2 text-xs font-bold bg-surface-container-low text-primary rounded-lg" type="button">All</button>
                <button class="px-4 py-2 text-xs font-bold text-on-surface-variant hover:bg-surface-container-low rounded-lg transition-all" type="button">New</button>
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

                <tbody id="applications-table-body" class="divide-y divide-surface-container">
                    <tr><td class="px-8 py-5 text-center" colspan="6">Loading...</td></tr>
                </tbody>
            </table>
        </div>

        <div class="px-8 py-5 border-t border-surface-container flex items-center justify-between">
            <p class="font-label-sm text-label-sm text-on-surface-variant" id="pagination-text">Showing 0-0 of 0 results</p>
            <div class="flex items-center gap-1">
                <button class="p-2 hover:bg-surface-container-low rounded-lg transition-all disabled:opacity-30" disabled type="button">
                    <span class="material-symbols-outlined">chevron_left</span>
                </button>
                <button class="w-8 h-8 flex items-center justify-center bg-primary text-white text-xs font-bold rounded-lg" type="button">1</button>
                <button class="p-2 hover:bg-surface-container-low rounded-lg transition-all" type="button">
                    <span class="material-symbols-outlined">chevron_right</span>
                </button>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
let applications = [];
document.addEventListener('DOMContentLoaded', loadApplications);

async function loadApplications() {
    try {
        const token = localStorage.getItem('token');
        const res = await fetch(`${API_URL}/applications`, {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: 'application/json'
            }
        });
        const json = await res.json();
        
        if (json.success && json.data) {
            applications = json.data;
            renderApplications();
            updateStats();
        }
    } catch (err) {
        console.error(err);
    }
}

function getStatusClass(status) {
    switch (status) {
        case 'pending': return 'bg-surface-container-low text-on-surface-variant';
        case 'reviewed': return 'bg-blue-50 text-blue-700';
        case 'accepted': return 'bg-green-50 text-green-700';
        case 'rejected': return 'bg-red-50 text-red-700';
        default: return 'bg-surface-container-low text-on-surface-variant';
    }
}

function getInitials(name) {
    return name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0,2);
}

function renderApplications() {
    const tbody = document.getElementById('applications-table-body');
    const paginationText = document.getElementById('pagination-text');
    
    if (applications.length === 0) {
        tbody.innerHTML = '<tr><td class="px-8 py-5 text-center" colspan="6">No applications found</td></tr>';
        paginationText.textContent = 'Showing 0-0 of 0 results';
        return;
    }

    paginationText.textContent = `Showing 1-${applications.length} of ${applications.length} results`;
    tbody.innerHTML = applications.map(app => `
        <tr class="group hover:bg-surface-container-low/30 transition-colors">
            <td class="px-8 py-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center font-bold text-primary">${getInitials(app.candidate?.name || 'Candidate')}</div>
                    <div class="flex flex-col">
                        <span class="font-body-md text-body-md font-semibold text-primary">${app.candidate?.name || 'Candidate'}</span>
                        <span class="text-xs text-on-surface-variant">${app.candidate?.city || ''}</span>
                    </div>
                </div>
            </td>
            <td class="px-8 py-5"><span class="font-body-md text-body-md">${app.job?.title || 'Job'}</span></td>
            <td class="px-8 py-5"><span class="font-body-md text-body-md text-on-surface-variant">${app.applied_at ? new Date(app.applied_at).toLocaleDateString() : 'N/A'}</span></td>
            <td class="px-8 py-5 text-center">
                ${app.candidate?.resume_url ? `
                    <a href="${app.candidate.resume_url}" target="_blank" class="p-2 rounded-lg hover:bg-surface-container inline-flex items-center justify-center text-primary transition-all">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'wght' 300;">description</span>
                    </a>
                ` : ''}
            </td>
            <td class="px-8 py-5">
                <select class="border-none rounded-full px-4 py-1.5 font-label-sm text-label-sm focus:ring-1 appearance-none cursor-pointer ${getStatusClass(app.status)}" data-id="${app.id}" onchange="updateApplicationStatus(this)">
                    <option ${app.status === 'pending' ? 'selected' : ''} value="pending">Pending</option>
                    <option ${app.status === 'reviewed' ? 'selected' : ''} value="reviewed">Reviewed</option>
                    <option ${app.status === 'accepted' ? 'selected' : ''} value="accepted">Accepted</option>
                    <option ${app.status === 'rejected' ? 'selected' : ''} value="rejected">Rejected</option>
                </select>
            </td>
            <td class="px-8 py-5 text-right"></td>
        </tr>
    `).join('');
}

async function updateApplicationStatus(select) {
    try {
        const token = localStorage.getItem('token');
        const id = select.dataset.id;
        const status = select.value;
        
        const res = await fetch(`${API_URL}/applications/${id}/review`, {
            method: 'PUT',
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ status })
        });
        const json = await res.json();
        
        if (json.success) {
            select.className = 'border-none rounded-full px-4 py-1.5 font-label-sm text-label-sm focus:ring-1 appearance-none cursor-pointer ' + getStatusClass(status);
            updateStats();
        } else {
            alert(json.message || 'Failed to update status');
        }
    } catch (err) {
        console.error(err);
        alert('Failed to update status');
    }
}

function updateStats() {
    const total = applications.length;
    const pending = applications.filter(a => a.status === 'pending').length;
    const reviewed = applications.filter(a => a.status === 'reviewed').length;
    const accepted = applications.filter(a => a.status === 'accepted').length;
    
    document.getElementById('total-applications').textContent = total;
    document.getElementById('pending-applications').textContent = pending;
    document.getElementById('reviewed-applications').textContent = reviewed;
    document.getElementById('accepted-applications').textContent = accepted;
}
</script>
@endpush

