<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'daily');
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        $month = $request->get('month', Carbon::now()->format('Y-m'));

        if ($period === 'daily') {
            $data = $this->getDailyReport($date);
        } else {
            $data = $this->getMonthlyReport($month);
        }

        return view('admin.reports.index', compact('period', 'date', 'month', 'data'));
    }

    private function getDailyReport($date)
    {
        $transactions = Transaction::with(['user', 'services', 'addons'])
            ->whereDate('created_at', $date)
            ->where('status', 'completed')
            ->get();

        $summary = [
            'total_transactions' => $transactions->count(),
            'total_revenue' => $transactions->sum('total'),
            'cash_revenue' => $transactions->where('payment_method', 'cash')->sum('total'),
            'qris_revenue' => $transactions->where('payment_method', 'qris')->sum('total'),
        ];

        // Group by service
        $serviceStats = [];
        foreach ($transactions as $transaction) {
            foreach ($transaction->services as $service) {
                if (!isset($serviceStats[$service->service_name])) {
                    $serviceStats[$service->service_name] = [
                        'count' => 0,
                        'revenue' => 0,
                    ];
                }
                $serviceStats[$service->service_name]['count']++;
                $serviceStats[$service->service_name]['revenue'] += $service->price;
            }
        }

        // Group by kasir
        $kasirStats = $transactions->groupBy('user_id')->map(function ($items) {
            return [
                'name' => $items->first()->user->name,
                'count' => $items->count(),
                'revenue' => $items->sum('total'),
            ];
        });

        return [
            'transactions' => $transactions,
            'summary' => $summary,
            'service_stats' => $serviceStats,
            'kasir_stats' => $kasirStats,
        ];
    }

    private function getMonthlyReport($month)
    {
        $startDate = Carbon::parse($month . '-01')->startOfMonth();
        $endDate = Carbon::parse($month . '-01')->endOfMonth();

        $transactions = Transaction::with(['user'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->get();

        $summary = [
            'total_transactions' => $transactions->count(),
            'total_revenue' => $transactions->sum('total'),
            'cash_revenue' => $transactions->where('payment_method', 'cash')->sum('total'),
            'qris_revenue' => $transactions->where('payment_method', 'qris')->sum('total'),
            'avg_per_day' => $transactions->count() > 0 ? $transactions->sum('total') / $endDate->day : 0,
        ];

        // Daily breakdown
        $dailyData = [];
        for ($i = 1; $i <= $endDate->day; $i++) {
            $dayDate = Carbon::parse($month . '-' . str_pad($i, 2, '0', STR_PAD_LEFT));
            $dayTransactions = $transactions->filter(function ($t) use ($dayDate) {
                return $t->created_at->format('Y-m-d') === $dayDate->format('Y-m-d');
            });

            $dailyData[] = [
                'date' => $dayDate->format('d'),
                'day' => $dayDate->isoFormat('ddd'),
                'count' => $dayTransactions->count(),
                'revenue' => $dayTransactions->sum('total'),
            ];
        }

        // Group by kasir
        $kasirStats = $transactions->groupBy('user_id')->map(function ($items) {
            return [
                'name' => $items->first()->user->name,
                'count' => $items->count(),
                'revenue' => $items->sum('total'),
            ];
        })->sortByDesc('revenue');

        return [
            'summary' => $summary,
            'daily_data' => $dailyData,
            'kasir_stats' => $kasirStats,
        ];
    }

    public function export(Request $request)
    {
        // Export to CSV
        $period = $request->get('period', 'daily');
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        $month = $request->get('month', Carbon::now()->format('Y-m'));

        if ($period === 'daily') {
            $transactions = Transaction::with(['user', 'services'])
                ->whereDate('created_at', $date)
                ->where('status', 'completed')
                ->get();
            $filename = 'laporan-harian-' . $date . '.csv';
        } else {
            $startDate = Carbon::parse($month . '-01')->startOfMonth();
            $endDate = Carbon::parse($month . '-01')->endOfMonth();
            $transactions = Transaction::with(['user', 'services'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'completed')
                ->get();
            $filename = 'laporan-bulanan-' . $month . '.csv';
        }

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['Invoice', 'Tanggal', 'Plat Nomor', 'Layanan', 'Total', 'Pembayaran', 'Kasir']);

            foreach ($transactions as $t) {
                $services = $t->services->pluck('service_name')->implode(', ');
                fputcsv($file, [
                    $t->invoice_number,
                    $t->created_at->format('d/m/Y H:i'),
                    $t->plate_number,
                    $services,
                    $t->total,
                    $t->payment_method === 'cash' ? 'Tunai' : 'QRIS',
                    $t->user->name,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}