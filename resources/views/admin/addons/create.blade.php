<!-- resources/views/admin/addons/create.blade.php -->

@extends('layouts.app')

@section('title', 'Tambah Layanan Tambahan - NARIS STEAM')
@section('page-title', 'Tambah Layanan Tambahan')

@section('breadcrumb')
<div class="flex items-center gap-2 text-sm text-gray-500">
    <a href="{{ route('admin.addons.index') }}" class="hover:text-blue-600">Layanan Tambahan</a>
    <i data-lucide="chevron-right" class="h-4 w-4"></i>
    <span class="text-gray-800">Tambah</span>
</div>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-800">Tambah Layanan Tambahan</h2>
            <p class="text-sm text-gray-500">Isi form di bawah untuk menambah layanan tambahan</p>
        </div>

        <form action="{{ route('admin.addons.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-gray-700">
                    Nama Layanan <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 @error('name') border-red-500 @enderror"
                       placeholder="Contoh: Semir Ban"
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price" class="mb-2 block text-sm font-medium text-gray-700">
                    Harga <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500 text-sm">Rp</span>
                    <input type="number" 
                           id="price" 
                           name="price" 
                           value="{{ old('price') }}"
                           class="w-full rounded-xl border border-gray-200 py-2.5 pl-12 pr-4 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 @error('price') border-red-500 @enderror"
                           placeholder="5000"
                           min="0"
                           required>
                </div>
                @error('price')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="mb-2 block text-sm font-medium text-gray-700">
                    Deskripsi
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="3"
                          class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                          placeholder="Deskripsi layanan (opsional)">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button type="submit" 
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-500/30 transition-all hover:from-blue-600 hover:to-blue-700">
                    <i data-lucide="save" class="h-4 w-4"></i>
                    <span>Simpan</span>
                </button>
                <a href="{{ route('admin.addons.index') }}" 
                   class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 px-5 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50">
                    <i data-lucide="x" class="h-4 w-4"></i>
                    <span>Batal</span>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection