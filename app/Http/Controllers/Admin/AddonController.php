<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use Illuminate\Http\Request;

class AddonController extends Controller
{
    public function index(Request $request)
    {
        $query = Addon::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $addons = $query->orderBy('name')->paginate(10);

        return view('admin.addons.index', compact('addons'));
    }

    public function create()
    {
        return view('admin.addons.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $validated['is_active'] = true;

        Addon::create($validated);

        return redirect()->route('admin.addons.index')
            ->with('success', 'Layanan tambahan berhasil ditambahkan!');
    }

    public function edit(Addon $addon)
    {
        return view('admin.addons.edit', compact('addon'));
    }

    public function update(Request $request, Addon $addon)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $addon->update($validated);

        return redirect()->route('admin.addons.index')
            ->with('success', 'Layanan tambahan berhasil diperbarui!');
    }

    public function destroy(Addon $addon)
    {
        if ($addon->transactionAddons()->exists()) {
            return redirect()->route('admin.addons.index')
                ->with('error', 'Layanan tambahan tidak dapat dihapus karena sudah digunakan dalam transaksi.');
        }

        $addon->delete();

        return redirect()->route('admin.addons.index')
            ->with('success', 'Layanan tambahan berhasil dihapus!');
    }

    public function toggleStatus(Addon $addon)
    {
        $addon->update(['is_active' => !$addon->is_active]);

        $status = $addon->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->route('admin.addons.index')
            ->with('success', "Layanan tambahan berhasil {$status}!");
    }
}