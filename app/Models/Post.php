<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'content',
        'image_path',
        'page_url',
    ];

    public function images()
    {
        return $this->hasMany(PostImage::class)->orderBy('order');
    }
}


