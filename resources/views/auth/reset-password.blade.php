@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-gray-50 to-white py-12 px-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-blue-600 text-3xl">lock_reset</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Reset Password</h1>
            <p class="text-gray-600 mt-2">Enter your new password</p>
        </div>

        <form id="reset-password-form" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input id="email" type="email" readonly
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-500 cursor-not-allowed">
            </div>

            <input type="hidden" id="token">

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                <input id="password" name="password" type="password" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
            </div>

            <button type="submit"
                class="w-full bg-black text-white font-semibold py-3 px-4 rounded-full hover:bg-gray-800 transition-colors">
                Reset Password
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    document.getElementById('email').value = urlParams.get('email') || '';
    document.getElementById('token').value = urlParams.get('token') || '';
});

document.getElementById('reset-password-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    try {
        const formData = {
            token: document.getElementById('token').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            password_confirmation: document.getElementById('password_confirmation').value
        };
        
        const res = await fetch(`${API_URL}/auth/reset-password`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json'
            },
            body: JSON.stringify(formData)
        });
        
        const json = await res.json();
        
        if (json.success) {
            window.location.href = '/auth/login?reset=success';
        } else {
            alert(json.message || 'Failed to reset password');
        }
    } catch (err) {
        console.error(err);
        alert('Failed to reset password');
    }
});
</script>
@endpush
