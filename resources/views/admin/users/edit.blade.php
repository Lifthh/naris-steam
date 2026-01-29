<!-- resources/views/admin/users/edit.blade.php -->

@extends('layouts.app')

@section('title', 'Edit Petugas - NARIS STEAM')
@section('page-title', 'Edit Petugas')

@section('breadcrumb')
<div class="flex items-center gap-2 text-sm text-gray-500">
    <a href="{{ route('admin.users.index') }}" class="hover:text-blue-600">Petugas</a>
    <i data-lucide="chevron-right" class="h-4 w-4"></i>
    <span class="text-gray-800">Edit</span>
</div>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-800">Edit Petugas</h2>
            <p class="text-sm text-gray-500">Perbarui informasi petugas</p>
        </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-gray-700">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $user->name) }}"
                       class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
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
                       value="{{ old('email', $user->email) }}"
                       class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
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
                       value="{{ old('phone', $user->phone) }}"
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
                    <option value="kasir" {{ old('role', $user->role) == 'kasir' ? 'selected' : '' }}>Kasir</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="rounded-xl bg-yellow-50 border border-yellow-200 p-4">
                <p class="text-sm text-yellow-800 font-medium mb-3">
                    <i data-lucide="info" class="h-4 w-4 inline mr-1"></i>
                    Kosongkan password jika tidak ingin mengubah
                </p>
                
                <div class="space-y-4">
                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-gray-700">
                            Password Baru
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                               placeholder="Minimal 6 karakter">
                        @error('password')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-medium text-gray-700">
                            Konfirmasi Password Baru
                        </label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                               placeholder="Ulangi password baru">
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button type="submit" 
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-500/30 transition-all hover:from-blue-600 hover:to-blue-700">
                    <i data-lucide="save" class="h-4 w-4"></i>
                    <span>Update</span>
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