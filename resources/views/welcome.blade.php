<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobHub - Find Your Perfect Job</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-15px) rotate(2deg);
            }
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }

        @keyframes rotateSlow {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-fadeInDown {
            animation: fadeInDown 0.8s ease-out forwards;
        }

        .animate-slideInLeft {
            animation: slideInLeft 0.8s ease-out forwards;
        }

        .animate-slideInRight {
            animation: slideInRight 0.8s ease-out forwards;
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        .animate-pulse-slow {
            animation: pulse 2s ease-in-out infinite;
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradientShift 4s ease infinite;
        }

        .animate-shimmer {
            background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.1) 50%, transparent 100%);
            background-size: 1000px 100%;
            animation: shimmer 3s infinite;
        }

        .animate-rotate-slow {
            animation: rotateSlow 20s linear infinite;
        }

        .animate-scaleIn {
            animation: scaleIn 0.6s ease-out forwards;
        }

        .delay-100 {
            animation-delay: 0.1s;
            opacity: 0;
        }

        .delay-200 {
            animation-delay: 0.2s;
            opacity: 0;
        }

        .delay-300 {
            animation-delay: 0.3s;
            opacity: 0;
        }

        .delay-400 {
            animation-delay: 0.4s;
            opacity: 0;
        }

        .delay-500 {
            animation-delay: 0.5s;
            opacity: 0;
        }

        /* Hero Overlay */
        .hero-overlay {
            background: linear-gradient(135deg, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.6) 40%, rgba(0,0,0,0.8) 100%);
        }

        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .glass-dark {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .glass-white {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Hover Effects */
        .hover-lift {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .hover-glow:hover {
            box-shadow: 0 0 40px rgba(255, 255, 255, 0.05);
        }

        .hover-scale {
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        /* Feature Icons */
        .feature-icon {
            transition: all 0.4s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }

        /* Stats Counter */
        .stat-number {
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-number {
            transform: scale(1.1);
        }

        /* Testimonial Cards */
        .testimonial-card {
            transition: all 0.4s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #0a0a0a;
        }

        ::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #444;
        }

        /* Progress Bar */
        .progress-bar {
            height: 4px;
            background: linear-gradient(90deg, #ffffff, #666666);
            animation: gradientShift 3s ease infinite;
            background-size: 200% 200%;
        }

        /* Gradient Border */
        .gradient-border {
            position: relative;
        }

        .gradient-border::before {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: inherit;
            padding: 1px;
            background: linear-gradient(135deg, rgba(255,255,255,0.3), transparent);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Section Divider */
        .section-divider {
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, white, transparent);
            margin: 0 auto;
        }
    </style>
</head>
<body class="bg-black text-white">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-black/95 backdrop-blur-md border-b border-white/5 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center hover:scale-110 transition-transform">
                        <i class="fas fa-briefcase text-black text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold text-white tracking-tight">JobHub</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#jobs" class="text-gray-300 hover:text-white transition-colors text-sm">Jobs</a>
                    <a href="#companies" class="text-gray-300 hover:text-white transition-colors text-sm">Companies</a>
                    <a href="#features" class="text-gray-300 hover:text-white transition-colors text-sm">Features</a>
                    <a href="#testimonials" class="text-gray-300 hover:text-white transition-colors text-sm">Testimonials</a>
                    <a href="#blog" class="text-gray-300 hover:text-white transition-colors text-sm">Blog</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('auth.login') }}" class="text-gray-300 hover:text-white transition-colors">Login</a>
                        <a href="{{ route('auth.signup') }}" class="bg-white text-black px-5 py-2 rounded-lg font-semibold hover:bg-gray-200 transition-all hover:scale-105">
                            Sign Up
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- ========== HERO SECTION ========== -->
    <section class="relative min-h-screen flex items-center overflow-hidden pt-16" id="home">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img
                src="https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
                alt="Office background"
                class="w-full h-full object-cover"
            >
            <div class="absolute inset-0 hero-overlay"></div>
        </div>

        <!-- Animated Background Elements -->
        <div class="absolute inset-0 z-0 overflow-hidden">
            <div class="absolute top-20 left-10 w-72 h-72 bg-white/5 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-white/5 rounded-full blur-3xl animate-float" style="animation-delay: 1.5s;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 border border-white/5 rounded-full animate-rotate-slow"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-block px-4 py-2 bg-white/10 rounded-full backdrop-blur-sm border border-white/10 mb-6 animate-fadeInUp">
                        <span class="text-sm font-medium text-white/80">
                            <i class="fas fa-rocket mr-2"></i> 10,000+ Jobs Available
                        </span>
                    </div>

                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold leading-tight mb-6 animate-slideInLeft">
                        Find Your
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-400 animate-gradient">
                            Dream Job
                        </span>
                        <br>
                        <span class="text-gray-300">Today</span>
                    </h1>

                    <p class="text-xl text-gray-300 mb-8 max-w-lg animate-slideInLeft delay-100">
                        Connect with thousands of opportunities from top companies worldwide. Your next career move starts here.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 animate-slideInLeft delay-200">
                        <a href="#jobs" class="group bg-white text-black px-8 py-3 rounded-lg font-semibold hover:bg-gray-200 transition-all hover:scale-105 flex items-center justify-center">
                            <span>Browse Jobs</span>
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        @guest
                            <a href="{{ route('auth.signup') }}" class="group border border-white/30 text-white px-8 py-3 rounded-lg font-semibold hover:bg-white/10 transition-all hover:scale-105 flex items-center justify-center">
                                <span>Get Started</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        @endguest
                    </div>

                    <!-- Trust Badges -->
                    <div class="flex items-center gap-6 mt-8 animate-fadeInUp delay-300">
                        <div class="flex -space-x-2">
                            <div class="w-10 h-10 rounded-full border-2 border-black bg-white/10 flex items-center justify-center text-sm font-bold">JD</div>
                            <div class="w-10 h-10 rounded-full border-2 border-black bg-white/10 flex items-center justify-center text-sm font-bold">AK</div>
                            <div class="w-10 h-10 rounded-full border-2 border-black bg-white/10 flex items-center justify-center text-sm font-bold">MS</div>
                            <div class="w-10 h-10 rounded-full border-2 border-black bg-white/10 flex items-center justify-center text-sm font-bold">+</div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Trusted by <span class="text-white font-semibold">50,000+</span> professionals</p>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Animated Stats Cards -->
                <div class="grid grid-cols-2 gap-4 animate-slideInRight delay-200">
                    <div class="glass p-6 rounded-xl text-center hover-lift">
                        <div class="text-4xl font-bold text-white mb-1 stat-number">10K+</div>
                        <p class="text-sm text-gray-400">Active Jobs</p>
                    </div>
                    <div class="glass p-6 rounded-xl text-center hover-lift delay-100">
                        <div class="text-4xl font-bold text-white mb-1 stat-number">5K+</div>
                        <p class="text-sm text-gray-400">Companies</p>
                    </div>
                    <div class="glass p-6 rounded-xl text-center hover-lift delay-200">
                        <div class="text-4xl font-bold text-white mb-1 stat-number">50K+</div>
                        <p class="text-sm text-gray-400">Candidates</p>
                    </div>
                    <div class="glass p-6 rounded-xl text-center hover-lift delay-300">
                        <div class="text-4xl font-bold text-white mb-1 stat-number">100K+</div>
                        <p class="text-sm text-gray-400">Applications</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 animate-bounce">
            <a href="#features" class="text-white/40 hover:text-white/60 transition-colors">
                <i class="fas fa-chevron-down text-2xl"></i>
            </a>
        </div>
    </section>

    <!-- ========== PROGRESS BAR ========== -->
    <div class="progress-bar"></div>

    <!-- ========== FEATURES SECTION ========== -->
    <section class="py-20 bg-black border-t border-white/5" id="features">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-sm font-medium text-gray-400 uppercase tracking-wider">Why Choose Us</span>
                <h2 class="text-4xl font-bold mt-2">Everything You Need to Succeed</h2>
                <div class="section-divider mt-4"></div>
                <p class="text-gray-400 mt-4 max-w-2xl mx-auto">Discover why thousands of professionals trust JobHub for their career journey</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="group bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-8 hover:bg-white/10 transition-all hover:scale-105">
                    <div class="w-16 h-16 bg-white/10 rounded-xl flex items-center justify-center mb-6 feature-icon group-hover:bg-white/20">
                        <i class="fas fa-search text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Smart Search</h3>
                    <p class="text-gray-400 leading-relaxed">Find jobs with advanced filters - by category, location, salary, and more. Powered by AI.</p>
                    <div class="mt-4 flex items-center text-white/60 group-hover:text-white transition-colors">
                        <span class="text-sm">Learn more</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>

                <div class="group bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-8 hover:bg-white/10 transition-all hover:scale-105">
                    <div class="w-16 h-16 bg-white/10 rounded-xl flex items-center justify-center mb-6 feature-icon group-hover:bg-white/20">
                        <i class="fas fa-building text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Top Companies</h3>
                    <p class="text-gray-400 leading-relaxed">Connect with leading employers looking for talented professionals like you.</p>
                    <div class="mt-4 flex items-center text-white/60 group-hover:text-white transition-colors">
                        <span class="text-sm">Learn more</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>

                <div class="group bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-8 hover:bg-white/10 transition-all hover:scale-105">
                    <div class="w-16 h-16 bg-white/10 rounded-xl flex items-center justify-center mb-6 feature-icon group-hover:bg-white/20">
                        <i class="fas fa-bolt text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Quick Apply</h3>
                    <p class="text-gray-400 leading-relaxed">Apply to jobs instantly with your profile and resume. One-click applications.</p>
                    <div class="mt-4 flex items-center text-white/60 group-hover:text-white transition-colors">
                        <span class="text-sm">Learn more</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== STATS SECTION ========== -->
    <section class="py-16 bg-white/5 border-y border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center stat-card">
                    <p class="text-5xl font-bold text-white stat-number">10K+</p>
                    <p class="text-gray-400 mt-2">Active Jobs</p>
                </div>
                <div class="text-center stat-card">
                    <p class="text-5xl font-bold text-white stat-number">5K+</p>
                    <p class="text-gray-400 mt-2">Companies</p>
                </div>
                <div class="text-center stat-card">
                    <p class="text-5xl font-bold text-white stat-number">50K+</p>
                    <p class="text-gray-400 mt-2">Candidates</p>
                </div>
                <div class="text-center stat-card">
                    <p class="text-5xl font-bold text-white stat-number">100K+</p>
                    <p class="text-gray-400 mt-2">Applications</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== JOB CATEGORIES SECTION ========== -->
    <section class="py-20 bg-black" id="jobs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-sm font-medium text-gray-400 uppercase tracking-wider">Categories</span>
                <h2 class="text-4xl font-bold mt-2">Popular Job Categories</h2>
                <div class="section-divider mt-4"></div>
                <p class="text-gray-400 mt-4 max-w-2xl mx-auto">Find jobs in your preferred industry from top companies</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="glass hover:bg-white/10 transition-all p-6 rounded-xl text-center hover-lift">
                    <div class="w-14 h-14 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-code text-2xl text-white"></i>
                    </div>
                    <h4 class="font-semibold">Technology</h4>
                    <p class="text-sm text-gray-400 mt-1">2,345 jobs</p>
                </div>
                <div class="glass hover:bg-white/10 transition-all p-6 rounded-xl text-center hover-lift">
                    <div class="w-14 h-14 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-2xl text-white"></i>
                    </div>
                    <h4 class="font-semibold">Finance</h4>
                    <p class="text-sm text-gray-400 mt-1">1,234 jobs</p>
                </div>
                <div class="glass hover:bg-white/10 transition-all p-6 rounded-xl text-center hover-lift">
                    <div class="w-14 h-14 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heartbeat text-2xl text-white"></i>
                    </div>
                    <h4 class="font-semibold">Healthcare</h4>
                    <p class="text-sm text-gray-400 mt-1">1,876 jobs</p>
                </div>
                <div class="glass hover:bg-white/10 transition-all p-6 rounded-xl text-center hover-lift">
                    <div class="w-14 h-14 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-graduation-cap text-2xl text-white"></i>
                    </div>
                    <h4 class="font-semibold">Education</h4>
                    <p class="text-sm text-gray-400 mt-1">987 jobs</p>
                </div>
                <div class="glass hover:bg-white/10 transition-all p-6 rounded-xl text-center hover-lift">
                    <div class="w-14 h-14 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shopping-cart text-2xl text-white"></i>
                    </div>
                    <h4 class="font-semibold">Sales</h4>
                    <p class="text-sm text-gray-400 mt-1">1,543 jobs</p>
                </div>
                <div class="glass hover:bg-white/10 transition-all p-6 rounded-xl text-center hover-lift">
                    <div class="w-14 h-14 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-paint-brush text-2xl text-white"></i>
                    </div>
                    <h4 class="font-semibold">Design</h4>
                    <p class="text-sm text-gray-400 mt-1">876 jobs</p>
                </div>
                <div class="glass hover:bg-white/10 transition-all p-6 rounded-xl text-center hover-lift">
                    <div class="w-14 h-14 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bullhorn text-2xl text-white"></i>
                    </div>
                    <h4 class="font-semibold">Marketing</h4>
                    <p class="text-sm text-gray-400 mt-1">1,234 jobs</p>
                </div>
                <div class="glass hover:bg-white/10 transition-all p-6 rounded-xl text-center hover-lift">
                    <div class="w-14 h-14 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-tools text-2xl text-white"></i>
                    </div>
                    <h4 class="font-semibold">Engineering</h4>
                    <p class="text-sm text-gray-400 mt-1">2,109 jobs</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== FEATURED JOBS SECTION ========== -->
    <section class="py-20 bg-white/5 border-y border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-sm font-medium text-gray-400 uppercase tracking-wider">Opportunities</span>
                <h2 class="text-4xl font-bold mt-2">Featured Jobs</h2>
                <div class="section-divider mt-4"></div>
                <p class="text-gray-400 mt-4 max-w-2xl mx-auto">Handpicked opportunities from top companies</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="glass p-6 rounded-xl hover-lift">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center">
                            <i class="fas fa-building text-xl text-white"></i>
                        </div>
                        <span class="bg-white/10 px-3 py-1 rounded-full text-xs text-gray-300">Full-time</span>
                    </div>
                    <h4 class="text-lg font-semibold mb-2">Senior PHP Developer</h4>
                    <p class="text-gray-400 text-sm mb-3">TechCorp Inc. • New York, NY</p>
                    <div class="flex items-center justify-between">
                        <span class="text-white font-semibold">$80K - $120K</span>
                        <a href="#" class="text-white/60 hover:text-white transition-colors text-sm">View Details →</a>
                    </div>
                </div>

                <div class="glass p-6 rounded-xl hover-lift">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center">
                            <i class="fas fa-building text-xl text-white"></i>
                        </div>
                        <span class="bg-white/10 px-3 py-1 rounded-full text-xs text-gray-300">Remote</span>
                    </div>
                    <h4 class="text-lg font-semibold mb-2">UX/UI Designer</h4>
                    <p class="text-gray-400 text-sm mb-3">DesignStudio • Remote</p>
                    <div class="flex items-center justify-between">
                        <span class="text-white font-semibold">$60K - $90K</span>
                        <a href="#" class="text-white/60 hover:text-white transition-colors text-sm">View Details →</a>
                    </div>
                </div>

                <div class="glass p-6 rounded-xl hover-lift">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center">
                            <i class="fas fa-building text-xl text-white"></i>
                        </div>
                        <span class="bg-white/10 px-3 py-1 rounded-full text-xs text-gray-300">Part-time</span>
                    </div>
                    <h4 class="text-lg font-semibold mb-2">Marketing Manager</h4>
                    <p class="text-gray-400 text-sm mb-3">BrandAgency • San Francisco, CA</p>
                    <div class="flex items-center justify-between">
                        <span class="text-white font-semibold">$70K - $100K</span>
                        <a href="#" class="text-white/60 hover:text-white transition-colors text-sm">View Details →</a>
                    </div>
                </div>
            </div>

            <div class="text-center mt-10">
                <a href="#" class="inline-block border border-white/30 text-white px-8 py-3 rounded-lg font-semibold hover:bg-white/10 transition-all hover:scale-105">
                    View All Jobs <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ========== HOW IT WORKS SECTION ========== -->
    <section class="py-20 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-sm font-medium text-gray-400 uppercase tracking-wider">Process</span>
                <h2 class="text-4xl font-bold mt-2">How It Works</h2>
                <div class="section-divider mt-4"></div>
                <p class="text-gray-400 mt-4 max-w-2xl mx-auto">Three simple steps to find your dream job</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                <!-- Connecting Line (Desktop) -->
                <div class="hidden md:block absolute top-16 left-1/6 right-1/6 h-0.5 bg-gradient-to-r from-white/20 via-white/40 to-white/20"></div>

                <div class="text-center relative">
                    <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl font-bold border-2 border-white/20 hover:bg-white/20 transition-all hover:scale-110">1</div>
                    <h4 class="text-xl font-semibold mb-3">Create Account</h4>
                    <p class="text-gray-400">Sign up in minutes and build your professional profile</p>
                </div>

                <div class="text-center relative">
                    <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl font-bold border-2 border-white/20 hover:bg-white/20 transition-all hover:scale-110">2</div>
                    <h4 class="text-xl font-semibold mb-3">Search Jobs</h4>
                    <p class="text-gray-400">Browse through thousands of opportunities that match your skills</p>
                </div>

                <div class="text-center relative">
                    <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl font-bold border-2 border-white/20 hover:bg-white/20 transition-all hover:scale-110">3</div>
                    <h4 class="text-xl font-semibold mb-3">Get Hired</h4>
                    <p class="text-gray-400">Apply instantly and land your dream job</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== TESTIMONIALS SECTION ========== -->
    <section class="py-20 bg-white/5 border-y border-white/5" id="testimonials">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-sm font-medium text-gray-400 uppercase tracking-wider">Testimonials</span>
                <h2 class="text-4xl font-bold mt-2">What Our Users Say</h2>
                <div class="section-divider mt-4"></div>
                <p class="text-gray-400 mt-4 max-w-2xl mx-auto">Real stories from real people who found their dream jobs</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="glass p-8 rounded-xl testimonial-card">
                    <div class="flex text-yellow-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-300 mb-6">"JobHub helped me find my dream job in just 2 weeks! The platform is incredibly user-friendly and the matching algorithm is spot on."</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center font-bold text-lg">JD</div>
                        <div class="ml-4">
                            <p class="font-semibold">John Doe</p>
                            <p class="text-sm text-gray-400">Senior Developer at Google</p>
                        </div>
                    </div>
                </div>

                <div class="glass p-8 rounded-xl testimonial-card">
                    <div class="flex text-yellow-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-300 mb-6">"As an employer, I've found exceptional talent through JobHub. The quality of candidates and the ease of use is unmatched."</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center font-bold text-lg">AK</div>
                        <div class="ml-4">
                            <p class="font-semibold">Sarah Kim</p>
                            <p class="text-sm text-gray-400">HR Manager at Microsoft</p>
                        </div>
                    </div>
                </div>

                <div class="glass p-8 rounded-xl testimonial-card">
                    <div class="flex text-yellow-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-300 mb-6">"I was job hunting for 6 months before I found JobHub. Within a week, I had multiple interviews and landed my perfect role!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center font-bold text-lg">MS</div>
                        <div class="ml-4">
                            <p class="font-semibold">Michael Smith</p>
                            <p class="text-sm text-gray-400">Data Scientist at Amazon</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== COMPANIES SECTION ========== -->
    <section class="py-20 bg-black" id="companies">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-sm font-medium text-gray-400 uppercase tracking-wider">Partners</span>
                <h2 class="text-4xl font-bold mt-2">Trusted by Leading Companies</h2>
                <div class="section-divider mt-4"></div>
                <p class="text-gray-400 mt-4 max-w-2xl mx-auto">Join thousands of companies already using JobHub</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8">
                <div class="glass p-6 rounded-xl text-center hover:bg-white/10 transition-all">
                    <i class="fas fa-google text-4xl text-white/60"></i>
                    <p class="text-sm text-gray-400 mt-2">Google</p>
                </div>
                <div class="glass p-6 rounded-xl text-center hover:bg-white/10 transition-all">
                    <i class="fas fa-microsoft text-4xl text-white/60"></i>
                    <p class="text-sm text-gray-400 mt-2">Microsoft</p>
                </div>
                <div class="glass p-6 rounded-xl text-center hover:bg-white/10 transition-all">
                    <i class="fas fa-amazon text-4xl text-white/60"></i>
                    <p class="text-sm text-gray-400 mt-2">Amazon</p>
                </div>
                <div class="glass p-6 rounded-xl text-center hover:bg-white/10 transition-all">
                    <i class="fas fa-apple text-4xl text-white/60"></i>
                    <p class="text-sm text-gray-400 mt-2">Apple</p>
                </div>
                <div class="glass p-6 rounded-xl text-center hover:bg-white/10 transition-all">
                    <i class="fas fa-facebook text-4xl text-white/60"></i>
                    <p class="text-sm text-gray-400 mt-2">Meta</p>
                </div>
                <div class="glass p-6 rounded-xl text-center hover:bg-white/10 transition-all">
                    <i class="fas fa-twitter text-4xl text-white/60"></i>
                    <p class="text-sm text-gray-400 mt-2">Twitter</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== BLOG / INSIGHTS SECTION ========== -->
    <section class="py-20 bg-white/5 border-y border-white/5" id="blog">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-sm font-medium text-gray-400 uppercase tracking-wider">Insights</span>
                <h2 class="text-4xl font-bold mt-2">Career Insights & Resources</h2>
                <div class="section-divider mt-4"></div>
                <p class="text-gray-400 mt-4 max-w-2xl mx-auto">Tips, guides, and advice to help you grow your career</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="glass overflow-hidden rounded-xl hover-lift">
                    <div class="h-48 bg-gradient-to-br from-white/10 to-transparent flex items-center justify-center">
                        <i class="fas fa-file-alt text-6xl text-white/30"></i>
                    </div>
                    <div class="p-6">
                        <span class="text-xs text-gray-400 uppercase">Career Advice</span>
                        <h4 class="text-xl font-semibold mt-2 mb-3">10 Tips for Acing Your Next Interview</h4>
                        <p class="text-gray-400 text-sm mb-4">Learn the secrets to impressing recruiters and landing your dream job.</p>
                        <a href="#" class="text-white/60 hover:text-white transition-colors text-sm">Read More →</a>
                    </div>
                </div>

                <div class="glass overflow-hidden rounded-xl hover-lift">
                    <div class="h-48 bg-gradient-to-br from-white/10 to-transparent flex items-center justify-center">
                        <i class="fas fa-chart-bar text-6xl text-white/30"></i>
                    </div>
                    <div class="p-6">
                        <span class="text-xs text-gray-400 uppercase">Industry Trends</span>
                        <h4 class="text-xl font-semibold mt-2 mb-3">Top Skills Employers Are Looking For in 2024</h4>
                        <p class="text-gray-400 text-sm mb-4">Stay ahead of the competition with the most in-demand skills.</p>
                        <a href="#" class="text-white/60 hover:text-white transition-colors text-sm">Read More →</a>
                    </div>
                </div>

                <div class="glass overflow-hidden rounded-xl hover-lift">
                    <div class="h-48 bg-gradient-to-br from-white/10 to-transparent flex items-center justify-center">
                        <i class="fas fa-rocket text-6xl text-white/30"></i>
                    </div>
                    <div class="p-6">
                        <span class="text-xs text-gray-400 uppercase">Career Growth</span>
                        <h4 class="text-xl font-semibold mt-2 mb-3">How to Negotiate Your Salary Like a Pro</h4>
                        <p class="text-gray-400 text-sm mb-4">Expert strategies to get the compensation you deserve.</p>
                        <a href="#" class="text-white/60 hover:text-white transition-colors text-sm">Read More →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== NEWSLETTER SECTION ========== -->
    <section class="py-20 bg-black">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="glass p-12 rounded-2xl relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent"></div>
                <div class="relative z-10">
                    <i class="fas fa-envelope text-5xl text-white/20 mb-6"></i>
                    <h2 class="text-3xl font-bold mb-4">Get Job Alerts</h2>
                    <p class="text-gray-400 mb-8 max-w-lg mx-auto">Subscribe to our newsletter and never miss new job opportunities</p>
                    <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                        <input type="email" placeholder="Enter your email" class="flex-1 px-4 py-3 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-white/30">
                        <button type="submit" class="bg-white text-black px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition-all hover:scale-105 whitespace-nowrap">
                            Subscribe
                        </button>
                    </form>
                    <p class="text-xs text-gray-500 mt-4">We respect your privacy. Unsubscribe at any time.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== CTA SECTION ========== -->
    <section class="py-20 relative overflow-hidden border-t border-white/5">
        <div class="absolute inset-0">
            <img
                src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
                alt="Team collaboration"
                class="w-full h-full object-cover"
            >
            <div class="absolute inset-0 bg-black/80"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-4 animate-fadeInUp">Ready to Find Your Next Opportunity?</h2>
            <p class="text-xl text-gray-300 mb-8 animate-fadeInUp delay-100">Join thousands of job seekers and employers on JobHub today</p>

            @guest
                <div class="flex flex-col sm:flex-row justify-center gap-4 animate-fadeInUp delay-200">
                    <a href="{{ route('auth.signup') }}?role=candidate" class="group bg-white text-black px-8 py-3 rounded-lg font-semibold hover:bg-gray-200 transition-all hover:scale-105 flex items-center justify-center">
                        <i class="fas fa-user mr-2"></i>
                        <span>I'm a Candidate</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="{{ route('auth.signup') }}?role=employer" class="group border border-white/30 text-white px-8 py-3 rounded-lg font-semibold hover:bg-white/10 transition-all hover:scale-105 flex items-center justify-center">
                        <i class="fas fa-building mr-2"></i>
                        <span>I'm an Employer</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            @endguest
        </div>
    </section>

    <!-- ========== FOOTER ========== -->
    <footer class="bg-black/95 border-t border-white/5 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8 mb-12">
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                            <i class="fas fa-briefcase text-black text-xl"></i>
                        </div>
                        <span class="text-xl font-bold text-white">JobHub</span>
                    </div>
                    <p class="text-gray-400 text-sm mb-4">Your trusted partner in career growth and talent acquisition.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-white/5 rounded-full flex items-center justify-center hover:bg-white/10 transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/5 rounded-full flex items-center justify-center hover:bg-white/10 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/5 rounded-full flex items-center justify-center hover:bg-white/10 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/5 rounded-full flex items-center justify-center hover:bg-white/10 transition-colors">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4">For Candidates</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Browse Jobs</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Create Profile</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Career Advice</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Salary Guide</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4">For Employers</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Post a Job</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Find Candidates</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Employer Resources</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4">Resources</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Community</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Events</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/5 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-500">&copy; 2024 JobHub. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-sm text-gray-500 hover:text-white transition-colors">Terms</a>
                    <a href="#" class="text-sm text-gray-500 hover:text-white transition-colors">Privacy</a>
                    <a href="#" class="text-sm text-gray-500 hover:text-white transition-colors">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button onclick="window.scrollTo({top:0,behavior:'smooth'})" class="fixed bottom-8 right-8 bg-white text-black w-12 h-12 rounded-full flex items-center justify-center hover:bg-gray-200 transition-all hover:scale-110 shadow-lg z-50">
        <i class="fas fa-arrow-up"></i>
    </button>
</body>
</html>
