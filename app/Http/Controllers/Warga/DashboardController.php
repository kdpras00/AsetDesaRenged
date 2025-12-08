<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Letter;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'active_loans' => $user->loans()->whereIn('status', ['pending', 'approved'])->count(),
            'pending_letters' => $user->letters()->pending()->count(),
            'verified_letters' => $user->letters()->verified()->count(),
        ];

        $recent_loans = $user->loans()
            ->with('asset')
            ->latest()
            ->take(5)
            ->get();

        $recent_letters = $user->letters()
            ->with('letterType')
            ->latest()
            ->take(5)
            ->get();

        return view('warga.dashboard', compact('stats', 'recent_loans', 'recent_letters'));
    }
}
