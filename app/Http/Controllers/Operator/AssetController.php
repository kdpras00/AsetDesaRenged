<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assets = Asset::with('category')->latest()->paginate(10);
        return view('operator.assets.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = AssetCategory::all();
        return view('operator.assets.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:assets,code',
            'category_id' => 'required|exists:asset_categories,id',
            'description' => 'nullable|string',
            'condition' => 'required|in:baik,rusak_ringan,rusak_berat',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric',
            'location' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048', // 2MB Max
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('assets', 'public');
        }

        // Set default status based on condition
        $validated['status'] = $validated['condition'] === 'baik' ? 'tersedia' : 'maintenance';

        Asset::create($validated);

        return redirect()->route('operator.assets.index')->with('success', 'Aset berhasil didaftarkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Maybe modal view or separate page
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        $categories = AssetCategory::all();
        return view('operator.assets.edit', compact('asset', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:assets,code,' . $asset->id,
            'category_id' => 'required|exists:asset_categories,id',
            'description' => 'nullable|string',
            'condition' => 'required|in:baik,rusak_ringan,rusak_berat',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric',
            'location' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($asset->image) {
                Storage::disk('public')->delete($asset->image);
            }
            $validated['image'] = $request->file('image')->store('assets', 'public');
        }

        $asset->update($validated);

        return redirect()->route('operator.assets.index')->with('success', 'Data aset berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        if ($asset->image) {
            Storage::disk('public')->delete($asset->image);
        }
        
        $asset->delete();

        return redirect()->route('operator.assets.index')->with('success', 'Aset berhasil dihapus.');
    }
}
