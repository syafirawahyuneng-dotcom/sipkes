<?php

namespace App\Models;

use App\Models\Concerns\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Informasi bergambar (menu Fitur & Layanan → Informasi).
 * - description : keterangan singkat (teks polos)
 * - date        : tanggal informasi
 * - is_active   : hanya yang aktif tampil di portal publik
 */
class Information extends Model
{
    use HasFactory, HasImage;

    protected $table = 'information';

    protected $fillable = [
        'title',
        'description',
        'image',
        'date',
        'is_active',
        'order',
    ];

    protected $casts = [
        'date' => 'date',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderByDesc('date')->orderByDesc('id');
    }
}
