@extends('layouts.app')

@section('title', 'Applications - JobHub')

@section('content')
<div class="min-h-screen bg-white flex items-center justify-center">
    <div class="text-center">
        <div class="inline-block">
            <i class="fas fa-spinner fa-spin text-4xl text-gray-400"></i>
        </div>
        <p class="text-gray-600 mt-4">Redirecting...</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check user role from localStorage and redirect
    const userStr = localStorage.getItem('user');
    let userRole = null;
    if (userStr) {
        try {
            const user = JSON.parse(userStr);
            userRole = user.role;
        } catch (e) {}
    }

    if (userRole === 'employer' || userRole === 'admin') {
        window.location.href = '{{ route('page.applications.review') }}';
    } else if (userRole === 'candidate') {
        window.location.href = '{{ route('applications.mine') }}';
    } else {
        // Default to login if no role
        window.location.href = '{{ route('auth.login') }}';
    }
});
</script>
@endsection
