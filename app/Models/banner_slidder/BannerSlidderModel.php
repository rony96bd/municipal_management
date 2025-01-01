<?php

namespace App\Models\banner_slidder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerSlidderModel extends Model
{
    use HasFactory;
    protected $table = 'banner_slidders';
    // Define the attributes that are mass assignable
    protected $fillable = [
        'order',
        'title',
        'image',
    ];
}
