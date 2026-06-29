@extends('layouts.app')

@section('title', 'Forgot Password - JobHub')

@section('content')
<div class="min-h-screen bg-black flex items-center justify-center px-4 py-12 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/5 rounded-full blur-3xl animate-float" style="animation-delay: 1.5s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] border border-white/5 rounded-full animate-rotate-slow"></div>
        <div class="absolute top-1/4 right-1/4 w-32 h-32 bg-white/5 rounded-full blur-2xl animate-float" style="animation-delay: 2s;"></div>

        <!-- Floating Particles -->
        <div class="absolute top-20 left-20 w-2 h-2 bg-white/20 rounded-full animate-pulse"></div>
        <div class="absolute bottom-40 right-20 w-3 h-3 bg-white/20 rounded-full animate-pulse" style="animation-delay: 0.5s;"></div>
        <div class="absolute top-1/2 left-10 w-2 h-2 bg-white/20 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-1/3 right-10 w-2 h-2 bg-white/20 rounded-full animate-pulse" style="animation-delay: 1.5s;"></div>

        <!-- Envelope Icon Animation -->
        <div class="absolute top-1/3 left-1/4 text-6xl text-white/5 animate-float" style="animation-delay: 1s;">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="absolute bottom-1/3 right-1/4 text-6xl text-white/5 animate-float" style="animation-delay: 2.5s;">
            <i class="fas fa-lock"></i>
        </div>
    </div>

    <div class="max-w-md w-full relative z-10">
        <!-- Card -->
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl p-8 hover:shadow-3xl transition-all duration-500 relative overflow-hidden" x-data="forgotPasswordForm()">
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
                        <i class="fas fa-lock text-black text-3xl"></i>
                    </div>
                </div>
                <h1 class="text-4xl font-bold text-white tracking-tight">Forgot Password</h1>
                <div class="w-16 h-1 bg-gradient-to-r from-white to-transparent mx-auto mt-3 rounded-full"></div>
                <p class="text-gray-400 mt-3 text-sm">We'll send you a reset link to your email</p>
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
                    <div class="w-8 h-8 rounded-full bg-white/20 border-2 border-white/30 text-white flex items-center justify-center text-xs font-bold">2</div>
                    <div class="flex-1 h-0.5 bg-white/10 mx-2"></div>
                </div>
                <div class="flex-1 flex items-center">
                    <div class="w-8 h-8 rounded-full bg-white/10 border border-white/10 text-white/50 flex items-center justify-center text-xs font-bold">3</div>
                </div>
            </div>

            <!-- Form -->
            <form @submit.prevent="sendReset()" class="space-y-5 relative" x-show="!success">
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
                    <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                        <i class="fas fa-info-circle"></i>
                        Enter the email address associated with your account
                    </p>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    :disabled="loading || !form.email"
                    class="w-full relative overflow-hidden group bg-white text-black font-semibold py-3 px-4 rounded-xl transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:shadow-white/10 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <!-- Shimmer Effect -->
                    <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></span>

                    <span x-show="!loading" class="relative flex items-center justify-center">
                        <i class="fas fa-paper-plane mr-2"></i>Send Reset Link
                    </span>
                    <span x-show="loading" class="relative flex items-center justify-center">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Sending...
                    </span>
                </button>
            </form>

            <!-- Success Message -->
            <div x-show="success" class="text-center py-4">
                <div class="relative inline-block mb-6">
                    <div class="absolute inset-0 bg-green-500/20 rounded-full blur-xl animate-pulse"></div>
                    <div class="relative w-24 h-24 bg-green-500/10 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-5xl text-green-400"></i>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Check Your Email</h3>
                <p class="text-gray-400 text-sm mb-4">We've sent a password reset link to your email address.</p>
                <div class="flex items-center justify-center gap-2 text-sm text-gray-500">
                    <i class="fas fa-spinner fa-spin"></i>
                    <span>Redirecting to login...</span>
                </div>
            </div>

            <!-- Back to Login -->
            <div class="mt-6 text-center" x-show="!success">
                <a href="{{ route('auth.login') }}" class="text-gray-400 hover:text-white transition-colors text-sm font-medium inline-flex items-center gap-2 group">
                    <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                    Back to Login
                </a>
            </div>

            <!-- Help Section -->
            <div class="mt-6 p-4 bg-white/5 border border-white/10 rounded-xl">
                <div class="flex items-start gap-3">
                    <i class="fas fa-question-circle text-gray-400 mt-0.5"></i>
                    <div>
                        <p class="text-xs text-gray-400">
                            <span class="font-semibold text-gray-300">Need help?</span> If you're having trouble,
                            <a href="#" class="text-white hover:underline">contact support</a>
                            and we'll assist you.
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-clock mr-1"></i> The reset link expires in 60 minutes
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <p class="text-center text-xs text-gray-600 mt-8 flex items-center justify-center gap-2">
            <i class="fas fa-shield-alt"></i>
            <span>Your information is secure and encrypted</span>
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

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-2px); }
        20%, 40%, 60%, 80% { transform: translateX(2px); }
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

    .animate-shake {
        animation: shake 0.5s ease-in-out;
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
function forgotPasswordForm() {
    return {
        form: {
            email: ''
        },
        loading: false,
        error: '',
        success: '',
        resendCount: 0,
        lastResendTime: null,

        get canResend() {
            if (!this.lastResendTime) return true;
            const elapsed = (Date.now() - this.lastResendTime) / 1000;
            return elapsed >= 60; // 60 seconds cooldown
        },

        get resendWaitTime() {
            if (!this.lastResendTime) return 0;
            const elapsed = (Date.now() - this.lastResendTime) / 1000;
            return Math.max(0, 60 - Math.floor(elapsed));
        },

        async sendReset() {
            this.error = '';
            this.success = '';

            // Email validation
            if (!this.form.email) {
                this.error = 'Please enter your email address';
                return;
            }

            // Simple email format validation
            if (!this.form.email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                this.error = 'Please enter a valid email address';
                return;
            }

            this.loading = true;

            try {
                const response = await axios.post('/api/auth/forgot-password', {
                    email: this.form.email
                });

                if (response.data.success) {
                    this.success = 'Password reset link sent successfully! Check your email inbox.';
                    this.lastResendTime = Date.now();
                    this.resendCount++;

                    // Auto redirect after 3 seconds
                    setTimeout(() => {
                        window.location.href = '/auth/login';
                    }, 3000);
                } else {
                    this.error = response.data.message || 'Failed to send reset link';
                }
            } catch (error) {
                if (error.response?.status === 404) {
                    this.error = 'No account found with this email address';
                } else if (error.response?.status === 429) {
                    this.error = 'Too many requests. Please wait a moment before trying again.';
                } else if (error.response?.data?.message) {
                    this.error = error.response.data.message;
                } else {
                    this.error = 'Unable to send reset link. Please try again later.';
                }
            } finally {
                this.loading = false;
            }
        },

        resendReset() {
            if (this.canResend) {
                this.sendReset();
            }
        }
    }
}
</script>
@endsection
