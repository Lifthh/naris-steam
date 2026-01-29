<!-- resources/views/admin/settings/index.blade.php -->

@extends('layouts.app')

@section('title', 'Pengaturan - NARIS STEAM')
@section('page-title', 'Pengaturan')

@section('content')
<div class="max-w-2xl space-y-6">
    <!-- Store Info -->
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-800">Informasi Usaha</h2>
            <p class="text-sm text-gray-500">Informasi ini akan tampil di struk</p>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="store_name" class="mb-2 block text-sm font-medium text-gray-700">
                    Nama Usaha <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="store_name" 
                       name="store_name" 
                       value="{{ old('store_name', $settings['store_name']) }}"
                       class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                       required>
                @error('store_name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="store_address" class="mb-2 block text-sm font-medium text-gray-700">
                    Alamat
                </label>
                <textarea id="store_address" 
                          name="store_address" 
                          rows="2"
                          class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                          placeholder="Alamat lengkap usaha">{{ old('store_address', $settings['store_address']) }}</textarea>
                @error('store_address')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="store_phone" class="mb-2 block text-sm font-medium text-gray-700">
                        No. Telepon
                    </label>
                    <input type="text" 
                           id="store_phone" 
                           name="store_phone" 
                           value="{{ old('store_phone', $settings['store_phone']) }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                           placeholder="08123456789">
                    @error('store_phone')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="store_email" class="mb-2 block text-sm font-medium text-gray-700">
                        Email
                    </label>
                    <input type="email" 
                           id="store_email" 
                           name="store_email" 
                           value="{{ old('store_email', $settings['store_email']) }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                           placeholder="email@contoh.com">
                    @error('store_email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="receipt_footer" class="mb-2 block text-sm font-medium text-gray-700">
                    Pesan di Struk
                </label>
                <textarea id="receipt_footer" 
                          name="receipt_footer" 
                          rows="2"
                          class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                          placeholder="Pesan yang tampil di bagian bawah struk">{{ old('receipt_footer', $settings['receipt_footer']) }}</textarea>
                @error('receipt_footer')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4">
                <button type="submit" 
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-500/30 transition-all hover:from-blue-600 hover:to-blue-700">
                    <i data-lucide="save" class="h-4 w-4"></i>
                    <span>Simpan Pengaturan</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Preview -->
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
        <h3 class="mb-4 text-lg font-semibold text-gray-800">Preview Struk</h3>
        <div class="mx-auto max-w-xs rounded-lg border-2 border-dashed border-gray-200 bg-gray-50 p-4 font-mono text-xs">
            <div class="text-center">
                <p class="font-bold text-sm">{{ $settings['store_name'] }}</p>
                @if($settings['store_address'])
                    <p class="text-gray-600">{{ $settings['store_address'] }}</p>
                @endif
                @if($settings['store_phone'])
                    <p class="text-gray-600">{{ $settings['store_phone'] }}</p>
                @endif
            </div>
            <div class="my-2 border-t border-dashed border-gray-300"></div>
            <p class="text-gray-500">INV-20240115-0001</p>
            <p class="text-gray-500">15/01/2024 10:30</p>
            <p class="text-gray-500">Kasir: Admin</p>
            <div class="my-2 border-t border-dashed border-gray-300"></div>
            <p>Plat: B 1234 ABC</p>
            <p>Steam Biasa - Kecil</p>
            <p class="text-right">Rp 13.000</p>
            <div class="my-2 border-t border-dashed border-gray-300"></div>
            <p class="font-bold text-right">Total: Rp 13.000</p>
            <p class="text-right">Bayar: Rp 15.000</p>
            <p class="text-right">Kembali: Rp 2.000</p>
            <div class="my-2 border-t border-dashed border-gray-300"></div>
            <p class="text-center text-gray-600">{{ $settings['receipt_footer'] }}</p>
        </div>
    </div>
</div>
@endsection