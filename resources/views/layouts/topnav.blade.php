<!-- Top Navigation -->
<div class="bg-white border-b border-gray-200 sticky top-0 z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Left: Menu Toggle & Brand -->
            <div class="flex items-center gap-4">
                <!-- Mobile Menu Toggle -->
                <button @click="sidebarOpen = !sidebarOpen"
                        class="md:hidden text-gray-500 hover:text-gray-700 transition-colors p-2 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Desktop Menu Toggle -->
                <button @click="sidebarOpen = !sidebarOpen"
                        class="hidden md:flex text-gray-500 hover:text-gray-700 transition-colors p-2 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-bars text-lg"></i>
                </button>

                <!-- Search Bar (Desktop) -->
                <div class="hidden md:flex items-center relative ml-4">
                    <i class="fas fa-search absolute left-3 text-gray-400 text-sm"></i>
                    <input type="text"
                           placeholder="Search..."
                           class="pl-9 pr-4 py-1.5 w-64 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200">
                </div>
            </div>

            <!-- Right: User Menu -->
            <div class="flex items-center gap-2 sm:gap-4">
                @if(auth()->check())
                    <!-- Search Button (Mobile) -->
                    <button class="md:hidden text-gray-500 hover:text-gray-700 transition-colors p-2 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-search text-lg"></i>
                    </button>

                    <!-- Notifications -->
                    <div x-data="{ open: false, notifications: [] }" class="relative">
                        <button @click="open = !open"
                                class="relative text-gray-500 hover:text-gray-700 transition-colors p-2 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-bell text-lg"></i>
                            <span x-show="notifications.length > 0"
                                  class="absolute top-1 right-1 h-2.5 w-2.5 bg-red-500 rounded-full badge-pulse"></span>
                        </button>

                        <!-- Notification Dropdown -->
                        <div x-show="open"
                             @click.away="open = false"
                             class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-xl shadow-2xl border border-gray-200 z-50 overflow-hidden"
                             x-transition:enter.duration.300.opacity.scale
                             x-transition:leave.duration.200.opacity.scale>

                            <!-- Header -->
                            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200">
                                <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                                <button class="text-xs text-gray-500 hover:text-gray-700 transition-colors">Mark all read</button>
                            </div>

                            <!-- Notifications List -->
                            <div class="max-h-64 overflow-y-auto">
                                <template x-for="notification in notifications" :key="notification.id">
                                    <div class="px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-100 last:border-0">
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                                                 :class="notification.type === 'success' ? 'bg-green-100 text-green-600' :
                                                         notification.type === 'warning' ? 'bg-yellow-100 text-yellow-600' :
                                                         notification.type === 'error' ? 'bg-red-100 text-red-600' :
                                                         'bg-blue-100 text-blue-600'">
                                                <i class="fas text-xs" :class="notification.icon || 'fa-bell'"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm text-gray-900" x-text="notification.title"></p>
                                                <p class="text-xs text-gray-500" x-text="notification.message"></p>
                                                <p class="text-xs text-gray-400 mt-1" x-text="notification.time"></p>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- Empty State -->
                                <div x-show="notifications.length === 0" class="px-4 py-8 text-center">
                                    <i class="fas fa-bell-slash text-3xl text-gray-300 mb-2"></i>
                                    <p class="text-sm text-gray-500">No new notifications</p>
                                    <p class="text-xs text-gray-400 mt-1">You're all caught up!</p>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="px-4 py-2 border-t border-gray-200 text-center">
                                <a href="#" class="text-xs text-gray-500 hover:text-gray-700 transition-colors">View all notifications</a>
                            </div>
                        </div>
                    </div>

                    <!-- User Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                                class="flex items-center gap-2 text-gray-700 hover:text-gray-900 transition-colors p-1 hover:bg-gray-100 rounded-lg group">
                            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=1a1a1a&color=fff&size=32"
                                 alt="User"
                                 class="w-8 h-8 rounded-full ring-2 ring-gray-200 group-hover:ring-gray-300 transition-all">
                            <span class="hidden sm:inline text-sm font-medium">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-400 group-hover:text-gray-600 transition-colors"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open"
                             @click.away="open = false"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-200 z-50 overflow-hidden"
                             x-transition:enter.duration.300.opacity.scale
                             x-transition:leave.duration.200.opacity.scale>

                            <!-- User Info -->
                            <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=1a1a1a&color=fff&size=40"
                                         alt="User"
                                         class="w-10 h-10 rounded-full">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                        <span class="inline-block mt-1 px-2 py-0.5 bg-gray-200 text-gray-700 text-[10px] font-semibold rounded-full uppercase">
                                            {{ ucfirst(auth()->user()->role) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Menu Items -->
                            <div class="py-1">
                                <a href="{{ route('profile') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-user mr-3 text-gray-400 w-4"></i>
                                    My Profile
                                </a>
                                <a href="{{ route('settings') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-cog mr-3 text-gray-400 w-4"></i>
                                    Settings
                                </a>
                                <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-question-circle mr-3 text-gray-400 w-4"></i>
                                    Help & Support
                                </a>
                            </div>

                            <hr class="my-1">

                            <!-- Logout -->
                            <div class="py-1">
                                <button @click="logout()" class="w-full flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="fas fa-sign-out-alt mr-3 text-red-400 w-4"></i>
                                    Logout
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Guest Links -->
                    <div class="flex items-center gap-3">
                        <a href="{{ route('auth.login') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium transition-colors px-3 py-2 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                        <a href="{{ route('auth.signup') }}" class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:shadow-lg hover:scale-105">
                            <i class="fas fa-user-plus mr-2"></i>Sign Up
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Mobile Search Bar -->
    <div x-data="{ open: false }" class="md:hidden px-4 pb-3" x-show="open" x-transition>
        <div class="relative">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text"
                   placeholder="Search jobs, companies..."
                   class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200">
        </div>
    </div>
</div>

<style>
    /* Badge Pulse Animation */
    .badge-pulse {
        animation: badgePulse 2s ease-in-out infinite;
    }
    @keyframes badgePulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.3); }
    }

    /* Dropdown Animations */
    .opacity.scale {
        transform-origin: top right;
    }

    /* Mobile Search Toggle */
    .search-toggle {
        transition: all 0.3s ease;
    }
</style>

<script>
    // Add sample notifications for demo
    document.addEventListener('alpine:init', () => {
        Alpine.data('topNav', () => ({
            notifications: [
                {
                    id: 1,
                    type: 'success',
                    icon: 'fa-check-circle',
                    title: 'Application Accepted!',
                    message: 'Your application for Senior Developer has been accepted.',
                    time: '2 hours ago'
                },
                {
                    id: 2,
                    type: 'warning',
                    icon: 'fa-clock',
                    title: 'Application Under Review',
                    message: 'Your application for UX Designer is being reviewed.',
                    time: '5 hours ago'
                },
                {
                    id: 3,
                    type: 'info',
                    icon: 'fa-info-circle',
                    title: 'New Job Alert',
                    message: 'Google has posted a new job: Product Manager.',
                    time: '1 day ago'
                }
            ]
        }));
    });
</script>
