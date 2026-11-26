<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use App\Support\ImageUpload;
use App\Support\RichText;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Artikel SIP-Kes: tulisan edukatif/wawasan (panduan RME, regulasi,
 * SATUSEHAT, BPJS). Terpisah dari Berita (kabar kegiatan TeFa).
 *
 * Status: draft | published. Artikel terbit dengan published_at di masa
 * depan dianggap "terjadwal" dan belum tampil di portal.
 */
class Article extends Model
{
    use HasUniqueSlug;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';

    protected string $slugSource = 'title';

    protected $fillable = [
        'category_id',
        'admin_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_image',
        'author',
        'status',
        'published_at',
        'is_featured',
        'meta_description',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /** Hanya artikel yang sudah terbit dan waktunya sudah tiba. */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED && $this->published_at && $this->published_at->lte(now());
    }

    /** draft | scheduled | published */
    public function getStateAttribute(): string
    {
        if ($this->status !== self::STATUS_PUBLISHED) {
            return 'draft';
        }

        return $this->published_at && $this->published_at->isFuture() ? 'scheduled' : 'published';
    }

    public function getStateLabelAttribute(): string
    {
        return ['draft' => 'Draf', 'scheduled' => 'Terjadwal', 'published' => 'Terbit'][$this->state];
    }

    public function hasValidCover(): bool
    {
        return ImageUpload::exists($this->cover_image);
    }

    public function getCoverUrlAttribute(): string
    {
        return $this->hasValidCover() ? ImageUpload::url($this->cover_image) : '';
    }

    public function getContentHtmlAttribute(): string
    {
        return RichText::render($this->content);
    }

    /** Ringkasan untuk kartu: excerpt, atau ±160 karakter pertama isi. */
    public function getExcerptTextAttribute(): string
    {
        return filled($this->excerpt) ? trim($this->excerpt) : RichText::plain($this->content, 160);
    }

    public function getMetaDescriptionTextAttribute(): string
    {
        // Deskripsi SEO selalu otomatis dari ringkasan / isi artikel (tanpa input manual admin).
        return RichText::plain($this->excerpt_text, 160);
    }

    public function getReadingTimeAttribute(): int
    {
        return RichText::readingMinutes($this->content);
    }

    public function getDetailUrlAttribute(): string
    {
        return route('articles.show', $this);
    }
}
