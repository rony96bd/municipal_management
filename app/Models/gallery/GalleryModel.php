<?php

namespace App\Models\gallery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryModel extends Model
{
    use HasFactory;
    protected $table = 'galleries';
    // Define the attributes that are mass assignable
    protected $fillable = [
        'topic',
        'description',
        'page_url',
        'image_path', // Store a serialized or JSON string of image paths
    ];

    // Optionally, cast image_paths as an array to easily access individual paths
    protected $casts = [
        'path' => 'array', // Store the paths as an array in the database
    ];
}
