<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NARIS STEAM')</title>
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Print Styles */
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div x-data="{ sidebarOpen: true, mobileSidebarOpen: false }" class="min-h-screen">
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="mobileSidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 lg:hidden"
             @click="mobileSidebarOpen = false"
             x-cloak>
        </div>
        
        <!-- Sidebar -->
        @include('layouts.partials.sidebar')
        
        <!-- Main Content -->
        <div :class="sidebarOpen ? 'lg:pl-64' : 'lg:pl-20'" class="transition-all duration-300">
            <!-- Top Header -->
            @include('layouts.partials.header')
            
            <!-- Page Content -->
            <main class="p-4 lg:p-6">
                <!-- Breadcrumb -->
                @hasSection('breadcrumb')
                    <nav class="mb-4">
                        @yield('breadcrumb')
                    </nav>
                @endif
                
                <!-- Flash Messages -->
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                         class="mb-4 flex items-center gap-3 rounded-lg bg-green-50 border border-green-200 p-4 text-green-800">
                        <i data-lucide="check-circle" class="h-5 w-5"></i>
                        <span>{{ session('success') }}</span>
                        <button @click="show = false" class="ml-auto">
                            <i data-lucide="x" class="h-4 w-4"></i>
                        </button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                         class="mb-4 flex items-center gap-3 rounded-lg bg-red-50 border border-red-200 p-4 text-red-800">
                        <i data-lucide="alert-circle" class="h-5 w-5"></i>
                        <span>{{ session('error') }}</span>
                        <button @click="show = false" class="ml-auto">
                            <i data-lucide="x" class="h-4 w-4"></i>
                        </button>
                    </div>
                @endif
                
                <!-- Main Content -->
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Initialize Lucide Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
        
        // Re-initialize icons after Alpine updates
        document.addEventListener('alpine:initialized', () => {
            lucide.createIcons();
        });
    </script>
    
    @stack('scripts')
</body>
</html>