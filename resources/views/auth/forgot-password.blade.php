@extends('layouts.auth')

@section('title', 'Forgot Password · jobboard')

@section('content')
<div class="relative z-10 flex flex-col items-center w-full max-w-[440px]">

    <!-- Header Brand -->
    <div class="mb-12 flex flex-col items-center">
        <div class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center mb-6 shadow-sm">
            <span class="material-symbols-outlined text-white text-[28px]" style="font-variation-settings: 'FILL' 1;">work</span>
        </div>
        <h1 class="font-display text-display text-primary tracking-tight mb-2">jobboard</h1>
        <p class="font-body-md text-body-md text-secondary opacity-70">The premium recruitment portal for 2026</p>
    </div>

    <!-- Card -->
    <div class="w-full bg-white rounded-[24px] border border-[#ECECEC] p-10" style="box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
        <header class="mb-8 text-center">
            <div class="w-14 h-14 bg-surface-container-low rounded-2xl flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-primary text-[28px]">lock_reset</span>
            </div>
            <h2 class="font-headline-md text-headline-md text-on-surface mb-1">Forgot Password?</h2>
            <p class="font-label-sm text-label-sm text-secondary">Enter your email and we'll send a reset link</p>
        </header>

        <!-- Alert box -->
        <div id="alertBox" class="hidden mb-6 rounded-xl px-4 py-3 text-sm"></div>

        <form id="forgotForm" class="space-y-6">
            <!-- Email -->
            <div class="space-y-2">
                <label class="font-label-sm text-label-sm text-on-surface ml-1" for="email">Email Address</label>
                <div class="input-field relative flex items-center bg-white border border-[#ECECEC] rounded-full px-5 py-3.5 transition-all">
                    <span class="material-symbols-outlined text-outline-variant mr-3 text-[20px]">mail</span>
                    <input
                        class="w-full bg-transparent border-none p-0 focus:ring-0 text-on-surface font-body-md placeholder:text-outline-variant"
                        id="email" name="email" placeholder="name@company.com" required type="email" />
                </div>
            </div>

            <!-- Submit -->
            <button
                class="w-full bg-primary text-white font-label-sm text-label-sm py-4 rounded-full shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 mt-4 flex items-center justify-center gap-2 group"
                type="submit" id="submitBtn">
                <span id="btnText">Send Reset Link</span>
                <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">send</span>
            </button>
        </form>

        <div class="mt-10 pt-8 border-t border-[#ECECEC] text-center">
            <p class="font-body-md text-body-md text-secondary">
                Remember your password?
                <a class="text-primary font-bold hover:underline" href="/auth/login">Sign In</a>
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
    .input-field:focus-within {
        border-color: #111111;
        border-width: 2px;
    }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('forgotForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        const btn     = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const alertBox = document.getElementById('alertBox');
        const email   = document.getElementById('email').value;

        btnText.textContent = 'Sending...';
        btn.disabled = true;
        alertBox.classList.add('hidden');

        try {
            const response = await fetch('/api/auth/forgot-password', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ email })
            });

            const data = await response.json();

            if (response.ok) {
                alertBox.className = 'mb-6 rounded-xl px-4 py-3 text-sm bg-green-50 text-green-700 border border-green-200';
                alertBox.textContent = data.message || 'Reset link sent! Check your email.';
                alertBox.classList.remove('hidden');
                document.getElementById('forgotForm').reset();
            } else {
                throw new Error(data.message || 'Failed to send reset link.');
            }
        } catch (err) {
            alertBox.className = 'mb-6 rounded-xl px-4 py-3 text-sm bg-red-50 text-red-700 border border-red-200';
            alertBox.textContent = err.message;
            alertBox.classList.remove('hidden');
        } finally {
            btnText.textContent = 'Send Reset Link';
            btn.disabled = false;
        }
    });
</script>
@endpush
@endsection
