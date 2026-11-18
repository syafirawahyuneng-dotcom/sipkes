<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
use App\Models\SiteSetting;
use App\Models\TargetFacility;
use App\Models\Article;
use App\Support\ImageUpload;
use App\Support\RichText;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'features' => Feature::count(),
            'advantages' => Advantage::count(),
            'pricing_plans' => PricingPlan::count(),
            'support_services' => SupportService::count(),
            'galleries' => Gallery::count(),
            'articles_published' => Article::published()->count(),
            'articles_draft' => Article::where('status', Article::STATUS_DRAFT)->count(),
            'messages_unread' => ContactMessage::where('is_read', false)->count(),
            'messages_total' => ContactMessage::count(),
        ];

        $latestMessages = ContactMessage::latest()->take(5)->get();
        $recentGalleries = Gallery::with('category')->latest()->take(4)->get();

        return view('admin.dashboard', compact('stats', 'latestMessages', 'recentGalleries'));
    }

    // Kelola Beranda (Hero Banner & Target Faskes)
    public function homeIndex()
    {
        $banner = Banner::first() ?? new Banner();
        $facilities = TargetFacility::orderBy('order')->get();
        $introImage = SiteSetting::get('home_intro_image');
        $introImageUrl = ImageUpload::exists($introImage) ? ImageUpload::url($introImage) : '';
        return view('admin.home.index', compact('banner', 'facilities', 'introImageUrl'));
    }

    public function homeUpdate(Request $request)
    {
        $request->validate([
            'image' => ImageUpload::RULE,
            'intro_image' => ImageUpload::RULE,
        ], ImageUpload::messages('image', 'Gambar hero') + ImageUpload::messages('intro_image', 'Gambar pengenalan'));

        $banner = Banner::first() ?? new Banner();
        $banner->image = ImageUpload::replace($request, $banner->image, 'banners');
        $banner->badge = $request->badge;
        $banner->title = $request->title;
        $banner->subtitle = $request->subtitle;
        $banner->primary_btn_text = $request->primary_btn_text;
        $banner->primary_btn_url = $request->primary_btn_url;
        $banner->secondary_btn_text = $request->secondary_btn_text;
        $banner->secondary_btn_url = $request->secondary_btn_url;
        $banner->save();

        $introImage = SiteSetting::get('home_intro_image');
        $newIntro = ImageUpload::replace($request, $introImage, 'home', 'intro_image');
        if ($newIntro !== $introImage) {
            SiteSetting::set('home_intro_image', $newIntro, 'home');
        }

        return back()->with('success', 'Konten Hero Beranda berhasil diperbarui!');
    }

    // Kelola Profil
    public function profileIndex()
    {
        $profile = Profile::first() ?? new Profile();
        return view('admin.profile.index', compact('profile'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate(['image' => ImageUpload::RULE], ImageUpload::messages('image', 'Gambar profil'));

        $profile = Profile::first() ?? new Profile();
        $profile->image = ImageUpload::replace($request, $profile->image, 'profile');
        $profile->name = $request->name;
        $profile->institution = $request->institution;
        $profile->tagline = $request->tagline;
        $profile->about_tefa = RichText::clean($request->about_tefa);
        $profile->about_sipkes = RichText::clean($request->about_sipkes);
        $profile->vision = RichText::clean($request->vision);
        $profile->mission = RichText::clean($request->mission);
        $profile->goals = $request->goals;
        $profile->background = RichText::clean($request->background);
        $profile->save();

        return back()->with('success', 'Data Profil TeFa & SIP-Kes berhasil diperbarui!');
    }

    // Kelola Kontak
    public function contactIndex()
    {
        $contact = ContactInfo::first() ?? new ContactInfo();
        $messages = ContactMessage::latest()->paginate(10);
        return view('admin.contact.index', compact('contact', 'messages'));
    }

    public function contactUpdate(Request $request)
    {
        $contact = ContactInfo::first() ?? new ContactInfo();
        $contact->phone = $request->phone;
        $contact->whatsapp = $request->whatsapp;
        $contact->email = $request->email;
        $contact->instagram = $request->instagram;
        $contact->instagram_url = $request->instagram_url;
        $contact->address = $request->address;
        $contact->maps_embed = $request->maps_embed;
        $contact->save();

        return back()->with('success', 'Informasi Kontak Resmi berhasil diperbarui!');
    }

    public function markMessageAsRead(ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        return back()->with('success', 'Pesan ditandai sebagai sudah dibaca.');
    }

    public function deleteMessage(ContactMessage $message)
    {
        $message->delete();
        return back()->with('success', 'Pesan berhasil dihapus.');
    }
}

