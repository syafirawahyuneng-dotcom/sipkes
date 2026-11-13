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

        return view('frontend.home', compact(
            'banner', 'profile', 'advantages', 'featuredFeatures', 'allFeatures',
            'facilities', 'pricingPlans', 'supportServices', 'galleries', 'contact'
        ));
    }

    // Halaman Profil
    public function profile()
    {
        $profile = Profile::first();
        $contact = ContactInfo::first();
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

        return view('frontend.feature_show', compact('feature', 'prev', 'next', 'related', 'contact'));
    }

    // Halaman Keunggulan
    public function advantages()
    {
        $advantages = Advantage::orderBy('order')->get();
        $contact = ContactInfo::first();
        return view('frontend.advantages', compact('advantages', 'contact'));
    }

    // Halaman Harga & Paket
    public function pricing()
    {
        $plans = PricingPlan::where('is_active', true)->orderBy('order')->get();
        $contact = ContactInfo::first();
        return view('frontend.pricing', compact('plans', 'contact'));
    }

    // Halaman Layanan Pendukung
    public function supportServices()
    {
        $services = SupportService::where('is_active', true)->orderBy('order')->get();
        $contact = ContactInfo::first();
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

        return view('frontend.news_show', compact('news', 'related', 'contact'));
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

