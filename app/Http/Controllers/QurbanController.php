<?php

namespace App\Http\Controllers;

use App\Models\Qurban;
use Illuminate\Http\Request;

class QurbanController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', '1447 H / 2026');
        
        $query = Qurban::where('year', $year)->orderBy('type', 'asc')->orderBy('group_number', 'asc');
        
        $participants = $query->paginate(15)->withQueryString();
        
        // Summaries
        $totalSapi = Qurban::where('year', $year)->where('type', 'sapi')->count();
        $totalKambing = Qurban::where('year', $year)->where('type', 'kambing')->count();
        $totalPaidFunds = Qurban::where('year', $year)->where('status', 'lunas')->sum('amount_paid');
        $totalUnpaidFunds = Qurban::where('year', $year)->where('status', 'belum_lunas')->sum('amount_paid');
        
        // Group count (usually 7 people per cow group)
        $sapiGroups = Qurban::where('year', $year)
            ->where('type', 'sapi')
            ->whereNotNull('group_number')
            ->get()
            ->groupBy('group_number');

        return view('admin.qurbans.index', compact(
            'participants', 'totalSapi', 'totalKambing', 
            'totalPaidFunds', 'totalUnpaidFunds', 'sapiGroups', 'year'
        ));
    }

    public function create()
    {
        return view('admin.qurbans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|string|max:100',
            'participant_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:100',
            'type' => 'required|in:sapi,kambing',
            'group_number' => 'nullable|integer|min:1',
            'amount_paid' => 'required|numeric|min:0',
            'status' => 'required|in:lunas,belum_lunas',
            'notes' => 'nullable|string',
        ]);

        Qurban::create($validated);

        return redirect()->route('admin.qurbans.index', ['year' => $request->year])
            ->with('success', 'Peserta Qurban berhasil didaftarkan.');
    }

    public function edit(Qurban $qurban)
    {
        return view('admin.qurbans.edit', compact('qurban'));
    }

    public function update(Request $request, Qurban $qurban)
    {
        $validated = $request->validate([
            'year' => 'required|string|max:100',
            'participant_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:100',
            'type' => 'required|in:sapi,kambing',
            'group_number' => 'nullable|integer|min:1',
            'amount_paid' => 'required|numeric|min:0',
            'status' => 'required|in:lunas,belum_lunas',
            'notes' => 'nullable|string',
        ]);

        $qurban->update($validated);

        return redirect()->route('admin.qurbans.index', ['year' => $request->year])
            ->with('success', 'Data peserta Qurban berhasil diperbarui.');
    }

    public function destroy(Qurban $qurban)
    {
        $year = $qurban->year;
        $qurban->delete();

        return redirect()->route('admin.qurbans.index', ['year' => $year])
            ->with('success', 'Peserta Qurban berhasil dihapus.');
    }
}
