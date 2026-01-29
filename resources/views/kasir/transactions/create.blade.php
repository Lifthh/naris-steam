<!-- resources/views/kasir/transactions/create.blade.php -->

@extends('layouts.app')

@section('title', 'Transaksi Baru - NARIS STEAM')
@section('page-title', 'Transaksi Baru')

@section('content')
<div x-data="transactionForm()" class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <!-- Form -->
    <div class="lg:col-span-2 space-y-6">
        <form action="{{ route('kasir.transactions.store') }}" method="POST" @submit="validateForm">
            @csrf

            <!-- Vehicle Info -->
            <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100 mb-6">
                <h3 class="mb-4 flex items-center gap-2 text-lg font-semibold text-gray-800">
                    <i data-lucide="bike" class="h-5 w-5 text-blue-600"></i>
                    Informasi Kendaraan
                </h3>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <!-- Plat Nomor -->
                    <div>
                        <label for="plate_number" class="mb-2 block text-sm font-medium text-gray-700">
                            Plat Nomor <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="plate_number" 
                               name="plate_number" 
                               x-model="plateNumber"
                               value="{{ old('plate_number') }}"
                               class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm uppercase focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 @error('plate_number') border-red-500 @enderror"
                               placeholder="B 1234 ABC"
                               required>
                        @error('plate_number')
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
                                x-model="vehicleType"
                                @change="filterServices()"
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                                required>
                            <option value="">Pilih Ukuran</option>
                            <option value="kecil" {{ old('vehicle_type') == 'kecil' ? 'selected' : '' }}>Motor Kecil (Bebek, Matic Kecil)</option>
                            <option value="sedang" {{ old('vehicle_type') == 'sedang' ? 'selected' : '' }}>Motor Sedang (Matic Besar, Sport Kecil)</option>
                            <option value="besar" {{ old('vehicle_type') == 'besar' ? 'selected' : '' }}>Motor Besar (Sport, Moge)</option>
                        </select>
                        @error('vehicle_type')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Merk Motor (Optional) -->
                    <div class="sm:col-span-2">
                        <label for="vehicle_brand" class="mb-2 block text-sm font-medium text-gray-700">
                            Merk/Tipe Motor <span class="text-gray-400">(Opsional)</span>
                        </label>
                        <input type="text" 
                               id="vehicle_brand" 
                               name="vehicle_brand" 
                               value="{{ old('vehicle_brand') }}"
                               class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                               placeholder="Contoh: Honda Beat, Yamaha NMAX">
                    </div>
                </div>
            </div>

            <!-- Service Selection -->
            <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100 mb-6">
                <h3 class="mb-4 flex items-center gap-2 text-lg font-semibold text-gray-800">
                    <i data-lucide="droplets" class="h-5 w-5 text-blue-600"></i>
                    Pilih Layanan Cuci
                </h3>

                <div x-show="!vehicleType" class="rounded-xl bg-yellow-50 border border-yellow-200 p-4 text-center text-sm text-yellow-700">
                    <i data-lucide="alert-circle" class="h-5 w-5 inline mr-1"></i>
                    Pilih ukuran motor terlebih dahulu
                </div>

                <div x-show="vehicleType" class="space-y-4">
                    <!-- Steam Biasa -->
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-500">Steam Biasa</p>
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                            @foreach($services['steam'] ?? [] as $service)
                                <label x-show="vehicleType === '{{ $service->vehicle_type }}'"
                                       class="relative cursor-pointer">
                                    <input type="radio" 
                                           name="service_id" 
                                           value="{{ $service->id }}"
                                           x-model="selectedService"
                                           @change="updateService({{ $service->id }}, '{{ $service->name }}', {{ $service->price }})"
                                           class="peer sr-only">
                                    <div class="rounded-xl border-2 border-gray-200 p-4 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-gray-300">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="font-medium text-gray-800">Steam Biasa</p>
                                                <p class="text-xs text-gray-500 capitalize">Motor {{ $service->vehicle_type }}</p>
                                            </div>
                                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-blue-600 peer-checked:bg-blue-600 peer-checked:text-white">
                                                <i data-lucide="droplets" class="h-4 w-4"></i>
                                            </div>
                                        </div>
                                        <p class="mt-2 text-lg font-bold text-blue-600">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Premium Wash -->
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-500">Premium Wash</p>
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                            @foreach($services['premium'] ?? [] as $service)
                                <label x-show="vehicleType === '{{ $service->vehicle_type }}'"
                                       class="relative cursor-pointer">
                                    <input type="radio" 
                                           name="service_id" 
                                           value="{{ $service->id }}"
                                           x-model="selectedService"
                                           @change="updateService({{ $service->id }}, '{{ $service->name }}', {{ $service->price }})"
                                           class="peer sr-only">
                                    <div class="rounded-xl border-2 border-gray-200 p-4 transition-all peer-checked:border-purple-500 peer-checked:bg-purple-50 hover:border-gray-300">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="font-medium text-gray-800">Premium Wash</p>
                                                <p class="text-xs text-gray-500 capitalize">Motor {{ $service->vehicle_type }}</p>
                                            </div>
                                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-purple-100 text-purple-600">
                                                <i data-lucide="sparkles" class="h-4 w-4"></i>
                                            </div>
                                        </div>
                                        <p class="mt-2 text-lg font-bold text-purple-600">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                @error('service_id')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Addon Selection -->
            <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100 mb-6">
                <h3 class="mb-4 flex items-center gap-2 text-lg font-semibold text-gray-800">
                    <i data-lucide="plus-circle" class="h-5 w-5 text-blue-600"></i>
                    Layanan Tambahan
                    <span class="text-sm font-normal text-gray-400">(Opsional)</span>
                </h3>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($addons as $addon)
                        <label class="relative cursor-pointer">
                            <input type="checkbox" 
                                   name="addon_ids[]" 
                                   value="{{ $addon->id }}"
                                   @change="toggleAddon({{ $addon->id }}, '{{ $addon->name }}', {{ $addon->price }})"
                                   class="peer sr-only">
                            <div class="rounded-xl border-2 border-gray-200 p-4 transition-all peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-gray-300">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-600 peer-checked:bg-green-100 peer-checked:text-green-600">
                                        <i data-lucide="check" class="h-5 w-5 hidden peer-checked:block"></i>
                                        <i data-lucide="plus" class="h-5 w-5"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $addon->name }}</p>
                                        <p class="text-sm font-semibold text-green-600">Rp {{ number_format($addon->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Payment -->
            <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100 mb-6">
                <h3 class="mb-4 flex items-center gap-2 text-lg font-semibold text-gray-800">
                    <i data-lucide="credit-card" class="h-5 w-5 text-blue-600"></i>
                    Pembayaran
                </h3>

                <div class="space-y-4">
                    <!-- Payment Method -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Metode Pembayaran <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-3">
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="cash"
                                       x-model="paymentMethod"
                                       class="peer sr-only" 
                                       checked>
                                <div class="flex items-center justify-center gap-2 rounded-xl border-2 border-gray-200 p-3 transition-all peer-checked:border-green-500 peer-checked:bg-green-50">
                                    <i data-lucide="banknote" class="h-5 w-5 text-green-600"></i>
                                    <span class="font-medium text-gray-800">Tunai</span>
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="qris"
                                       x-model="paymentMethod"
                                       class="peer sr-only">
                                <div class="flex items-center justify-center gap-2 rounded-xl border-2 border-gray-200 p-3 transition-all peer-checked:border-purple-500 peer-checked:bg-purple-50">
                                    <i data-lucide="qr-code" class="h-5 w-5 text-purple-600"></i>
                                    <span class="font-medium text-gray-800">QRIS</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Payment Amount -->
                    <div>
                        <label for="payment_amount" class="mb-2 block text-sm font-medium text-gray-700">
                            Jumlah Bayar <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500">Rp</span>
                            <input type="number" 
                                   id="payment_amount" 
                                   name="payment_amount" 
                                   x-model="paymentAmount"
                                   @input="calculateChange()"
                                   class="w-full rounded-xl border border-gray-200 py-3 pl-12 pr-4 text-lg font-semibold focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                                   placeholder="0"
                                   min="0"
                                   required>
                        </div>
                        @error('payment_amount')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quick Amount Buttons (Cash Only) -->
                    <div x-show="paymentMethod === 'cash'" class="flex flex-wrap gap-2">
                        <button type="button" @click="setPaymentAmount(total)" class="rounded-lg bg-gray-100 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-200">Uang Pas</button>
                        <button type="button" @click="setPaymentAmount(20000)" class="rounded-lg bg-gray-100 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-200">20.000</button>
                        <button type="button" @click="setPaymentAmount(50000)" class="rounded-lg bg-gray-100 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-200">50.000</button>
                        <button type="button" @click="setPaymentAmount(100000)" class="rounded-lg bg-gray-100 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-200">100.000</button>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="mb-2 block text-sm font-medium text-gray-700">
                            Catatan <span class="text-gray-400">(Opsional)</span>
                        </label>
                        <textarea id="notes" 
                                  name="notes" 
                                  rows="2"
                                  class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                                  placeholder="Catatan tambahan...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Submit Button (Mobile) -->
            <div class="lg:hidden">
                <button type="submit" 
                        :disabled="!canSubmit"
                        class="w-full rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 py-4 text-center font-semibold text-white shadow-lg shadow-blue-500/30 transition-all hover:from-blue-600 hover:to-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i data-lucide="check-circle" class="h-5 w-5 inline mr-2"></i>
                    Proses Transaksi
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Sidebar -->
    <div class="lg:col-span-1">
        <div class="sticky top-24 rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
            <h3 class="mb-4 text-lg font-semibold text-gray-800">Ringkasan</h3>

            <!-- Vehicle -->
            <div class="mb-4 pb-4 border-b border-gray-100">
                <p class="text-sm text-gray-500">Kendaraan</p>
                <p class="font-semibold text-gray-800" x-text="plateNumber || '-'"></p>
                <p class="text-sm text-gray-500 capitalize" x-text="vehicleType ? 'Motor ' + vehicleType : '-'"></p>
            </div>

            <!-- Selected Service -->
            <div class="mb-4 pb-4 border-b border-gray-100">
                <p class="text-sm text-gray-500 mb-2">Layanan</p>
                <div x-show="!serviceName" class="text-sm text-gray-400 italic">Belum dipilih</div>
                <div x-show="serviceName" class="flex items-center justify-between">
                    <span class="text-sm text-gray-800" x-text="serviceName"></span>
                    <span class="font-semibold text-gray-800" x-text="'Rp ' + formatNumber(servicePrice)"></span>
                </div>
            </div>

            <!-- Selected Addons -->
            <div class="mb-4 pb-4 border-b border-gray-100">
                <p class="text-sm text-gray-500 mb-2">Tambahan</p>
                <div x-show="selectedAddons.length === 0" class="text-sm text-gray-400 italic">Tidak ada</div>
                <template x-for="addon in selectedAddons" :key="addon.id">
                    <div class="flex items-center justify-between py-1">
                        <span class="text-sm text-gray-800" x-text="addon.name"></span>
                        <span class="text-sm text-gray-600" x-text="'Rp ' + formatNumber(addon.price)"></span>
                    </div>
                </template>
            </div>

            <!-- Total -->
            <div class="mb-4 pb-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <span class="text-lg font-semibold text-gray-800">Total</span>
                    <span class="text-xl font-bold text-blue-600" x-text="'Rp ' + formatNumber(total)"></span>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="mb-6 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Dibayar</span>
                    <span class="font-medium text-gray-800" x-text="'Rp ' + formatNumber(paymentAmount || 0)"></span>
                </div>
                <div x-show="paymentMethod === 'cash'" class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Kembalian</span>
                    <span class="font-bold" 
                          :class="change >= 0 ? 'text-green-600' : 'text-red-600'"
                          x-text="'Rp ' + formatNumber(Math.max(0, change))"></span>
                </div>
                <div x-show="paymentAmount < total" class="mt-2 rounded-lg bg-red-50 p-2 text-center text-sm text-red-600">
                    Pembayaran kurang Rp <span x-text="formatNumber(total - paymentAmount)"></span>
                </div>
            </div>

            <!-- Submit Button (Desktop) -->
            <button type="submit" 
                    form="transaction-form"
                    onclick="document.querySelector('form').submit()"
                    :disabled="!canSubmit"
                    class="hidden lg:flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 py-3 font-semibold text-white shadow-lg shadow-blue-500/30 transition-all hover:from-blue-600 hover:to-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                <i data-lucide="check-circle" class="h-5 w-5"></i>
                <span>Proses Transaksi</span>
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function transactionForm() {
    return {
        plateNumber: '{{ old('plate_number') }}',
        vehicleType: '{{ old('vehicle_type') }}',
        selectedService: '{{ old('service_id') }}',
        serviceName: '',
        servicePrice: 0,
        selectedAddons: [],
        paymentMethod: '{{ old('payment_method', 'cash') }}',
        paymentAmount: {{ old('payment_amount', 0) }},
        
        get total() {
            let addonTotal = this.selectedAddons.reduce((sum, addon) => sum + addon.price, 0);
            return this.servicePrice + addonTotal;
        },
        
        get change() {
            return this.paymentAmount - this.total;
        },
        
        get canSubmit() {
            return this.plateNumber && 
                   this.vehicleType && 
                   this.selectedService && 
                   this.paymentAmount >= this.total;
        },
        
        filterServices() {
            this.selectedService = '';
            this.serviceName = '';
            this.servicePrice = 0;
        },
        
        updateService(id, name, price) {
            this.selectedService = id;
            this.serviceName = name;
            this.servicePrice = price;
        },
        
        toggleAddon(id, name, price) {
            const index = this.selectedAddons.findIndex(a => a.id === id);
            if (index > -1) {
                this.selectedAddons.splice(index, 1);
            } else {
                this.selectedAddons.push({ id, name, price });
            }
        },
        
        setPaymentAmount(amount) {
            this.paymentAmount = amount;
        },
        
        calculateChange() {
            // Automatic via getter
        },
        
        formatNumber(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        },
        
        validateForm(e) {
            if (!this.canSubmit) {
                e.preventDefault();
                alert('Mohon lengkapi form transaksi');
            }
        }
    }
}
</script>
@endpush
@endsection