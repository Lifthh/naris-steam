<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\AddonController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Kasir\DashboardController as KasirDashboardController;
use App\Http\Controllers\Kasir\TransactionController as KasirTransactionController;

// Redirect root ke login
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin' 
            ? redirect()->route('admin.dashboard')
            : redirect()->route('kasir.dashboard');
    }
    return redirect()->route('login');
});

// Auth routes
require __DIR__.'/auth.php';

// Redirect setelah login
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('kasir.dashboard');
})->middleware(['auth'])->name('dashboard');

// ============================================
// ADMIN ROUTES
// ============================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Layanan Cuci
    Route::resource('services', ServiceController::class);
    Route::patch('/services/{service}/toggle-status', [ServiceController::class, 'toggleStatus'])->name('services.toggle-status');
    
    // Layanan Tambahan
    Route::resource('addons', AddonController::class);
    Route::patch('/addons/{addon}/toggle-status', [AddonController::class, 'toggleStatus'])->name('addons.toggle-status');
    
    // Petugas/User
    Route::resource('users', UserController::class);
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    
    // Transaksi
    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [AdminTransactionController::class, 'show'])->name('transactions.show');
    Route::patch('/transactions/{transaction}/cancel', [AdminTransactionController::class, 'cancel'])->name('transactions.cancel');
    
    // Laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/daily', [ReportController::class, 'daily'])->name('reports.daily');
    Route::get('/reports/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    
    // Pengaturan
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
});

// ============================================
// KASIR ROUTES
// ============================================
Route::middleware(['auth', 'role:kasir,admin'])->prefix('kasir')->name('kasir.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [KasirDashboardController::class, 'index'])->name('dashboard');
    
    // Transaksi
    Route::get('/transactions', [KasirTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [KasirTransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [KasirTransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{transaction}', [KasirTransactionController::class, 'show'])->name('transactions.show');
    Route::get('/transactions/{transaction}/print', [KasirTransactionController::class, 'print'])->name('transactions.print');
    
    // API untuk get services berdasarkan vehicle type
    Route::get('/api/services', [KasirTransactionController::class, 'getServices'])->name('api.services');
});