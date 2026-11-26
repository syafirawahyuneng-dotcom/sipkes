<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Banner;
use App\Models\Feature;
use App\Models\Advantage;
use App\Models\PricingPlan;
use App\Models\SupportService;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use App\Models\ContactInfo;
use App\Models\ContactMessage;
use App\Models\TargetFacility;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Support\Seo;

class PortalController extends Controller
{
    // Halaman Beranda
    public function home()
    {
        $banner = Banner::where('is_active', true)->orderBy('order')->first();
        $profile = Profile::first();
        $advantages = Advantage::orderBy('order')->get();
        $featuredFeatures = Feature::where('is_featured', true)->orderBy('order')->get();
        if ($featuredFeatures->isEmpty()) {
            $featuredFeatures = Feature::orderBy('order')->take(8)->get();
        }
        $allFeatures = Feature::orderBy('order')->get();
        $facilities = TargetFacility::orderBy('order')->get();
        $pricingPlans = PricingPlan::where('is_active', true)->orderBy('order')->get();
        $supportServices = SupportService::where('is_active', true)->orderBy('order')->get();
        $galleries = Gallery::with('category')->orderByDesc('date')->orderBy('order')->take(4)->get();
        $contact = ContactInfo::first();

        // Artikel terbaru (artikel unggulan diprioritaskan)
        $latestArticles = Article::published()->with('category')
            ->orderByDesc('is_featured')->orderByDesc('published_at')->take(3)->get();

        // Gambar pendamping bagian Pengenalan: memakai gambar Profil TeFa
        $introImage = $profile?->image_url ?: '';

        Seo::page()
            ->title('SIP-Kes - Sistem Informasi Pelayanan Kesehatan TeFa V-Kes Polije')
            ->description($banner?->subtitle, $profile?->about_sipkes, $profile?->tagline)
            ->keywords(
                $featuredFeatures->pluck('name')->take(5)->all(),
                implode(' ', [$banner?->title, $banner?->subtitle, $profile?->about_sipkes])
            )
            ->image($banner?->image_url ?: $introImage);

        return view('frontend.home', compact(
            'banner', 'profile', 'advantages', 'featuredFeatures', 'allFeatures',
            'facilities', 'pricingPlans', 'supportServices', 'galleries', 'contact',
            'latestArticles', 'introImage'
        ));
    }

    // Halaman Profil
    public function profile()
    {
        $profile = Profile::first();
        $contact = ContactInfo::first();

        Seo::page()
            ->title('Profil TeFa Inovasi Kesehatan & SIP-Kes - Politeknik Negeri Jember')
            ->description($profile?->about_sipkes, $profile?->about_tefa, $profile?->background, $profile?->tagline)
            ->keywords(
                array_filter(['profil SIP-Kes', 'Teaching Factory', $profile?->name, $profile?->institution]),
                implode(' ', [$profile?->about_tefa, $profile?->about_sipkes, $profile?->vision])
            )
            ->image($profile?->image_url);

        return view('frontend.profile', compact('profile', 'contact'));
    }

    // Halaman Fitur Lengkap
    public function features(Request $request)
    {
        $query = Feature::query()->orderBy('order');
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        $features = $query->get();
        $categories = Feature::select('category')->distinct()->whereNotNull('category')->pluck('category');
        $contact = ContactInfo::first();

        $category = $request->filled('category') && is_string($request->category) ? $request->category : null;
        Seo::page()
            ->title($category ? "Fitur & Modul {$category} SIP-Kes" : 'Fitur & Modul Lengkap SIP-Kes')
            ->description(($category ? "Modul {$category} SIP-Kes: " : 'Fitur & modul rekam medis elektronik SIP-Kes: ')
                . Seo::listText($features->pluck('name')) . '. Terintegrasi SATUSEHAT dan BPJS Kesehatan.')
            ->keywords(
                array_merge(['fitur SIP-Kes', 'modul rekam medis elektronik'], $features->pluck('name')->take(5)->all(), $categories->take(3)->all()),
                $features->pluck('description')->implode(' ')
            )
            ->image($features->first(fn ($f) => $f->image_url)?->image_url);

        return view('frontend.features', compact('features', 'categories', 'contact'));
    }

