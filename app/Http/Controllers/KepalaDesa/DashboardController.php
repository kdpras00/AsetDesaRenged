<?php

namespace App\Http\Controllers\KepalaDesa;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Letter;
use App\Models\Loan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_assets' => Asset::count(),
            'total_asset_value' => Asset::sum('purchase_price'),
            'pending_verification' => Letter::processed()->count(),
            'verified_letters' => Letter::verified()->count(),
            'active_loans' => Loan::approved()->count(),
        ];

        $recent_letters = Letter::with(['user', 'letterType', 'operator'])
            ->processed()
            ->latest()
            ->take(5)
            ->get();

        return view('kepala-desa.dashboard', compact('stats', 'recent_letters'));
    }
}
