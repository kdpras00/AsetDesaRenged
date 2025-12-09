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

        // Chart 1: Asset Condition Distribution
        $asset_conditions = Asset::select('condition', \DB::raw('count(*) as total'))
            ->groupBy('condition')
            ->pluck('total', 'condition')
            ->toArray();
            
        $asset_chart = [
            'labels' => ['Baik', 'Rusak Ringan', 'Rusak Berat'],
            'data' => [
                $asset_conditions['baik'] ?? 0,
                $asset_conditions['rusak_ringan'] ?? 0,
                $asset_conditions['rusak_berat'] ?? 0,
            ]
        ];

        // Chart 2: Recent Letters Trend (Last 6 Months)
        $monthly_letters = Letter::select(
            \DB::raw('DATE_FORMAT(request_date, "%Y-%m") as month'),
            \DB::raw('count(*) as total')
        )
        ->where('request_date', '>=', now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month')
        ->toArray();

        // Fill missing months with 0
        $labels = [];
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $labels[] = \Carbon\Carbon::parse($month)->translatedFormat('F'); // Month Name
            $data[] = $monthly_letters[$month] ?? 0;
        }

        $letter_chart = [
            'labels' => $labels,
            'data' => $data,
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

        return view('operator.dashboard', compact('stats', 'recent_loans', 'recent_letters', 'asset_chart', 'letter_chart'));
    }
}
