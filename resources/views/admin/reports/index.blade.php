<!-- resources/views/admin/reports/index.blade.php -->

@extends('layouts.app')

@section('title', 'Laporan - NARIS STEAM')
@section('page-title', 'Laporan')

@section('content')
<div class="space-y-6">
    <!-- Period Tabs -->
    <div class="rounded-2xl bg-white p-4 shadow-sm border border-gray-100">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-col gap-4 sm:flex-row sm:items-end">
            <!-- Period Toggle -->
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Periode</label>
                <div class="flex rounded-xl border border-gray-200 p-1">
                    <button type="submit" name="period" value="daily" 
                            class="rounded-lg px-4 py-2 text-sm font-medium transition-all {{ $period === 'daily' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        Harian
                    </button>
                    <button type="submit" name="period" value="monthly" 
                            class="rounded-lg px-4 py-2 text-sm font-medium transition-all {{ $period === 'monthly' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        Bulanan
                    </button>
                </div>
            </div>

            @if($period === 'daily')
                <div>
                    <label for="date" class="mb-2 block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" 
                           id="date" 
                           name="date" 
                           value="{{ $date }}"
                           class="rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                </div>
            @else
                <div>
                    <label for="month" class="mb-2 block text-sm font-medium text-gray-700">Bulan</label>
                    <input type="month" 
                           id="month" 
                           name="month" 
                           value="{{ $month }}"
                           class="rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                </div>
            @endif

            <button type="submit" 
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700">
                <i data-lucide="search" class="h-4 w-4"></i>
                <span>Tampilkan</span>
            </button>

            <a href="{{ route('admin.reports.export', ['period' => $period, 'date' => $date, 'month' => $month]) }}" 
               class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50">
                <i data-lucide="download" class="h-4 w-4"></i>
                <span>Export CSV</span>
            </a>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl bg-white p-5 shadow-sm border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i data-lucide="receipt" class="h-6 w-6"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Transaksi</p>
                    <p class="text-xl font-bold text-gray-800">{{ number_format($data['summary']['total_transactions']) }}</p>
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
                    <p class="text-xl font-bold text-gray-800">Rp {{ number_format($data['summary']['total_revenue'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-white p-5 shadow-sm border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <i data-lucide="banknote" class="h-6 w-6"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tunai</p>
                    <p class="text-xl font-bold text-gray-800">Rp {{ number_format($data['summary']['cash_revenue'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-white p-5 shadow-sm border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                    <i data-lucide="qr-code" class="h-6 w-6"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">QRIS</p>
                    <p class="text-xl font-bold text-gray-800">Rp {{ number_format($data['summary']['qris_revenue'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Chart / Daily Breakdown -->
        @if($period === 'monthly')
            <div class="lg:col-span-2 rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
                <h3 class="mb-4 text-lg font-semibold text-gray-800">Grafik Pendapatan Harian</h3>
                <div class="h-64 overflow-x-auto">
                    <div class="flex h-full items-end gap-1 min-w-max pb-8">
                        @php
                            $maxRevenue = collect($data['daily_data'])->max('revenue') ?: 1;
                        @endphp
                        @foreach($data['daily_data'] as $day)
                            <div class="flex flex-col items-center" style="width: 30px;">
                                <div class="w-full rounded-t-md bg-gradient-to-t from-blue-500 to-blue-400 hover:from-blue-600 hover:to-blue-500 transition-all cursor-pointer relative group"
                                     style="height: {{ $maxRevenue > 0 ? max(($day['revenue'] / $maxRevenue) * 180, 4) : 4 }}px;">
                                    <div class="absolute bottom-full mb-2 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                        Rp {{ number_format($day['revenue'], 0, ',', '.') }}
                                    </div>
                                </div>
                                <span class="mt-2 text-xs text-gray-500">{{ $day['date'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Kasir Stats -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
            <h3 class="mb-4 text-lg font-semibold text-gray-800">Performa Kasir</h3>
            <div class="space-y-4">
                @forelse($data['kasir_stats'] as $kasir)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                                <i data-lucide="user" class="h-5 w-5"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $kasir['name'] }}</p>
                                <p class="text-sm text-gray-500">{{ $kasir['count'] }} transaksi</p>
                            </div>
                        </div>
                        <span class="font-semibold text-gray-800">Rp {{ number_format($kasir['revenue'], 0, ',', '.') }}</span>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-4">Belum ada data</p>
                @endforelse
            </div>
        </div>

        <!-- Service Stats (Daily Only) -->
        @if($period === 'daily' && !empty($data['service_stats']))
            <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
                <h3 class="mb-4 text-lg font-semibold text-gray-800">Layanan Terjual</h3>
                <div class="space-y-4">
                    @foreach($data['service_stats'] as $serviceName => $stats)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                            <div>
                                <p class="font-medium text-gray-800">{{ $serviceName }}</p>
                                <p class="text-sm text-gray-500">{{ $stats['count'] }}x</p>
                            </div>
                            <span class="font-semibold text-gray-800">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Transaction List (Daily Only) -->
    @if($period === 'daily' && isset($data['transactions']))
        <div class="rounded-2xl bg-white shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Daftar Transaksi</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">Invoice</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">Plat Nomor</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">Pembayaran</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">Kasir</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($data['transactions'] as $transaction)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3">
                                    <span class="font-mono text-sm text-blue-600">{{ $transaction->invoice_number }}</span>
                                </td>
                                <td class="px-6 py-3 text-sm text-gray-800">{{ $transaction->plate_number }}</td>
                                <td class="px-6 py-3 text-sm font-semibold text-gray-800">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                                <td class="px-6 py-3">
                                    <span class="text-sm text-gray-600">{{ $transaction->payment_method === 'cash' ? 'Tunai' : 'QRIS' }}</span>
                                </td>
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $transaction->user->name }}</td>
                                <td class="px-6 py-3 text-sm text-gray-500">{{ $transaction->created_at->format('H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">Tidak ada transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection