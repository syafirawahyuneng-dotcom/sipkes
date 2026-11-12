<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'description',
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

        // Public storage file
        if (file_exists(public_path('storage/' . $this->image)) || file_exists(storage_path('app/public/' . $this->image))) {
            return asset('storage/' . $this->image);
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

