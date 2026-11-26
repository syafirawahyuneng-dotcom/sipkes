<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ContactInfo;
use App\Rules\RichTextRequired;
use App\Support\ImageUpload;
use App\Support\RichText;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Kelola Artikel (PRD Fase 2 · A-08–A-12): CRUD, draf/terbit/terjadwal,
 * pratinjau, dan kategori artikel.
 */
class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with('category')->latest('updated_at');

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->status === 'draft') {
            $query->where('status', Article::STATUS_DRAFT);
        } elseif ($request->status === 'scheduled') {
            $query->where('status', Article::STATUS_PUBLISHED)->where('published_at', '>', now());
        } elseif ($request->status === 'published') {
            $query->published();
        }

        $articles = $query->paginate(15)->withQueryString();
        $categories = ArticleCategory::withCount('articles')->orderBy('name')->get();

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    public function create()
    {
        $categories = ArticleCategory::orderBy('name')->get();

        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['cover_image'] = ImageUpload::replace($request, null, 'articles', 'cover_image');
        $data['admin_id'] = Auth::guard('admin')->id();

        $article = Article::create($data);

        return redirect()->route('admin.articles.index')
            ->with('success', $article->isPublished() ? 'Artikel berhasil diterbitkan!' : 'Artikel berhasil disimpan sebagai ' . strtolower($article->state_label) . '.');
    }

    public function edit(Article $article)
    {
        $categories = ArticleCategory::orderBy('name')->get();

        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $this->validated($request, $article);
        $data['cover_image'] = ImageUpload::replace($request, $article->cover_image, 'articles', 'cover_image');

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy(Article $article)
    {
        ImageUpload::delete($article->cover_image);
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus!');
    }

    /** Terbitkan ↔ kembalikan ke draf langsung dari daftar artikel. */
    public function togglePublish(Article $article)
    {
        if ($article->status === Article::STATUS_PUBLISHED) {
            $article->update(['status' => Article::STATUS_DRAFT]);

            return back()->with('success', 'Artikel "' . $article->title . '" dikembalikan ke draf.');
        }

        $article->update([
            'status' => Article::STATUS_PUBLISHED,
            'published_at' => $article->published_at ?? now(),
        ]);

        return back()->with('success', $article->published_at->isFuture()
            ? 'Artikel "' . $article->title . '" dijadwalkan terbit ' . $article->published_at->locale('id')->isoFormat('D MMMM Y HH:mm') . '.'
            : 'Artikel "' . $article->title . '" berhasil diterbitkan!');
    }

    /** Pratinjau artikel (termasuk draf) dengan tampilan portal. */
    public function preview(Article $article)
    {
        $article->load('category');
        $related = collect();
        $contact = ContactInfo::first();
        $preview = true;

        // Pratinjau admin: metadata tetap lengkap, tetapi tidak boleh diindeks.
        \App\Support\Seo::page()->forArticle($article)->noindex(false);

        return view('frontend.article_show', compact('article', 'related', 'contact', 'preview'));
    }

    // Kelola Kategori Artikel
    public function storeCategory(Request $request)
    {
        $request->validate(
            ['name' => 'required|string|max:100|unique:article_categories,name'],
            ['name.required' => 'Nama kategori wajib diisi.', 'name.unique' => 'Kategori dengan nama ini sudah ada.']
        );

        ArticleCategory::create(['name' => $request->name]);

        return back()->with('success', 'Kategori artikel berhasil dibuat!');
    }

    public function destroyCategory(ArticleCategory $category)
    {
        $category->delete(); // artikel terkait menjadi tanpa kategori (nullOnDelete)

        return back()->with('success', 'Kategori artikel berhasil dihapus!');
    }

    private function validated(Request $request, ?Article $article = null): array
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:article_categories,id',
            'excerpt' => 'nullable|string|max:300',
            'content' => ['required', 'string', new RichTextRequired('Isi artikel')],
            'author' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'cover_image' => ImageUpload::RULE,
        ], ImageUpload::messages('cover_image', 'Gambar utama') + [
            'title.required' => 'Judul artikel wajib diisi.',
            'content.required' => 'Isi artikel wajib diisi.',
            'excerpt.max' => 'Ringkasan maksimal 300 karakter.',
            'status.in' => 'Status artikel tidak valid.',
        ]);

        $publishedAt = filled($validated['published_at'] ?? null) ? $validated['published_at'] : null;
        if ($validated['status'] === Article::STATUS_PUBLISHED && ! $publishedAt) {
            $publishedAt = $article?->published_at ?? now();
        }

        return [
            'title' => $validated['title'],
            'category_id' => $validated['category_id'] ?? null,
            'excerpt' => filled($validated['excerpt'] ?? null) ? trim(strip_tags($validated['excerpt'])) : null,
            'content' => RichText::clean($validated['content']),
            'author' => filled($validated['author'] ?? null)
                ? $validated['author']
                : ($article?->author ?? Auth::guard('admin')->user()?->name),
            'status' => $validated['status'],
            'published_at' => $publishedAt,
            'is_featured' => $request->boolean('is_featured'),
        ];
    }
}
