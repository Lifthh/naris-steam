<!-- resources/views/auth/login.blade.php -->

<x-guest-layout>
    <div class="w-full max-w-md">
        <!-- Logo Card -->
        <div class="mb-6 text-center">
            <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-2xl bg-white shadow-xl">
                <i data-lucide="droplets" class="h-10 w-10 text-blue-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-white">NARIS STEAM</h1>
            <p class="mt-1 text-blue-100">Sistem Kasir Steam Motor</p>
        </div>
        
        <!-- Login Form Card -->
        <div class="rounded-2xl bg-white p-8 shadow-2xl">
            <div class="mb-6 text-center">
                <h2 class="text-xl font-semibold text-gray-800">Selamat Datang</h2>
                <p class="text-sm text-gray-500">Silakan masuk ke akun Anda</p>
            </div>
            
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="mb-2 block text-sm font-medium text-gray-700">
                        Email
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i data-lucide="mail" class="h-5 w-5"></i>
                        </span>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               class="w-full rounded-xl border border-gray-200 py-3 pl-10 pr-4 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                               placeholder="nama@email.com"
                               required 
                               autofocus>
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="mb-2 block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <div class="relative" x-data="{ show: false }">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i data-lucide="lock" class="h-5 w-5"></i>
                        </span>
                        <input :type="show ? 'text' : 'password'" 
                               id="password" 
                               name="password" 
                               class="w-full rounded-xl border border-gray-200 py-3 pl-10 pr-12 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                               placeholder="Masukkan password"
                               required>
                        <button type="button" 
                                @click="show = !show" 
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                            <i data-lucide="eye" x-show="!show" class="h-5 w-5"></i>
                            <i data-lucide="eye-off" x-show="show" class="h-5 w-5" x-cloak></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Remember Me -->
                <div class="mb-6 flex items-center">
                    <input type="checkbox" 
                           id="remember" 
                           name="remember" 
                           class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label for="remember" class="ml-2 text-sm text-gray-600">
                        Ingat saya
                    </label>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" 
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/30 transition-all hover:from-blue-600 hover:to-blue-700 hover:shadow-xl hover:shadow-blue-500/40">
                    <i data-lucide="log-in" class="h-5 w-5"></i>
                    <span>Masuk</span>
                </button>
            </form>
        </div>
        
        <!-- Footer -->
        <p class="mt-6 text-center text-sm text-blue-100">
            &copy; {{ date('Y') }} NARIS STEAM. All rights reserved.
        </p>
    </div>
</x-guest-layout>