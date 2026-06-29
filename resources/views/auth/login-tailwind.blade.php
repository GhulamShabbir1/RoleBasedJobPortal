@extends('layouts.app')

@section('title', 'Login - JobHub')

@section('content')
<div class="min-h-screen bg-black flex items-center justify-center px-4 py-12 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/5 rounded-full blur-3xl animate-float" style="animation-delay: 1.5s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] border border-white/5 rounded-full animate-rotate-slow"></div>
        <div class="absolute top-1/3 right-1/3 w-40 h-40 bg-white/5 rounded-full blur-2xl animate-float" style="animation-delay: 2.5s;"></div>

        <!-- Floating Particles -->
        <div class="absolute top-20 left-20 w-2 h-2 bg-white/20 rounded-full animate-pulse"></div>
        <div class="absolute bottom-40 right-20 w-3 h-3 bg-white/20 rounded-full animate-pulse" style="animation-delay: 0.5s;"></div>
        <div class="absolute top-1/2 left-10 w-2 h-2 bg-white/20 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-1/3 right-10 w-2 h-2 bg-white/20 rounded-full animate-pulse" style="animation-delay: 1.5s;"></div>
    </div>

    <div class="max-w-md w-full relative z-10">
        <!-- Card -->
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl p-8 hover:shadow-3xl transition-all duration-500 relative overflow-hidden" x-data="loginForm()">
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
                        <i class="fas fa-briefcase text-black text-3xl"></i>
                    </div>
                </div>
                <h1 class="text-4xl font-bold text-white tracking-tight">Welcome Back</h1>
                <div class="w-16 h-1 bg-gradient-to-r from-white to-transparent mx-auto mt-3 rounded-full"></div>
                <p class="text-gray-400 mt-3 text-sm">Sign in to continue your journey</p>
            </div>

            <!-- Error Alert -->
            <div x-show="error" class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-400 flex items-start backdrop-blur-sm animate-fadeInUp" x-transition>
                <i class="fas fa-exclamation-circle mr-3 mt-0.5 text-red-400"></i>
                <span x-text="error" class="text-sm"></span>
            </div>

            <!-- Success Alert (for logout or registration) -->
            <div x-show="success" class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 flex items-start backdrop-blur-sm animate-fadeInUp" x-transition>
                <i class="fas fa-check-circle mr-3 mt-0.5 text-green-400"></i>
                <span x-text="success" class="text-sm"></span>
            </div>

            <!-- Form -->
            <form @submit.prevent="login()" class="space-y-5 relative">
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

                <!-- Password -->
                <div class="group">
                    <label class="block text-sm font-medium text-gray-300 mb-2 transition-colors group-focus-within:text-white">
                        <i class="fas fa-lock mr-2"></i>Password
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
                            autocomplete="current-password"
                        >
                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-white transition-colors group">
                            <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" x-model="form.remember" class="hidden">
                            <div class="w-5 h-5 border-2 rounded flex items-center justify-center transition-all duration-300" :class="form.remember ? 'border-white bg-white' : 'border-white/30 group-hover:border-white/60'">
                                <i class="fas fa-check text-black text-xs" x-show="form.remember"></i>
                            </div>
                        </div>
                        <span class="ml-2 text-sm text-gray-400 group-hover:text-gray-300 transition-colors">Remember me</span>
                    </label>

                    <a href="{{ route('auth.forgot-password') }}" class="text-sm text-gray-400 hover:text-white transition-colors hover:underline">
                        Forgot Password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    :disabled="loading"
                    class="w-full relative overflow-hidden group bg-white text-black font-semibold py-3 px-4 rounded-xl transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:shadow-white/10 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <!-- Shimmer Effect -->
                    <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></span>

                    <span x-show="!loading" class="relative flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                    </span>
                    <span x-show="loading" class="relative flex items-center justify-center">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Signing in...
                    </span>
                </button>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/10"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-black/50 text-gray-500 backdrop-blur-sm">Or continue with</span>
                    </div>
                </div>

                <!-- Social Login Buttons -->
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" class="flex items-center justify-center gap-2 py-2.5 px-4 border border-white/10 rounded-xl text-gray-300 hover:bg-white/5 hover:border-white/30 transition-all duration-300 group">
                        <i class="fab fa-google text-lg group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm">Google</span>
                    </button>
                    <button type="button" class="flex items-center justify-center gap-2 py-2.5 px-4 border border-white/10 rounded-xl text-gray-300 hover:bg-white/5 hover:border-white/30 transition-all duration-300 group">
                        <i class="fab fa-linkedin-in text-lg group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm">LinkedIn</span>
                    </button>
                </div>
            </form>

            <!-- Sign Up Link -->
            <div class="mt-6 text-center text-sm text-gray-500">
                Don't have an account?
                <a href="{{ route('auth.signup') }}" class="text-white hover:text-gray-300 font-medium transition-colors hover:underline">
                    Create Account
                </a>
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

    /* Smooth transitions for all interactive elements */
    * {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
</style>

<script>
function loginForm() {
    return {
        form: {
            email: '',
            password: '',
            remember: false
        },
        loading: false,
        error: '',
        success: '',
        showPassword: false,

        setDemo(email, password) {
            this.form.email = email;
            this.form.password = password;
            // Visual feedback - highlight the fields
            this.success = 'Demo credentials loaded! Click Sign In to continue.';
            setTimeout(() => {
                this.success = '';
            }, 3000);
        },

        async login() {
            this.error = '';
            this.success = '';

            // Basic validation
            if (!this.form.email || !this.form.password) {
                this.error = 'Please fill in all fields';
                return;
            }

            this.loading = true;

            try {
                const response = await axios.post('/api/auth/login', {
                    email: this.form.email,
                    password: this.form.password
                });

                if (response.data.success) {
                    // Store token
                    localStorage.setItem('token', response.data.data.token);

                    // Store user data if needed
                    if (response.data.data.user) {
                        localStorage.setItem('user', JSON.stringify(response.data.data.user));
                    }

                    // Redirect based on role
                    const role = response.data.data.user.role || 'candidate';

                    // Show success message before redirect
                    this.success = 'Login successful! Redirecting...';

                    setTimeout(() => {
                        window.location.href = `/dashboard/${role}`;
                    }, 1000);
                } else {
                    this.error = response.data.message || 'Login failed';
                }
            } catch (error) {
                if (error.response?.status === 401) {
                    this.error = 'Invalid email or password. Please try again.';
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
