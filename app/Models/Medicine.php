<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'expired_date' => 'date',
        'price' => 'decimal:2',
        'stock' => 'integer',
        'min_stock' => 'integer',
    ];

    public function isLowStock(): bool
    {
        return $this->stock <= $this->min_stock;
    }
}

