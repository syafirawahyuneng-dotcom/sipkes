<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    use HasUniqueSlug;

    protected string $slugSource = 'name';

    protected $fillable = ['name', 'slug'];

    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id');
    }
}
