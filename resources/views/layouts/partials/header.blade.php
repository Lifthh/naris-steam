<!-- resources/views/layouts/partials/header.blade.php -->

<header class="sticky top-0 z-20 flex h-16 items-center justify-between border-b border-gray-100 bg-white px-4 lg:px-6">
    <div class="flex items-center gap-4">
        <!-- Toggle Sidebar Desktop -->
        <button @click="sidebarOpen = !sidebarOpen" class="hidden rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 lg:block">
            <i data-lucide="panel-left-close" x-show="sidebarOpen" class="h-5 w-5"></i>
            <i data-lucide="panel-left-open" x-show="!sidebarOpen" class="h-5 w-5" x-cloak></i>
        </button>
        
        <!-- Toggle Sidebar Mobile -->
        <button @click="mobileSidebarOpen = true" class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 lg:hidden">
            <i data-lucide="menu" class="h-5 w-5"></i>
        </button>
        
        <!-- Page Title -->
        <div>
            <h1 class="text-lg font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
        </div>
    </div>
    
    <div class="flex items-center gap-3">
        <!-- Current Date Time -->
        <div class="hidden items-center gap-2 rounded-lg bg-gray-50 px-3 py-2 text-sm text-gray-600 md:flex">
            <i data-lucide="calendar" class="h-4 w-4"></i>
            <span id="current-datetime">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
        </div>
        
        <!-- User Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                    <i data-lucide="user" class="h-4 w-4"></i>
                </div>
                <span class="hidden md:block">{{ auth()->user()->name }}</span>
                <i data-lucide="chevron-down" class="h-4 w-4"></i>
            </button>
            
            <div x-show="open" 
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-48 origin-top-right rounded-xl bg-white py-2 shadow-lg ring-1 ring-black ring-opacity-5"
                 x-cloak>
                
                <div class="border-b border-gray-100 px-4 py-2">
                    <p class="text-sm font-medium text-gray-800">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                        <i data-lucide="log-out" class="h-4 w-4"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>