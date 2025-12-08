<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index()
    {
        return view('public.verification');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $letter = Letter::where('verification_code', strtoupper($request->code))
            ->with(['user', 'kepalaDesa', 'letterType'])
            ->first();

        if (!$letter) {
            return back()->with('error', 'Kode verifikasi tidak ditemukan. Pastikan kode yang Anda masukkan benar.');
        }

        if ($letter->status !== 'verified') {
            return back()->with('error', 'Surat ini belum diverifikasi atau ditolak.');
        }

        return view('public.verification-result', compact('letter'));
    }
}
