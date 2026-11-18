<?php

namespace App\Models;

use App\Models\Concerns\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportService extends Model
{
    use HasFactory, HasImage;

    protected $fillable = [
        'title',
        'icon',
        'summary',
        'description',
        'benefits',
        'image',
        'is_active',
        'order',
    ];

    protected $casts = [
        'benefits' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}

