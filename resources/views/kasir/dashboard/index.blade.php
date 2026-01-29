<!-- resources/views/kasir/dashboard/index.blade.php -->

@extends('layouts.app')

@section('title', 'Dashboard Kasir - NARIS STEAM')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Quick Action -->
    <div class="rounded-2xl bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white shadow-lg">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold">Selamat Datang, {{ auth()->user()->name }}!</h2>
                <p class="text-blue-100">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
            </div>
            <a href="{{ route('kasir.transactions.create') }}" 
               class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-6 py-3 text-sm font-semibold text-blue-600 shadow-lg transition-all hover:bg-blue-50">
                <i data-lucide="plus" class="h-5 w-5"></i>
                <span>Transaksi Baru</span>
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <!-- My Transactions -->
        <div class="rounded-2xl bg-white p-5 shadow-sm border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i data-lucide="user-check" class="h-6 w-6"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Transaksi Saya</p>
                    <p class="text-xl font-bold text-gray-800">{{ $myTodayTransactions }}</p>
                </div>
            </div>
        </div>

        <!-- My Revenue -->
        <div class="rounded-2xl bg-white p-5 shadow-sm border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-green-600">
                    <i data-lucide="wallet" class="h-6 w-6"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pendapatan Saya</p>
                    <p class="text-xl font-bold text-gray-800">Rp {{ number_format($myTodayRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Total Transactions Today -->
        <div class="rounded-2xl bg-white p-5 shadow-sm border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-50 text-orange-600">
                    <i data-lucide="receipt" class="h-6 w-6"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Hari Ini</p>
                    <p class="text-xl font-bold text-gray-800">{{ $todayTransactions }}</p>
                </div>
            </div>
        </div>

        <!-- Total Revenue Today -->
        <div class="rounded-2xl bg-white p-5 shadow-sm border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                    <i data-lucide="trending-up" class="h-6 w-6"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Omzet Hari Ini</p>
                    <p class="text-xl font-bold text-gray-800">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="rounded-2xl bg-white shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Transaksi Terakhir Saya</h3>
            <a href="{{ route('kasir.transactions.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">
                Lihat Semua
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">Invoice</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">Plat Nomor</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">Pembayaran</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">Waktu</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentTransactions as $transaction)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3">
                                <span class="font-mono text-sm text-blue-600">{{ $transaction->invoice_number }}</span>
                            </td>
                            <td class="px-6 py-3">
                                <span class="rounded-lg bg-gray-100 px-2 py-1 text-sm font-medium text-gray-700">
                                    {{ $transaction->plate_number }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-sm font-semibold text-gray-800">
                                Rp {{ number_format($transaction->total, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-3">
                                @if($transaction->payment_method === 'cash')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700">
                                        <i data-lucide="banknote" class="h-3 w-3"></i>
                                        Tunai
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700">
                                        <i data-lucide="qr-code" class="h-3 w-3"></i>
                                        QRIS
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-500">
                                {{ $transaction->created_at->format('H:i') }}
                            </td>
                            <td class="px-6 py-3">
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
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i data-lucide="receipt" class="h-10 w-10 text-gray-300 mb-2"></i>
                                    <p>Belum ada transaksi hari ini</p>
                                    <a href="{{ route('kasir.transactions.create') }}" class="mt-2 text-sm text-blue-600 hover:underline">
                                        Buat transaksi pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection