<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feature;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::orderBy('order')->paginate(20);
        return view('admin.feature.index', compact('features'));
    }

    public function create()
    {
        return view('admin.feature.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'icon' => 'nullable|string|max:100',
            'description' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_featured'] = $request->has('is_featured');

        Feature::create($validated);

        return redirect()->route('admin.features.index')->with('success', 'Fitur RME berhasil ditambahkan!');
    }

    public function edit(Feature $feature)
    {
        return view('admin.feature.edit', compact('feature'));
    }

    public function update(Request $request, Feature $feature)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'icon' => 'nullable|string|max:100',
            'description' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_featured'] = $request->has('is_featured');

        $feature->update($validated);

        return redirect()->route('admin.features.index')->with('success', 'Fitur RME berhasil diperbarui!');
    }

    public function destroy(Feature $feature)
    {
        $feature->delete();
        return redirect()->route('admin.features.index')->with('success', 'Fitur RME berhasil dihapus!');
    }
}

