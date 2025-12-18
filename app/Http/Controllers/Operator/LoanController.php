<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Notifications\LoanStatusUpdated; // Import Notification

class LoanController extends Controller
{
    /**
     * Display a listing of loans.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        
        $loans = Loan::with(['user', 'asset'])
            ->when($status, function ($query) use ($status) {
                if ($status === 'history') {
                    return $query->whereIn('status', ['rejected', 'returned']);
                }
                if ($status === 'pending') {
                     return $query->whereIn('status', ['pending', 'returning']);
                }
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('operator.loans.index', compact('loans', 'status'));
    }

    /**
     * Approve the specific loan.
     */
    public function approve(Request $request, Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Status peminjaman tidak valid untuk disetujui.');
        }

        // Strict Stock Validation
        // Calculate current availability excluding this loan (it's pending, so already counted as 'borrowed' in our logic? 
        // Wait, our getAvailableQuantity subtracts PENDING and APPROVED.
        // So rentable_stock ALREADY subtracts this current pending loan?
        // Let's re-verify: 
        // $borrowed = loans where status IN [pending, approved].
        // So yes, THIS loan is already subtracted.
        // But logically, if we want to check if it CAN be approved, we should check if (Total - Others) >= Request.
        // Or simply: check if rentable_stock >= 0.
        // If rentable_stock is currently calculated as (Total - All Pending/Approved), 
        // then if it's negative, it means we have over-subscribed.
        
        // Let's refine the Asset logic first or handle it here correctly.
        // Actually, for better UX:
        // Available for NEW requests = Total - (Approved + Pending).
        // Validation for APPROVAL:
        // Check if (Total - (Approved + Other Pending)) >= This Request.
        
        // Let's use a cleaner approach:
        // real_available = asset->quantity - (loans where status='approved' OR (status='pending' AND id != current_id))
        
        // Check availability for this loan's specific date range
        // We pass the current loan ID to exclude it from the "already borrowed" sum if it was somehow counted (though pending IS counted normally)
        // Actually, our getAvailableStock excludes nothing by default.
        // But since this loan is PENDING, it IS returned by the query.
        // So we MUST exclude this current loan ID to see if there is room *for it* to be approved.
        // Wait.
        // If Total = 10. This loan = 5. Status = Pending.
        // Query "overlaps" will find THIS loan (5).
        // So Borrowed = 5. Available = 5.
        // If we want to check if we can approve it?
        // Logic: Is (Available IF we ignore this loan) >= This Loan Qty?
        // Yes.
        
        $availableStock = $loan->asset->getAvailableStockForDateRange($loan->loan_date, $loan->return_date, $loan->id);
        
        if ($availableStock < $loan->quantity) {
             return back()->with('error', "Gagal! Stok aset tidak mencukupi untuk periode tersebut. Tersedia: {$availableStock}, Permintaan: {$loan->quantity}");
        }

        DB::transaction(function () use ($loan) {
            $loan->update([
                'status' => 'approved',
                'operator_id' => auth()->id(),
                'operator_notes' => 'Disetujui oleh operator.'
            ]);
            
            // Send Notification
            $loan->user->notify(new LoanStatusUpdated($loan, 'approved'));
        });

        return redirect()->back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    /**
     * Reject the specific loan.
     */
    public function reject(Request $request, Loan $loan)
    {
        $request->validate(['reason' => 'required|string|max:255']);

        if ($loan->status !== 'pending') {
            return back()->with('error', 'Status peminjaman tidak valid untuk ditolak.');
        }

        $loan->update([
            'status' => 'rejected',
            'operator_id' => auth()->id(),
            'rejection_reason' => $request->reason,
        ]);

        // Send Notification
        $loan->user->notify(new LoanStatusUpdated($loan, 'rejected'));

        return redirect()->back()->with('success', 'Peminjaman berhasil ditolak.');
    }

    /**
     * Mark loan as returned.
     */
    public function markreturned(Loan $loan)
    {
        if (!in_array($loan->status, ['approved', 'returning'])) {
            return back()->with('error', 'Status peminjaman tidak valid untuk dikembalikan.');
        }

        $loan->update([
            'status' => 'returned',
            'actual_return_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Aset telah dikembalikan.');
    }
}
