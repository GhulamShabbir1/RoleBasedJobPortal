@extends('layouts.app')

@section('title', 'Applications · Job Board')
@section('page_title', 'Applications')
@section('page_subtitle', '· track your status')

@push('styles')
<style>
    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #ececec;
    }

    .table th {
        color: #777;
        font-weight: 500;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge {
        display: inline-block;
        padding: 0.3rem 0.8rem;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge.pending { background: #fff3cd; color: #856404; }
    .badge.reviewed { background: #cce5ff; color: #004085; }
    .badge.rejected { background: #f8d7da; color: #721c24; }
    .badge.hired { background: #d4edda; color: #155724; }
</style>
@endpush

@section('content')
<div class="card">
    <div style="overflow-x: auto;">
        <table class="table" id="appsTable">
            <thead>
                <tr id="tableHeaderRow">
                    <!-- Headers injected by JS -->
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="5" class="text-center text-muted">Loading applications...</td></tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const role = currentUser.role || 'candidate';
        const headerRow = document.getElementById('tableHeaderRow');
        const tbody = document.querySelector('#appsTable tbody');

        if (role === 'employer' || role === 'admin') {
            headerRow.innerHTML = `
                <th>Candidate</th>
                <th>Job Title</th>
                <th>Applied On</th>
                <th>Status</th>
                <th>Actions</th>
            `;
            document.getElementById('globalUserRoleDisplay').parentElement.parentElement.previousElementSibling.innerHTML = `
                Applications <small>· review candidates</small>
            `;
        } else {
            headerRow.innerHTML = `
                <th>Job Title</th>
                <th>Company</th>
                <th>Applied On</th>
                <th>Status</th>
            `;
        }

        try {
            const response = await fetch(`${API_URL}/applications`, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success && data.data) {
                const apps = data.data.data ? data.data.data : data.data;

                if (apps.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">No applications found.</td></tr>`;
                    return;
                }

                if (role === 'employer' || role === 'admin') {
                    tbody.innerHTML = apps.map(app => `
                        <tr>
                            <td>
                                <strong>${app.candidate_name || 'Candidate'}</strong><br>
                                <a href="http://localhost:8000/storage/${app.resume_path}" target="_blank" style="font-size: 0.85rem; color: #0056b3;">View Resume</a>
                            </td>
                            <td>${app.job_title || 'Unknown Job'}</td>
                            <td>${new Date(app.created_at).toLocaleDateString()}</td>
                            <td><span class="badge ${app.status || 'pending'}">${app.status || 'pending'}</span></td>
                            <td>
                                <select onchange="updateAppStatus('${app.id}', this.value)" class="form-control" style="width: auto; padding: 0.3rem; font-size: 0.8rem; display: inline-block;">
                                    <option value="" disabled selected>Update Status</option>
                                    <option value="reviewed">Reviewed</option>
                                    <option value="hired">Hired</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </td>
                        </tr>
                    `).join('');
                } else {
                    tbody.innerHTML = apps.map(app => `
                        <tr>
                            <td><strong>${app.job_title || 'Unknown Job'}</strong></td>
                            <td>${app.company_name || '-'}</td>
                            <td>${new Date(app.created_at).toLocaleDateString()}</td>
                            <td><span class="badge ${app.status || 'pending'}">${app.status || 'pending'}</span></td>
                        </tr>
                    `).join('');
                }
            } else {
                tbody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">Failed to load applications.</td></tr>`;
            }
        } catch (err) {
            console.error(err);
            tbody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">A network error occurred.</td></tr>`;
        }
    });

    async function updateAppStatus(id, newStatus) {
        if(!newStatus) return;
        try {
            const response = await fetch(`${API_URL}/applications/${id}`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status: newStatus })
            });
            const data = await response.json();
            if(data.success) {
                alert('Status updated successfully!');
                window.location.reload();
            } else {
                alert('Error updating status: ' + data.message);
            }
        } catch(err) {
            console.error(err);
            alert('Failed to update status.');
        }
    }
</script>
@endpush
