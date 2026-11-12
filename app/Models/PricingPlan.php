<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'period',
        'badge',
        'description',
        'features_list',
        'terms',
        'is_active',
        'order',
    ];

    protected $casts = [
        'features_list' => 'array',
        'terms' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'order' => 'integer',
    ];
}

