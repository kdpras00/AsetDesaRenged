<?php

namespace App\Http\Controllers\KepalaDesa;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use Illuminate\Http\Request;

class LetterVerificationController extends Controller
{
    /**
     * Display a listing of letters pending verification.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'processed');

        $letters = Letter::with(['user', 'letterType', 'operator'])
            ->when($status, function ($query) use ($status) {
                if ($status === 'history') {
                    return $query->whereIn('status', ['verified', 'rejected']);
                }
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('kepala-desa.letters.index', compact('letters', 'status'));
    }

    /**
     * Verify and sign the letter.
     */
    public function verify(Request $request, Letter $letter)
    {
        if ($letter->status !== 'processed') {
            return back()->with('error', 'Hanya surat yang sudah diproses admin yang dapat diverifikasi.');
        }

        // Generate Verification Code (Simple for now)
        $verificationCode = strtoupper(uniqid('VERIFY-'));

        $letter->update([
            'status' => 'verified',
            'kepala_desa_id' => auth()->id(),
            'approved_date' => now(),
            'verification_code' => $verificationCode,
            // QR Code logic normally goes here
        ]);

        return redirect()->back()->with('success', 'Surat berhasil diverifikasi dan ditandatangani secara digital.');
    }

    /**
     * Reject the letter.
     */
    public function reject(Request $request, Letter $letter)
    {
        $request->validate(['reason' => 'required|string|max:255']);

        if ($letter->status !== 'processed') {
            return back()->with('error', 'Status surat tidak valid.');
        }

        $letter->update([
            'status' => 'rejected',
            'kepala_desa_id' => auth()->id(),
            'rejection_reason' => $request->reason,
        ]);

        return redirect()->back()->with('success', 'Pengajuan surat ditolak.');
    }
}
