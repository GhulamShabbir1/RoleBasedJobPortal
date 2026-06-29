<!-- Candidate Module Sidebar -->
<div class="w-64 bg-white border-r border-gray-200 min-h-screen sticky top-0 flex flex-col shadow-sm">
    <!-- Brand / Logo -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gray-900 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-graduate text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900 tracking-tight">Candidate Panel</h2>
                <p class="text-xs text-gray-500">Find your dream job</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="flex-1 p-4 overflow-y-auto">
        <div class="mb-4">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-3">Main Menu</p>
            <nav class="space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('dashboard.candidate') }}"
                   class="flex items-center px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('dashboard.candidate') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : '' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('dashboard.candidate') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200' }}">
                        <i class="fas fa-chart-line text-sm {{ request()->routeIs('dashboard.candidate') ? 'text-white' : 'text-gray-500' }}"></i>
                    </div>
                    <span class="font-medium">Dashboard</span>
                    <span class="ml-auto text-xs {{ request()->routeIs('dashboard.candidate') ? 'text-white/50' : 'text-gray-400' }}">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </a>

                <!-- Profile -->
                <a href="{{ route('candidate.profile.edit') }}"
                   class="flex items-center px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('candidate.profile.edit', 'candidate.profile.create') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : '' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('candidate.profile.edit', 'candidate.profile.create') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200' }}">
                        <i class="fas fa-user text-sm {{ request()->routeIs('candidate.profile.edit', 'candidate.profile.create') ? 'text-white' : 'text-gray-500' }}"></i>
                    </div>
                    <span class="font-medium">My Profile</span>
                    <span class="ml-auto text-xs {{ request()->routeIs('candidate.profile.edit', 'candidate.profile.create') ? 'text-white/50' : 'text-gray-400' }}">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </a>

                <!-- Browse Jobs -->
                <a href="{{ route('jobs.index') }}"
                   class="flex items-center px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('jobs.index', 'jobs.show') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : '' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('jobs.index', 'jobs.show') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200' }}">
                        <i class="fas fa-search text-sm {{ request()->routeIs('jobs.index', 'jobs.show') ? 'text-white' : 'text-gray-500' }}"></i>
                    </div>
                    <span class="font-medium">Browse Jobs</span>
                    <span class="ml-auto text-xs {{ request()->routeIs('jobs.index', 'jobs.show') ? 'text-white/50' : 'text-gray-400' }}">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </a>

                <!-- My Applications -->
                <a href="{{ route('applications.mine') }}"
                   class="flex items-center px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('applications.mine') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : '' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('applications.mine') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200' }}">
                        <i class="fas fa-file-check text-sm {{ request()->routeIs('applications.mine') ? 'text-white' : 'text-gray-500' }}"></i>
                    </div>
                    <span class="font-medium">My Applications</span>
                    <span class="ml-auto text-xs {{ request()->routeIs('applications.mine') ? 'text-white/50' : 'text-gray-400' }}">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </a>

                <!-- Saved Jobs (Additional) -->
                <a href="#"
                   class="flex items-center px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 bg-gray-100 group-hover:bg-gray-200">
                        <i class="fas fa-bookmark text-sm text-gray-500"></i>
                    </div>
                    <span class="font-medium">Saved Jobs</span>
                    <span class="ml-auto text-xs text-gray-400">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </a>
            </nav>
        </div>

        <!-- Profile Completion Section -->
        <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Profile Progress</p>
                <span class="text-xs font-bold text-gray-900" id="profileProgress">0%</span>
            </div>
            <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-gray-900 rounded-full transition-all duration-1000" id="profileProgressBar" style="width: 0%"></div>
            </div>
            <p class="text-xs text-gray-500 mt-2">
                <i class="fas fa-info-circle mr-1"></i>
                Complete your profile to get noticed
            </p>
            <a href="{{ route('candidate.profile.edit') }}" class="mt-3 text-xs text-gray-900 hover:underline font-medium block">
                Update Profile <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

    <!-- Footer / User Info -->
    <div class="p-4 border-t border-gray-200">
        <div class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 transition-all duration-200 cursor-pointer" x-data="{ userName: '', userEmail: '' }" x-init="
            const user = JSON.parse(localStorage.getItem('user') || '{}');
            userName = user.name || '{{ auth()->user()->name ?? 'Candidate' }}';
            userEmail = user.email || '{{ auth()->user()->email ?? 'candidate@jobhub.com' }}';
        ">
            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-gray-500"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate" x-text="userName"></p>
                <p class="text-xs text-gray-500 truncate" x-text="userEmail"></p>
            </div>
            <button @click="logout()" class="text-gray-400 hover:text-red-500 transition-colors" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </div>
    </div>
</div>

<script>
    // Fetch and update profile completion
    document.addEventListener('DOMContentLoaded', function() {
        async function updateProfileProgress() {
            try {
                const token = localStorage.getItem('token');
                if (!token) return;

                const response = await axios.get('/api/candidate/profiles/me');

                if (response.data.success && response.data.data) {
                    const profile = response.data.data;
                    const fields = [
                        profile.phone,
                        profile.city,
                        profile.skills,
                        profile.experience,
                        profile.education,
                        profile.resume_url
                    ];
                    const filled = fields.filter(f => f).length;
                    const percentage = Math.round((filled / fields.length) * 100);

                    document.getElementById('profileProgress').textContent = percentage + '%';
                    document.getElementById('profileProgressBar').style.width = percentage + '%';
                }
            } catch (error) {
                // Silently handle 404 - profile doesn't exist yet, show 0%
                if (error.response?.status === 404) {
                    document.getElementById('profileProgress').textContent = '0%';
                    document.getElementById('profileProgressBar').style.width = '0%';
                } else {
                    console.error('Error fetching profile:', error);
                    document.getElementById('profileProgress').textContent = '0%';
                    document.getElementById('profileProgressBar').style.width = '0%';
                }
            }
        }

        // Update immediately and every 30 seconds
        updateProfileProgress();
        setInterval(updateProfileProgress, 30000);
    });
</script>

<style>
    /* Smooth scrolling for the sidebar */
    .overflow-y-auto {
        scrollbar-width: thin;
        scrollbar-color: #d1d5db transparent;
    }

    .overflow-y-auto::-webkit-scrollbar {
        width: 4px;
    }

    .overflow-y-auto::-webkit-scrollbar-track {
        background: transparent;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb {
        background-color: #d1d5db;
        border-radius: 20px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background-color: #9ca3af;
    }

    /* Active state animation */
    .bg-gray-900 {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Hover effects for nav items */
    .group:hover .w-8.h-8 {
        transition: all 0.3s ease;
    }

    /* Progress bar animation */
    #profileProgressBar {
        transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Shimmer effect for progress */
    @keyframes progressPulse {
        0% { opacity: 1; }
        50% { opacity: 0.8; }
        100% { opacity: 1; }
    }

    #profileProgress {
        animation: progressPulse 2s ease-in-out infinite;
    }
</style>
