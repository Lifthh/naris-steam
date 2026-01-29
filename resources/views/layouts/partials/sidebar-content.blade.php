<!-- resources/views/layouts/partials/sidebar-content.blade.php -->

<div class="flex h-full flex-col">
    <!-- Logo -->
    <div class="flex h-16 items-center justify-between border-b border-gray-100 px-4">
        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('kasir.dashboard') }}" 
           class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-500/30">
                <i data-lucide="droplets" class="h-6 w-6"></i>
            </div>
            <span x-show="sidebarOpen || mobileSidebarOpen" 
                  x-transition
                  class="text-lg font-bold text-gray-800">
                NARIS STEAM
            </span>
        </a>
        
        <!-- Close button for mobile -->
        <button @click="mobileSidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700">
            <i data-lucide="x" class="h-5 w-5"></i>
        </button>
    </div>
    
    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto p-4">
        @if(auth()->user()->isAdmin())
            <!-- Admin Menu -->
            <div class="mb-6">
                <p x-show="sidebarOpen || mobileSidebarOpen" class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">
                    Menu Utama
                </p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i data-lucide="layout-dashboard" class="h-5 w-5"></i>
                            <span x-show="sidebarOpen || mobileSidebarOpen">Dashboard</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="mb-6">
                <p x-show="sidebarOpen || mobileSidebarOpen" class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">
                    Master Data
                </p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.services.index') }}" 
                           class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.services.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i data-lucide="spray-can" class="h-5 w-5"></i>
                            <span x-show="sidebarOpen || mobileSidebarOpen">Layanan Cuci</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.addons.index') }}" 
                           class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.addons.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i data-lucide="plus-circle" class="h-5 w-5"></i>
                            <span x-show="sidebarOpen || mobileSidebarOpen">Layanan Tambahan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" 
                           class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i data-lucide="users" class="h-5 w-5"></i>
                            <span x-show="sidebarOpen || mobileSidebarOpen">Petugas</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="mb-6">
                <p x-show="sidebarOpen || mobileSidebarOpen" class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">
                    Transaksi
                </p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('kasir.transactions.create') }}" 
                           class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('kasir.transactions.create') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i data-lucide="plus-square" class="h-5 w-5"></i>
                            <span x-show="sidebarOpen || mobileSidebarOpen">Transaksi Baru</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.transactions.index') }}" 
                           class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.transactions.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i data-lucide="receipt" class="h-5 w-5"></i>
                            <span x-show="sidebarOpen || mobileSidebarOpen">Riwayat Transaksi</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="mb-6">
                <p x-show="sidebarOpen || mobileSidebarOpen" class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">
                    Laporan
                </p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.reports.index') }}" 
                           class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.reports.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i data-lucide="bar-chart-3" class="h-5 w-5"></i>
                            <span x-show="sidebarOpen || mobileSidebarOpen">Laporan</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="mb-6">
                <p x-show="sidebarOpen || mobileSidebarOpen" class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">
                    Sistem
                </p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.settings.index') }}" 
                           class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i data-lucide="settings" class="h-5 w-5"></i>
                            <span x-show="sidebarOpen || mobileSidebarOpen">Pengaturan</span>
                        </a>
                    </li>
                </ul>
            </div>
        @else
            <!-- Kasir Menu -->
            <div class="mb-6">
                <p x-show="sidebarOpen || mobileSidebarOpen" class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">
                    Menu
                </p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('kasir.dashboard') }}" 
                           class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('kasir.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i data-lucide="layout-dashboard" class="h-5 w-5"></i>
                            <span x-show="sidebarOpen || mobileSidebarOpen">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kasir.transactions.create') }}" 
                           class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('kasir.transactions.create') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i data-lucide="plus-square" class="h-5 w-5"></i>
                            <span x-show="sidebarOpen || mobileSidebarOpen">Transaksi Baru</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kasir.transactions.index') }}" 
                           class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('kasir.transactions.index') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i data-lucide="history" class="h-5 w-5"></i>
                            <span x-show="sidebarOpen || mobileSidebarOpen">Riwayat Hari Ini</span>
                        </a>
                    </li>
                </ul>
            </div>
        @endif
    </nav>
    
    <!-- User Info at Bottom -->
    <div class="border-t border-gray-100 p-4">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-600">
                <i data-lucide="user" class="h-5 w-5"></i>
            </div>
            <div x-show="sidebarOpen || mobileSidebarOpen" class="flex-1 truncate">
                <p class="truncate text-sm font-medium text-gray-800">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
            </div>
        </div>
    </div>
</div>