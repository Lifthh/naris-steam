<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\TransactionAddon;
use App\Models\TransactionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['services', 'addons'])
            ->where('user_id', auth()->id())
            ->whereDate('created_at', Carbon::today());

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('invoice_number', 'like', '%' . $request->search . '%')
                  ->orWhere('plate_number', 'like', '%' . $request->search . '%');
            });
        }

        $transactions = $query->latest()->paginate(15);

        $summary = [
            'count' => $transactions->total(),
            'revenue' => Transaction::where('user_id', auth()->id())
                ->whereDate('created_at', Carbon::today())
                ->where('status', 'completed')
                ->sum('total'),
        ];

        return view('kasir.transactions.index', compact('transactions', 'summary'));
    }

    public function create()
    {
        $services = Service::active()->get()->groupBy('category');
        $addons = Addon::active()->get();

        return view('kasir.transactions.create', compact('services', 'addons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|max:20',
            'vehicle_type' => 'required|in:kecil,sedang,besar',
            'vehicle_brand' => 'nullable|string|max:100',
            'service_id' => 'required|exists:services,id',
            'addon_ids' => 'nullable|array',
            'addon_ids.*' => 'exists:addons,id',
            'payment_method' => 'required|in:cash,qris',
            'payment_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            // Get service
            $service = Service::findOrFail($validated['service_id']);
            
            // Calculate totals
            $subtotal = $service->price;
            $addonTotal = 0;

            if (!empty($validated['addon_ids'])) {
                $addons = Addon::whereIn('id', $validated['addon_ids'])->get();
                $addonTotal = $addons->sum('price');
            }

            $total = $subtotal + $addonTotal;
            $changeAmount = $validated['payment_method'] === 'cash' 
                ? max(0, $validated['payment_amount'] - $total) 
                : 0;

            // Validate payment amount
            if ($validated['payment_amount'] < $total) {
                return back()->withInput()->with('error', 'Jumlah pembayaran kurang dari total.');
            }

            // Create transaction
            $transaction = Transaction::create([
                'invoice_number' => Transaction::generateInvoiceNumber(),
                'user_id' => auth()->id(),
                'plate_number' => strtoupper($validated['plate_number']),
                'vehicle_type' => $validated['vehicle_type'],
                'vehicle_brand' => $validated['vehicle_brand'],
                'subtotal' => $subtotal,
                'total' => $total,
                'payment_method' => $validated['payment_method'],
                'payment_amount' => $validated['payment_amount'],
                'change_amount' => $changeAmount,
                'status' => 'completed',
                'notes' => $validated['notes'],
            ]);

            // Create transaction service
            TransactionService::create([
                'transaction_id' => $transaction->id,
                'service_id' => $service->id,
                'service_name' => $service->name,
                'price' => $service->price,
            ]);

            // Create transaction addons
            if (!empty($validated['addon_ids'])) {
                foreach ($addons as $addon) {
                    TransactionAddon::create([
                        'transaction_id' => $transaction->id,
                        'addon_id' => $addon->id,
                        'addon_name' => $addon->name,
                        'price' => $addon->price,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('kasir.transactions.show', $transaction)
                ->with('success', 'Transaksi berhasil! Silakan cetak struk.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'services', 'addons']);
        return view('kasir.transactions.show', compact('transaction'));
    }

    public function print(Transaction $transaction)
    {
        $transaction->load(['user', 'services', 'addons']);
        
        $settings = [
            'store_name' => Setting::get('store_name', 'NARIS STEAM'),
            'store_address' => Setting::get('store_address', ''),
            'store_phone' => Setting::get('store_phone', ''),
            'receipt_footer' => Setting::get('receipt_footer', 'Terima kasih!'),
        ];

        return view('kasir.transactions.print', compact('transaction', 'settings'));
    }

    public function getServices(Request $request)
    {
        $vehicleType = $request->get('vehicle_type');
        
        $services = Service::active()
            ->where('vehicle_type', $vehicleType)
            ->get()
            ->groupBy('category');

        return response()->json($services);
    }
}