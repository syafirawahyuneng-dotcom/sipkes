<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feature;
use App\Rules\RichTextRequired;
use App\Support\ImageUpload;
use App\Support\RichText;

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
            'description' => ['required', 'string', new RichTextRequired('Deskripsi fitur')],
            'image' => ImageUpload::RULE,
            'users' => 'nullable|string',
            'functions' => 'nullable|string',
            'benefits' => 'nullable|string',
            'workflow' => 'nullable|string',
            'order' => 'nullable|integer',
        ], ImageUpload::messages('image', 'Gambar fitur'));

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_featured'] = $request->has('is_featured');
        $validated['description'] = RichText::clean($validated['description']);
        $validated['image'] = ImageUpload::replace($request, null, 'features');

        Feature::create($validated);

        return redirect()->route('admin.features.index')->with('success', 'Fitur berhasil ditambahkan!');
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
            'description' => ['required', 'string', new RichTextRequired('Deskripsi fitur')],
            'image' => ImageUpload::RULE,
            'users' => 'nullable|string',
            'functions' => 'nullable|string',
            'benefits' => 'nullable|string',
            'workflow' => 'nullable|string',
            'order' => 'nullable|integer',
        ], ImageUpload::messages('image', 'Gambar fitur'));

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_featured'] = $request->has('is_featured');
        $validated['description'] = RichText::clean($validated['description']);
        $validated['image'] = ImageUpload::replace($request, $feature->image, 'features');

        $feature->update($validated);

        return redirect()->route('admin.features.index')->with('success', 'Fitur berhasil diperbarui!');
    }

    public function destroy(Feature $feature)
    {
        ImageUpload::delete($feature->image);
        $feature->delete();
        return redirect()->route('admin.features.index')->with('success', 'Fitur berhasil dihapus!');
    }
}

