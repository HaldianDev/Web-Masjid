<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    // Public: Store donation and redirect to checkout simulation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:100',
            'donor_phone' => 'nullable|string|max:20',
            'amount' => 'required|numeric|min:1000',
            'payment_method' => 'required|string|in:qris,bca,mandiri,gopay,ovo',
            'notes' => 'nullable|string',
        ]);

        $referenceId = 'TX-' . strtoupper($validated['payment_method']) . '-' . rand(100000, 999999);

        $donation = Donation::create([
            'donor_name' => $validated['donor_name'],
            'donor_phone' => $validated['donor_phone'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'status' => 'pending',
            'reference_id' => $referenceId,
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('donation.checkout', $referenceId);
    }

    // Public: Render simulated checkout page
    public function checkout($referenceId)
    {
        $donation = Donation::where('reference_id', $referenceId)->firstOrFail();

        if ($donation->status === 'success') {
            return redirect()->route('donation.receipt', $referenceId);
        }

        return view('donation.checkout', compact('donation'));
    }

    // Public/AJAX: Simulate payment completion and log in finances
    public function simulateSuccess(Request $request, $referenceId)
    {
        $donation = Donation::where('reference_id', $referenceId)->firstOrFail();

        if ($donation->status === 'pending') {
            $donation->update(['status' => 'success']);

            // Insert into finances ledger automatically
            // If logged in, associate with that user, else associate with Super Admin (user_id = 1)
            $userId = Auth::check() ? Auth::id() : 1;

            Finance::create([
                'type' => 'in',
                'category' => 'donasi_digital',
                'amount' => $donation->amount,
                'description' => "Donasi Digital Online ({$donation->payment_method}) dari {$donation->donor_name} - Ref: {$donation->reference_id}",
                'transaction_date' => now()->toDateString(),
                'user_id' => $userId,
            ]);
        }

        return response()->json(['success' => true]);
    }

    // Public: Show donation receipt page
    public function receipt($referenceId)
    {
        $donation = Donation::where('reference_id', $referenceId)->firstOrFail();

        if ($donation->status !== 'success') {
            return redirect()->route('donation.checkout', $referenceId);
        }

        return view('donation.receipt', compact('donation'));
    }

    // Admin: List all donations in dashboard
    public function index()
    {
        $donations = Donation::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.donations.index', compact('donations'));
    }
}
