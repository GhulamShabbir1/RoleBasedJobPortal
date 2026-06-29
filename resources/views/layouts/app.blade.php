<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'JobHub - Recruitment Portal')</title>

    <!-- Tailwind CSS (Development) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        /* Base Styles */
        [x-cloak] { display: none !important; }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        /* Animations */
        .fade-enter { animation: fadeIn 0.3s ease-in; }
        .fade-enter-active { animation: fadeIn 0.4s ease-in; }
        .fade-leave-active { animation: fadeOut 0.3s ease-out; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(10px); }
        }

        @keyframes slideIn {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .slide-in { animation: slideIn 0.4s ease-out; }
        .pulse-animation { animation: pulse 2s ease-in-out infinite; }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Custom Utilities */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 200ms;
        }

        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        /* Notification Badge Pulse */
        .badge-pulse {
            animation: pulse 2s ease-in-out infinite;
        }

        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .glass-dark {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Loading Spinner */
        .spinner {
            border: 3px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top: 3px solid #1a1a1a;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Toast Notifications */
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
            animation: slideIn 0.4s ease-out;
        }

        /* Dark Mode Toggle */
        .theme-toggle {
            transition: all 0.3s ease;
        }
        .theme-toggle:hover {
            transform: rotate(30deg);
        }

        /* Mobile Menu Overlay */
        .mobile-overlay {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        /* Smooth Loader */
        .loader-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #1a1a1a, #4a4a4a, #1a1a1a);
            background-size: 200% 100%;
            animation: loading 1.5s ease-in-out infinite;
            z-index: 99999;
            transition: width 0.3s ease;
        }
        @keyframes loading {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        /* Card Styles */
        .card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
            border-color: #d1d5db;
        }

        /* Button Styles */
        .btn-primary {
            background: #1a1a1a;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: #2d2d2d;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .btn-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #1a1a1a;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
        }

        /* Input Styles */
        .input-field {
            width: 100%;
            padding: 10px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            transition: all 0.3s ease;
            outline: none;
        }
        .input-field:focus {
            border-color: #1a1a1a;
            box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.1);
        }
        .input-field:disabled {
            background: #f9fafb;
            cursor: not-allowed;
        }

        /* Badge Styles */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-info { background: #dbeafe; color: #1e40af; }
        .badge-gray { background: #f3f4f6; color: #374151; }
    </style>

    @yield('extra_css')
</head>
<body class="bg-gray-50 antialiased" x-data="appState()" x-cloak>

    <!-- Global Loading Bar -->
    <div x-show="loading" class="loader-bar" style="width: 100%;"></div>

    @if(request()->is('auth/*') || request()->is('reset-password') || request()->is('password/*'))
        <!-- Auth Layout -->
        <div class="min-h-screen bg-white">
            @yield('content')
        </div>
    @else
        <!-- Main Layout -->
        <div class="flex h-screen bg-gray-50 overflow-hidden">
            <!-- Mobile Overlay -->
            <div x-show="mobileOpen" @click="mobileOpen = false" class="fixed inset-0 z-30 md:hidden mobile-overlay" x-transition></div>

            <!-- Sidebar -->
            <div class="hidden md:block">
                @include('layouts.sidebar')
            </div>

            <!-- Mobile Sidebar -->
            <div x-show="mobileOpen" class="fixed inset-y-0 left-0 z-40 md:hidden w-64 bg-white shadow-2xl" x-transition>
                @include('layouts.sidebar')
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Nav -->
                @include('layouts.topnav')

                <!-- Content -->
                <main class="flex-1 overflow-y-auto bg-gray-50">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 py-6">
                        <!-- Flash Messages -->
                        @if(session('success'))
                            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 flex items-start slide-in" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                                <i class="fas fa-check-circle mr-3 mt-0.5 text-green-500"></i>
                                <div class="flex-1">
                                    <p class="font-medium">Success!</p>
                                    <p class="text-sm">{{ session('success') }}</p>
                                </div>
                                <button @click="show = false" class="text-green-500 hover:text-green-700 transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 flex items-start slide-in" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                                <i class="fas fa-exclamation-circle mr-3 mt-0.5 text-red-500"></i>
                                <div class="flex-1">
                                    <p class="font-medium">Error!</p>
                                    <p class="text-sm">{{ session('error') }}</p>
                                </div>
                                <button @click="show = false" class="text-red-500 hover:text-red-700 transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endif

                        @if(session('info'))
                            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-xl text-blue-700 flex items-start slide-in" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                                <i class="fas fa-info-circle mr-3 mt-0.5 text-blue-500"></i>
                                <div class="flex-1">
                                    <p class="font-medium">Info</p>
                                    <p class="text-sm">{{ session('info') }}</p>
                                </div>
                                <button @click="show = false" class="text-blue-500 hover:text-blue-700 transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </main>

                <!-- Footer -->
                <footer class="bg-white border-t border-gray-200 py-4 px-6">
                    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2 text-sm text-gray-500">
                        <p>&copy; {{ date('Y') }} JobHub. All rights reserved.</p>
                        <div class="flex items-center gap-4">
                            <a href="#" class="hover:text-gray-900 transition-colors">Privacy Policy</a>
                            <a href="#" class="hover:text-gray-900 transition-colors">Terms of Service</a>
                            <a href="#" class="hover:text-gray-900 transition-colors">Help</a>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    @endif

    <!-- Toast Container -->
    <div class="toast" x-data="{ toasts: [] }" x-show="toasts.length > 0" x-transition>
        <template x-for="(toast, index) in toasts" :key="index">
            <div class="mb-3 p-4 bg-white rounded-xl shadow-lg border border-gray-200 flex items-start slide-in"
                 :class="{
                     'border-green-200 bg-green-50': toast.type === 'success',
                     'border-red-200 bg-red-50': toast.type === 'error',
                     'border-blue-200 bg-blue-50': toast.type === 'info'
                 }">
                <i class="fas mr-3 mt-0.5"
                   :class="{
                       'fa-check-circle text-green-500': toast.type === 'success',
                       'fa-exclamation-circle text-red-500': toast.type === 'error',
                       'fa-info-circle text-blue-500': toast.type === 'info'
                   }"></i>
                <div class="flex-1">
                    <p class="font-medium text-gray-900" x-text="toast.title"></p>
                    <p class="text-sm text-gray-600" x-text="toast.message"></p>
                </div>
                <button @click="toasts.splice(index, 1)" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </template>
    </div>

    <script>
        function appState() {
            return {
                user: @json(auth()->user()),
                sidebarOpen: true,
                mobileOpen: false,
                loading: false,
                toasts: [],

                init() {
                    // Initialize theme from localStorage
                    const theme = localStorage.getItem('theme') || 'light';
                    if (theme === 'dark') {
                        document.documentElement.classList.add('dark');
                    }

                    // Auto-hide flash messages
                    document.querySelectorAll('.slide-in').forEach(el => {
                        setTimeout(() => {
                            el.style.opacity = '0';
                            setTimeout(() => el.remove(), 300);
                        }, 5000);
                    });

                    // Add resize listener for sidebar
                    window.addEventListener('resize', () => {
                        if (window.innerWidth >= 768) {
                            this.mobileOpen = false;
                        }
                    });
                },

                toggleTheme() {
                    const isDark = document.documentElement.classList.toggle('dark');
                    localStorage.setItem('theme', isDark ? 'dark' : 'light');
                },

                toggleSidebar() {
                    if (window.innerWidth < 768) {
                        this.mobileOpen = !this.mobileOpen;
                    } else {
                        this.sidebarOpen = !this.sidebarOpen;
                        // Dispatch event for sidebar to listen
                        window.dispatchEvent(new CustomEvent('sidebar-toggle', {
                            detail: { open: this.sidebarOpen }
                        }));
                    }
                },

                showToast(type, title, message) {
                    this.toasts.unshift({ type, title, message });
                    setTimeout(() => {
                        this.toasts.pop();
                    }, 5000);
                },

                async fetchApi(method, endpoint, data = null) {
                    try {
                        this.loading = true;
                        const config = {
                            method,
                            url: `/api${endpoint}`,
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        };

                        const token = localStorage.getItem('token');
                        if (token) {
                            config.headers['Authorization'] = `Bearer ${token}`;
                        }

                        if (data) config.data = data;

                        const response = await axios(config);
                        return response.data;
                    } catch (error) {
                        if (error.response?.status === 401) {
                            localStorage.removeItem('token');
                            localStorage.removeItem('user');
                            this.showToast('error', 'Session Expired', 'Please login again.');
                            setTimeout(() => {
                                window.location.href = '/auth/login';
                            }, 1500);
                        }
                        throw error;
                    } finally {
                        this.loading = false;
                    }
                },

logout() {
                    // legacy UI logout (not API)
                    if (confirm('Are you sure you want to logout?')) {
                        localStorage.removeItem('token');
                        localStorage.removeItem('user');
                        this.showToast('success', 'Logged Out', 'You have been successfully logged out.');
                        setTimeout(() => {
                            window.location.href = '/auth/login';
                        }, 1000);
                    }
                }
            }
        }

        // Set JWT token in localStorage from cookie if available
        document.addEventListener('DOMContentLoaded', function() {
            const user = @json(auth()->user());
            if (user && !localStorage.getItem('user')) {
                localStorage.setItem('user', JSON.stringify(user));
            }
        });

        // Axios request interceptor: don't send auth headers for public endpoints
        axios.interceptors.request.use(
            config => {
                console.log('Request:', config.url);
                // Check if endpoint is public (jobs, categories, candidate-profiles, auth/login, auth/register, auth/forgot-password)
                const isPublicEndpoint = config.url.startsWith('/api/jobs') ||
                                      config.url.startsWith('/api/categories') ||
                                      config.url.startsWith('/api/candidate-profiles') ||
                                      config.url.startsWith('/api/auth/login') ||
                                      config.url.startsWith('/api/auth/register') ||
                                      config.url.startsWith('/api/auth/forgot-password');

                console.log('Is public endpoint?', isPublicEndpoint);

                if (isPublicEndpoint) {
                    delete config.headers['Authorization'];
                    console.log('Removed authorization header');
                } else {
                    const token = localStorage.getItem('token');
                    console.log('Token exists:', !!token);
                    if (token) {
                        config.headers['Authorization'] = `Bearer ${token}`;
                        console.log('Added authorization header');
                    }
                }
                return config;
            },
            error => Promise.reject(error)
        );

        // Axios response interceptor
        axios.interceptors.response.use(
            response => response,
            error => {
                console.log('Response error FULL DETAILS:', error.response?.data);
                if (error.response?.status === 401) {
                    const originalRequest = error.config;

                    // Check if endpoint is public
                    const isPublicEndpoint = originalRequest.url.startsWith('/api/jobs') ||
                                          originalRequest.url.startsWith('/api/categories') ||
                                          originalRequest.url.startsWith('/api/candidate-profiles');

                    if (isPublicEndpoint) {
                        // Don't do anything for public endpoints - just reject
                        console.log('Public endpoint 401, ignoring');
                        return Promise.reject(error);
                    }

                    // For protected endpoints:
                    if (!originalRequest._retry) {
                        originalRequest._retry = true;
                        const token = localStorage.getItem('token');

                        // Try to refresh token
                        console.log('Trying to refresh token...');
                        return axios.post('/api/auth/refresh', {}, {
                            headers: { Authorization: token ? `Bearer ${token}` : undefined }
                        })
                            .then(response => {
                                console.log('Token refresh response:', response.data);
                                if (response.data.success) {
                                    localStorage.setItem('token', response.data.data.token);
                                    originalRequest.headers['Authorization'] = `Bearer ${response.data.data.token}`;
                                    return axios(originalRequest);
                                }
                            })
                            .catch(err => {
                                console.error('Token refresh failed:', err);
                                localStorage.removeItem('token');
                                localStorage.removeItem('user');
                                // Only redirect if not already on login page
                                if (!window.location.pathname.startsWith('/auth/login')) {
                                    window.location.href = '/auth/login';
                                }
                            });
                    }
                }
                return Promise.reject(error);
            }
        );
    </script>

    @yield('extra_js')
</body>
</html>
