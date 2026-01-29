<!-- resources/views/admin/addons/index.blade.php -->

@extends('layouts.app')

@section('title', 'Layanan Tambahan - NARIS STEAM')
@section('page-title', 'Layanan Tambahan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Daftar Layanan Tambahan</h2>
            <p class="text-sm text-gray-500">Kelola layanan tambahan (add-on)</p>
        </div>
        <a href="{{ route('admin.addons.create') }}" 
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-500/30 transition-all hover:from-blue-600 hover:to-blue-700">
            <i data-lucide="plus" class="h-4 w-4"></i>
            <span>Tambah Layanan</span>
        </a>
    </div>

    <!-- Filters -->
    <div class="rounded-2xl bg-white p-4 shadow-sm border border-gray-100">
        <form action="{{ route('admin.addons.index') }}" method="GET" class="flex flex-col gap-4 sm:flex-row">
            <div class="flex-1">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i data-lucide="search" class="h-4 w-4"></i>
                    </span>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari layanan tambahan..."
                           class="w-full rounded-xl border border-gray-200 py-2.5 pl-10 pr-4 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                </div>
            </div>
            
            <select name="status" 
                    class="rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            
            <button type="submit" 
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-gray-100 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-200">
                <i data-lucide="filter" class="h-4 w-4"></i>
                <span>Filter</span>
            </button>

            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.addons.index') }}" 
                   class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50">
                    <i data-lucide="x" class="h-4 w-4"></i>
                    <span>Reset</span>
                </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="rounded-2xl bg-white shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Nama Layanan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Deskripsi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Harga</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($addons as $addon)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                                        <i data-lucide="plus-circle" class="h-5 w-5"></i>
                                    </div>
                                    <span class="font-medium text-gray-800">{{ $addon->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-500">{{ $addon->description ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-gray-800">{{ $addon->formatted_price }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($addon->is_active)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('admin.addons.edit', $addon) }}" 
                                       class="rounded-lg p-2 text-gray-500 hover:bg-blue-50 hover:text-blue-600"
                                       title="Edit">
                                        <i data-lucide="pencil" class="h-4 w-4"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.addons.toggle-status', $addon) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="rounded-lg p-2 text-gray-500 hover:bg-orange-50 hover:text-orange-600"
                                                title="{{ $addon->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            @if($addon->is_active)
                                                <i data-lucide="toggle-right" class="h-4 w-4"></i>
                                            @else
                                                <i data-lucide="toggle-left" class="h-4 w-4"></i>
                                            @endif
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('admin.addons.destroy', $addon) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus layanan tambahan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="rounded-lg p-2 text-gray-500 hover:bg-red-50 hover:text-red-600"
                                                title="Hapus">
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i data-lucide="inbox" class="h-12 w-12 text-gray-300 mb-3"></i>
                                    <p class="text-gray-500">Belum ada layanan tambahan</p>
                                    <a href="{{ route('admin.addons.create') }}" class="mt-2 text-sm text-blue-600 hover:underline">
                                        Tambah layanan pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($addons->hasPages())
            <div class="border-t border-gray-100 px-6 py-4">
                {{ $addons->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection