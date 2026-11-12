<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'institution',
        'tagline',
        'about_tefa',
        'about_sipkes',
        'vision',
        'mission',
        'goals',
        'background',
        'image',
    ];
}

