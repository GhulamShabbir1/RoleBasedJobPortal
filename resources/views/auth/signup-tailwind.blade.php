@extends('layouts.auth')

@section('title', 'Sign Up | jobboard')

@section('content')
<!-- Main Container -->
<main class="w-full max-w-[480px]">
    <!-- Logo Header -->
    <header class="mb-10 text-center">
        <h1 class="font-display text-display text-primary tracking-tighter mb-2">jobboard</h1>
        <p class="font-body-md text-body-md text-on-surface-variant">The elite portal for premium recruitment.</p>
    </header>
    <!-- Sign Up Card -->
    <div class="bg-surface-container-lowest rounded-[24px] border border-outline-variant/30 p-10 custom-shadow">
        <div class="mb-8">
            <h2 class="font-headline-lg text-headline-lg text-on-surface mb-2">Get Started</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Create your account to access our exclusive network.</p>
        </div>
        <form class="space-y-6" id="registrationForm">
            <!-- Role Selection -->
            <div class="space-y-3">
                <label class="font-label-sm text-label-sm text-on-surface uppercase tracking-widest">Identify as</label>
                <div class="grid grid-cols-2 gap-3">
                    <div class="relative">
                        <input checked="" class="role-radio hidden" id="role_candidate" name="role" type="radio" value="candidate"/>
                        <label class="flex items-center justify-center h-12 rounded-full border border-outline-variant cursor-pointer font-body-md text-body-md transition-all duration-200 hover:bg-surface-container-low" for="role_candidate">
                            I am a Candidate
                        </label>
                    </div>
                    <div class="relative">
                        <input class="role-radio hidden" id="role_employer" name="role" type="radio" value="employer"/>
                        <label class="flex items-center justify-center h-12 rounded-full border border-outline-variant cursor-pointer font-body-md text-body-md transition-all duration-200 hover:bg-surface-container-low" for="role_employer">
                            I am an Employer
                        </label>
                    </div>
                </div>
            </div>
            <!-- Full Name -->
            <div class="space-y-2">
                <label class="font-label-sm text-label-sm text-on-surface uppercase tracking-widest" for="fullName">Full Name</label>
                <div class="relative">
                    <input class="w-full h-14 px-5 rounded-xl border border-outline-variant bg-white font-body-md text-body-md focus:outline-none focus:ring-0 focus:border-primary focus:border-2 form-input-transition placeholder:text-outline-variant" id="fullName" name="fullName" placeholder="Jane Doe" required="" type="text"/>
                </div>
            </div>
            <!-- Email Address -->
            <div class="space-y-2">
                <label class="font-label-sm text-label-sm text-on-surface uppercase tracking-widest" for="email">Email Address</label>
                <div class="relative">
                    <input class="w-full h-14 px-5 rounded-xl border border-outline-variant bg-white font-body-md text-body-md focus:outline-none focus:ring-0 focus:border-primary focus:border-2 form-input-transition placeholder:text-outline-variant" id="email" name="email" placeholder="jane@example.com" required="" type="email"/>
                </div>
            </div>
            <!-- Password -->
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <label class="font-label-sm text-label-sm text-on-surface uppercase tracking-widest" for="password">Password</label>
                </div>
                <div class="relative">
                    <input class="w-full h-14 px-5 rounded-xl border border-outline-variant bg-white font-body-md text-body-md focus:outline-none focus:ring-0 focus:border-primary focus:border-2 form-input-transition placeholder:text-outline-variant" id="password" name="password" placeholder="••••••••" required="" type="password"/>
                    <button class="absolute right-5 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-primary transition-colors" type="button">
                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                    </button>
                </div>
            </div>
            <!-- Terms & Privacy -->
            <div class="flex items-start gap-3 py-2">
                <input class="mt-1 w-5 h-5 rounded border-outline-variant text-primary focus:ring-0 focus:ring-offset-0" id="terms" name="terms" required="" type="checkbox"/>
                <label class="font-body-md text-body-md text-on-surface-variant leading-tight" for="terms">
                    I agree to the <a class="text-primary font-semibold hover:underline" href="#">Terms of Service</a> and <a class="text-primary font-semibold hover:underline" href="#">Privacy Policy</a>.
                </label>
            </div>
            <!-- Submit Button -->
            <button class="w-full h-14 bg-primary text-white rounded-full font-headline-md text-headline-md hover:opacity-90 active:scale-[0.98] transition-all duration-150 flex items-center justify-center gap-2 group" type="submit">
                Create Account
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </button>
        </form>
        <!-- Secondary CTA -->
        <div class="mt-8 pt-8 border-t border-outline-variant/30 text-center">
            <p class="font-body-md text-body-md text-on-surface-variant">
                Already have an account?
                <a class="text-primary font-bold hover:underline ml-1" href="/auth/login">Log in</a>
            </p>
        </div>
    </div>
    <!-- Footer Info -->
    <footer class="mt-10 text-center space-y-4">
        <div class="flex justify-center gap-6 text-on-surface-variant opacity-60">
            <a class="font-label-sm text-label-sm hover:opacity-100 transition-opacity" href="#">Help Center</a>
            <a class="font-label-sm text-label-sm hover:opacity-100 transition-opacity" href="#">Security</a>
            <a class="font-label-sm text-label-sm hover:opacity-100 transition-opacity" href="#">Contact</a>
        </div>
        <p class="font-label-sm text-label-sm text-on-surface-variant opacity-40">© 2024 jobboard. All rights reserved.</p>
    </footer>
</main>
<!-- Background Decoration (Atmospheric) -->
<div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
    <div class="absolute top-[-10%] right-[-10%] w-[40%] h-[40%] bg-surface-container rounded-full blur-[120px] opacity-50"></div>
    <div class="absolute bottom-[-10%] left-[-10%] w-[30%] h-[30%] bg-surface-container-high rounded-full blur-[100px] opacity-30"></div>
</div>

@push('styles')
<style>
    .role-radio:checked + label {
        background-color: #111111;
        color: #FFFFFF;
        border-color: #111111;
    }
</style>
@endpush

@push('scripts')
<script>
    const toggleBtn = document.querySelector('button span.material-symbols-outlined');
    const passwordInput = document.getElementById('password');

    if (toggleBtn) {
        toggleBtn.parentElement.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            toggleBtn.textContent = isPassword ? 'visibility_off' : 'visibility';
        });
    }

    document.getElementById('registrationForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = e.target.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;

        btn.disabled = true;
        btn.innerHTML = '<span class="material-symbols-outlined animate-spin">progress_activity</span> Processing...';

        try {
            const response = await fetch('/api/auth/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    name: document.getElementById('fullName').value,
                    email: document.getElementById('email').value,
                    password: document.getElementById('password').value,
                    password_confirmation: document.getElementById('password').value,
                    role: document.querySelector('input[name="role"]:checked')?.value || 'candidate',
                }),
            });

            const data = await response.json();
            const token = data?.data?.token || data?.token || data?.access_token;
            const user = data?.data?.user || data?.user;

            if (!response.ok) {
                throw new Error(data.message || 'Registration failed');
            }

            if (token) {
                localStorage.setItem('token', token);
            }
            if (user) {
                localStorage.setItem('user', JSON.stringify(user));
            }

            btn.innerHTML = '<span class="material-symbols-outlined">check_circle</span> Account Created';
            const role = user?.role || document.querySelector('input[name="role"]:checked')?.value || 'candidate';
            window.location.href = `/dashboard/${role}`;
        } catch (error) {
            alert(error.message);
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    });
</script>
@endpush

@endsection
