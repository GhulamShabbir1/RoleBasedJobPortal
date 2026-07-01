@extends('layouts.app')

@section('title', 'Reset Password - JobHub')

@section('content')
<div class="min-h-screen bg-black flex items-center justify-center px-4 py-12 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-0 left-0 w-96 h-96 bg-white/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl animate-float" style="animation-delay: 1.5s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] border border-white/5 rounded-full animate-rotate-slow"></div>
        <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-white/5 rounded-full blur-2xl animate-float" style="animation-delay: 2s;"></div>

        <!-- Floating Particles -->
        <div class="absolute top-20 right-20 w-2 h-2 bg-white/20 rounded-full animate-pulse"></div>
        <div class="absolute bottom-40 left-20 w-3 h-3 bg-white/20 rounded-full animate-pulse" style="animation-delay: 0.5s;"></div>
        <div class="absolute top-1/2 right-10 w-2 h-2 bg-white/20 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-1/3 left-10 w-2 h-2 bg-white/20 rounded-full animate-pulse" style="animation-delay: 1.5s;"></div>

        <!-- Key Icon Animation -->
        <div class="absolute top-1/4 right-1/4 text-6xl text-white/5 animate-float" style="animation-delay: 1s;">
            <i class="fas fa-key"></i>
        </div>
        <div class="absolute bottom-1/4 left-1/4 text-6xl text-white/5 animate-float" style="animation-delay: 2.5s;">
            <i class="fas fa-lock"></i>
        </div>
    </div>

    <div class="max-w-md w-full relative z-10">
        <!-- Card -->
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl p-8 hover:shadow-3xl transition-all duration-500 relative overflow-hidden" x-data="resetPasswordForm()">
            <!-- Glassmorphism Glow Effects -->
            <div class="absolute -top-20 -right-20 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>

            <!-- Animated Border Glow -->
            <div class="absolute inset-0 rounded-2xl opacity-0 hover:opacity-100 transition-opacity duration-500" style="background: radial-gradient(circle at 50% 0%, rgba(255,255,255,0.1), transparent 70%);"></div>

            <!-- Logo -->
            <div class="text-center mb-8 relative">
                <div class="relative inline-block">
                    <div class="absolute inset-0 bg-white/20 rounded-full blur-xl animate-pulse-slow"></div>
                    <div class="relative w-20 h-20 bg-gradient-to-br from-white to-gray-300 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-2xl transform hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-key text-black text-3xl"></i>
                    </div>
                </div>
                <h1 class="text-4xl font-bold text-white tracking-tight">Reset Password</h1>
                <div class="w-16 h-1 bg-gradient-to-r from-white to-transparent mx-auto mt-3 rounded-full"></div>
                <p class="text-gray-400 mt-3 text-sm">Enter your new password to continue</p>
            </div>

            <!-- Error Alert -->
            <div x-show="error" class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-400 flex items-start backdrop-blur-sm animate-fadeInUp" x-transition>
                <i class="fas fa-exclamation-circle mr-3 mt-0.5 text-red-400"></i>
                <span x-text="error" class="text-sm"></span>
            </div>

            <!-- Success Alert -->
            <div x-show="success" class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 flex items-start backdrop-blur-sm animate-fadeInUp" x-transition>
                <i class="fas fa-check-circle mr-3 mt-0.5 text-green-400"></i>
                <span x-text="success" class="text-sm"></span>
            </div>

            <!-- Progress Steps -->
            <div class="flex items-center justify-between mb-8 px-4">
                <div class="flex-1 flex items-center">
                    <div class="w-8 h-8 rounded-full bg-white text-black flex items-center justify-center text-xs font-bold">1</div>
                    <div class="flex-1 h-0.5 bg-white/20 mx-2"></div>
                </div>
                <div class="flex-1 flex items-center">
                    <div class="w-8 h-8 rounded-full bg-white text-black flex items-center justify-center text-xs font-bold">2</div>
                    <div class="flex-1 h-0.5 bg-white/20 mx-2"></div>
                </div>
                <div class="flex-1 flex items-center">
                    <div class="w-8 h-8 rounded-full bg-white/20 border-2 border-white/30 text-white flex items-center justify-center text-xs font-bold">3</div>
                </div>
            </div>

            <!-- Form -->
            <form @submit.prevent="resetPassword()" class="space-y-5 relative">
                <!-- Email -->
                <div class="group">
                    <label class="block text-sm font-medium text-gray-300 mb-2 transition-colors group-focus-within:text-white">
                        <i class="fas fa-envelope mr-2"></i>Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-500 group-focus-within:text-white transition-colors"></i>
                        </div>
                        <input
                            type="email"
                            x-model="form.email"
                            placeholder="you@example.com"
                            class="w-full pl-10 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:ring-2 focus:ring-white/30 focus:border-transparent outline-none transition-all duration-300"
                            required
                            autocomplete="email"
                        >
                    </div>
                </div>

                <!-- Token -->
                <div class="group">
                    <label class="block text-sm font-medium text-gray-300 mb-2 transition-colors group-focus-within:text-white">
                        <i class="fas fa-key mr-2"></i>Reset Token
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-key text-gray-500 group-focus-within:text-white transition-colors"></i>
                        </div>
                        <input
                            type="text"
                            x-model="form.token"
                            placeholder="Paste token from email"
                            class="w-full pl-10 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:ring-2 focus:ring-white/30 focus:border-transparent outline-none transition-all duration-300"
                            required
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <span x-show="form.token.length > 0" class="text-xs text-green-400">
                                <i class="fas fa-check-circle"></i>
                            </span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Check your email for the reset token</p>
                </div>

                <!-- New Password -->
                <div class="group">
                    <label class="block text-sm font-medium text-gray-300 mb-2 transition-colors group-focus-within:text-white">
                        <i class="fas fa-lock mr-2"></i>New Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-500 group-focus-within:text-white transition-colors"></i>
                        </div>
                        <input
                            :type="showPassword ? 'text' : 'password'"
                            x-model="form.password"
                            placeholder="••••••••"
                            class="w-full pl-10 pr-12 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:ring-2 focus:ring-white/30 focus:border-transparent outline-none transition-all duration-300"
                            required
                            minlength="8"
                            autocomplete="new-password"
                        >
                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-white transition-colors">
                            <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    <!-- Password Strength Indicator -->
                    <div class="mt-2" x-show="form.password.length > 0">
                        <div class="flex items-center gap-2">
                            <div class="flex-1 h-1 bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full transition-all duration-500" :style="{ width: passwordStrength + '%', background: passwordStrengthColor }"></div>
                            </div>
                            <span class="text-xs text-gray-500" x-text="passwordStrengthText"></span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Minimum 8 characters with mix of letters, numbers & symbols</p>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="group">
                    <label class="block text-sm font-medium text-gray-300 mb-2 transition-colors group-focus-within:text-white">
                        <i class="fas fa-check-circle mr-2"></i>Confirm Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-check-circle text-gray-500 group-focus-within:text-white transition-colors"></i>
                        </div>
                        <input
                            :type="showConfirmPassword ? 'text' : 'password'"
                            x-model="form.password_confirmation"
                            placeholder="••••••••"
                            class="w-full pl-10 pr-12 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:ring-2 focus:ring-white/30 focus:border-transparent outline-none transition-all duration-300"
                            required
                            autocomplete="new-password"
                        >
                        <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-white transition-colors">
                            <i class="fas" :class="showConfirmPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    <!-- Password Match Indicator -->
                    <div x-show="form.password_confirmation.length > 0" class="mt-2">
                        <p class="text-xs" :class="form.password === form.password_confirmation && form.password.length > 0 ? 'text-green-400' : 'text-red-400'">
                            <i class="fas" :class="form.password === form.password_confirmation && form.password.length > 0 ? 'fa-check-circle' : 'fa-times-circle'"></i>
                            <span x-text="form.password === form.password_confirmation && form.password.length > 0 ? 'Passwords match' : 'Passwords do not match'"></span>
                        </p>
                    </div>
                </div>

                <!-- Password Requirements -->
                <div class="p-4 bg-white/5 border border-white/10 rounded-xl">
                    <p class="text-xs font-semibold text-gray-300 mb-2">Password Requirements:</p>
                    <ul class="space-y-1 text-xs text-gray-500">
                        <li class="flex items-center" :class="form.password.length >= 8 ? 'text-green-400' : 'text-gray-500'">
                            <i class="fas mr-2" :class="form.password.length >= 8 ? 'fa-check-circle' : 'fa-circle'"></i>
                            At least 8 characters
                        </li>
                        <li class="flex items-center" :class="form.password.match(/[A-Z]/) && form.password.match(/[a-z]/) ? 'text-green-400' : 'text-gray-500'">
                            <i class="fas mr-2" :class="form.password.match(/[A-Z]/) && form.password.match(/[a-z]/) ? 'fa-check-circle' : 'fa-circle'"></i>
                            Uppercase & lowercase letters
                        </li>
                        <li class="flex items-center" :class="form.password.match(/\d/) ? 'text-green-400' : 'text-gray-500'">
                            <i class="fas mr-2" :class="form.password.match(/\d/) ? 'fa-check-circle' : 'fa-circle'"></i>
                            At least one number
                        </li>
                        <li class="flex items-center" :class="form.password.match(/[^a-zA-Z\d]/) ? 'text-green-400' : 'text-gray-500'">
                            <i class="fas mr-2" :class="form.password.match(/[^a-zA-Z\d]/) ? 'fa-check-circle' : 'fa-circle'"></i>
                            At least one special character
                        </li>
                    </ul>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    :disabled="loading || !isFormValid"
                    class="w-full relative overflow-hidden group bg-white text-black font-semibold py-3 px-4 rounded-xl transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:shadow-white/10 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <!-- Shimmer Effect -->
                    <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></span>

                    <span x-show="!loading" class="relative flex items-center justify-center">
                        <i class="fas fa-check mr-2"></i>Reset Password
                    </span>
                    <span x-show="loading" class="relative flex items-center justify-center">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Resetting...
                    </span>
                </button>
            </form>

            <!-- Back to Login -->
            <div class="mt-6 text-center">
                <a href="{{ route('auth.login') }}" class="text-gray-400 hover:text-white transition-colors text-sm font-medium inline-flex items-center gap-2 group">
                    <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                    Back to Login
                </a>
            </div>

            <!-- Help Section -->
            <div class="mt-6 p-4 bg-white/5 border border-white/10 rounded-xl">
                <p class="text-xs text-gray-400 text-center">
                    <i class="fas fa-question-circle mr-1"></i>
                    Didn't receive a token?
                    <a href="{{ route('auth.forgot-password') }}" class="text-white hover:underline">Request a new one</a>
                </p>
            </div>
        </div>

        <!-- Footer Note -->
        <p class="text-center text-xs text-gray-600 mt-8 flex items-center justify-center gap-2">
            <i class="fas fa-shield-alt"></i>
            <span>Your password is securely encrypted</span>
        </p>
    </div>
