<?php

namespace App\Http\Controllers;

use App\Models\ZisRecord;
use Illuminate\Http\Request;

class ZisController extends Controller
{
    public function index(Request $request)
    {
        $query = ZisRecord::orderBy('date_recorded', 'desc')->orderBy('id', 'desc');

        if ($request->filled('person_type')) {
            $query->where('person_type', $request->person_type);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $records = $query->paginate(15)->withQueryString();

        $totalMuzakkiMoney = ZisRecord::where('person_type', 'muzakki')->whereNotNull('amount_money')->sum('amount_money');
        $totalMuzakkiRice = ZisRecord::where('person_type', 'muzakki')->whereNotNull('amount_rice')->sum('amount_rice');
        $totalMustahikMoney = ZisRecord::where('person_type', 'mustahik')->whereNotNull('amount_money')->sum('amount_money');
        $totalMustahikRice = ZisRecord::where('person_type', 'mustahik')->whereNotNull('amount_rice')->sum('amount_rice');

        return view('admin.zis.index', compact(
            'records',
            'totalMuzakkiMoney', 'totalMuzakkiRice',
            'totalMustahikMoney', 'totalMustahikRice'
        ));
    }

    public function create()
    {
        return view('admin.zis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:zakat_fitrah_uang,zakat_fitrah_beras,zakat_maal,infaq,sedekah',
            'person_type' => 'required|in:muzakki,mustahik',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'amount_money' => 'nullable|numeric|min:0',
            'amount_rice' => 'nullable|numeric|min:0',
            'date_recorded' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        ZisRecord::create($validated);

        return redirect()->route('admin.zis.index')->with('success', 'Catatan ZIS berhasil disimpan.');
    }

    public function edit(ZisRecord $zi)
    {
        $record = $zi;
        return view('admin.zis.edit', compact('record'));
    }

    public function update(Request $request, ZisRecord $zi)
    {
        $validated = $request->validate([
            'type' => 'required|in:zakat_fitrah_uang,zakat_fitrah_beras,zakat_maal,infaq,sedekah',
            'person_type' => 'required|in:muzakki,mustahik',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'amount_money' => 'nullable|numeric|min:0',
            'amount_rice' => 'nullable|numeric|min:0',
            'date_recorded' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $zi->update($validated);

        return redirect()->route('admin.zis.index')->with('success', 'Catatan ZIS berhasil diperbarui.');
    }

    public function destroy(ZisRecord $zi)
    {
        $zi->delete();
        return redirect()->route('admin.zis.index')->with('success', 'Catatan ZIS berhasil dihapus.');
    }
}
