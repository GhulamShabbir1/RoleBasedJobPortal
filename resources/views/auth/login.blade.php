@extends('layouts.auth')

@section('title', 'Sign In | jobboard')

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

    <!-- Login Card -->
    <div class="login-card w-full bg-white rounded-[24px] border border-[#ECECEC] p-10">
        <header class="mb-8 text-center">
            <h2 class="font-headline-md text-headline-md text-on-surface mb-1">Welcome back</h2>
            <p class="font-label-sm text-label-sm text-secondary uppercase tracking-widest">Sign in to your account</p>
        </header>

        <form action="#" class="space-y-6" method="POST" onsubmit="event.preventDefault();">
            <div class="space-y-2">
                <label class="font-label-sm text-label-sm text-on-surface ml-1" for="email">Email Address</label>
                <div class="input-field relative flex items-center bg-white border border-[#ECECEC] rounded-full px-5 py-3.5 transition-all">
                    <span class="material-symbols-outlined text-outline-variant mr-3 text-[20px]">mail</span>
                    <input class="w-full bg-transparent border-none p-0 focus:ring-0 text-on-surface font-body-md placeholder:text-outline-variant" id="email" name="email" placeholder="name@company.com" required type="email" />
                </div>
            </div>

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

            <button class="w-full bg-primary text-white font-label-sm text-label-sm py-4 rounded-full shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 mt-4 flex items-center justify-center gap-2 group" type="submit" onclick="event.preventDefault();">
                <span>Sign In</span>
                <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </button>
        </form>

        <div class="mt-10 pt-8 border-t border-[#ECECEC] text-center">
            <p class="font-body-md text-body-md text-secondary">
                Don't have an account?
                <a class="text-primary font-bold hover:underline" href="#">Request access</a>
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
