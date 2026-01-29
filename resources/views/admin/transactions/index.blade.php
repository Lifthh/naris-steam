<!-- resources/views/admin/transactions/index.blade.php -->

@extends('layouts.app')

@section('title', 'Riwayat Transaksi - NARIS STEAM')
@section('page-title', 'Riwayat Transaksi')

@section('content')
<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="rounded-2xl bg-white p-5 shadow-sm border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i data-lucide="receipt" class="h-6 w-6"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Transaksi</p>
                    <p class="text-xl font-bold text-gray-800">{{ number_format($summary['total_transactions']) }}</p>
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
                    <p class="text-xl font-bold text-gray-800">Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="rounded-2xl bg-white p-4 shadow-sm border border-gray-100">
        <form action="{{ route('admin.transactions.index') }}" method="GET">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-6">
                <!-- Search -->
                <div class="relative lg:col-span-2">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i data-lucide="search" class="h-4 w-4"></i>
                    </span>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari invoice/plat nomor..."
                           class="w-full rounded-xl border border-gray-200 py-2.5 pl-10 pr-4 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                </div>

                <!-- Date From -->
                <input type="date" 
                       name="date_from" 
                       value="{{ request('date_from') }}"
                       class="rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                       placeholder="Dari Tanggal">

                <!-- Date To -->
                <input type="date" 
                       name="date_to" 
                       value="{{ request('date_to') }}"
                       class="rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                       placeholder="Sampai Tanggal">

                <!-- Payment Method -->
                <select name="payment_method" 
                        class="rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    <option value="">Semua Pembayaran</option>
                    <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Tunai</option>
                    <option value="qris" {{ request('payment_method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                </select>

                <!-- Status -->
                <select name="status" 
                        class="rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    <option value="">Semua Status</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <div class="mt-4 flex gap-2">
                <button type="submit" 
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-gray-100 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-200">
                    <i data-lucide="filter" class="h-4 w-4"></i>
                    <span>Filter</span>
                </button>

                @if(request()->hasAny(['search', 'date_from', 'date_to', 'payment_method', 'status']))
                    <a href="{{ route('admin.transactions.index') }}" 
                       class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50">
                        <i data-lucide="x" class="h-4 w-4"></i>
                        <span>Reset</span>
                    </a>
                @endif
            </div>
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
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Kasir</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Waktu</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <span class="font-mono text-sm font-medium text-blue-600">{{ $transaction->invoice_number }}</span>
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
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $transaction->user->name }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600">{{ $transaction->created_at->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-400">{{ $transaction->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($transaction->status === 'completed')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                        Selesai
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                        Dibatalkan
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('admin.transactions.show', $transaction) }}" 
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
                                    
                                    @if($transaction->status === 'completed')
                                        <form action="{{ route('admin.transactions.cancel', $transaction) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Yakin ingin membatalkan transaksi ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="rounded-lg p-2 text-gray-500 hover:bg-red-50 hover:text-red-600"
                                                    title="Batalkan">
                                                <i data-lucide="x-circle" class="h-4 w-4"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i data-lucide="receipt" class="h-12 w-12 text-gray-300 mb-3"></i>
                                    <p class="text-gray-500">Belum ada transaksi</p>
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