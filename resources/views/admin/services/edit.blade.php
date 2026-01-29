<!-- resources/views/admin/services/edit.blade.php -->

@extends('layouts.app')

@section('title', 'Edit Layanan - NARIS STEAM')
@section('page-title', 'Edit Layanan')

@section('breadcrumb')
<div class="flex items-center gap-2 text-sm text-gray-500">
    <a href="{{ route('admin.services.index') }}" class="hover:text-blue-600">Layanan Cuci</a>
    <i data-lucide="chevron-right" class="h-4 w-4"></i>
    <span class="text-gray-800">Edit Layanan</span>
</div>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-800">Edit Layanan</h2>
            <p class="text-sm text-gray-500">Perbarui informasi layanan cuci</p>
        </div>

        <form action="{{ route('admin.services.update', $service) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Nama Layanan -->
            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-gray-700">
                    Nama Layanan <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $service->name) }}"
                       class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 @error('name') border-red-500 @enderror"
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori -->
            <div>
                <label for="category" class="mb-2 block text-sm font-medium text-gray-700">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select id="category" 
                        name="category" 
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                        required>
                    <option value="steam" {{ old('category', $service->category) == 'steam' ? 'selected' : '' }}>Steam Biasa</option>
                    <option value="premium" {{ old('category', $service->category) == 'premium' ? 'selected' : '' }}>Premium Wash</option>
                </select>
                @error('category')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ukuran Motor -->
            <div>
                <label for="vehicle_type" class="mb-2 block text-sm font-medium text-gray-700">
                    Ukuran Motor <span class="text-red-500">*</span>
                </label>
                <select id="vehicle_type" 
                        name="vehicle_type" 
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                        required>
                    <option value="kecil" {{ old('vehicle_type', $service->vehicle_type) == 'kecil' ? 'selected' : '' }}>Motor Kecil</option>
                    <option value="sedang" {{ old('vehicle_type', $service->vehicle_type) == 'sedang' ? 'selected' : '' }}>Motor Sedang</option>
                    <option value="besar" {{ old('vehicle_type', $service->vehicle_type) == 'besar' ? 'selected' : '' }}>Motor Besar</option>
                </select>
                @error('vehicle_type')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Harga -->
            <div>
                <label for="price" class="mb-2 block text-sm font-medium text-gray-700">
                    Harga <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500 text-sm">Rp</span>
                    <input type="number" 
                           id="price" 
                           name="price" 
                           value="{{ old('price', $service->price) }}"
                           class="w-full rounded-xl border border-gray-200 py-2.5 pl-12 pr-4 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                           min="0"
                           required>
                </div>
                @error('price')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Estimasi Waktu -->
            <div>
                <label for="estimated_time" class="mb-2 block text-sm font-medium text-gray-700">
                    Estimasi Waktu (menit)
                </label>
                <input type="number" 
                       id="estimated_time" 
                       name="estimated_time" 
                       value="{{ old('estimated_time', $service->estimated_time) }}"
                       class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                       min="1">
                @error('estimated_time')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="mb-2 block text-sm font-medium text-gray-700">
                    Deskripsi
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="3"
                          class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">{{ old('description', $service->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-3 pt-4">
                <button type="submit" 
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-500/30 transition-all hover:from-blue-600 hover:to-blue-700">
                    <i data-lucide="save" class="h-4 w-4"></i>
                    <span>Update</span>
                </button>
                <a href="{{ route('admin.services.index') }}" 
                   class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 px-5 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50">
                    <i data-lucide="x" class="h-4 w-4"></i>
                    <span>Batal</span>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection