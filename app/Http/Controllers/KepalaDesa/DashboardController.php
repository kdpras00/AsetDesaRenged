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

        // Chart: Verification Status (Verified vs Rejected)
        $letter_status = Letter::select('status', \DB::raw('count(*) as total'))
            ->whereIn('status', ['verified', 'rejected'])
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $verification_chart = [
            'data' => [
                $letter_status['verified'] ?? 0,
                $letter_status['rejected'] ?? 0,
            ]
        ];

        $recent_letters = Letter::with(['user', 'letterType', 'operator'])
            ->processed()
            ->latest()
            ->take(5)
            ->get();

        return view('kepala-desa.dashboard', compact('stats', 'recent_letters', 'verification_chart'));
    }
}
