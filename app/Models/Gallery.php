<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Berita SIP-Kes (sebelumnya "Galeri"). Nama tabel/model dipertahankan agar
 * data dan file unggahan yang sudah ada tetap terpakai.
 *
 * - description : ringkasan berita (tampil di kartu)
 * - content     : isi berita lengkap (paragraf dipisah baris kosong)
 * - date        : tanggal publikasi
 */
class Gallery extends Model
{
    use HasFactory, HasUniqueSlug;

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
        $text = trim((string) ($this->content ?: $this->description));
        if ($text === '') {
            return [];
        }

        return array_values(array_filter(
            array_map('trim', preg_split('/\R\s*\R/u', $text)),
            fn ($p) => $p !== ''
        ));
    }

    public function getDetailUrlAttribute(): string
    {
        return route('news.show', $this);
    }

    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return '';
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://') || str_starts_with($this->image, 'data:')) {
            return $this->image;
        }

        // Direct public file (e.g. public/gallery/...)
        if (file_exists(public_path($this->image))) {
            return asset($this->image);
        }

        // File di disk public lewat link public/storage (php artisan storage:link)
        if (file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }

        // Cadangan bila link public/storage belum dibuat: sajikan lewat route media
        if (file_exists(storage_path('app/public/' . $this->image))) {
            return route('media', ['path' => $this->image]);
        }

        return asset('storage/' . $this->image);
    }

    public function hasValidImage(): bool
    {
        if (empty($this->image)) {
            return false;
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://') || str_starts_with($this->image, 'data:')) {
            return true;
        }

        return file_exists(public_path($this->image)) || 
               file_exists(public_path('storage/' . $this->image)) || 
               file_exists(storage_path('app/public/' . $this->image));
    }
}

