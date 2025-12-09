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
        if ($asset->status !== 'tersedia' || $asset->rentable_stock <= 0) {
            return back()->with('error', 'Aset tidak tersedia atau stok habis.');
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
        
        // Strict stock check using dynamic availability
        if ($request->quantity > $asset->rentable_stock) {
             return back()->withInput()->with('error', 'Jumlah permintaan melebihi stok tersedia. Sisa stok saat ini: ' . $asset->rentable_stock . ' unit.');
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
}
