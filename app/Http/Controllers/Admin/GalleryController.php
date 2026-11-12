<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Gallery;
use App\Models\GalleryCategory;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with('category')->orderBy('order')->paginate(12);
        $categories = GalleryCategory::all();
        return view('admin.galleries.index', compact('galleries', 'categories'));
    }

    public function create()
    {
        $categories = GalleryCategory::all();
        return view('admin.galleries.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:gallery_categories,id',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'order' => 'nullable|integer',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('gallery', 'public');
        }

        Gallery::create([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'description' => $validated['description'],
            'date' => $validated['date'],
            'image' => $imagePath,
            'order' => $validated['order'] ?? 0,
        ]);

        return redirect()->route('admin.galleries.index')->with('success', 'Foto galeri berhasil ditambahkan!');
    }

    public function edit(Gallery $gallery)
    {
        $categories = GalleryCategory::all();
        return view('admin.galleries.edit', compact('gallery', 'categories'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:gallery_categories,id',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($gallery->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($gallery->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($gallery->image);
            }
            $gallery->image = $request->file('image')->store('gallery', 'public');
        }

        $gallery->title = $validated['title'];
        $gallery->category_id = $validated['category_id'];
        $gallery->description = $validated['description'];
        $gallery->date = $validated['date'];
        $gallery->order = $validated['order'] ?? 0;
        $gallery->save();

        return redirect()->route('admin.galleries.index')->with('success', 'Foto galeri berhasil diperbarui!');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($gallery->image)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($gallery->image);
        }
        $gallery->delete();
        return redirect()->route('admin.galleries.index')->with('success', 'Foto galeri berhasil dihapus!');
    }

    // Kelola Kategori Galeri
    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        GalleryCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return back()->with('success', 'Kategori galeri berhasil dibuat!');
    }

    public function destroyCategory(GalleryCategory $category)
    {
        $category->delete();
        return back()->with('success', 'Kategori galeri berhasil dihapus!');
    }
}

