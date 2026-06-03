<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Finance::orderBy('transaction_date', 'desc')->orderBy('id', 'desc');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $finances = $query->paginate(15)->withQueryString();

        $totalIn = Finance::where('type', 'in')->sum('amount');
        $totalOut = Finance::where('type', 'out')->sum('amount');
        $balance = $totalIn - $totalOut;

        // Aggregates for weekly, monthly, and yearly reports
        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        if ($driver === 'sqlite') {
            $weeklyRecs = Finance::selectRaw("
                strftime('%Y', transaction_date) as year,
                strftime('%W', transaction_date) as week,
                SUM(CASE WHEN type = 'in' THEN amount ELSE 0 END) as total_in,
                SUM(CASE WHEN type = 'out' THEN amount ELSE 0 END) as total_out
            ")
            ->groupBy('year', 'week')
            ->orderBy('year', 'desc')
            ->orderBy('week', 'desc')
            ->get();

            $monthlyRecs = Finance::selectRaw("
                strftime('%Y', transaction_date) as year,
                strftime('%m', transaction_date) as month,
                SUM(CASE WHEN type = 'in' THEN amount ELSE 0 END) as total_in,
                SUM(CASE WHEN type = 'out' THEN amount ELSE 0 END) as total_out
            ")
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

            $yearlyRecs = Finance::selectRaw("
                strftime('%Y', transaction_date) as year,
                SUM(CASE WHEN type = 'in' THEN amount ELSE 0 END) as total_in,
                SUM(CASE WHEN type = 'out' THEN amount ELSE 0 END) as total_out
            ")
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();
        } else {
            $weeklyRecs = Finance::selectRaw("
                YEAR(transaction_date) as year,
                WEEK(transaction_date, 1) as week,
                SUM(CASE WHEN type = 'in' THEN amount ELSE 0 END) as total_in,
                SUM(CASE WHEN type = 'out' THEN amount ELSE 0 END) as total_out
            ")
            ->groupBy('year', 'week')
            ->orderBy('year', 'desc')
            ->orderBy('week', 'desc')
            ->get();

            $monthlyRecs = Finance::selectRaw("
                YEAR(transaction_date) as year,
                MONTH(transaction_date) as month,
                SUM(CASE WHEN type = 'in' THEN amount ELSE 0 END) as total_in,
                SUM(CASE WHEN type = 'out' THEN amount ELSE 0 END) as total_out
            ")
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

            $yearlyRecs = Finance::selectRaw("
                YEAR(transaction_date) as year,
                SUM(CASE WHEN type = 'in' THEN amount ELSE 0 END) as total_in,
                SUM(CASE WHEN type = 'out' THEN amount ELSE 0 END) as total_out
            ")
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();
        }

        return view('admin.finances.index', compact(
            'finances', 'totalIn', 'totalOut', 'balance', 
            'weeklyRecs', 'monthlyRecs', 'yearlyRecs'
        ));
    }

    public function create()
    {
        return view('admin.finances.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:in,out',
            'category' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string',
            'transaction_date' => 'required|date',
        ]);

        $validated['user_id'] = Auth::id();

        Finance::create($validated);

        return redirect()->route('admin.finances.index')->with('success', 'Transaksi keuangan berhasil dicatat.');
    }

    public function edit(Finance $finance)
    {
        return view('admin.finances.edit', compact('finance'));
    }

    public function update(Request $request, Finance $finance)
    {
        $validated = $request->validate([
            'type' => 'required|in:in,out',
            'category' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string',
            'transaction_date' => 'required|date',
        ]);

        $finance->update($validated);

        return redirect()->route('admin.finances.index')->with('success', 'Transaksi keuangan berhasil diperbarui.');
    }

    public function destroy(Finance $finance)
    {
        $finance->delete();
        return redirect()->route('admin.finances.index')->with('success', 'Transaksi keuangan berhasil dihapus.');
    }
}
