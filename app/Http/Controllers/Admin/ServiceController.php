<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query();

        // Filter by search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by vehicle type
        if ($request->filled('vehicle_type')) {
            $query->where('vehicle_type', $request->vehicle_type);
        }

        $services = $query->orderBy('category')->orderBy('vehicle_type')->paginate(10);

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:steam,premium',
            'vehicle_type' => 'required|in:kecil,sedang,besar',
            'price' => 'required|numeric|min:0',
            'estimated_time' => 'nullable|integer|min:1',
        ]);

        $validated['is_active'] = true;

        Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:steam,premium',
            'vehicle_type' => 'required|in:kecil,sedang,besar',
            'price' => 'required|numeric|min:0',
            'estimated_time' => 'nullable|integer|min:1',
        ]);

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil diperbarui!');
    }

    public function destroy(Service $service)
    {
        // Check if service is used in any transaction
        if ($service->transactionServices()->exists()) {
            return redirect()->route('admin.services.index')
                ->with('error', 'Layanan tidak dapat dihapus karena sudah digunakan dalam transaksi.');
        }

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil dihapus!');
    }

    public function toggleStatus(Service $service)
    {
        $service->update(['is_active' => !$service->is_active]);

        $status = $service->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->route('admin.services.index')
            ->with('success', "Layanan berhasil {$status}!");
    }
}