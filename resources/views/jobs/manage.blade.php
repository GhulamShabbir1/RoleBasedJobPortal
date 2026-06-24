@extends('layouts.app')

@section('title', 'Manage Jobs | Admin')
@section('page_title', 'Manage Jobs')

@section('content')
<div class="bg-white rounded-2xl p-6 shadow-sm mb-6">
    <input id="search-input" type="text" placeholder="Search by job title..."
        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Job Title</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Company</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">City</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Created</th>
                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody id="jobs-table-body" class="divide-y divide-gray-100">
            <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Loading...</td></tr>
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    loadJobs();
    document.getElementById('search-input').addEventListener('input', function(e) {
        loadJobs(e.target.value);
    });
});

async function loadJobs(search = '') {
    try {
        const token = localStorage.getItem('token');
        const res = await fetch(`${API_URL}/admin/jobs` + (search ? `?search=${encodeURIComponent(search)}` : ''), {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: 'application/json'
            }
        });
        const json = await res.json();
        
        const tbody = document.getElementById('jobs-table-body');
        
        if (json.success && json.data && json.data.length > 0) {
            tbody.innerHTML = json.data.map(job => `
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">${job.title}</td>
                    <td class="px-6 py-4 text-gray-600">${job.company_name || 'N/A'}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold ${
                            job.status === 'open' ? 'bg-green-100 text-green-700' :
                            job.status === 'closed' ? 'bg-red-100 text-red-700' :
                            'bg-yellow-100 text-yellow-700'
                        }">
                            ${job.status}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">${job.city}</td>
                    <td class="px-6 py-4 text-gray-600 text-sm">
                        ${new Date(job.created_at).toLocaleDateString()}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-3">
                            ${job.status !== 'closed' ? `
                                <button onclick="closeJob(${job.id})" 
                                    class="px-3 py-1.5 text-xs font-semibold text-blue-600 bg-blue-50 rounded-full hover:bg-blue-100 transition-colors">
                                    Close
                                </button>
                            ` : ''}
                            <button onclick="deleteJob(${job.id})" 
                                class="px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 rounded-full hover:bg-red-100 transition-colors">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        } else {
            tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">No jobs found</td></tr>';
        }
    } catch (err) {
        console.error('Failed to load jobs:', err);
        alert('Failed to load jobs');
    }
}

async function closeJob(id) {
    if (!confirm('Are you sure you want to close this job?')) return;
    try {
        const token = localStorage.getItem('token');
        const res = await fetch(`${API_URL}/admin/jobs/${id}/close`, {
            method: 'POST',
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: 'application/json',
                'Content-Type': 'application/json'
            }
        });
        const json = await res.json();
        if (json.success) {
            loadJobs(document.getElementById('search-input').value);
        } else {
            alert(json.message || 'Failed to close job');
        }
    } catch (err) {
        console.error(err);
        alert('Failed to close job');
    }
}

async function deleteJob(id) {
    if (!confirm('Are you sure you want to delete this job?')) return;
    try {
        const token = localStorage.getItem('token');
        const res = await fetch(`${API_URL}/admin/jobs/${id}`, {
            method: 'DELETE',
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: 'application/json'
            }
        });
        const json = await res.json();
        if (json.success) {
            loadJobs(document.getElementById('search-input').value);
        } else {
            alert(json.message || 'Failed to delete job');
        }
    } catch (err) {
        console.error(err);
        alert('Failed to delete job');
    }
}
</script>
@endpush
