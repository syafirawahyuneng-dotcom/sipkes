<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advantage;

class AdvantageController extends Controller
{
    public function index()
    {
        $advantages = Advantage::orderBy('order')->get();
        return view('admin.advantages.index', compact('advantages'));
    }

    public function create()
    {
        return view('admin.advantages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'description' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        $validated['order'] = $validated['order'] ?? 0;
        Advantage::create($validated);

        return redirect()->route('admin.advantages.index')->with('success', 'Keunggulan baru berhasil ditambahkan!');
    }

    public function edit(Advantage $advantage)
    {
        return view('admin.advantages.edit', compact('advantage'));
    }

    public function update(Request $request, Advantage $advantage)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'description' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        $advantage->update($validated);
        return redirect()->route('admin.advantages.index')->with('success', 'Keunggulan berhasil diperbarui!');
    }

    public function destroy(Advantage $advantage)
    {
        $advantage->delete();
        return redirect()->route('admin.advantages.index')->with('success', 'Keunggulan berhasil dihapus!');
    }
}

