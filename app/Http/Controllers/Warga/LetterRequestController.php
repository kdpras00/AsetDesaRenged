<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use App\Models\LetterType;
use App\Models\User;
use App\Notifications\NewLetterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class LetterRequestController extends Controller
{
    /**
     * Display a listing of Letter Types or User's Letter History.
     */
    public function index(Request $request)
    {
        $view = $request->get('view', 'catalog');

        if ($view === 'history') {
            $letters = auth()->user()->letters()
                ->with('letterType')
                ->latest()
                ->paginate(10);
            return view('warga.letters.history', compact('letters'));
        }

        // Catalog
        $letterTypes = LetterType::all(); // Assuming small table, no pagination needed usually
        return view('warga.letters.index', compact('letterTypes'));
    }

    /**
     * Show the form for creating a new letter request.
     */
    public function create(LetterType $type)
    {
        return view('warga.letters.create', compact('type'));
    }

    /**
     * Store a newly created letter request in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'letter_type_id' => 'required|exists:letter_types,id',
            'purpose' => 'required|string|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB
        ]);

        $data = [
            'user_id' => auth()->id(),
            'letter_type_id' => $request->letter_type_id,
            'purpose' => $request->purpose,
            'request_date' => now(),
            'status' => 'pending',
        ];

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        $letter = Letter::create($data);

        // Notify Operators
        $operators = User::where('role', 'operator')->get();
        Notification::send($operators, new NewLetterRequest($letter));

        return redirect()->route('warga.letters.index', ['view' => 'history'])->with('success', 'Permohonan surat berhasil diajukan. Menunggu verifikasi.');
    }
    /**
     * Download the letter as PDF.
     */
    public function download(Letter $letter)
    {
        // Authorization: Warga can only download their own letters
        if ($letter->user_id !== auth()->id()) {
            abort(403);
        }

        // Ideally only verified letters
        if ($letter->status !== 'verified') {
            return back()->with('error', 'Surat belum terverifikasi.');
        }

        $view = \Illuminate\Support\Str::contains(strtolower($letter->letterType->name), 'skck') 
            ? 'pdf.skck' 
            : 'pdf.letter';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView($view, compact('letter'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('Surat-' . str_replace('/', '-', $letter->letter_number) . '.pdf');
    }
}
