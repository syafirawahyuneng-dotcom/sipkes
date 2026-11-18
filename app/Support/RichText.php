<?php

namespace App\Support;

use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Support\Str;

/**
 * Konten berformat dari WYSIWYG editor (TinyMCE).
 *
 * - clean()  : sanitasi HTML (whitelist tag) sebelum disimpan / ditampilkan.
 * - render() : HTML siap tampil; konten teks polos lama diubah menjadi paragraf.
 * - plain()  : teks polos tanpa tag untuk kartu, ringkasan, dan meta.
 */
class RichText
{
    private static ?HTMLPurifier $purifier = null;

    /** Sanitasi HTML dari editor. Hasil kosong (mis. hanya "<p></p>") menjadi null. */
    public static function clean(?string $html): ?string
    {
        if ($html === null || trim($html) === '') {
            return null;
        }

        $clean = trim(self::purifier()->purify($html));

        return self::isEmpty($clean) ? null : $clean;
    }

    /** HTML aman untuk ditampilkan dengan {!! !!}. */
    public static function render(?string $value): string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return '';
        }

        if (self::isHtml($value)) {
            return (string) self::clean($value);
        }

        // Teks polos lama: paragraf dipisah baris kosong, baris tunggal menjadi <br>.
        $paragraphs = array_filter(array_map('trim', preg_split('/\R\s*\R/u', $value)), fn ($p) => $p !== '');

        return implode("\n", array_map(fn ($p) => '<p>' . nl2br(e($p), false) . '</p>', $paragraphs));
    }

    /** Teks polos (tanpa tag), spasi dirapikan, opsional dipotong. */
    public static function plain(?string $value, ?int $limit = null): string
    {
        $value = (string) $value;
        // Beri jarak antar-blok agar kata dari paragraf berbeda tidak menempel.
        $value = preg_replace('/<\/(p|h[1-6]|li|blockquote|td|th|div)>|<br\s*\/?>/i', ' ', $value);
        $text = trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8')));

        return $limit ? Str::limit($text, $limit) : $text;
    }

    /** Konten dianggap kosong bila tidak ada teks maupun gambar. */
    public static function isEmpty(?string $value): bool
    {
        $value = (string) $value;

        return self::plain($value) === '' && stripos($value, '<img') === false;
    }

    public static function isHtml(string $value): bool
    {
        return (bool) preg_match('/<\s*\/?\s*(p|br|h[1-6]|ul|ol|li|strong|b|em|i|u|s|a|blockquote|table|div|span|img)\b[^>]*>/i', $value);
    }

    /** Estimasi menit baca (±200 kata/menit). */
    public static function readingMinutes(?string $value): int
    {
        return max(1, (int) ceil(str_word_count(self::plain($value)) / 200));
    }

    private static function purifier(): HTMLPurifier
    {
        if (self::$purifier) {
            return self::$purifier;
        }

        $config = HTMLPurifier_Config::createDefault();
        $config->set('Core.Encoding', 'UTF-8');
        $config->set('HTML.Doctype', 'HTML 4.01 Transitional');
        $config->set('HTML.Allowed', implode(',', [
            'p[style]', 'br', 'h2[style]', 'h3[style]', 'h4[style]',
            'strong', 'b', 'em', 'i', 'u', 's', 'strike', 'sub', 'sup', 'span[style]', 'hr',
            'ul[style]', 'ol[style]', 'li[style]', 'blockquote',
            'a[href|title|target|rel]',
            'img[src|alt|width|height|style]',
            'table[style|border|cellpadding|cellspacing]', 'thead', 'tbody', 'tfoot', 'tr',
            'th[style|colspan|rowspan]', 'td[style|colspan|rowspan]', 'caption',
        ]));
        $config->set('CSS.AllowedProperties', ['text-align', 'text-decoration', 'width', 'height', 'float', 'margin', 'margin-left', 'margin-right', 'list-style-type']);
        $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true, 'tel' => true]);
        $config->set('Attr.AllowedFrameTargets', ['_blank']);
        $config->set('HTML.TargetNoopener', true);
        $config->set('HTML.TargetNoreferrer', true);
        $config->set('AutoFormat.RemoveEmpty', false);

        $cache = storage_path('framework/cache/htmlpurifier');
        if (! is_dir($cache)) {
            @mkdir($cache, 0775, true);
        }
        if (is_dir($cache) && is_writable($cache)) {
            $config->set('Cache.SerializerPath', $cache);
        } else {
            $config->set('Cache.DefinitionImpl', null);
        }

        return self::$purifier = new HTMLPurifier($config);
    }
}
