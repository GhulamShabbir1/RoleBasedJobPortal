@extends('layouts.app')

@section('title', 'My Profile · jobboard')
@section('page_title', 'Profile')
@section('page_subtitle', '· account details')

@push('styles')
<style>
    .profile-card {
        background: #fff;
        border: 1px solid #ececec;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        transition: box-shadow 0.2s ease;
    }
    .profile-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.04); }

    .avatar-circle {
        width: 80px; height: 80px;
        border-radius: 50%;
        background: #111;
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 2rem; font-weight: 700;
        text-transform: uppercase;
        flex-shrink: 0;
    }

    .role-badge {
        display: inline-block;
        padding: 0.25rem 0.8rem;
        border-radius: 40px;
        font-size: 0.75rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.05em;
        background: #111; color: #fff;
    }

    .info-row {
        display: flex; align-items: center; gap: 1rem;
        padding: 0.9rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .info-row:last-child { border-bottom: none; }
    .info-row .label {
        font-size: 0.8rem; font-weight: 600; color: #888;
        text-transform: uppercase; letter-spacing: 0.05em;
        min-width: 120px;
    }
    .info-row .value { color: #111; font-size: 0.95rem; }

    .section-title {
        font-size: 1rem; font-weight: 700; color: #111;
        margin-bottom: 1.2rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #ececec;
    }

    .alert { padding: 0.8rem 1rem; border-radius: 10px; margin-bottom: 1.2rem; font-size: 0.9rem; }
    .alert-success { background: #d4edda; color: #155724; border-left: 3px solid #155724; }
    .alert-error   { background: #f8d7da; color: #721c24; border-left: 3px solid #721c24; }
</style>
@endpush

@section('content')
<div style="max-width: 860px; margin: 0 auto;">

    <!-- Profile Header -->
    <div class="profile-card" style="margin-bottom: 1.8rem; display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;">
        <div class="avatar-circle" id="profileAvatar">?</div>
        <div style="flex: 1; min-width: 200px;">
            <h2 style="font-size: 1.6rem; font-weight: 700; color: #111; margin-bottom: 0.3rem;" id="profileName">Loading...</h2>
            <p style="color: #666; margin-bottom: 0.6rem;" id="profileEmail">—</p>
            <span class="role-badge" id="profileRole">—</span>
        </div>
        <div>
            <p style="font-size: 0.85rem; color: #888; text-align: right;">Member since</p>
            <p style="font-weight: 600; color: #111; font-size: 0.95rem;" id="profileJoined">—</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.8rem; margin-bottom: 1.8rem;">

        <!-- Account Info -->
        <div class="profile-card">
            <div class="section-title">Account Information</div>
            <div id="infoRows">
                <div class="info-row">
                    <span class="label">Full Name</span>
                    <span class="value" id="infoName">—</span>
                </div>
                <div class="info-row">
                    <span class="label">Email</span>
                    <span class="value" id="infoEmail">—</span>
                </div>
                <div class="info-row">
                    <span class="label">Role</span>
                    <span class="value" id="infoRole">—</span>
                </div>
                <div class="info-row">
                    <span class="label">User ID</span>
                    <span class="value" id="infoId">—</span>
                </div>
            </div>
        </div>

        <!-- Quick Links by role -->
        <div class="profile-card">
            <div class="section-title">Quick Actions</div>
            <div id="quickActions" style="display: flex; flex-direction: column; gap: 0.8rem;">
                <!-- Populated by JS based on role -->
            </div>
        </div>
    </div>

    <!-- Change Password -->
    <div class="profile-card">
        <div class="section-title">Change Password</div>
        <div id="pwAlert" class="hidden"></div>
        <form id="changePasswordForm" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; align-items: end;">
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-group label" for="currentPassword">Current Password</label>
                <input type="password" id="currentPassword" class="form-control" placeholder="••••••••" required />
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-group label" for="newPassword">New Password</label>
                <input type="password" id="newPassword" class="form-control" placeholder="Min. 8 chars" minlength="8" required />
            </div>
            <div>
                <button type="submit" class="btn" style="width: 100%;" id="pwBtn">
                    <i class="fas fa-key" style="margin-right: 0.4rem;"></i> Update Password
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Load user from localStorage
    let user = {};
    try { user = JSON.parse(localStorage.getItem('user')) || {}; } catch(e) {}

    if (!user || !user.id) {
        window.location.href = '/auth/login';
        return;
    }

    // Header
    document.getElementById('profileAvatar').textContent = (user.name || 'U').charAt(0).toUpperCase();
    document.getElementById('profileName').textContent   = user.name  || 'Unknown';
    document.getElementById('profileEmail').textContent  = user.email || '—';
    document.getElementById('profileRole').textContent   = (user.role || 'user').toUpperCase();
    document.getElementById('profileJoined').textContent = user.created_at
        ? new Date(user.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })
        : '—';

    // Info rows
    document.getElementById('infoName').textContent  = user.name  || '—';
    document.getElementById('infoEmail').textContent = user.email || '—';
    document.getElementById('infoRole').textContent  = (user.role || '—').charAt(0).toUpperCase() + (user.role || '').slice(1);
    document.getElementById('infoId').textContent    = '#' + (user.id || '—');

    // Quick actions by role
    const role = user.role || 'candidate';
    const actions = {
        admin: [
            { href: '/dashboard/admin',   icon: 'fa-chart-pie',    text: 'Go to Dashboard' },
            { href: '/companies/pending', icon: 'fa-building',     text: 'Review Pending Companies' },
            { href: '/applications/review', icon: 'fa-file-alt',  text: 'Review Applications' },
            { href: '/users',             icon: 'fa-users-cog',   text: 'Manage Users' },
        ],
        employer: [
            { href: '/dashboard/employer', icon: 'fa-chart-pie',   text: 'Go to Dashboard' },
            { href: '/jobs/create',        icon: 'fa-plus-circle', text: 'Post a New Job' },
            { href: '/companies/create',   icon: 'fa-building',    text: 'My Company Profile' },
            { href: '/applications/review', icon: 'fa-file-alt',  text: 'Review Applications' },
        ],
        candidate: [
            { href: '/dashboard/candidate',  icon: 'fa-chart-pie',  text: 'Go to Dashboard' },
            { href: '/jobs',                 icon: 'fa-search',     text: 'Browse Jobs' },
            { href: '/applications/mine',    icon: 'fa-file-alt',   text: 'My Applications' },
        ],
    };

    const container = document.getElementById('quickActions');
    (actions[role] || actions.candidate).forEach(a => {
        const link = document.createElement('a');
        link.href = a.href;
        link.className = 'btn outlined';
        link.style.cssText = 'display:flex;align-items:center;gap:0.6rem;padding:0.6rem 1.2rem;font-size:0.9rem;';
        link.innerHTML = `<i class="fas ${a.icon}" style="width:1.2rem;"></i> ${a.text}`;
        container.appendChild(link);
    });

    // Change password form
    document.getElementById('changePasswordForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const alertEl = document.getElementById('pwAlert');
        const btn     = document.getElementById('pwBtn');
        const current = document.getElementById('currentPassword').value;
        const newPass = document.getElementById('newPassword').value;

        btn.disabled = true;
        btn.textContent = 'Updating...';
        alertEl.className = 'hidden';

        try {
            const res  = await fetch(`${API_URL}/auth/change-password`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                },
                body: JSON.stringify({ current_password: current, new_password: newPass, new_password_confirmation: newPass })
            });
            const data = await res.json();
            if (res.ok && data.success !== false) {
                alertEl.className = 'alert alert-success';
                alertEl.textContent = 'Password updated successfully!';
                document.getElementById('changePasswordForm').reset();
            } else {
                throw new Error(data.message || 'Failed to update password.');
            }
        } catch (err) {
            alertEl.className = 'alert alert-error';
            alertEl.textContent = err.message;
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-key" style="margin-right:0.4rem;"></i> Update Password';
        }
    });
});
</script>
@endpush
