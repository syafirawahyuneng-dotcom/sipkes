<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportService extends Model
{
    use HasFactory;

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