</div>

<style>
    @keyframes rotate-slow {
        from { transform: translate(-50%, -50%) rotate(0deg); }
        to { transform: translate(-50%, -50%) rotate(360deg); }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) scale(1); }
        50% { transform: translateY(-20px) scale(1.05); }
    }

    @keyframes pulse-slow {
        0%, 100% { opacity: 0.3; transform: scale(1); }
        50% { opacity: 0.6; transform: scale(1.1); }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse {
        0%, 100% { opacity: 0.2; }
        50% { opacity: 0.5; }
    }

    .animate-rotate-slow {
        animation: rotate-slow 25s linear infinite;
    }

    .animate-float {
        animation: float 6s ease-in-out infinite;
    }

    .animate-pulse-slow {
        animation: pulse-slow 3s ease-in-out infinite;
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.5s ease-out forwards;
    }

    .animate-pulse {
        animation: pulse 2s ease-in-out infinite;
    }

    .shadow-3xl {
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.6);
    }

    /* Custom Scrollbar for inputs */
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus {
        -webkit-box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.05) inset !important;
        -webkit-text-fill-color: white !important;
        border-color: rgba(255, 255, 255, 0.2) !important;
    }

    /* Smooth transitions */
    * {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
</style>

<script>
function resetPasswordForm() {
    return {
        form: {
            email: '',
            token: new URLSearchParams(window.location.search).get('token') || '',
            password: '',
            password_confirmation: ''
        },
        loading: false,
        error: '',
        success: '',
        showPassword: false,
        showConfirmPassword: false,

        get passwordStrength() {
            const pwd = this.form.password;
            if (!pwd) return 0;
            let strength = 0;
            if (pwd.length >= 8) strength += 25;
            if (pwd.match(/[a-z]/) && pwd.match(/[A-Z]/)) strength += 25;
            if (pwd.match(/\d/)) strength += 25;
            if (pwd.match(/[^a-zA-Z\d]/)) strength += 25;
            return strength;
        },

        get passwordStrengthColor() {
            const strength = this.passwordStrength;
            if (strength < 25) return '#ef4444';
            if (strength < 50) return '#f59e0b';
            if (strength < 75) return '#3b82f6';
            return '#22c55e';
        },

        get passwordStrengthText() {
            const strength = this.passwordStrength;
            if (strength < 25) return 'Weak';
            if (strength < 50) return 'Fair';
            if (strength < 75) return 'Good';
            return 'Strong';
        },

        get isFormValid() {
            return this.form.email &&
                   this.form.token &&
                   this.form.password.length >= 8 &&
                   this.form.password === this.form.password_confirmation;
        },

        async resetPassword() {
            this.error = '';
            this.success = '';

            if (this.form.password !== this.form.password_confirmation) {
                this.error = 'Passwords do not match';
                return;
            }

            if (this.form.password.length < 8) {
                this.error = 'Password must be at least 8 characters';
                return;
            }

            this.loading = true;

            try {
                const response = await axios.post('/api/auth/reset-password', {
                    email: this.form.email,
                    token: this.form.token,
                    password: this.form.password,
                    password_confirmation: this.form.password_confirmation
                });

                if (response.data.status) {
                    this.success = 'Password reset successfully! Redirecting to login...';
                    setTimeout(() => {
                        window.location.href = '/auth/login';
                    }, 2000);
                } else {
                    this.error = response.data.message || 'Password reset failed';
                }
            } catch (error) {
                if (error.response?.status === 400) {
                    this.error = 'Invalid or expired token. Please request a new one.';
                } else if (error.response?.data?.message) {
                    this.error = error.response.data.message;
                } else {
                    this.error = 'An error occurred. Please try again.';
                }
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
@endsection
