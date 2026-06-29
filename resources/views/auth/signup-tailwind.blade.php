@extends('layouts.app')

@section('title', 'Register - JobHub')

@section('content')
<div class="min-h-screen bg-black flex items-center justify-center px-4 py-12 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-0 left-0 w-96 h-96 bg-white/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl animate-float" style="animation-delay: 1.5s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] border border-white/5 rounded-full animate-rotate-slow"></div>
        <div class="absolute top-1/4 right-1/4 w-32 h-32 bg-white/5 rounded-full blur-2xl animate-float" style="animation-delay: 2s;"></div>
    </div>

    <div class="max-w-md w-full relative z-10">
        <!-- Card -->
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl p-8 hover:shadow-3xl transition-all duration-500" x-data="registerForm()">
            <!-- Glassmorphism Glow -->
            <div class="absolute -top-20 -right-20 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>

            <!-- Logo -->
            <div class="text-center mb-8 relative">
                <div class="relative inline-block">
                    <div class="absolute inset-0 bg-white/20 rounded-full blur-xl animate-pulse-slow"></div>
                    <div class="relative w-20 h-20 bg-gradient-to-br from-white to-gray-300 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-2xl transform hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-briefcase text-black text-3xl"></i>
                    </div>
                </div>
                <h1 class="text-4xl font-bold text-white tracking-tight">Join JobHub</h1>
                <div class="w-16 h-1 bg-gradient-to-r from-white to-transparent mx-auto mt-3 rounded-full"></div>
                <p class="text-gray-400 mt-3 text-sm">Create Your Account & Start Your Journey</p>
            </div>

            <!-- Error Alert -->
            <div x-show="error" class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-400 flex items-start backdrop-blur-sm" x-transition>
                <i class="fas fa-exclamation-circle mr-3 mt-0.5 text-red-400"></i>
                <span x-text="error" class="text-sm"></span>
            </div>

            <!-- Success Alert -->
            <div x-show="success" class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 flex items-start backdrop-blur-sm" x-transition>
                <i class="fas fa-check-circle mr-3 mt-0.5 text-green-400"></i>
                <span x-text="success" class="text-sm"></span>
            </div>

            <!-- Form -->
            <form @submit.prevent="register()" class="space-y-5 relative" x-show="!success">
                <!-- Name -->
                <div class="group">
                    <label class="block text-sm font-medium text-gray-300 mb-2 transition-colors group-focus-within:text-white">
                        <i class="fas fa-user mr-2"></i>Full Name
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-500 group-focus-within:text-white transition-colors"></i>
                        </div>
                        <input
                            type="text"
                            x-model="form.name"
                            placeholder="John Doe"
                            class="w-full pl-10 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:ring-2 focus:ring-white/30 focus:border-transparent outline-none transition-all duration-300"
                            required
                        >
                    </div>
                </div>

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
                            minlength="8"
                        >
                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-white transition-colors">
                            <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    <!-- Password Strength Indicator -->
                    <div class="mt-2">
                        <div class="flex items-center gap-2">
                            <div class="flex-1 h-1 bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full transition-all duration-500" :style="{ width: passwordStrength + '%', background: passwordStrengthColor }"></div>
                            </div>
                            <span class="text-xs text-gray-500" x-text="passwordStrengthText"></span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">At least 8 characters</p>
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
                            type="password"
                            x-model="form.password_confirmation"
                            placeholder="••••••••"
                            class="w-full pl-10 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:ring-2 focus:ring-white/30 focus:border-transparent outline-none transition-all duration-300"
                            required
                        >
                    </div>
                    <!-- Password Match Indicator -->
                    <div x-show="form.password_confirmation.length > 0" class="mt-2">
                        <p class="text-xs" :class="form.password === form.password_confirmation ? 'text-green-400' : 'text-red-400'">
                            <i class="fas" :class="form.password === form.password_confirmation ? 'fa-check-circle' : 'fa-times-circle'"></i>
                            <span x-text="form.password === form.password_confirmation ? 'Passwords match' : 'Passwords do not match'"></span>
                        </p>
                    </div>
                </div>

                <!-- Role Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-3">
                        <i class="fas fa-users mr-2"></i>I am a...
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="group cursor-pointer" @click="form.role = 'candidate'">
                            <div class="p-4 border rounded-xl text-center transition-all duration-300" :class="form.role === 'candidate' ? 'border-white bg-white/10 shadow-lg shadow-white/5' : 'border-white/10 hover:border-white/30 hover:bg-white/5'">
                                <input type="radio" x-model="form.role" value="candidate" class="hidden">
                                <div class="text-3xl mb-2" :class="form.role === 'candidate' ? 'text-white' : 'text-gray-500'">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <p class="font-medium text-sm" :class="form.role === 'candidate' ? 'text-white' : 'text-gray-400'">Candidate</p>
                                <p class="text-xs text-gray-500 mt-1">Looking for a job</p>
                            </div>
                        </label>

                        <label class="group cursor-pointer" @click="form.role = 'employer'">
                            <div class="p-4 border rounded-xl text-center transition-all duration-300" :class="form.role === 'employer' ? 'border-white bg-white/10 shadow-lg shadow-white/5' : 'border-white/10 hover:border-white/30 hover:bg-white/5'">
                                <input type="radio" x-model="form.role" value="employer" class="hidden">
                                <div class="text-3xl mb-2" :class="form.role === 'employer' ? 'text-white' : 'text-gray-500'">
                                    <i class="fas fa-building"></i>
                                </div>
                                <p class="font-medium text-sm" :class="form.role === 'employer' ? 'text-white' : 'text-gray-400'">Employer</p>
                                <p class="text-xs text-gray-500 mt-1">Hiring talent</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Terms -->
                <label class="flex items-start cursor-pointer group">
                    <div class="relative">
                        <input type="checkbox" x-model="form.agree_terms" class="hidden">
                        <div class="w-5 h-5 border-2 rounded flex items-center justify-center transition-all duration-300" :class="form.agree_terms ? 'border-white bg-white' : 'border-white/30 group-hover:border-white/60'">
                            <i class="fas fa-check text-black text-xs" x-show="form.agree_terms"></i>
                        </div>
                    </div>
                    <span class="ml-3 text-xs text-gray-400 group-hover:text-gray-300 transition-colors">
                        I agree to the <a href="#" class="text-white hover:underline">Terms of Service</a> and <a href="#" class="text-white hover:underline">Privacy Policy</a>
                    </span>
                </label>

                <!-- Submit Button -->
                <button
                    type="submit"
                    :disabled="loading"
                    class="w-full relative overflow-hidden group bg-white text-black font-semibold py-3 px-4 rounded-xl transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:shadow-white/10 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></span>
                    <span x-show="!loading" class="relative flex items-center justify-center">
                        <i class="fas fa-user-plus mr-2"></i>Create Account
                    </span>
                    <span x-show="loading" class="relative flex items-center justify-center">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Creating...
                    </span>
                </button>

                <!-- Social Login Divider -->
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
                    <button type="button" class="flex items-center justify-center gap-2 py-2.5 px-4 border border-white/10 rounded-xl text-gray-300 hover:bg-white/5 hover:border-white/30 transition-all duration-300">
                        <i class="fab fa-google text-lg"></i>
                        <span class="text-sm">Google</span>
                    </button>
                    <button type="button" class="flex items-center justify-center gap-2 py-2.5 px-4 border border-white/10 rounded-xl text-gray-300 hover:bg-white/5 hover:border-white/30 transition-all duration-300">
                        <i class="fab fa-linkedin-in text-lg"></i>
                        <span class="text-sm">LinkedIn</span>
                    </button>
                </div>
            </form>

            <!-- Success Message -->
            <div x-show="success" class="text-center py-8">
                <div class="relative inline-block mb-6">
                    <div class="absolute inset-0 bg-green-500/20 rounded-full blur-xl animate-pulse"></div>
                    <div class="relative w-24 h-24 bg-green-500/10 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-5xl text-green-400"></i>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Welcome to JobHub!</h3>
                <p class="text-gray-400 mb-4">Your account has been created successfully.</p>
                <div class="flex items-center justify-center gap-2 text-sm text-gray-500">
                    <i class="fas fa-spinner fa-spin"></i>
                    <span>Redirecting to login...</span>
                </div>
            </div>

            <!-- Login Link -->
            <div class="mt-6 text-center text-sm text-gray-500">
                Already have an account?
                <a href="{{ route('auth.login') }}" class="text-white hover:text-gray-300 font-medium transition-colors hover:underline">
                    Sign In
                </a>
            </div>
        </div>

        <!-- Footer Note -->
        <p class="text-center text-xs text-gray-600 mt-8">
            <i class="fas fa-shield-alt mr-1"></i> Your information is secure and protected
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

    .animate-rotate-slow {
        animation: rotate-slow 25s linear infinite;
    }

    .animate-float {
        animation: float 6s ease-in-out infinite;
    }

    .animate-pulse-slow {
        animation: pulse-slow 3s ease-in-out infinite;
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
</style>

<script>
function registerForm() {
    return {
        form: {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            role: 'candidate',
            agree_terms: false
        },
        loading: false,
        error: '',
        success: '',
        showPassword: false,

        get passwordStrength() {
            const pwd = this.form.password;
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

        async register() {
            this.error = '';
            this.success = '';

            if (!this.form.agree_terms) {
                this.error = 'You must agree to the Terms of Service';
                return;
            }

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
                const response = await axios.post('/api/auth/register', {
                    name: this.form.name,
                    email: this.form.email,
                    password: this.form.password,
                    password_confirmation: this.form.password_confirmation,
                    role: this.form.role
                });

                if (response.data.success) {
                    this.success = 'Account created successfully!';
                    setTimeout(() => {
                        window.location.href = '/auth/login';
                    }, 2000);
                } else {
                    this.error = response.data.message || 'Registration failed';
                }
            } catch (error) {
                if (error.response?.data?.errors) {
                    const errors = error.response.data.errors;
                    this.error = Object.values(errors).flat().join(', ');
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
