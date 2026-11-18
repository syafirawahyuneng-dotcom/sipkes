<?php

namespace App\Models\Concerns;

use App\Support\ImageUpload;

/**
 * Accessor gambar bersama untuk model yang memiliki kolom `image`.
 * - $model->image_url     : URL gambar ('' bila kosong)
 * - $model->hasValidImage(): true bila file gambar benar-benar ada
 */
trait HasImage
{
    public function getImageUrlAttribute(): string
    {
        return $this->hasValidImage() ? ImageUpload::url($this->image) : '';
    }

    public function hasValidImage(): bool
    {
        return ImageUpload::exists($this->image);
    }
}
