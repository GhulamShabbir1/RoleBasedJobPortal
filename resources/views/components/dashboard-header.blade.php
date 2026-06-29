<!-- Dashboard Header with Back Button -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div class="flex items-center space-x-4">
        <!-- Back Button -->
        <button onclick="history.back()"
                class="group flex items-center px-4 py-2.5 border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 hover:shadow-md">
            <i class="fas fa-arrow-left mr-2 text-gray-400 group-hover:text-gray-600 transition-colors"></i>
            <span class="text-sm font-medium">Back</span>
        </button>

        <!-- Title Section -->
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">
                {{ $title }}
            </h1>
            @if(isset($subtitle))
                <p class="text-sm text-gray-500 mt-0.5 flex items-center gap-2">
                    <i class="fas fa-circle text-[6px] text-gray-300"></i>
                    {{ $subtitle }}
                </p>
            @endif
        </div>
    </div>

    <!-- Header Action / Right Section -->
    <div class="flex items-center gap-3">
        <!-- Optional Breadcrumb -->
        @if(isset($breadcrumb))
            <div class="hidden md:flex items-center text-sm text-gray-500">
                @foreach($breadcrumb as $item)
                    @if(!$loop->last)
                        <a href="{{ $item['url'] ?? '#' }}" class="hover:text-gray-700 transition-colors">{{ $item['label'] }}</a>
                        <i class="fas fa-chevron-right mx-2 text-xs text-gray-300"></i>
                    @else
                        <span class="text-gray-900 font-medium">{{ $item['label'] }}</span>
                    @endif
                @endforeach
            </div>
        @endif

        <!-- Action Button -->
        @if(isset($headerAction))
            <div class="flex items-center gap-2">
                {{ $headerAction }}
            </div>
        @endif

        <!-- Refresh Button -->
        @if(isset($showRefresh) && $showRefresh)
            <button onclick="window.location.reload()"
                    class="p-2.5 border border-gray-200 rounded-xl text-gray-500 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 hover:shadow-md"
                    title="Refresh page">
                <i class="fas fa-sync-alt text-sm"></i>
            </button>
        @endif
    </div>
</div>

<!-- Optional: Stats or Filter Bar -->
@if(isset($showStats) && $showStats)
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider">Total</p>
                <p class="text-2xl font-bold text-gray-900">{{ $statsTotal ?? '0' }}</p>
            </div>
            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                <i class="fas fa-chart-bar text-gray-500"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider">Pending</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $statsPending ?? '0' }}</p>
            </div>
            <div class="w-10 h-10 bg-yellow-50 rounded-full flex items-center justify-center">
                <i class="fas fa-clock text-yellow-600"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider">Active</p>
                <p class="text-2xl font-bold text-green-600">{{ $statsActive ?? '0' }}</p>
            </div>
            <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider">Completed</p>
                <p class="text-2xl font-bold text-blue-600">{{ $statsCompleted ?? '0' }}</p>
            </div>
            <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center">
                <i class="fas fa-check-double text-blue-600"></i>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Optional: Search & Filter Bar -->
@if(isset($showFilters) && $showFilters)
<div class="bg-white rounded-xl border border-gray-200 p-4 mb-8">
    <div class="flex flex-col sm:flex-row gap-4">
        <div class="flex-1 relative">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input
                type="text"
                placeholder="{{ $searchPlaceholder ?? 'Search...' }}"
                class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200"
                id="searchInput"
                oninput="window.filterItems?.(this.value)"
            >
        </div>
        <div class="flex gap-2">
            <select class="px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 bg-white" id="filterSelect">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
            </select>
            <button onclick="document.getElementById('searchInput').value = ''; document.getElementById('filterSelect').value = ''; window.filterItems?.('')"
                    class="px-4 py-2 text-gray-600 hover:text-gray-900 transition-colors">
                <i class="fas fa-times mr-1"></i>Clear
            </button>
        </div>
    </div>
</div>
@endif

<style>
    /* Smooth transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }

    /* Back button hover */
    .group:hover i {
        transform: translateX(-2px);
        transition: transform 0.2s ease;
    }

    /* Stats card hover */
    .hover\:shadow-md:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .flex-col {
            flex-direction: column;
        }
    }
</style>

<script>
    // Optional: Filter functionality
    window.filterItems = function(searchTerm) {
        // This function can be overridden in child components
        console.log('Searching for:', searchTerm);

        // Custom event for components to listen to
        const event = new CustomEvent('filter-items', {
            detail: { search: searchTerm }
        });
        document.dispatchEvent(event);
    };

    // Listen for filter changes
    document.addEventListener('DOMContentLoaded', function() {
        const filterSelect = document.getElementById('filterSelect');
        if (filterSelect) {
            filterSelect.addEventListener('change', function() {
                const event = new CustomEvent('filter-items', {
                    detail: {
                        search: document.getElementById('searchInput')?.value || '',
                        status: this.value
                    }
                });
                document.dispatchEvent(event);
            });
        }
    });
</script>
