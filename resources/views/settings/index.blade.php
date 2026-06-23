@extends('layouts.app')

@section('title', 'Settings · jobboard')
@section('page_title', 'Settings')
@section('page_subtitle', '· account preferences')

@push('styles')
<style>
    .settings-card {
        background: #fff;
        border: 1px solid #ececec;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 1.8rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        transition: box-shadow 0.2s ease;
    }
    .settings-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.04); }
    .section-title {
        font-size: 1rem; font-weight: 700; color: #111;
        margin-bottom: 1.4rem;
        padding-bottom: 0.6rem;
        border-bottom: 2px solid #ececec;
        display: flex; align-items: center; gap: 0.6rem;
    }
    .section-title i { color: #555; }

    .toggle-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 0.9rem 0; border-bottom: 1px solid #f5f5f5;
    }
    .toggle-row:last-child { border-bottom: none; }
    .toggle-info h4 { font-size: 0.95rem; font-weight: 600; color: #111; margin-bottom: 0.2rem; }
    .toggle-info p  { font-size: 0.82rem; color: #888; margin: 0; }

    /* Toggle switch */
    .toggle-switch { position: relative; width: 48px; height: 26px; flex-shrink: 0; }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-slider {
        position: absolute; cursor: pointer; inset: 0;
        background: #ddd; border-radius: 40px;
        transition: background 0.25s;
    }
    .toggle-slider:before {
        content: ''; position: absolute;
        width: 20px; height: 20px; left: 3px; bottom: 3px;
        background: #fff; border-radius: 50%;
        transition: transform 0.25s;
    }
    input:checked + .toggle-slider { background: #111; }
    input:checked + .toggle-slider:before { transform: translateX(22px); }

    .alert { padding: 0.8rem 1rem; border-radius: 10px; margin-bottom: 1rem; font-size: 0.9rem; }
    .alert-success { background: #d4edda; color: #155724; border-left: 3px solid #155724; }
    .alert-error   { background: #f8d7da; color: #721c24; border-left: 3px solid #721c24; }

    .danger-btn {
        background: transparent; color: #dc3545;
        border: 1.5px solid #dc3545;
        padding: 0.6rem 1.4rem; border-radius: 40px;
        font-weight: 600; font-size: 0.88rem; cursor: pointer;
        transition: all 0.2s;
    }
    .danger-btn:hover { background: #dc3545; color: #fff; }
</style>
@endpush

@section('content')
<div style="max-width: 760px; margin: 0 auto;">

    <!-- Notification Settings -->
    <div class="settings-card">
        <div class="section-title">
            <i class="fas fa-bell"></i> Notification Preferences
        </div>

        <div class="toggle-row">
            <div class="toggle-info">
                <h4>Application Status Updates</h4>
                <p>Get notified when your application status changes (Reviewed, Rejected, Hired)</p>
            </div>
            <label class="toggle-switch">
                <input type="checkbox" id="notifStatus" checked>
                <span class="toggle-slider"></span>
            </label>
        </div>

        <div class="toggle-row">
            <div class="toggle-info">
                <h4>New Job Matches</h4>
                <p>Receive alerts when new jobs matching your profile are posted</p>
            </div>
            <label class="toggle-switch">
                <input type="checkbox" id="notifJobMatch" checked>
                <span class="toggle-slider"></span>
            </label>
        </div>

        <div class="toggle-row">
            <div class="toggle-info">
                <h4>Company Approval Alerts</h4>
                <p>For employers: get notified when your company is approved or rejected</p>
            </div>
            <label class="toggle-switch">
                <input type="checkbox" id="notifCompany">
                <span class="toggle-slider"></span>
            </label>
        </div>

        <div class="toggle-row">
            <div class="toggle-info">
                <h4>Marketing Emails</h4>
                <p>Receive tips, product updates, and platform news</p>
            </div>
            <label class="toggle-switch">
                <input type="checkbox" id="notifMarketing">
                <span class="toggle-slider"></span>
            </label>
        </div>

        <div style="margin-top: 1.5rem; text-align: right;">
            <button class="btn" onclick="saveNotificationPrefs()" id="saveNotifBtn">
                <i class="fas fa-save" style="margin-right: 0.4rem;"></i> Save Preferences
            </button>
        </div>
    </div>

    <!-- Privacy Settings -->
    <div class="settings-card">
        <div class="section-title">
            <i class="fas fa-user-shield"></i> Privacy
        </div>

        <div class="toggle-row">
            <div class="toggle-info">
                <h4>Profile Visible to Employers</h4>
                <p>Allow employers to find and view your candidate profile</p>
            </div>
            <label class="toggle-switch">
                <input type="checkbox" id="privacyProfileVisible" checked>
                <span class="toggle-slider"></span>
            </label>
        </div>

        <div class="toggle-row">
            <div class="toggle-info">
                <h4>Show Resume to Employers</h4>
                <p>Display your uploaded resume in your public profile</p>
            </div>
            <label class="toggle-switch">
                <input type="checkbox" id="privacyShowResume" checked>
                <span class="toggle-slider"></span>
            </label>
        </div>
    </div>

    <!-- Danger Zone -->
    <div class="settings-card" style="border-color: #f5c6cb;">
        <div class="section-title" style="color: #dc3545;">
            <i class="fas fa-exclamation-triangle" style="color: #dc3545;"></i> Danger Zone
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h4 style="font-size: 0.95rem; font-weight: 600; color: #111; margin-bottom: 0.2rem;">Delete Account</h4>
                <p style="font-size: 0.82rem; color: #888; margin: 0;">This action cannot be undone. All your data will be permanently removed.</p>
            </div>
            <button class="danger-btn" onclick="confirmDeleteAccount()">
                <i class="fas fa-trash-alt" style="margin-right: 0.4rem;"></i> Delete Account
            </button>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Load prefs from localStorage
    const prefs = JSON.parse(localStorage.getItem('notifPrefs') || '{}');
    if (prefs.notifStatus    !== undefined) document.getElementById('notifStatus').checked    = prefs.notifStatus;
    if (prefs.notifJobMatch  !== undefined) document.getElementById('notifJobMatch').checked  = prefs.notifJobMatch;
    if (prefs.notifCompany   !== undefined) document.getElementById('notifCompany').checked   = prefs.notifCompany;
    if (prefs.notifMarketing !== undefined) document.getElementById('notifMarketing').checked = prefs.notifMarketing;
    if (prefs.privacyProfileVisible !== undefined) document.getElementById('privacyProfileVisible').checked = prefs.privacyProfileVisible;
    if (prefs.privacyShowResume     !== undefined) document.getElementById('privacyShowResume').checked     = prefs.privacyShowResume;
});

function saveNotificationPrefs() {
    const prefs = {
        notifStatus:            document.getElementById('notifStatus').checked,
        notifJobMatch:          document.getElementById('notifJobMatch').checked,
        notifCompany:           document.getElementById('notifCompany').checked,
        notifMarketing:         document.getElementById('notifMarketing').checked,
        privacyProfileVisible:  document.getElementById('privacyProfileVisible').checked,
        privacyShowResume:      document.getElementById('privacyShowResume').checked,
    };
    localStorage.setItem('notifPrefs', JSON.stringify(prefs));

    const btn = document.getElementById('saveNotifBtn');
    btn.innerHTML = '<i class="fas fa-check" style="margin-right:0.4rem;"></i> Saved!';
    btn.style.background = '#155724';
    setTimeout(() => {
        btn.innerHTML = '<i class="fas fa-save" style="margin-right:0.4rem;"></i> Save Preferences';
        btn.style.background = '';
    }, 2000);
}

function confirmDeleteAccount() {
    if (!confirm('Are you absolutely sure you want to delete your account? This CANNOT be undone.')) return;
    alert('Account deletion is not available via the web portal. Please contact support at support@jobboard.com.');
}
</script>
@endpush
