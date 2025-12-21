<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\LetterType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LetterTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $letterTypes = LetterType::latest()->paginate(10);
        return view('operator.letter-types.index', compact('letterTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('operator.letter-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'description' => 'nullable|string',
            // Simple validation for now, more complex logic for fields JSON might be added later
        ]);

        $slug = Str::slug($request->name);
        
        // Default Config for Dynamic Letters
        $defaultConfig = [
            'letter_number_prefix' => strtoupper($slug),
            'pdf_view' => 'pdf.generic',
            'fields' => [
                 // Standard fields
            ],
             'validation_rules' => []
        ];

        LetterType::create([
            'name' => $request->name,
            'slug' => strtoupper($slug),
            'code' => $request->code,
            'description' => $request->description,
            'form_config' => $defaultConfig,
            // 'requirements' => [], // Default empty or define standard ones
        ]);

        return redirect()->route('operator.letter-types.index')->with('success', 'Jenis Surat berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LetterType $letterType)
    {
        return view('operator.letter-types.edit', compact('letterType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LetterType $letterType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        $slug = Str::slug($request->name);
        
        // We preserve existing config but update prefix if needed, or allow manual config edit in future
        $config = $letterType->form_config;
        if(empty($config)) {
             $config = [
                'letter_number_prefix' => strtoupper($slug),
                'pdf_view' => 'pdf.generic',
                'fields' => [],
                'validation_rules' => []
            ];
        }

        $letterType->update([
            'name' => $request->name,
             // Slug usually shouldn't change to break links, but if name changes drastically? 
             // Let's keep slug stable or update it if they want.
            'slug' => strtoupper($slug),
            'code' => $request->code,
            'description' => $request->description,
            'form_config' => $config,
        ]);

        return redirect()->route('operator.letter-types.index')->with('success', 'Jenis Surat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LetterType $letterType)
    {
        // Prevent deleting if letters exist?
        if($letterType->letters()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus jenis surat ini karena sudah ada permohonan yang menggunakannya.');
        }

        $letterType->delete();
        return redirect()->route('operator.letter-types.index')->with('success', 'Jenis Surat berhasil dihapus.');
    }
}
