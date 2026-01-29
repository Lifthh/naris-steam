<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Pendapatan hari ini
        $todayRevenue = Transaction::whereDate('created_at', Carbon::today())
            ->where('status', 'completed')
            ->sum('total');

        // Pendapatan bulan ini
        $monthlyRevenue = Transaction::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status', 'completed')
            ->sum('total');

        // Transaksi hari ini
        $todayTransactions = Transaction::whereDate('created_at', Carbon::today())
            ->where('status', 'completed')
            ->count();

        // Total motor bulan ini
        $monthlyMotor = Transaction::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status', 'completed')
            ->count();

        // Transaksi terakhir
        $recentTransactions = Transaction::with('user')
            ->where('status', 'completed')
            ->latest()
            ->take(5)
            ->get();

        // Data chart mingguan
        $weeklyData = $this->getWeeklyData();

        // Layanan terpopuler
        $popularServices = $this->getPopularServices();

        return view('admin.dashboard.index', compact(
            'todayRevenue',
            'monthlyRevenue',
            'todayTransactions',
            'monthlyMotor',
            'recentTransactions',
            'weeklyData',
            'popularServices'
        ));
    }

    private function getWeeklyData()
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $revenue = Transaction::whereDate('created_at', $date)
                ->where('status', 'completed')
                ->sum('total');
            
            $data[] = [
                'day' => $date->isoFormat('ddd'),
                'date' => $date->format('d/m'),
                'revenue' => $revenue,
            ];
        }
        return $data;
    }

    private function getPopularServices()
    {
        return \DB::table('transaction_services')
            ->select('service_name', \DB::raw('COUNT(*) as total'))
            ->whereMonth('created_at', Carbon::now()->month)
            ->groupBy('service_name')
            ->orderByDesc('total')
            ->take(5)
            ->get();
    }
}