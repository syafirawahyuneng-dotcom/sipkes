<?php

namespace App\Rules;

use App\Support\RichText;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Field WYSIWYG wajib berisi teks/gambar setelah tag HTML dibuang
 * (isi yang hanya "<p></p>" atau "<p>&nbsp;</p>" dianggap kosong).
 */
class RichTextRequired implements ValidationRule
{
    public function __construct(private string $label) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (RichText::isEmpty(is_string($value) ? $value : '')) {
            $fail("{$this->label} wajib diisi.");
        }
    }
}
