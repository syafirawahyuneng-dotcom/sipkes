<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use App\Support\ImageUpload;
use App\Support\RichText;

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
            'image' => ImageUpload::RULE,
            'order' => 'nullable|integer',
        ], ImageUpload::messages('image', 'Gambar berita'));

        $imagePath = ImageUpload::replace($request, null, 'gallery');

        Gallery::create([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'] ?? null,
            'description' => $validated['description'] ?? null,
            'content' => RichText::clean($validated['content'] ?? null),
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
            'image' => ImageUpload::RULE,
            'order' => 'nullable|integer',
        ], ImageUpload::messages('image', 'Gambar berita'));

        // kolom image NOT NULL; '' = tanpa gambar
        $gallery->image = ImageUpload::replace($request, $gallery->image, 'gallery') ?? '';

        $gallery->title = $validated['title'];
        $gallery->category_id = $validated['category_id'] ?? null;
        $gallery->description = $validated['description'] ?? null;
        $gallery->content = RichText::clean($validated['content'] ?? null);
        $gallery->author = $validated['author'] ?? null;
        $gallery->date = $validated['date'] ?? null;
        $gallery->order = $validated['order'] ?? 0;
        $gallery->save();

        return redirect()->route('admin.galleries.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(Gallery $gallery)
    {
        ImageUpload::delete($gallery->image);
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

