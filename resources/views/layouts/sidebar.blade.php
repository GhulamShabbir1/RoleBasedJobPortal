<!-- Sidebar -->
<div x-data="sidebarState()" x-show="user" x-cloak>
    <div class="w-64 bg-white border-r border-gray-200 min-h-screen flex flex-col shadow-sm"
         x-show="sidebarOpen"
         x-transition:enter.duration.300ms.opacity.scale
         x-transition:leave.duration.200ms.opacity.scale
         :class="{'hidden': !sidebarOpen}">

        <!-- Logo & Brand -->
        <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200 flex-shrink-0">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gray-900 rounded-xl flex items-center justify-center">
                    <i class="fas fa-briefcase text-white text-lg"></i>
                </div>
                <div>
                    <span class="text-xl font-bold text-gray-900 tracking-tight">JobHub</span>
                    <span class="block text-[10px] text-gray-500 font-medium uppercase tracking-wider">Recruitment Portal</span>
                </div>
            </div>
            <button @click="sidebarOpen = false" class="md:hidden text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <!-- User Info -->
        <div class="px-4 py-4 border-b border-gray-200 flex-shrink-0">
            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors cursor-pointer">
                <div class="w-10 h-10 bg-gradient-to-br from-gray-700 to-gray-900 rounded-full flex items-center justify-center text-white font-bold text-sm">
                    <span x-text="user.name ? user.name.charAt(0).toUpperCase() : 'U'"></span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate" x-text="user.name"></p>
                    <p class="text-xs text-gray-500 truncate" x-text="user.email"></p>
                </div>
                <span class="px-2 py-0.5 bg-gray-200 text-gray-700 text-[10px] font-semibold rounded-full uppercase" x-text="user.role"></span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-4 px-3">
            <div class="space-y-1">
                <!-- Admin Menu -->
                <template x-if="user.role === 'admin'">
                    <div>
                        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Admin Panel</p>

                        <a href="{{ route('dashboard.admin') }}"
                           class="flex items-center px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('dashboard.admin') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : '' }}">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('dashboard.admin') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200' }}">
                                <i class="fas fa-chart-line text-sm {{ request()->routeIs('dashboard.admin') ? 'text-white' : 'text-gray-500' }}"></i>
                            </div>
                            <span class="font-medium">Dashboard</span>
                            @if(request()->routeIs('dashboard.admin'))
                                <span class="ml-auto text-xs text-white/50"><i class="fas fa-chevron-right"></i></span>
                            @endif
                        </a>

                        <a href="{{ route('users.manage') }}"
                           class="flex items-center px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('users.manage') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : '' }}">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('users.manage') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200' }}">
                                <i class="fas fa-users text-sm {{ request()->routeIs('users.manage') ? 'text-white' : 'text-gray-500' }}"></i>
                            </div>
                            <span class="font-medium">Users</span>
                            @if(request()->routeIs('users.manage'))
                                <span class="ml-auto text-xs text-white/50"><i class="fas fa-chevron-right"></i></span>
                            @endif
                        </a>

                        <a href="{{ route('admin.companies.index') }}"
                           class="flex items-center px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('admin.companies.index') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : '' }}">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.companies.index') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200' }}">
                                <i class="fas fa-building text-sm {{ request()->routeIs('admin.companies.index') ? 'text-white' : 'text-gray-500' }}"></i>
                            </div>
                            <span class="font-medium">Companies</span>
                            @if(request()->routeIs('admin.companies.index'))
                                <span class="ml-auto text-xs text-white/50"><i class="fas fa-chevron-right"></i></span>
                            @endif
                        </a>

                        <a href="{{ route('admin.categories.manage') }}"
                           class="flex items-center px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('admin.categories.manage') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : '' }}">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.categories.manage') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200' }}">
                                <i class="fas fa-tags text-sm {{ request()->routeIs('admin.categories.manage') ? 'text-white' : 'text-gray-500' }}"></i>
                            </div>
                            <span class="font-medium">Categories</span>
                            @if(request()->routeIs('admin.categories.manage'))
                                <span class="ml-auto text-xs text-white/50"><i class="fas fa-chevron-right"></i></span>
                            @endif
                        </a>

                        <a href="{{ route('admin.jobs.manage') }}"
                           class="flex items-center px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('admin.jobs.manage') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : '' }}">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.jobs.manage') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200' }}">
                                <i class="fas fa-briefcase text-sm {{ request()->routeIs('admin.jobs.manage') ? 'text-white' : 'text-gray-500' }}"></i>
                            </div>
                            <span class="font-medium">Jobs</span>
                            @if(request()->routeIs('admin.jobs.manage'))
                                <span class="ml-auto text-xs text-white/50"><i class="fas fa-chevron-right"></i></span>
                            @endif
                        </a>

                        <a href="{{ route('page.applications.review') }}"
                           class="flex items-center px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('page.applications.review') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : '' }}">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('page.applications.review') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200' }}">
                                <i class="fas fa-inbox text-sm {{ request()->routeIs('page.applications.review') ? 'text-white' : 'text-gray-500' }}"></i>
                            </div>
                            <span class="font-medium">Applications</span>
                            @if(request()->routeIs('page.applications.review'))
                                <span class="ml-auto text-xs text-white/50"><i class="fas fa-chevron-right"></i></span>
                            @endif
                        </a>
                    </div>
                </template>

                <!-- Employer Menu -->
                <template x-if="user.role === 'employer'">
                    <div>
                        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Employer Panel</p>

                        <a href="{{ route('dashboard.employer') }}"
                           class="flex items-center px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('dashboard.employer') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : '' }}">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('dashboard.employer') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200' }}">
                                <i class="fas fa-chart-line text-sm {{ request()->routeIs('dashboard.employer') ? 'text-white' : 'text-gray-500' }}"></i>
                            </div>
                            <span class="font-medium">Dashboard</span>
                            @if(request()->routeIs('dashboard.employer'))
                                <span class="ml-auto text-xs text-white/50"><i class="fas fa-chevron-right"></i></span>
                            @endif
                        </a>

                        <a href="{{ route('companies.create') }}"
                           class="flex items-center px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('companies.create', 'companies.edit') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : '' }}">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('companies.create', 'companies.edit') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200' }}">
                                <i class="fas fa-building text-sm {{ request()->routeIs('companies.create', 'companies.edit') ? 'text-white' : 'text-gray-500' }}"></i>
                            </div>
                            <span class="font-medium">Company Profile</span>
                            @if(request()->routeIs('companies.create', 'companies.edit'))
                                <span class="ml-auto text-xs text-white/50"><i class="fas fa-chevron-right"></i></span>
                            @endif
                        </a>

                        <a href="{{ route('employer.jobs') }}"
                           class="flex items-center px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('employer.jobs') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : '' }}">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('employer.jobs') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200' }}">
                                <i class="fas fa-briefcase text-sm {{ request()->routeIs('employer.jobs') ? 'text-white' : 'text-gray-500' }}"></i>
                            </div>
                            <span class="font-medium">My Jobs</span>
                            @if(request()->routeIs('employer.jobs'))
                                <span class="ml-auto text-xs text-white/50"><i class="fas fa-chevron-right"></i></span>
                            @endif
                        </a>

                        <a href="{{ route('jobs.create') }}"
                           class="flex items-center px-4 py-2.5 rounded-xl bg-gray-900 text-white hover:bg-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl group">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 bg-white/10">
                                <i class="fas fa-plus-circle text-sm text-white"></i>
                            </div>
                            <span class="font-medium">Post a Job</span>
                            <span class="ml-auto text-xs text-white/50"><i class="fas fa-chevron-right"></i></span>
                        </a>

                        <a href="{{ route('page.applications.review') }}"
                           class="flex items-center px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('page.applications.review') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : '' }}">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('page.applications.review') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200' }}">
                                <i class="fas fa-inbox text-sm {{ request()->routeIs('page.applications.review') ? 'text-white' : 'text-gray-500' }}"></i>
                            </div>
                            <span class="font-medium">Applications</span>
                            @if(request()->routeIs('page.applications.review'))
                                <span class="ml-auto text-xs text-white/50"><i class="fas fa-chevron-right"></i></span>
                            @endif
                        </a>
                    </div>
                </template>

                <!-- Candidate Menu -->
                <template x-if="user.role === 'candidate'">
                    <div>
                        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Candidate Panel</p>

                        <a href="{{ route('dashboard.candidate') }}"
                           class="flex items-center px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('dashboard.candidate') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : '' }}">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('dashboard.candidate') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200' }}">
                                <i class="fas fa-chart-line text-sm {{ request()->routeIs('dashboard.candidate') ? 'text-white' : 'text-gray-500' }}"></i>
                            </div>
                            <span class="font-medium">Dashboard</span>
                            @if(request()->routeIs('dashboard.candidate'))
                                <span class="ml-auto text-xs text-white/50"><i class="fas fa-chevron-right"></i></span>
                            @endif
                        </a>

                        <a href="{{ route('candidate.profile.create') }}"
                           class="flex items-center px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('candidate.profile.create', 'candidate.profile.edit') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : '' }}">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('candidate.profile.create', 'candidate.profile.edit') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200' }}">
                                <i class="fas fa-user text-sm {{ request()->routeIs('candidate.profile.create', 'candidate.profile.edit') ? 'text-white' : 'text-gray-500' }}"></i>
                            </div>
                            <span class="font-medium">My Profile</span>
                            @if(request()->routeIs('candidate.profile.create', 'candidate.profile.edit'))
                                <span class="ml-auto text-xs text-white/50"><i class="fas fa-chevron-right"></i></span>
                            @endif
                        </a>

                        <a href="{{ route('jobs.index') }}"
                           class="flex items-center px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('jobs.index') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : '' }}">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('jobs.index') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200' }}">
                                <i class="fas fa-search text-sm {{ request()->routeIs('jobs.index') ? 'text-white' : 'text-gray-500' }}"></i>
                            </div>
                            <span class="font-medium">Browse Jobs</span>
                            @if(request()->routeIs('jobs.index'))
                                <span class="ml-auto text-xs text-white/50"><i class="fas fa-chevron-right"></i></span>
                            @endif
                        </a>

                        <a href="{{ route('applications.mine') }}"
                           class="flex items-center px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('applications.mine') ? 'bg-gray-900 text-white shadow-lg hover:bg-gray-800' : '' }}">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('applications.mine') ? 'bg-white/10' : 'bg-gray-100 group-hover:bg-gray-200' }}">
                                <i class="fas fa-file-check text-sm {{ request()->routeIs('applications.mine') ? 'text-white' : 'text-gray-500' }}"></i>
                            </div>
                            <span class="font-medium">My Applications</span>
                            @if(request()->routeIs('applications.mine'))
                                <span class="ml-auto text-xs text-white/50"><i class="fas fa-chevron-right"></i></span>
                            @endif
                        </a>

                        <!-- Profile Completion -->
                        <div class="mt-6 px-3">
                            <div class="p-3 bg-gray-50 rounded-xl border border-gray-200">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs font-medium text-gray-600">Profile Progress</span>
                                    <span class="text-xs font-bold text-gray-900" id="profileProgress">0%</span>
                                </div>
                                <div class="w-full h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-gray-900 rounded-full transition-all duration-1000" id="profileProgressBar" style="width: 0%"></div>
                                </div>
                                <p class="text-[10px] text-gray-500 mt-1">Complete your profile to get noticed</p>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Divider -->
                <div class="my-4 border-t border-gray-200"></div>

                <!-- Common Links -->
                <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Settings</p>

                <a href="{{ route('profile') }}"
                   class="flex items-center px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 bg-gray-100 group-hover:bg-gray-200">
                        <i class="fas fa-cog text-sm text-gray-500"></i>
                    </div>
                    <span class="font-medium">Settings</span>
                </a>

                <button @click="logout()"
                        class="w-full flex items-center px-4 py-2.5 rounded-xl text-red-600 hover:bg-red-50 transition-all duration-200 group">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 bg-red-50 group-hover:bg-red-100">
                        <i class="fas fa-sign-out-alt text-sm text-red-500"></i>
                    </div>
                    <span class="font-medium">Logout</span>
                </button>
            </div>
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-gray-200 flex-shrink-0">
            <div class="text-center">
                <p class="text-[10px] text-gray-400 uppercase tracking-wider">JobHub v2.0</p>
                <p class="text-[10px] text-gray-400">© {{ date('Y') }} All rights reserved</p>
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm md:hidden z-30"
         x-show="sidebarOpen"
         @click="sidebarOpen = false"
         x-transition:enter.duration.300.opacity
         x-transition:leave.duration.200.opacity>
    </div>
</div>

<script>
function sidebarState() {
    return {
        user: null,
        init() {
            // Load user from localStorage
            const userStr = localStorage.getItem('user');
            if (userStr) {
                try {
                    this.user = JSON.parse(userStr);
                } catch (e) {
                    this.user = null;
                }
            }
        }
    };
}
</script>
