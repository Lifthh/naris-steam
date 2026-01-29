<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'services', 'addons']);

        // Search by invoice or plate number
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('invoice_number', 'like', '%' . $request->search . '%')
                  ->orWhere('plate_number', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by kasir
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $transactions = $query->latest()->paginate(15);

        // Get kasir list for filter
        $kasirs = \App\Models\User::where('role', 'kasir')->orWhere('role', 'admin')->get();

        // Summary
        $summary = [
            'total_transactions' => $query->count(),
            'total_revenue' => $query->where('status', 'completed')->sum('total'),
        ];

        return view('admin.transactions.index', compact('transactions', 'kasirs', 'summary'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'services', 'addons']);
        return view('admin.transactions.show', compact('transaction'));
    }

    public function cancel(Transaction $transaction)
    {
        if ($transaction->status === 'cancelled') {
            return redirect()->back()->with('error', 'Transaksi sudah dibatalkan sebelumnya.');
        }

        $transaction->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Transaksi berhasil dibatalkan.');
    }
}