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

        // Logic Change: Stock is ALREADY decremented during Request.
        // So we just approve it. No stock check needed (unless we want to verify it didn't go negative, but transaction handles that).

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

        if ($loan->status === 'pending') {
             // If Pending request is rejected, we MUST Restore Stock
             DB::transaction(function () use ($loan, $request) {
                $loan->update([
                    'status' => 'rejected',
                    'operator_id' => auth()->id(),
                    'rejection_reason' => $request->reason,
                ]);

                // Restore Stock
                $loan->asset->increment('quantity', $loan->quantity);
             });
        } elseif ($loan->status === 'returning') {
             // If "Returning" claim is rejected (e.g., item broken/missing),
             // We revert status to 'approved' (Active Loan) so it stays "Borrowed".
             // We do NOT restore stock.
             $loan->update([
                'status' => 'approved', // Revert to borrowed state
                'operator_id' => auth()->id(),
                'rejection_reason' => $request->reason, // Log why return was rejected
             ]);
             return redirect()->back()->with('warning', 'Pengajuan pengembalian ditolak. Status kembali menjadi "Dipinjam".');
        } else {
             return back()->with('error', 'Status peminjaman tidak valid untuk ditolak.');
        }

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

        DB::transaction(function () use ($loan) {
            $loan->update([
                'status' => 'returned',
                'actual_return_date' => now(),
            ]);

            // Restore Stock
            $loan->asset->increment('quantity', $loan->quantity);
        });

        return redirect()->back()->with('success', 'Aset telah dikembalikan.');
    }
}
