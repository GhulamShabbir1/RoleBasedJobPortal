@extends('layouts.app')

@section('title', 'Manage Users · jobboard Admin')
@section('page_title', 'Manage Users')

@section('content')
<section class="max-w-container_max_width mx-auto p-margin_desktop">
    <!-- Header Section -->
    <div class="flex justify-between items-end mb-8">
        <div>
            <h3 class="font-headline-lg text-headline-lg text-primary mb-2">User Directory</h3>
            <p class="font-body-md text-body-md text-secondary max-w-lg">Manage permissions, monitor activity, and regulate user access across the recruitment ecosystem.</p>
        </div>
        <div class="flex space-x-3">
            <button class="px-6 py-2.5 rounded-full border border-outline-variant text-primary font-label-sm text-label-sm hover:bg-surface-container-low transition-all" type="button">Export CSV</button>
            <button class="px-6 py-2.5 rounded-full bg-primary text-white font-label-sm text-label-sm hover:bg-opacity-90 transition-all shadow-sm" type="button">+ Add New User</button>
        </div>
    </div>

    <!-- Stats/Metrics Bar (Bento style) -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-3xl border border-[#ECECEC] shadow-[0_4px_12px_rgba(0,0,0,0.02)]">
            <p class="text-secondary font-label-sm text-label-sm mb-1 uppercase tracking-wider">Total Users</p>
            <p class="text-3xl font-bold text-primary">12,482</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-[#ECECEC] shadow-[0_4px_12px_rgba(0,0,0,0.02)]">
            <p class="text-secondary font-label-sm text-label-sm mb-1 uppercase tracking-wider">Employers</p>
            <p class="text-3xl font-bold text-primary">843</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-[#ECECEC] shadow-[0_4px_12px_rgba(0,0,0,0.02)]">
            <p class="text-secondary font-label-sm text-label-sm mb-1 uppercase tracking-wider">Candidates</p>
            <p class="text-3xl font-bold text-primary">11,639</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-[#ECECEC] shadow-[0_4px_12px_rgba(0,0,0,0.02)]">
            <p class="text-secondary font-label-sm text-label-sm mb-1 uppercase tracking-wider">Active Now</p>
            <div class="flex items-center">
                <p class="text-3xl font-bold text-primary">154</p>
                <span class="ml-2 w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-3xl border border-[#ECECEC] shadow-[0_4px_12px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-[#ECECEC] bg-surface-bright">
                        <th class="px-8 py-5 font-label-sm text-label-sm text-secondary uppercase tracking-widest w-12">
                            <input class="rounded border-outline-variant text-primary focus:ring-primary h-4 w-4" type="checkbox" />
                        </th>
                        <th class="px-8 py-5 font-label-sm text-label-sm text-secondary uppercase tracking-widest">Name</th>
                        <th class="px-8 py-5 font-label-sm text-label-sm text-secondary uppercase tracking-widest">Email Address</th>
                        <th class="px-8 py-5 font-label-sm text-label-sm text-secondary uppercase tracking-widest">Role</th>
                        <th class="px-8 py-5 font-label-sm text-label-sm text-secondary uppercase tracking-widest">Joined</th>
                        <th class="px-8 py-5 font-label-sm text-label-sm text-secondary uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#ECECEC]" id="usersTableBody">
                    <tr><td class="px-8 py-6 text-secondary" colspan="6">Loading users...</td></tr>
                </tbody>
            </table>
        </div>

        <div class="px-8 py-6 border-t border-[#ECECEC] flex items-center justify-between">
            <p class="font-body-md text-body-md text-secondary" id="usersTableSummary">Loading real users...</p>
            <div class="flex space-x-2">
                <button class="w-10 h-10 flex items-center justify-center rounded-full border border-outline-variant hover:bg-surface-container-low transition-all" type="button">
                    <span class="material-symbols-outlined" data-icon="chevron_left">chevron_left</span>
                </button>
                <button class="w-10 h-10 flex items-center justify-center rounded-full bg-primary text-white font-label-sm text-label-sm transition-all" type="button">1</button>
                <button class="w-10 h-10 flex items-center justify-center rounded-full border border-outline-variant hover:bg-surface-container-low transition-all font-label-sm text-label-sm" type="button">2</button>
                <button class="w-10 h-10 flex items-center justify-center rounded-full border border-outline-variant hover:bg-surface-container-low transition-all font-label-sm text-label-sm" type="button">3</button>
                <button class="w-10 h-10 flex items-center justify-center rounded-full border border-outline-variant hover:bg-surface-container-low transition-all" type="button">
                    <span class="material-symbols-outlined" data-icon="chevron_right">chevron_right</span>
                </button>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    body {
        font-family: 'Inter', sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        vertical-align: middle;
    }
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; }
    ::-webkit-scrollbar-thumb { background: #d1d1d1; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #111111; }
    .user-row-transition { transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', loadUsers);

    function initials(name) {
        return (name || 'U').split(' ').map(part => part[0]).join('').substring(0, 2).toUpperCase();
    }

    async function loadUsers() {
        const tbody = document.getElementById('usersTableBody');
        try {
            const response = await fetch(`${API_URL}/users`, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Accept': 'application/json',
                },
            });
            const data = await response.json();
            if (!response.ok || !data.success) {
                throw new Error(data.message || 'Failed to load users');
            }

            const users = data.data?.data || data.data || [];
            document.getElementById('usersTableSummary').textContent = `Showing ${users.length} real user(s)`;
            if (!users.length) {
                tbody.innerHTML = '<tr><td class="px-8 py-6 text-secondary" colspan="6">No users found.</td></tr>';
                return;
            }

            tbody.innerHTML = users.map(user => `
                <tr class="user-row-transition hover:bg-[#F5F5F5] group">
                    <td class="px-8 py-4"><input class="rounded border-outline-variant text-primary focus:ring-primary h-4 w-4" type="checkbox" /></td>
                    <td class="px-8 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-surface-container text-on-surface-variant flex items-center justify-center font-bold text-xs border border-outline-variant">${initials(user.name)}</div>
                            <span class="font-headline-md text-body-lg text-primary">${user.name || 'Unknown User'}</span>
                        </div>
                    </td>
                    <td class="px-8 py-4 font-body-md text-secondary">${user.email || '-'}</td>
                    <td class="px-8 py-4">
                        <select class="bg-transparent border border-outline-variant rounded-full px-3 py-1 text-label-sm font-label-sm focus:ring-0 focus:border-primary cursor-pointer" onchange="updateUserRole('${user.id}', this.value)">
                            <option value="candidate" ${user.role === 'candidate' ? 'selected' : ''}>Candidate</option>
                            <option value="employer" ${user.role === 'employer' ? 'selected' : ''}>Employer</option>
                            <option value="admin" ${user.role === 'admin' ? 'selected' : ''}>Admin</option>
                        </select>
                    </td>
                    <td class="px-8 py-4 font-body-md text-secondary">${user.created_at ? new Date(user.created_at).toLocaleDateString() : '-'}</td>
                    <td class="px-8 py-4 text-right">
                        <button class="text-secondary opacity-0 group-hover:opacity-100 hover:text-error transition-all p-2 rounded-full" type="button" onclick="deleteUser('${user.id}')" title="Delete User">
                            <span class="material-symbols-outlined" data-icon="delete">delete</span>
                        </button>
                    </td>
                </tr>
            `).join('');
        } catch (error) {
            tbody.innerHTML = `<tr><td class="px-8 py-6 text-secondary" colspan="6">${error.message}</td></tr>`;
        }
    }

    async function updateUserRole(userId, role) {
        const response = await fetch(`${API_URL}/users/${userId}/role`, {
            method: 'PUT',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ role }),
        });
        const data = await response.json();
        if (!response.ok || !data.success) {
            alert(data.message || 'Failed to update role');
            loadUsers();
        }
    }

    async function deleteUser(userId) {
        if (!confirm('Are you sure you want to remove this user from the recruitment portal? This action is permanent.')) return;
        const response = await fetch(`${API_URL}/users/${userId}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'Accept': 'application/json',
            },
        });
        const data = await response.json();
        if (!response.ok || !data.success) {
            alert(data.message || 'Failed to delete user');
            return;
        }
        loadUsers();
    }
</script>
@endpush
