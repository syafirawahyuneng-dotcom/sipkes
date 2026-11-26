<?php

namespace App\Support;

use App\Models\Article;
use App\Models\Feature;
use App\Models\Gallery;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

/**
 * SEO otomatis & terpusat untuk seluruh halaman publik SIP-Kes.
 *
 * Metadata TIDAK diisi manual oleh admin: judul, deskripsi, kata kunci,
 * gambar, dan canonical diturunkan dari konten halaman yang sudah ada.
 * Bila suatu halaman tidak mengisi data, informasi umum SIP-Kes dipakai
 * sebagai cadangan. Dirender sekali di <head> (partials/seo) sehingga
 * tidak ada meta tag ganda.
 *
 * Pemakaian (controller / view):  Seo::page()->title(..)->description(..)->image(..)
 */
class Seo
{
    /** Instans SEO untuk request yang sedang berjalan (singleton container). */
    public static function page(): static
    {
        return app(static::class);
    }

    public const SITE_NAME = 'SIP-Kes';
    public const SUFFIX = 'TeFa V-Kes Polije';
    public const DEFAULT_TITLE = 'SIP-Kes - Sistem Informasi Pelayanan Kesehatan';
    public const DEFAULT_DESCRIPTION = 'Portal Resmi SIP-Kes (Sistem Informasi Pelayanan Kesehatan) - Rekam Medis Elektronik Terintegrasi SATUSEHAT Kemenkes RI & BPJS Kesehatan. Dikembangkan oleh Teaching Factory Inovasi Kesehatan Polije.';

    /** Kata kunci inti situs, selalu disertakan setelah kata kunci halaman. */
    public const BASE_KEYWORDS = [
        'SIP-Kes', 'Sistem Informasi Pelayanan Kesehatan', 'rekam medis elektronik', 'RME',
        'SATUSEHAT', 'BPJS Kesehatan', 'TeFa V-Kes', 'Politeknik Negeri Jember',
    ];

    /** Kata umum Bahasa Indonesia yang tidak layak menjadi kata kunci. */
    private const STOPWORDS = [
        'yang', 'dan', 'di', 'ke', 'dari', 'untuk', 'dengan', 'pada', 'dalam', 'ini', 'itu', 'atau',
        'adalah', 'akan', 'oleh', 'sebagai', 'juga', 'tidak', 'bisa', 'dapat', 'lebih', 'telah', 'sudah',
        'para', 'serta', 'karena', 'agar', 'bagi', 'tersebut', 'secara', 'kami', 'kita', 'anda', 'mereka',
        'ada', 'saat', 'hingga', 'antara', 'setiap', 'sehingga', 'yaitu', 'jika', 'namun', 'masih', 'harus',
        'tanpa', 'baik', 'atas', 'tentang', 'melalui', 'seperti', 'hal', 'dua', 'satu', 'tiga', 'per', 'pun',
        'bahwa', 'sangat', 'kini', 'lalu', 'kepada', 'hanya', 'semua', 'yakni', 'maupun', 'menjadi', 'bagaimana',
        'apa', 'mengapa', 'kapan', 'dimana', 'nya', 'pula', 'tetapi', 'sedang', 'belum', 'cara', 'the', 'and',
        'for', 'with', 'of', 'to', 'in', 'on', 'is', 'are', 'a', 'an', 'oleh', 'kembali', 'banyak', 'sejak',
    ];

    private ?string $title = null;
    private ?string $description = null;
    private array $keywords = [];
    private ?string $image = null;
    private ?string $canonical = null;
    private string $type = 'website';
    private string $robots = 'index, follow, max-image-preview:large';
    private ?string $publishedTime = null;
    private ?string $modifiedTime = null;
    private ?string $author = null;
    private ?string $section = null;
    private array $schema = [];

    // ---------------------------------------------------------------
    // Setter (fluent)
    // ---------------------------------------------------------------

    public function title(?string $title): static
    {
        $title = RichText::plain($title);
        $this->title = $title !== '' ? $title : null;

        return $this;
    }

    /** Deskripsi diambil dari teks/HTML apa pun, dirapikan dan dipotong ±160 karakter. */
    public function description(?string ...$sources): static
    {
        foreach ($sources as $source) {
            $text = RichText::plain($source);
            if ($text !== '') {
                $this->description = self::limit($text, 160);
                break;
            }
        }

        return $this;
    }

    /** Kata kunci tambahan (frasa) + kata kunci otomatis dari teks konten. */
    public function keywords(array $phrases = [], ?string $content = null): static
    {
        foreach ($phrases as $phrase) {
            $phrase = trim(RichText::plain($phrase));
            if ($phrase !== '' && mb_strlen($phrase) <= 60) {
                $this->keywords[] = $phrase;
            }
        }
        if ($content) {
            array_push($this->keywords, ...self::extractKeywords($content));
        }

        return $this;
    }

    public function image(?string $url): static
    {
        if (filled($url)) {
            $this->image = $url;
        }

        return $this;
    }

    public function type(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function canonical(?string $url): static
    {
        $this->canonical = $url;

        return $this;
    }

    public function noindex(bool $follow = true): static
    {
        $this->robots = 'noindex, ' . ($follow ? 'follow' : 'nofollow');

        return $this;
    }

    public function article(?\DateTimeInterface $published, ?\DateTimeInterface $modified = null, ?string $author = null, ?string $section = null): static
    {
        $this->type = 'article';
        $this->publishedTime = $published?->format(DATE_ATOM);
        $this->modifiedTime = ($modified ?? $published)?->format(DATE_ATOM);
        $this->author = $author ?: null;
        $this->section = $section ?: null;

        return $this;
    }

    /** Data terstruktur JSON-LD tambahan (schema.org). */
    public function schema(array $data): static
    {
        $this->schema[] = ['@context' => 'https://schema.org'] + $data;

        return $this;
    }

    // ---------------------------------------------------------------
    // Preset konten dinamis
    // ---------------------------------------------------------------

    public function forArticle(Article $article): static
    {
        $category = $article->category?->name;

        $this->title($article->title . ' - Artikel SIP-Kes')
            ->description($article->meta_description_text, $article->content)
            ->keywords(array_filter([$article->title, $category, 'artikel rekam medis elektronik']), $article->title . ' ' . $article->excerpt . ' ' . $article->content)
            ->image($article->cover_url ?: self::firstImage($article->content))
            ->canonical(route('articles.show', $article))
            ->article($article->published_at, $article->updated_at, $article->author, $category);

        return $this->schema([
            '@type' => 'Article',
            'headline' => Str::limit($article->title, 110, ''),
            'description' => $this->getDescription(),
            'image' => $this->getImage(),
            'datePublished' => $this->publishedTime,
            'dateModified' => $this->modifiedTime,
            'author' => ['@type' => $article->author ? 'Person' : 'Organization', 'name' => $article->author ?: self::SUFFIX],
            'publisher' => $this->publisherSchema(),
            'mainEntityOfPage' => route('articles.show', $article),
        ]);
    }

    public function forNews(Gallery $news): static
    {
        $category = $news->category?->name;

        $this->title($news->title . ' - Berita SIP-Kes')
            ->description($news->description, $news->content)
            ->keywords(array_filter([$news->title, $category, 'berita TeFa V-Kes']), $news->title . ' ' . $news->description . ' ' . $news->content)
            ->image($news->image_url ?: self::firstImage($news->content))
            ->canonical(route('news.show', $news))
            ->article($news->date, $news->updated_at, $news->author, $category);

        return $this->schema([
            '@type' => 'NewsArticle',
            'headline' => Str::limit($news->title, 110, ''),
            'description' => $this->getDescription(),
            'image' => $this->getImage(),
            'datePublished' => $this->publishedTime,
            'dateModified' => $this->modifiedTime,
            'author' => ['@type' => $news->author ? 'Person' : 'Organization', 'name' => $news->author ?: self::SUFFIX],
            'publisher' => $this->publisherSchema(),
            'mainEntityOfPage' => route('news.show', $news),
        ]);
    }

    public function forFeature(Feature $feature): static
    {
        $intro = 'Modul ' . $feature->name . ' pada SIP-Kes';

        return $this->title($feature->name . ' - Fitur & Modul SIP-Kes')
            ->description(
                $feature->description,
                $intro . ': ' . implode(', ', $feature->listOf('functions')),
                $intro . ', sistem rekam medis elektronik terintegrasi SATUSEHAT dan BPJS Kesehatan.'
            )
            ->keywords(array_filter([$feature->name, $feature->category, 'modul ' . $feature->name]), implode(' ', [
                $feature->name, $feature->description, $feature->functions, $feature->benefits,
            ]))
            ->image($feature->image_url)
            ->canonical(route('features.show', $feature));
    }

    // ---------------------------------------------------------------
    // Getter (dipakai partial <head>)
    // ---------------------------------------------------------------

    /** Judul halaman lengkap untuk <title>. */
    public function getTitle(): string
    {
        $title = $this->title ?: (trim(View::yieldContent('title')) ?: self::DEFAULT_TITLE);
        $title = html_entity_decode($title, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return Str::contains($title, self::SUFFIX) ? $title : $title . ' | ' . self::SUFFIX;
    }

    /** Judul untuk Open Graph / Twitter (tanpa akhiran situs). */
    public function getShareTitle(): string
    {
        return Str::before($this->getTitle(), ' | ' . self::SUFFIX);
    }

    public function getDescription(): string
    {
        if ($this->description) {
            return $this->description;
        }
        $yielded = RichText::plain(View::yieldContent('meta_description'));

        return self::limit($yielded !== '' ? $yielded : self::DEFAULT_DESCRIPTION, 160);
    }

    public function getKeywords(): string
    {
        $phrases = $this->keywords;
        if (! $phrases) {
            $phrases = self::extractKeywords($this->getShareTitle() . ' ' . $this->getDescription());
        }

        $unique = [];
        foreach (array_merge($phrases, self::BASE_KEYWORDS) as $phrase) {
            $key = mb_strtolower($phrase);
            if (! isset($unique[$key])) {
                $unique[$key] = $phrase;
            }
        }

        return implode(', ', array_slice(array_values($unique), 0, 15));
    }

    public function getImage(): string
    {
        return self::absolute($this->image ?: self::defaultImage());
    }

    /** Canonical: URL saat ini, hanya mempertahankan parameter yang mengubah isi (kategori, halaman). */
    public function getCanonical(): string
    {
        if ($this->canonical) {
            return $this->canonical;
        }

        $query = array_filter(
            request()->only(['category', 'page']),
            fn ($v, $k) => is_scalar($v) && $v !== '' && ! ($k === 'page' && (int) $v <= 1),
            ARRAY_FILTER_USE_BOTH
        );
        ksort($query);

        return url()->current() . ($query ? '?' . http_build_query($query) : '');
    }

    public function getRobots(): string
    {
        // Hasil pencarian internal tidak diindeks (konten duplikat), tautannya tetap diikuti.
        if (request()->filled('q') && str_starts_with($this->robots, 'index')) {
            return 'noindex, follow';
        }

        return $this->robots;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getMeta(): array
    {
        return [
            'published_time' => $this->publishedTime,
            'modified_time' => $this->modifiedTime,
            'author' => $this->author,
            'section' => $this->section,
        ];
    }

    /** Seluruh blok JSON-LD: WebSite + Organization, ditambah data halaman. */
    public function getSchemas(): array
    {
        return array_merge([
            [
                '@context' => 'https://schema.org',
                '@type' => 'WebSite',
                'name' => self::SITE_NAME,
                'alternateName' => 'Sistem Informasi Pelayanan Kesehatan',
                'url' => url('/'),
                'inLanguage' => 'id-ID',
                'potentialAction' => [
                    '@type' => 'SearchAction',
                    'target' => route('articles') . '?q={search_term_string}',
                    'query-input' => 'required name=search_term_string',
                ],
            ],
            ['@context' => 'https://schema.org'] + $this->publisherSchema(),
        ], $this->schema);
    }

    // ---------------------------------------------------------------
    // Utilitas
    // ---------------------------------------------------------------

    /** Kata kunci otomatis: kata bermakna yang paling sering muncul dalam teks. */
    public static function extractKeywords(?string $text, int $limit = 6): array
    {
        $text = mb_strtolower(RichText::plain($text));
        preg_match_all('/[\p{L}][\p{L}\p{N}\-]{2,}/u', $text, $m);

        $base = array_map('mb_strtolower', self::BASE_KEYWORDS);
        $counts = [];
        foreach ($m[0] as $word) {
            $word = trim($word, '-');
            $len = mb_strlen($word);
            // Abaikan kata pendek/umum, kata inti situs (sudah ada), dan "kata" tak wajar (huruf berulang / terlalu panjang).
            if ($len < 4 || $len > 20 || in_array($word, self::STOPWORDS, true) || in_array($word, $base, true)
                || preg_match('/(\p{L})\1{2,}/u', $word)) {
                continue;
            }
            $counts[$word] = ($counts[$word] ?? 0) + 1;
        }
        arsort($counts);

        return array_slice(array_keys($counts), 0, $limit);
    }

    /** Daftar nama digabung menjadi kalimat ringkas: "A, B, C, dan lainnya". */
    public static function listText(iterable $items, int $max = 6): string
    {
        $items = collect($items)->map(fn ($i) => trim((string) $i))->filter()->values();
        $text = $items->take($max)->implode(', ');

        return $items->count() > $max ? $text . ', dan lainnya' : $text;
    }

    private static function limit(string $text, int $limit): string
    {
        if (mb_strlen($text) <= $limit) {
            return $text;
        }
        $cut = mb_substr($text, 0, $limit - 1);
        $space = mb_strrpos($cut, ' ');

        return rtrim($space > $limit * 0.6 ? mb_substr($cut, 0, $space) : $cut, " ,.;:-") . '…';
    }

    private static function firstImage(?string $html): ?string
    {
        return preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', (string) $html, $m) ? $m[1] : null;
    }

    private static function absolute(string $url): string
    {
        return preg_match('#^https?://#i', $url) ? $url : url($url);
    }

    private static function defaultImage(): string
    {
        static $logo = null;
        if ($logo === null) {
            try {
                $path = SiteSetting::get('site_logo');
            } catch (\Throwable $e) {
                $path = null;
            }
            $logo = $path && ImageUpload::exists($path) ? ImageUpload::url($path) : asset('images/logo.png');
        }

        return $logo;
    }

    private function publisherSchema(): array
    {
        return [
            '@type' => 'Organization',
            'name' => 'Teaching Factory Inovasi Kesehatan (TeFa V-Kes) Politeknik Negeri Jember',
            'url' => url('/'),
            'logo' => ['@type' => 'ImageObject', 'url' => self::absolute(self::defaultImage())],
        ];
    }
}
