<!-- resources/views/admin/dashboard/index.blade.php -->

@extends('layouts.app')

@section('title', 'Dashboard - NARIS STEAM')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Pendapatan Hari Ini -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Hari Ini</p>
                    <p class="mt-1 text-2xl font-bold text-gray-800">
                        Rp {{ number_format($todayRevenue, 0, ',', '.') }}
                    </p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i data-lucide="wallet" class="h-6 w-6"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-sm">
                <i data-lucide="trending-up" class="h-4 w-4 text-green-500"></i>
                <span class="text-green-600">{{ $todayTransactions }} transaksi</span>
            </div>
        </div>

        <!-- Pendapatan Bulan Ini -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Bulan Ini</p>
                    <p class="mt-1 text-2xl font-bold text-gray-800">
                        Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}
                    </p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-green-600">
                    <i data-lucide="banknote" class="h-6 w-6"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-sm text-gray-500">
                <i data-lucide="calendar" class="h-4 w-4"></i>
                <span>{{ now()->isoFormat('MMMM Y') }}</span>
            </div>
        </div>

        <!-- Motor Hari Ini -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Motor Hari Ini</p>
                    <p class="mt-1 text-2xl font-bold text-gray-800">{{ $todayTransactions }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-50 text-orange-600">
                    <i data-lucide="bike" class="h-6 w-6"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-sm text-gray-500">
                <i data-lucide="droplets" class="h-4 w-4"></i>
                <span>Motor dicuci</span>
            </div>
        </div>

        <!-- Motor Bulan Ini -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Motor Bulan Ini</p>
                    <p class="mt-1 text-2xl font-bold text-gray-800">{{ $monthlyMotor }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                    <i data-lucide="bar-chart-3" class="h-6 w-6"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-sm text-gray-500">
                <i data-lucide="calendar" class="h-4 w-4"></i>
                <span>{{ now()->isoFormat('MMMM Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Charts & Tables Row -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Weekly Chart -->
        <div class="lg:col-span-2 rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
            <div class="mb-6 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">Pendapatan Mingguan</h3>
                <span class="text-sm text-gray-500">7 hari terakhir</span>
            </div>
            <div class="h-64" id="weekly-chart">
                <!-- Simple Bar Chart -->
                <div class="flex h-full items-end justify-between gap-2">
                    @php
                        $maxRevenue = collect($weeklyData)->max('revenue') ?: 1;
                    @endphp
                    @foreach($weeklyData as $data)
                        <div class="flex flex-1 flex-col items-center gap-2">
                            <div class="relative w-full flex justify-center">
                                <div class="w-full max-w-[40px] rounded-t-lg bg-gradient-to-t from-blue-500 to-blue-400 transition-all hover:from-blue-600 hover:to-blue-500"
                                     style="height: {{ $maxRevenue > 0 ? ($data['revenue'] / $maxRevenue) * 180 : 0 }}px; min-height: 4px;"
                                     title="Rp {{ number_format($data['revenue'], 0, ',', '.') }}">
                                </div>
                            </div>
                            <div class="text-center">
                                <p class="text-xs font-medium text-gray-600">{{ $data['day'] }}</p>
                                <p class="text-xs text-gray-400">{{ $data['date'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Popular Services -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
            <div class="mb-6 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">Layanan Terpopuler</h3>
                <span class="text-sm text-gray-500">Bulan ini</span>
            </div>
            <div class="space-y-4">
                @forelse($popularServices as $index => $service)
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-sm font-bold text-blue-600">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="truncate text-sm font-medium text-gray-800">{{ $service->service_name }}</p>
                            <p class="text-xs text-gray-500">{{ $service->total }}x digunakan</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i data-lucide="inbox" class="h-10 w-10 mx-auto mb-2 opacity-50"></i>
                        <p class="text-sm">Belum ada data</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
        <div class="mb-6 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Transaksi Terakhir</h3>
            <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-700">
                Lihat Semua
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="pb-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Invoice</th>
                        <th class="pb-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Plat Nomor</th>
                        <th class="pb-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Kasir</th>
                        <th class="pb-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Total</th>
                        <th class="pb-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recentTransactions as $transaction)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3">
                                <span class="font-mono text-sm font-medium text-blue-600">{{ $transaction->invoice_number }}</span>
                            </td>
                            <td class="py-3">
                                <span class="rounded-lg bg-gray-100 px-2 py-1 text-sm font-medium text-gray-700">
                                    {{ $transaction->plate_number }}
                                </span>
                            </td>
                            <td class="py-3 text-sm text-gray-600">{{ $transaction->user->name }}</td>
                            <td class="py-3 text-sm font-semibold text-gray-800">
                                Rp {{ number_format($transaction->total, 0, ',', '.') }}
                            </td>
                            <td class="py-3 text-sm text-gray-500">
                                {{ $transaction->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">
                                <i data-lucide="inbox" class="h-10 w-10 mx-auto mb-2 opacity-50"></i>
                                <p class="text-sm">Belum ada transaksi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection