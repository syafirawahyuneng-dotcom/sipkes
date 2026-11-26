<?php

namespace App\Http\Controllers;

use App\Models\Advantage;
use App\Models\Article;
use App\Models\Banner;
use App\Models\ContactInfo;
use App\Models\Feature;
use App\Models\Gallery;
use App\Models\PricingPlan;
use App\Models\Profile;
use App\Models\SupportService;

/**
 * SEO teknis otomatis: sitemap.xml & robots.txt dibangun langsung dari
 * database sehingga selalu mengikuti halaman, fitur, berita, dan artikel terbaru.
 */
class SeoController extends Controller
{
    public function sitemap()
    {
        $last = fn (string $model) => $model::query()->max('updated_at');

        $features = Feature::orderBy('order')->get(['id', 'slug', 'updated_at']);
        $news = Gallery::whereNotNull('slug')->orderByDesc('date')->get(['id', 'slug', 'date', 'updated_at']);
        $articles = Article::published()->orderByDesc('published_at')->get(['id', 'slug', 'published_at', 'updated_at']);

        $latestArticle = $articles->max('updated_at');
        $latestNews = $news->max('updated_at');

        $urls = [
            ['loc' => route('home'), 'lastmod' => collect([$last(Banner::class), $last(Profile::class), $latestArticle, $latestNews])->filter()->map(fn ($v) => \Illuminate\Support\Carbon::parse($v))->max(), 'changefreq' => 'weekly', 'priority' => '1.0'],
            ['loc' => route('profile'), 'lastmod' => $last(Profile::class), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => route('features'), 'lastmod' => $features->max('updated_at'), 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['loc' => route('advantages'), 'lastmod' => $last(Advantage::class), 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => route('pricing'), 'lastmod' => $last(PricingPlan::class), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => route('support.services'), 'lastmod' => $last(SupportService::class), 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => route('news'), 'lastmod' => $latestNews, 'changefreq' => 'daily', 'priority' => '0.8'],
            ['loc' => route('articles'), 'lastmod' => $latestArticle, 'changefreq' => 'daily', 'priority' => '0.8'],
            ['loc' => route('contact'), 'lastmod' => $last(ContactInfo::class), 'changefreq' => 'yearly', 'priority' => '0.6'],
        ];

        foreach ($features as $f) {
            if ($f->slug) {
                $urls[] = ['loc' => route('features.show', $f), 'lastmod' => $f->updated_at, 'changefreq' => 'monthly', 'priority' => '0.7'];
            }
        }
        foreach ($news as $n) {
            $urls[] = ['loc' => route('news.show', $n), 'lastmod' => $n->updated_at ?? $n->date, 'changefreq' => 'monthly', 'priority' => '0.6'];
        }
        foreach ($articles as $a) {
            $urls[] = ['loc' => route('articles.show', $a), 'lastmod' => $a->updated_at ?? $a->published_at, 'changefreq' => 'monthly', 'priority' => '0.7'];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
            . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $u) {
            $xml .= "  <url>\n    <loc>" . e($u['loc']) . "</loc>\n";
            if ($u['lastmod']) {
                $xml .= '    <lastmod>' . \Illuminate\Support\Carbon::parse($u['lastmod'])->toAtomString() . "</lastmod>\n";
            }
            $xml .= "    <changefreq>{$u['changefreq']}</changefreq>\n    <priority>{$u['priority']}</priority>\n  </url>\n";
        }
        $xml .= '</urlset>' . "\n";

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    public function robots()
    {
        // Mendukung instalasi di subfolder (mis. http://localhost/sip-kes2).
        $base = rtrim((string) parse_url(url('/'), PHP_URL_PATH), '/');

        $lines = [
            'User-agent: *',
            'Allow: ' . $base . '/',
            'Disallow: ' . $base . '/admin',
            'Disallow: ' . $base . '/kontak/kirim-pesan',
            '',
            'Sitemap: ' . route('sitemap'),
            '',
        ];

        return response(implode("\n", $lines), 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
