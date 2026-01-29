<!-- resources/views/layouts/partials/sidebar.blade.php -->

<!-- Mobile Sidebar -->
<aside x-show="mobileSidebarOpen"
       x-transition:enter="transition ease-in-out duration-300 transform"
       x-transition:enter-start="-translate-x-full"
       x-transition:enter-end="translate-x-0"
       x-transition:leave="transition ease-in-out duration-300 transform"
       x-transition:leave-start="translate-x-0"
       x-transition:leave-end="-translate-x-full"
       class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-xl lg:hidden"
       x-cloak>
    @include('layouts.partials.sidebar-content')
</aside>

<!-- Desktop Sidebar -->
<aside :class="sidebarOpen ? 'w-64' : 'w-20'"
       class="fixed inset-y-0 left-0 z-30 hidden transform bg-white shadow-lg transition-all duration-300 lg:block">
    @include('layouts.partials.sidebar-content')
</aside>