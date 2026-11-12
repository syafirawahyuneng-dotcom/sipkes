<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportService;

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
            'description' => 'required|string',
            'benefits_text' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ]);

        $benefits = array_filter(array_map('trim', explode("\n", $request->input('benefits_text', ''))));

        SupportService::create([
            'title' => $validated['title'],
            'icon' => $validated['icon'],
            'summary' => $validated['summary'],
            'description' => $validated['description'],
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
            'description' => 'required|string',
            'benefits_text' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ]);

        $benefits = array_filter(array_map('trim', explode("\n", $request->input('benefits_text', ''))));

        $support_service->update([
            'title' => $validated['title'],
            'icon' => $validated['icon'],
            'summary' => $validated['summary'],
            'description' => $validated['description'],
            'benefits' => array_values($benefits),
            'is_active' => $request->has('is_active'),
            'order' => $validated['order'] ?? 0,
        ]);

        return redirect()->route('admin.support-services.index')->with('success', 'Layanan pendukung berhasil diperbarui!');
    }

    public function destroy(SupportService $support_service)
    {
        $support_service->delete();
        return redirect()->route('admin.support-services.index')->with('success', 'Layanan pendukung berhasil dihapus!');
    }
}