    // Halaman Detail Fitur & Modul
    public function featureShow(Feature $feature)
    {
        $ordered = Feature::orderBy('order')->orderBy('id')->get(['id', 'name', 'slug', 'icon', 'category', 'order']);
        $index = $ordered->search(fn ($f) => $f->id === $feature->id);
        $prev = $index > 0 ? $ordered[$index - 1] : null;
        $next = $index !== false && $index < $ordered->count() - 1 ? $ordered[$index + 1] : null;

        $related = $feature->category
            ? Feature::where('category', $feature->category)->whereKeyNot($feature->id)->orderBy('order')->take(4)->get()
            : collect();
        if ($related->isEmpty()) {
            $related = Feature::whereKeyNot($feature->id)->orderBy('order')->take(4)->get();
        }
        $contact = ContactInfo::first();

        Seo::page()->forFeature($feature);

        return view('frontend.feature_show', compact('feature', 'prev', 'next', 'related', 'contact'));
    }

    // Halaman Keunggulan
    public function advantages()
    {
        $advantages = Advantage::orderBy('order')->get();
        $contact = ContactInfo::first();

        Seo::page()
            ->title('Keunggulan Sistem Rekam Medis Elektronik SIP-Kes')
            ->description('Keunggulan SIP-Kes: ' . Seo::listText($advantages->pluck('title')) . '.', $advantages->first()?->description)
            ->keywords(
                array_merge(['keunggulan SIP-Kes'], $advantages->pluck('title')->take(5)->all()),
                $advantages->pluck('description')->implode(' ')
            )
            ->image($advantages->first(fn ($a) => $a->image_url)?->image_url);

        return view('frontend.advantages', compact('advantages', 'contact'));
    }

    // Halaman Harga & Paket
    public function pricing()
    {
        $plans = PricingPlan::where('is_active', true)->orderBy('order')->get();
        $contact = ContactInfo::first();

        Seo::page()
            ->title('Pilihan Paket & Biaya Berlangganan SIP-Kes')
            ->description('Pilihan paket berlangganan rekam medis elektronik SIP-Kes untuk fasilitas kesehatan: '
                . Seo::listText($plans->pluck('name')) . '.', $plans->first()?->description)
            ->keywords(
                array_merge(['harga SIP-Kes', 'paket rekam medis elektronik', 'biaya RME'], $plans->pluck('name')->take(4)->all()),
                $plans->pluck('description')->implode(' ')
            );

        return view('frontend.pricing', compact('plans', 'contact'));
    }

    // Halaman Layanan Pendukung
    public function supportServices()
    {
        $services = SupportService::where('is_active', true)->orderBy('order')->get();
        $contact = ContactInfo::first();

        Seo::page()
            ->title('Layanan Pendukung Faskes - Pendampingan BPJS & Akreditasi')
            ->description('Layanan pendukung fasilitas kesehatan dari TeFa V-Kes Polije: '
                . Seo::listText($services->pluck('title')) . '.', $services->first()?->summary)
            ->keywords(
                array_merge(['layanan pendukung faskes', 'pendampingan akreditasi'], $services->pluck('title')->take(5)->all()),
                $services->map(fn ($s) => $s->summary . ' ' . $s->description)->implode(' ')
            )
            ->image($services->first(fn ($s) => $s->image_url)?->image_url);

        return view('frontend.support_services', compact('services', 'contact'));
    }

    // Halaman Berita (sebelumnya Galeri)
    public function news(Request $request)
    {
        $categories = GalleryCategory::orderBy('name')->get();
        $query = Gallery::with('category')->orderByDesc('date')->orderBy('order')->orderByDesc('id');
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        $news = $query->paginate(9)->withQueryString();
        $contact = ContactInfo::first();

        $activeCategory = $categories->firstWhere('slug', $request->category);
        Seo::page()
            ->title($activeCategory ? "Berita {$activeCategory->name} - TeFa V-Kes Polije" : 'Berita & Kegiatan TeFa V-Kes Polije')
            ->description(
                ($activeCategory ? "Berita kategori {$activeCategory->name}" : 'Berita dan kegiatan terbaru TeFa V-Kes Politeknik Negeri Jember')
                . ($news->isNotEmpty() ? ': ' . Seo::listText($news->pluck('title'), 3) : ' seputar SIP-Kes dan rekam medis elektronik') . '.'
            )
            ->keywords(
                array_merge(['berita SIP-Kes', 'kegiatan TeFa V-Kes'], $categories->pluck('name')->take(4)->all()),
                $news->map(fn ($n) => $n->title . ' ' . $n->description)->implode(' ')
            )
            ->image($news->first(fn ($n) => $n->image_url)?->image_url);

        return view('frontend.news', compact('news', 'categories', 'contact'));
    }

