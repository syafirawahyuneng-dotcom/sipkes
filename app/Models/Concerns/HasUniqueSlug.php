<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

/**
 * Membuat kolom `slug` unik secara otomatis dari kolom sumber
 * (didefinisikan lewat properti $slugSource) bila slug masih kosong.
 * Slug yang sudah ada tidak diubah agar URL detail tetap stabil.
 */
trait HasUniqueSlug
{
    protected static function bootHasUniqueSlug(): void
    {
        static::saving(function ($model) {
            if (blank($model->slug)) {
                $model->slug = $model->generateUniqueSlug((string) $model->{$model->slugSource});
            }
        });
    }

    public function generateUniqueSlug(string $text): string
    {
        $base = Str::slug($text) ?: Str::lower(class_basename($this)) . '-' . Str::random(6);
        $slug = $base;
        $i = 2;

        while (static::where('slug', $slug)->when($this->exists, fn ($q) => $q->whereKeyNot($this->getKey()))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
