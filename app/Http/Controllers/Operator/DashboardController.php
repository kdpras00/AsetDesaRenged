<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Loan;
use App\Models\Letter;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_assets' => Asset::count(),
            'available_assets' => Asset::available()->count(),
            'pending_loans' => Loan::pending()->count(),
            'pending_letters' => Letter::pending()->count(),
            'processed_letters' => Letter::processed()->count(),
        ];

        $recent_loans = Loan::with(['user', 'asset'])
            ->pending()
            ->latest()
            ->take(5)
            ->get();

        $recent_letters = Letter::with(['user', 'letterType'])
            ->pending()
            ->latest()
            ->take(5)
            ->get();

        return view('operator.dashboard', compact('stats', 'recent_loans', 'recent_letters'));
    }
}