    // Halaman Detail Berita
    public function newsShow(Gallery $news)
    {
        $news->load('category');

        $related = Gallery::with('category')
            ->whereKeyNot($news->id)
            ->when($news->category_id, fn ($q) => $q->orderByRaw('category_id = ? DESC', [$news->category_id]))
            ->orderByDesc('date')
            ->take(3)
            ->get();
        $contact = ContactInfo::first();

        Seo::page()->forNews($news);

        return view('frontend.news_show', compact('news', 'related', 'contact'));
    }

    // Halaman Daftar Artikel
    public function articles(Request $request)
    {
        $categories = ArticleCategory::whereHas('articles', fn ($q) => $q->published())->orderBy('name')->get();

        $query = Article::published()->with('category')->orderByDesc('published_at')->orderByDesc('id');
        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }
        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }
        $articles = $query->paginate(9)->withQueryString();
        $contact = ContactInfo::first();

        $activeCategory = $categories->firstWhere('slug', $request->category);
        Seo::page()
            ->title($activeCategory ? "Artikel {$activeCategory->name} - SIP-Kes" : 'Artikel & Wawasan Rekam Medis Elektronik')
            ->description($activeCategory
                ? "Kumpulan artikel {$activeCategory->name} dari SIP-Kes" . ($articles->isNotEmpty() ? ': ' . Seo::listText($articles->pluck('title'), 3) : '') . '.'
                : 'Artikel SIP-Kes: panduan rekam medis elektronik, regulasi PMK 24/2022, akreditasi, serta integrasi SATUSEHAT dan BPJS Kesehatan dari TeFa V-Kes Politeknik Negeri Jember.')
            ->keywords(
                array_merge(['artikel rekam medis elektronik', 'wawasan RME'], $categories->pluck('name')->take(5)->all()),
                $articles->map(fn ($a) => $a->title . ' ' . $a->excerpt)->implode(' ')
            )
            ->image($articles->first(fn ($a) => $a->cover_url)?->cover_url);

        return view('frontend.articles', compact('articles', 'categories', 'contact'));
    }

    // Halaman Detail Artikel (draf / terjadwal → 404)
    public function articleShow(Article $article)
    {
        abort_unless($article->isPublished(), 404);
        $article->load('category');

        $related = Article::published()->with('category')
            ->whereKeyNot($article->id)
            ->when($article->category_id, fn ($q) => $q->orderByRaw('category_id = ? DESC', [$article->category_id]))
            ->orderByDesc('published_at')
            ->take(3)
            ->get();
        $contact = ContactInfo::first();

        Seo::page()->forArticle($article);

        return view('frontend.article_show', compact('article', 'related', 'contact'));
    }

    // Sajikan gambar unggahan dari disk public (cadangan bila storage:link belum dibuat)
    public function media(string $path)
    {
        abort_if(str_contains($path, '..'), 404);
        $disk = \Illuminate\Support\Facades\Storage::disk('public');
        abort_unless($disk->exists($path), 404);

        return response()->file($disk->path($path), ['Cache-Control' => 'public, max-age=604800']);
    }

    // Halaman Kontak
    public function contact()
    {
        $contact = ContactInfo::first();

        $contactDetails = collect([
            $contact?->address ? 'Alamat: ' . $contact->address : null,
            $contact?->phone ? 'Telp: ' . $contact->phone : null,
            $contact?->email ? 'Email: ' . $contact->email : null,
        ])->filter()->implode('. ');
        Seo::page()
            ->title('Kontak & Informasi Sekretariat SIP-Kes')
            ->description('Hubungi tim SIP-Kes TeFa V-Kes Polije untuk konsultasi dan demo rekam medis elektronik'
                . ($contactDetails ? '. ' . $contactDetails : '') . '.')
            ->keywords(['kontak SIP-Kes', 'konsultasi rekam medis elektronik', 'demo SIP-Kes', 'alamat TeFa V-Kes']);

        return view('frontend.contact', compact('contact'));
    }

    // Kirim Pesan / Konsultasi
    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'faskes_name' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'Pesan Anda telah berhasil dikirim! Tim TeFa V-Kes akan segera menghubungi faskes Anda.');
    }
}

