<!-- resources/views/kasir/transactions/index.blade.php -->

@extends('layouts.app')

@section('title', 'Riwayat Transaksi - NARIS STEAM')
@section('page-title', 'Riwayat Transaksi Hari Ini')

@section('content')
<div class="space-y-6">
    <!-- Summary -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="rounded-2xl bg-white p-5 shadow-sm border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i data-lucide="receipt" class="h-6 w-6"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Transaksi</p>
                    <p class="text-xl font-bold text-gray-800">{{ $summary['count'] }}</p>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-green-600">
                    <i data-lucide="wallet" class="h-6 w-6"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Pendapatan</p>
                    <p class="text-xl font-bold text-gray-800">Rp {{ number_format($summary['revenue'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="rounded-2xl bg-white p-4 shadow-sm border border-gray-100">
        <form action="{{ route('kasir.transactions.index') }}" method="GET" class="flex gap-4">
            <div class="flex-1 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i data-lucide="search" class="h-4 w-4"></i>
                </span>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari invoice atau plat nomor..."
                       class="w-full rounded-xl border border-gray-200 py-2.5 pl-10 pr-4 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
            </div>
            <button type="submit" class="rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700">
                Cari
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="rounded-2xl bg-white shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Invoice</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Plat Nomor</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Layanan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Total</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Pembayaran</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Waktu</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <span class="font-mono text-sm text-blue-600">{{ $transaction->invoice_number }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="rounded-lg bg-gray-100 px-2 py-1 text-sm font-medium text-gray-700">
                                    {{ $transaction->plate_number }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    @foreach($transaction->services as $service)
                                        <span class="block text-sm text-gray-800">{{ $service->service_name }}</span>
                                    @endforeach
                                    @foreach($transaction->addons as $addon)
                                        <span class="block text-xs text-gray-500">+ {{ $addon->addon_name }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-gray-800">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($transaction->payment_method === 'cash')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">
                                        <i data-lucide="banknote" class="h-3 w-3"></i>
                                        Tunai
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-purple-50 px-2.5 py-1 text-xs font-medium text-purple-700">
                                        <i data-lucide="qr-code" class="h-3 w-3"></i>
                                        QRIS
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $transaction->created_at->format('H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('kasir.transactions.show', $transaction) }}" 
                                       class="rounded-lg p-2 text-gray-500 hover:bg-blue-50 hover:text-blue-600"
                                       title="Detail">
                                        <i data-lucide="eye" class="h-4 w-4"></i>
                                    </a>
                                    <a href="{{ route('kasir.transactions.print', $transaction) }}" 
                                       target="_blank"
                                       class="rounded-lg p-2 text-gray-500 hover:bg-green-50 hover:text-green-600"
                                       title="Cetak">
                                        <i data-lucide="printer" class="h-4 w-4"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i data-lucide="receipt" class="h-12 w-12 text-gray-300 mb-3"></i>
                                    <p class="text-gray-500">Belum ada transaksi hari ini</p>
                                    <a href="{{ route('kasir.transactions.create') }}" class="mt-2 text-sm text-blue-600 hover:underline">
                                        Buat transaksi baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($transactions->hasPages())
            <div class="border-t border-gray-100 px-6 py-4">
                {{ $transactions->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection