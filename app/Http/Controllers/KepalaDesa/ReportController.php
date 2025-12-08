<?php

namespace App\Http\Controllers\KepalaDesa;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Letter;
use App\Models\Loan;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display reports.
     */
    public function index(Request $request)
    {
        $type = $request->get('type', 'assets');
        
        $data = [];
        
        if ($type === 'assets') {
             $data = Asset::with('category')->latest()->get();
        } elseif ($type === 'loans') {
             $data = Loan::with(['user', 'asset'])->latest()->get();
        } elseif ($type === 'letters') {
             $data = Letter::with(['user', 'letterType'])->latest()->get();
        }

        return view('kepala-desa.reports.index', compact('data', 'type'));
    }
}
