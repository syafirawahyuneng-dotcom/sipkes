<?php

namespace App\Models;

use App\Models\Concerns\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advantage extends Model
{
    use HasFactory, HasImage;

    protected $fillable = [
        'title',
        'icon',
        'image',
        'description',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];
}

