<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\PricingPlan;

class PricingPlanController extends Controller
{
    public function index()
    {
        $plans = PricingPlan::orderBy('order')->get();
        return view('admin.pricing.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.pricing.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'period' => 'required|string|max:50',
            'badge' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'features_text' => 'nullable|string',
            'terms_text' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ]);

        $features = array_filter(array_map('trim', explode("\n", $request->input('features_text', ''))));
        $terms = array_filter(array_map('trim', explode("\n", $request->input('terms_text', ''))));

        PricingPlan::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'price' => $validated['price'],
            'period' => $validated['period'],
            'badge' => $validated['badge'],
            'description' => $validated['description'],
            'features_list' => array_values($features),
            'terms' => array_values($terms),
            'is_active' => $request->has('is_active'),
            'order' => $validated['order'] ?? 0,
        ]);

        return redirect()->route('admin.pricing.index')->with('success', 'Paket harga berhasil ditambahkan!');
    }

    public function edit(PricingPlan $pricing)
    {
        $plan = $pricing;
        return view('admin.pricing.edit', compact('plan'));
    }

    public function update(Request $request, PricingPlan $pricing)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'period' => 'required|string|max:50',
            'badge' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'features_text' => 'nullable|string',
            'terms_text' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ]);

        $features = array_filter(array_map('trim', explode("\n", $request->input('features_text', ''))));
        $terms = array_filter(array_map('trim', explode("\n", $request->input('terms_text', ''))));

        $pricing->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'price' => $validated['price'],
            'period' => $validated['period'],
            'badge' => $validated['badge'],
            'description' => $validated['description'],
            'features_list' => array_values($features),
            'terms' => array_values($terms),
            'is_active' => $request->has('is_active'),
            'order' => $validated['order'] ?? 0,
        ]);

        return redirect()->route('admin.pricing.index')->with('success', 'Paket harga berhasil diperbarui!');
    }

    public function destroy(PricingPlan $pricing)
    {
        $pricing->delete();
        return redirect()->route('admin.pricing.index')->with('success', 'Paket harga berhasil dihapus!');
    }
}

