<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Upload, ganti, dan hapus gambar konten di disk `public`.
 * Dipakai bersama oleh semua form admin yang memiliki input gambar.
 */
class ImageUpload
{
    /** Aturan validasi gambar (sama dengan aturan Berita sejak Fase 1). */
    public const RULE = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';

    /** Pesan validasi Bahasa Indonesia untuk field gambar. */
    public static function messages(string $field = 'image', string $label = 'Gambar'): array
    {
        return [
            "{$field}.image" => "{$label} harus berupa file gambar.",
            "{$field}.mimes" => "{$label} harus berformat JPG, PNG, WEBP, atau GIF.",
            "{$field}.max" => "Ukuran {$label} maksimal 5 MB.",
            "{$field}.uploaded" => "{$label} gagal diunggah. Pastikan ukurannya tidak melebihi 5 MB.",
        ];
    }

    /**
     * Kembalikan path gambar baru:
     * - ada file baru  → simpan, hapus file lama
     * - centang hapus  → hapus file lama, kembalikan null
     * - selain itu     → path lama tidak berubah
     */
    public static function replace(Request $request, ?string $current, string $dir, string $field = 'image'): ?string
    {
        if ($request->hasFile($field)) {
            self::delete($current);

            return $request->file($field)->store($dir, 'public');
        }

        if ($request->boolean('remove_' . $field)) {
            self::delete($current);

            return null;
        }

        return $current ?: null;
    }

    /** Hapus file dari disk public (URL eksternal & file di luar disk diabaikan). */
    public static function delete(?string $path): void
    {
        if (! $path || preg_match('#^(https?:|data:)#i', $path)) {
            return;
        }

        $disk = Storage::disk('public');
        if ($disk->exists($path)) {
            $disk->delete($path);
        }
    }

    /** URL publik gambar; '' bila kosong. Cadangan route media bila storage:link belum dibuat. */
    public static function url(?string $path): string
    {
        if (empty($path)) {
            return '';
        }

        if (preg_match('#^(https?:|data:)#i', $path)) {
            return $path;
        }

        if (file_exists(public_path($path))) {
            return asset($path);
        }

        if (file_exists(public_path('storage/' . $path))) {
            return asset('storage/' . $path);
        }

        if (file_exists(storage_path('app/public/' . $path))) {
            return route('media', ['path' => $path]);
        }

        return asset('storage/' . $path);
    }

    /** Apakah path menunjuk ke file yang benar-benar ada (atau URL eksternal). */
    public static function exists(?string $path): bool
    {
        if (empty($path)) {
            return false;
        }

        if (preg_match('#^(https?:|data:)#i', $path)) {
            return true;
        }

        return file_exists(public_path($path))
            || file_exists(public_path('storage/' . $path))
            || file_exists(storage_path('app/public/' . $path));
    }
}
