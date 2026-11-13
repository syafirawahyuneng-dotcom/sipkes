<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Gallery;
use App\Models\GalleryCategory;

/**
 * Kelola Berita (sebelumnya Galeri). Memakai tabel `galleries`.
 */
class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with('category')->orderByDesc('date')->orderBy('order')->paginate(12);
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
            'description' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'author' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'order' => 'nullable|integer',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('gallery', 'public');
        }

        Gallery::create([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'] ?? null,
            'description' => $validated['description'] ?? null,
            'content' => $validated['content'] ?? null,
            'author' => $validated['author'] ?? null,
            'date' => $validated['date'] ?? now()->toDateString(),
            'image' => $imagePath ?? '', // kolom image NOT NULL; '' = tanpa gambar
            'order' => $validated['order'] ?? 0,
        ]);

        return redirect()->route('admin.galleries.index')->with('success', 'Berita berhasil diterbitkan!');
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
            'description' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'author' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($gallery->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($gallery->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($gallery->image);
            }
            $gallery->image = $request->file('image')->store('gallery', 'public');
        }

        $gallery->title = $validated['title'];
        $gallery->category_id = $validated['category_id'] ?? null;
        $gallery->description = $validated['description'] ?? null;
        $gallery->content = $validated['content'] ?? null;
        $gallery->author = $validated['author'] ?? null;
        $gallery->date = $validated['date'] ?? null;
        $gallery->order = $validated['order'] ?? 0;
        $gallery->save();

        return redirect()->route('admin.galleries.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($gallery->image)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($gallery->image);
        }
        $gallery->delete();
        return redirect()->route('admin.galleries.index')->with('success', 'Berita berhasil dihapus!');
    }

    // Kelola Kategori Berita
    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        GalleryCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return back()->with('success', 'Kategori berita berhasil dibuat!');
    }

    public function destroyCategory(GalleryCategory $category)
    {
        $category->delete();
        return back()->with('success', 'Kategori berita berhasil dihapus!');
    }
}

