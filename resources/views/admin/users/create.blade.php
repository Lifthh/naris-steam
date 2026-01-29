<!-- resources/views/admin/users/create.blade.php -->

@extends('layouts.app')

@section('title', 'Tambah Petugas - NARIS STEAM')
@section('page-title', 'Tambah Petugas')

@section('breadcrumb')
<div class="flex items-center gap-2 text-sm text-gray-500">
    <a href="{{ route('admin.users.index') }}" class="hover:text-blue-600">Petugas</a>
    <i data-lucide="chevron-right" class="h-4 w-4"></i>
    <span class="text-gray-800">Tambah</span>
</div>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-800">Tambah Petugas Baru</h2>
            <p class="text-sm text-gray-500">Isi form di bawah untuk menambah petugas</p>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-gray-700">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 @error('name') border-red-500 @enderror"
                       placeholder="Nama lengkap"
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-gray-700">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}"
                       class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 @error('email') border-red-500 @enderror"
                       placeholder="email@contoh.com"
                       required>
                @error('email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone" class="mb-2 block text-sm font-medium text-gray-700">
                    No. Telepon
                </label>
                <input type="text" 
                       id="phone" 
                       name="phone" 
                       value="{{ old('phone') }}"
                       class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                       placeholder="08123456789">
                @error('phone')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="role" class="mb-2 block text-sm font-medium text-gray-700">
                    Role <span class="text-red-500">*</span>
                </label>
                <select id="role" 
                        name="role" 
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                        required>
                    <option value="">Pilih Role</option>
                    <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-gray-700">
                    Password <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 @error('password') border-red-500 @enderror"
                       placeholder="Minimal 6 karakter"
                       required>
                @error('password')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="mb-2 block text-sm font-medium text-gray-700">
                    Konfirmasi Password <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                       placeholder="Ulangi password"
                       required>
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button type="submit" 
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-500/30 transition-all hover:from-blue-600 hover:to-blue-700">
                    <i data-lucide="save" class="h-4 w-4"></i>
                    <span>Simpan</span>
                </button>
                <a href="{{ route('admin.users.index') }}" 
                   class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 px-5 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50">
                    <i data-lucide="x" class="h-4 w-4"></i>
                    <span>Batal</span>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection