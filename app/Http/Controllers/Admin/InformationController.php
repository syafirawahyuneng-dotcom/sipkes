<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Information;
use App\Support\ImageUpload;
use Illuminate\Http\Request;

/**
 * Kelola Informasi bergambar (menu publik Fitur & Layanan → Informasi).
 */
class InformationController extends Controller
{
    public function index()
    {
        $items = Information::ordered()->paginate(12);

        return view('admin.information.index', compact('items'));
    }

    public function create()
    {
        return view('admin.information.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request, true);
        $validated['image'] = ImageUpload::replace($request, null, 'information');

        Information::create($validated);

        return redirect()->route('admin.information.index')->with('success', 'Informasi berhasil ditambahkan!');
    }

    public function edit(Information $information)
    {
        return view('admin.information.edit', compact('information'));
    }

    public function update(Request $request, Information $information)
    {
        $validated = $this->validated($request, false);
        $validated['image'] = ImageUpload::replace($request, $information->image, 'information');

        $information->update($validated);

        return redirect()->route('admin.information.index')->with('success', 'Informasi berhasil diperbarui!');
    }

    public function destroy(Information $information)
    {
        ImageUpload::delete($information->image);
        $information->delete();

        return redirect()->route('admin.information.index')->with('success', 'Informasi berhasil dihapus!');
    }

    private function validated(Request $request, bool $creating): array
    {
        $imageRule = $creating
            ? str_replace('nullable', 'required', ImageUpload::RULE)
            : ImageUpload::RULE;

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'date' => 'nullable|date',
            'image' => $imageRule,
            'order' => 'nullable|integer',
        ], ImageUpload::messages('image', 'Foto informasi') + [
            'image.required' => 'Foto informasi wajib diunggah.',
        ]);

        return [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'date' => $validated['date'] ?? now()->toDateString(),
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ];
    }
}
