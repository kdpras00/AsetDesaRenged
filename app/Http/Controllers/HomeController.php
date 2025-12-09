<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Letter;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // If already authenticated, redirect to appropriate dashboard
        if (auth()->check()) {
            $user = auth()->user();
            
            if ($user->isOperator()) {
                return redirect('/operator/dashboard');
            } elseif ($user->isKepalaDesa()) {
                return redirect('/kepala-desa/dashboard');
            } else {
                return redirect('/warga/dashboard');
            }
        }

        return view('public.home');
    }

    public function layanan()
    {
        return view('public.layanan');
    }

    public function statistik()
    {
        $stats = [
            'assets_count' => Asset::count(),
            'assets_value' => Asset::sum('purchase_price'),
            'letters_issued' => Letter::verified()->count(),
            'users_count' => User::count(),
            'warga_count' => User::where('role', 'warga')->count(),
            'asset_categories' => \App\Models\AssetCategory::withCount('assets')->get(),
        ];

        return view('public.stats', compact('stats'));
    }
    public function sejarah()
    {
        return view('public.profile.sejarah');
    }

    public function visiMisi()
    {
        return view('public.profile.visi-misi');
    }

    public function struktur()
    {
        return view('public.profile.struktur');
    }
}
