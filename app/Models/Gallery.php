<?php

namespace App\Models;

use App\Models\Concerns\HasImage;
use App\Models\Concerns\HasUniqueSlug;
use App\Support\RichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Berita SIP-Kes (sebelumnya "Galeri"). Nama tabel/model dipertahankan agar
 * data dan file unggahan yang sudah ada tetap terpakai.
 *
 * - description : ringkasan berita (tampil di kartu)
 * - content     : isi berita lengkap (HTML dari editor, atau teks polos lama)
 * - date        : tanggal publikasi
 */
class Gallery extends Model
{
    use HasFactory, HasImage, HasUniqueSlug;

    protected string $slugSource = 'title';

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'content',
        'author',
        'image',
        'date',
        'order',
    ];

    protected $casts = [
        'date' => 'date',
        'order' => 'integer',
    ];

    protected $appends = ['image_url'];

    public function category()
    {
        return $this->belongsTo(GalleryCategory::class, 'category_id');
    }

    /** Paragraf isi berita; bila isi kosong, ringkasan dipakai sebagai isi. */
    public function paragraphs(): array
    {
        $source = (string) ($this->content ?: $this->description);
        // Konten HTML dari editor: paragraf diambil sebagai teks polos per blok.
        if (RichText::isHtml($source)) {
            $source = preg_replace('/<\/(p|h[1-6]|li|blockquote)>|<br\s*\/?>/i', "\n\n", $source);
            $source = html_entity_decode(strip_tags($source), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }
        $text = trim($source);
        if ($text === '') {
            return [];
        }

        return array_values(array_filter(
            array_map('trim', preg_split('/\R\s*\R/u', $text)),
            fn ($p) => $p !== ''
        ));
    }

    /** Isi berita siap tampil (HTML tersanitasi); teks polos lama menjadi paragraf. */
    public function getContentHtmlAttribute(): string
    {
        return RichText::render($this->content ?: $this->description);
    }

    public function getDetailUrlAttribute(): string
    {
        return route('news.show', $this);
    }
}
