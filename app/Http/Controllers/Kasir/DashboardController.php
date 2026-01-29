<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $today = Carbon::today();

        // My stats today
        $myTodayTransactions = Transaction::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->where('status', 'completed')
            ->count();

        $myTodayRevenue = Transaction::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->where('status', 'completed')
            ->sum('total');

        // All stats today
        $todayTransactions = Transaction::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->count();

        $todayRevenue = Transaction::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->sum('total');

        // My recent transactions
        $recentTransactions = Transaction::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->latest()
            ->take(10)
            ->get();

        return view('kasir.dashboard.index', compact(
            'myTodayTransactions',
            'myTodayRevenue',
            'todayTransactions',
            'todayRevenue',
            'recentTransactions'
        ));
    }
}