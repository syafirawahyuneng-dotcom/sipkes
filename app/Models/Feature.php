<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory, HasUniqueSlug;

    protected string $slugSource = 'name';

    protected $fillable = [
        'name',
        'slug',
        'category',
        'icon',
        'description',
        'users',
        'functions',
        'benefits',
        'workflow',
        'is_featured',
        'order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Ubah kolom teks multi-baris (satu poin per baris) menjadi array poin.
     * Penanda daftar di awal baris (•, -, *, angka.) dibuang.
     */
    public function listOf(string $field): array
    {
        $lines = preg_split('/\r\n|\r|\n/', (string) $this->{$field});

        return array_values(array_filter(array_map(
            fn ($line) => trim(preg_replace('/^\s*(?:[•\-\*]|\d+[.)])\s*/u', '', $line)),
            $lines
        ), fn ($line) => $line !== ''));
    }

    public function getDetailUrlAttribute(): string
    {
        return route('features.show', $this);
    }
}
