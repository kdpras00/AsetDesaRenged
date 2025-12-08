<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Check availability
        // Simple logic: Check validation against current stock if we were tracking live stock
        // For now, just approve. Ideally we subtract available stock or check it.
        // Let's assume Asset has 'quantity' as total. We can calculate availability if needed.
        // For this version, we trust the operator's judgment on physical availability.

        DB::transaction(function () use ($loan) {
            $loan->update([
                'status' => 'approved',
                'operator_id' => auth()->id(),
                'operator_notes' => 'Disetujui oleh operator.'
            ]);
            
            // Optional: Decrement asset availability logic here if strict tracking is required
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

        return redirect()->back()->with('success', 'Peminjaman berhasil ditolak.');
    }

    /**
     * Mark loan as returned.
     */
    public function markreturned(Loan $loan)
    {
        if ($loan->status !== 'approved') {
            return back()->with('error', 'Hanya peminjaman aktif yang bisa dikembalikan.');
        }

        $loan->update([
            'status' => 'returned',
            'actual_return_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Aset telah dikembalikan.');
    }
}
