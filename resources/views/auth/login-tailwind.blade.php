@extends('layouts.auth')

@section('title', 'Sign In | jobboard')

@section('content')
<!-- Main Wrapper -->
<div class="relative z-10 flex flex-col items-center w-full max-w-[440px]">

    <!-- Header Brand -->
    <div class="mb-12 flex flex-col items-center">
        <div class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center mb-6 shadow-sm">
            <span class="material-symbols-outlined text-white text-[28px]" style="font-variation-settings: 'FILL' 1;">work</span>
        </div>
        <h1 class="font-display text-display text-primary tracking-tight mb-2">jobboard</h1>
        <p class="font-body-md text-body-md text-secondary opacity-70">The premium recruitment portal for 2026</p>
    </div>

    <!-- Login Card -->
    <div class="login-card w-full bg-white rounded-[24px] border border-[#ECECEC] p-10">
        <header class="mb-8 text-center">
            <h2 class="font-headline-md text-headline-md text-on-surface mb-1">Welcome back</h2>
            <p class="font-label-sm text-label-sm text-secondary uppercase tracking-widest">Sign in to your account</p>
        </header>

        <!-- Optional: Server-side messages -->
        @if(session('status'))
            <div class="mb-6 rounded-xl border border-outline-variant/30 bg-surface-container-lowest px-4 py-3 text-on-surface-variant text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form action="#" class="space-y-6" method="POST" id="loginForm">
            <!-- Email -->
            <div class="space-y-2">
                <label class="font-label-sm text-label-sm text-on-surface ml-1" for="email">Email Address</label>
                <div class="input-field relative flex items-center bg-white border border-[#ECECEC] rounded-full px-5 py-3.5 transition-all">
                    <span class="material-symbols-outlined text-outline-variant mr-3 text-[20px]">mail</span>
                    <input class="w-full bg-transparent border-none p-0 focus:ring-0 text-on-surface font-body-md placeholder:text-outline-variant" id="email" name="email" placeholder="name@company.com" required type="email" />
                </div>
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <div class="flex justify-between items-center px-1">
                    <label class="font-label-sm text-label-sm text-on-surface" for="password">Password</label>
                    <a class="font-label-sm text-label-sm text-primary hover:underline transition-all" href="#">Forgot password?</a>
                </div>
                <div class="input-field relative flex items-center bg-white border border-[#ECECEC] rounded-full px-5 py-3.5 transition-all">
                    <span class="material-symbols-outlined text-outline-variant mr-3 text-[20px]">lock</span>
                    <input class="w-full bg-transparent border-none p-0 focus:ring-0 text-on-surface font-body-md placeholder:text-outline-variant" id="password" name="password" placeholder="••••••••" required type="password" />
                    <button class="ml-2 focus:outline-none opacity-40 hover:opacity-100 transition-opacity" type="button" aria-label="Toggle password visibility">
                        <span class="material-symbols-outlined text-[20px]" id="passwordToggleIcon">visibility</span>
                    </button>
                </div>
            </div>

            <!-- Submit -->
            <button class="w-full bg-primary text-white font-label-sm text-label-sm py-4 rounded-full shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 mt-4 flex items-center justify-center gap-2 group" type="submit">
                <span>Sign In</span>
                <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </button>
        </form>

        <div class="mt-10 pt-8 border-t border-[#ECECEC] text-center">
            <p class="font-body-md text-body-md text-secondary">
                Don't have an account?
                <a class="text-primary font-bold hover:underline" href="/auth/signup">Request access</a>
            </p>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-12 flex items-center gap-8 text-outline-variant font-label-sm text-label-sm">
        <a class="hover:text-primary transition-colors" href="#">Privacy</a>
        <span class="w-1 h-1 rounded-full bg-outline-variant"></span>
        <a class="hover:text-primary transition-colors" href="#">Terms</a>
        <span class="w-1 h-1 rounded-full bg-outline-variant"></span>
        <a class="hover:text-primary transition-colors" href="#">Security</a>
    </footer>

</div>

<!-- Background Decorations -->
<div class="absolute inset-0 pointer-events-none opacity-40">
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-gradient-to-br from-surface-container-high to-transparent blur-3xl"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-gradient-to-tl from-surface-variant to-transparent blur-3xl"></div>
</div>
@endsection

@push('styles')
<style>
    .login-card {
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        transition: box-shadow 0.3s ease;
    }

    .login-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.04);
    }

    .input-field:focus-within {
        border-color: #111111;
        border-width: 2px;
    }

    .premium-blur {
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Focus styling (micro interaction)
        const inputs = document.querySelectorAll('.input-field input');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.classList.add('shadow-md');
            });
            input.addEventListener('blur', () => {
                input.parentElement.classList.remove('shadow-md');
            });
        });

        // Password visibility toggle
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('passwordToggleIcon');
        const toggleBtn = toggleIcon ? toggleIcon.closest('button') : null;

        if (toggleBtn && passwordInput && toggleIcon) {
            toggleBtn.addEventListener('click', () => {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                toggleIcon.textContent = isPassword ? 'visibility_off' : 'visibility';
            });
        }

        // Real API login
        const loginForm = document.getElementById('loginForm');
        const submitBtn = document.querySelector('button[type="submit"]');
        if (loginForm && submitBtn) {
            const span = submitBtn.querySelector('span:first-child');
            loginForm.addEventListener('submit', async function(event) {
                event.preventDefault();

                const originalText = span.innerText;
                span.innerText = 'Verifying...';
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-80');

                try {
                    const response = await fetch('/api/auth/login', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            email: document.getElementById('email').value,
                            password: document.getElementById('password').value,
                        }),
                    });

                    const data = await response.json();
                    const token = data?.data?.token || data?.token || data?.access_token;
                    const user = data?.data?.user || data?.user;

                    if (!response.ok || !token) {
                        throw new Error(data.message || 'Login failed');
                    }

                    localStorage.setItem('token', token);
                    if (user) {
                        localStorage.setItem('user', JSON.stringify(user));
                    }
                    const role = user?.role || 'candidate';
                    window.location.href = `/dashboard/${role}`;
                } catch (error) {
                    alert(error.message);
                    span.innerText = originalText;
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-80');
                }
            });
        }
    });
</script>
@endpush
@endsection
