<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Loan;
use App\Models\User;
use App\Notifications\NewLoanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class LoanRequestController extends Controller
{
    /**
     * Display a listing of available assets (Catalog) or User's Loans (History).
     */
    public function index(Request $request)
    {
        // If 'view' param is 'history', show history. Else show catalog.
        $view = $request->get('view', 'catalog');

        if ($view === 'history') {
            $loans = auth()->user()->loans()
                ->with('asset')
                ->latest()
                ->paginate(10);
            return view('warga.loans.history', compact('loans'));
        }

        // Catalog
        $assets = Asset::where('status', 'tersedia')
            ->where('condition', 'baik')
            ->latest()
            ->paginate(12);

        return view('warga.loans.index', compact('assets'));
    }

    /**
     * Show the form for creating a new loan request.
     */
    public function create(Asset $asset)
    {
        if ($asset->status !== 'tersedia') {
            return back()->with('error', 'Aset sedang tidak tersedia (Rusak/Hilang).');
        }
        return view('warga.loans.create', compact('asset'));
    }

    /**
     * Store a newly created loan request in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'loan_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after_or_equal:loan_date',
            'quantity' => 'required|integer|min:1',
            'purpose' => 'required|string|max:500',
        ]);

        $asset = Asset::findOrFail($request->asset_id);
        
        // Check availability for specific date range
        $availableStock = $asset->getAvailableStockForDateRange($request->loan_date, $request->return_date);

        if ($request->quantity > $availableStock) {
             return back()->withInput()->with('error', "Stok tidak mencukupi untuk periode tanggal tersebut. Hanya tersedia {$availableStock} unit.");
        }

        $loan = Loan::create([
            'user_id' => auth()->id(),
            'asset_id' => $request->asset_id,
            'loan_date' => $request->loan_date,
            'return_date' => $request->return_date,
            'quantity' => $request->quantity,
            'purpose' => $request->purpose,
            'status' => 'pending',
        ]);

        // Notify Operators
        $operators = User::where('role', 'operator')
                        ->where('id', '!=', auth()->id())
                        ->get();
        Notification::send($operators, new NewLoanRequest($loan));

        return redirect()->route('warga.loans.index', ['view' => 'history'])->with('success', 'Permintaan peminjaman berhasil diajukan. Menunggu persetujuan.');
    }

    /**
     * Mark loan as returning (Warga initiates return).
     */
    public function return(Loan $loan)
    {
        if ($loan->user_id !== auth()->id()) {
            abort(403);
        }

        if ($loan->status !== 'approved') {
            return back()->with('error', 'Hanya peminjaman aktif yang dapat dikembalikan.');
        }

        $loan->update(['status' => 'returning']);
        
        // Notify Operators (Re-use NewLoanRequest or create new one, let's genericize or just assume Operator checks dashboard)
        // ideally we send notification.
        $operators = User::where('role', 'operator')->get();
        // Notification::send($operators, new LoanReturnInitiated($loan)); // Assuming we might leave this simple for now.

        return back()->with('success', 'Pengajuan pengembalian berhasil. Silakan kembalikan barang ke kantor desa.');
    }
}
