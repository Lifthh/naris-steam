<!-- resources/views/admin/transactions/show.blade.php -->

@extends('layouts.app')

@section('title', 'Detail Transaksi - NARIS STEAM')
@section('page-title', 'Detail Transaksi')

@section('breadcrumb')
<div class="flex items-center gap-2 text-sm text-gray-500">
    <a href="{{ route('admin.transactions.index') }}" class="hover:text-blue-600">Riwayat Transaksi</a>
    <i data-lucide="chevron-right" class="h-4 w-4"></i>
    <span class="text-gray-800">{{ $transaction->invoice_number }}</span>
</div>
@endsection

@section('content')
<div class="max-w-3xl space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">{{ $transaction->invoice_number }}</h2>
            <p class="text-sm text-gray-500">{{ $transaction->created_at->isoFormat('dddd, D MMMM Y HH:mm') }}</p>
        </div>
        <div class="flex items-center gap-2">
            @if($transaction->status === 'completed')
                <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-3 py-1.5 text-sm font-medium text-green-700">
                    <span class="h-2 w-2 rounded-full bg-green-500"></span>
                    Selesai
                </span>
            @else
                <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-3 py-1.5 text-sm font-medium text-red-700">
                    <span class="h-2 w-2 rounded-full bg-red-500"></span>
                    Dibatalkan
                </span>
            @endif
        </div>
    </div>

    <!-- Main Info -->
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <!-- Kendaraan -->
            <div>
                <h3 class="mb-4 flex items-center gap-2 text-sm font-semibold text-gray-800">
                    <i data-lucide="bike" class="h-4 w-4 text-blue-600"></i>
                    Informasi Kendaraan
                </h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-500">Plat Nomor</p>
                        <p class="font-semibold text-gray-800">{{ $transaction->plate_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Ukuran Motor</p>
                        <p class="font-medium text-gray-800 capitalize">{{ $transaction->vehicle_type }}</p>
                    </div>
                    @if($transaction->vehicle_brand)
                        <div>
                            <p class="text-xs text-gray-500">Merk/Tipe</p>
                            <p class="font-medium text-gray-800">{{ $transaction->vehicle_brand }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Transaksi -->
            <div>
                <h3 class="mb-4 flex items-center gap-2 text-sm font-semibold text-gray-800">
                    <i data-lucide="user" class="h-4 w-4 text-blue-600"></i>
                    Informasi Transaksi
                </h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-500">Kasir</p>
                        <p class="font-medium text-gray-800">{{ $transaction->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Metode Pembayaran</p>
                        <p class="font-medium text-gray-800">{{ $transaction->payment_method === 'cash' ? 'Tunai' : 'QRIS' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Layanan -->
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
        <h3 class="mb-4 flex items-center gap-2 text-sm font-semibold text-gray-800">
            <i data-lucide="list" class="h-4 w-4 text-blue-600"></i>
            Detail Layanan
        </h3>
        
        <div class="space-y-3">
            @foreach($transaction->services as $service)
                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                            <i data-lucide="droplets" class="h-4 w-4"></i>
                        </div>
                        <span class="font-medium text-gray-800">{{ $service->service_name }}</span>
                    </div>
                    <span class="font-semibold text-gray-800">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                </div>
            @endforeach

            @foreach($transaction->addons as $addon)
                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-50 text-purple-600">
                            <i data-lucide="plus-circle" class="h-4 w-4"></i>
                        </div>
                        <span class="font-medium text-gray-800">{{ $addon->addon_name }}</span>
                    </div>
                    <span class="font-semibold text-gray-800">Rp {{ number_format($addon->price, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>

        <!-- Total -->
        <div class="mt-4 pt-4 border-t-2 border-gray-200">
            <div class="flex items-center justify-between">
                <span class="text-lg font-semibold text-gray-800">Total</span>
                <span class="text-xl font-bold text-blue-600">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="mt-4 pt-4 border-t border-gray-100 space-y-2">
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-500">Dibayar</span>
                <span class="font-medium text-gray-800">Rp {{ number_format($transaction->payment_amount, 0, ',', '.') }}</span>
            </div>
            @if($transaction->payment_method === 'cash')
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500">Kembalian</span>
                    <span class="font-medium text-gray-800">Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Notes -->
    @if($transaction->notes)
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
            <h3 class="mb-2 flex items-center gap-2 text-sm font-semibold text-gray-800">
                <i data-lucide="file-text" class="h-4 w-4 text-blue-600"></i>
                Catatan
            </h3>
            <p class="text-sm text-gray-600">{{ $transaction->notes }}</p>
        </div>
    @endif

    <!-- Actions -->
    <div class="flex items-center gap-3">
        <a href="{{ route('kasir.transactions.print', $transaction) }}" 
           target="_blank"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-500/30 transition-all hover:from-blue-600 hover:to-blue-700">
            <i data-lucide="printer" class="h-4 w-4"></i>
            <span>Cetak Struk</span>
        </a>
        <a href="{{ route('admin.transactions.index') }}" 
           class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 px-5 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            <span>Kembali</span>
        </a>
    </div>
</div>
@endsection