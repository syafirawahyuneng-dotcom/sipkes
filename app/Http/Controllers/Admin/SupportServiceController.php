<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportService;
use App\Rules\RichTextRequired;
use App\Support\ImageUpload;
use App\Support\RichText;

class SupportServiceController extends Controller
{
    public function index()
    {
        $services = SupportService::orderBy('order')->get();
        return view('admin.support_services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.support_services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'summary' => 'nullable|string',
            'description' => ['required', 'string', new RichTextRequired('Deskripsi layanan')],
            'image' => ImageUpload::RULE,
            'benefits_text' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ], ImageUpload::messages('image', 'Gambar layanan'));

        $benefits = array_filter(array_map('trim', explode("\n", $request->input('benefits_text', ''))));

        SupportService::create([
            'title' => $validated['title'],
            'icon' => $validated['icon'],
            'summary' => $validated['summary'],
            'description' => RichText::clean($validated['description']),
            'image' => ImageUpload::replace($request, null, 'services'),
            'benefits' => array_values($benefits),
            'is_active' => $request->has('is_active'),
            'order' => $validated['order'] ?? 0,
        ]);

        return redirect()->route('admin.support-services.index')->with('success', 'Layanan pendukung berhasil ditambahkan!');
    }

    public function edit(SupportService $support_service)
    {
        $service = $support_service;
        return view('admin.support_services.edit', compact('service'));
    }

    public function update(Request $request, SupportService $support_service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'summary' => 'nullable|string',
            'description' => ['required', 'string', new RichTextRequired('Deskripsi layanan')],
            'image' => ImageUpload::RULE,
            'benefits_text' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ], ImageUpload::messages('image', 'Gambar layanan'));

        $benefits = array_filter(array_map('trim', explode("\n", $request->input('benefits_text', ''))));

        $support_service->update([
            'title' => $validated['title'],
            'icon' => $validated['icon'],
            'summary' => $validated['summary'],
            'description' => RichText::clean($validated['description']),
            'image' => ImageUpload::replace($request, $support_service->image, 'services'),
            'benefits' => array_values($benefits),
            'is_active' => $request->has('is_active'),
            'order' => $validated['order'] ?? 0,
        ]);

        return redirect()->route('admin.support-services.index')->with('success', 'Layanan pendukung berhasil diperbarui!');
    }

    public function destroy(SupportService $support_service)
    {
        ImageUpload::delete($support_service->image);
        $support_service->delete();
        return redirect()->route('admin.support-services.index')->with('success', 'Layanan pendukung berhasil dihapus!');
    }
}

