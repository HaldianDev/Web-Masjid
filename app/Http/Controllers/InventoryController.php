<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::orderBy('item_name', 'asc')->paginate(10);
        return view('admin.inventory.index', compact('inventories'));
    }

    public function create()
    {
        return view('admin.inventory.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:inventory',
            'quantity' => 'required|integer|min:1',
            'condition' => 'required|in:baik,rusak_ringan,rusak_berat',
            'location' => 'required|string|max:255',
            'purchase_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        Inventory::create($validated);

        return redirect()->route('admin.inventory.index')->with('success', 'Aset inventaris berhasil ditambahkan.');
    }

    public function edit(Inventory $inventory)
    {
        return view('admin.inventory.edit', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:inventory,code,' . $inventory->id,
            'quantity' => 'required|integer|min:1',
            'condition' => 'required|in:baik,rusak_ringan,rusak_berat',
            'location' => 'required|string|max:255',
            'purchase_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $inventory->update($validated);

        return redirect()->route('admin.inventory.index')->with('success', 'Aset inventaris berhasil diperbarui.');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('admin.inventory.index')->with('success', 'Aset inventaris berhasil dihapus.');
    }
}
