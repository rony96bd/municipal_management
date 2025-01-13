<?php

namespace App\Models\media;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaModel extends Model
{
    use HasFactory;
    protected $table = 'medias';
    protected $fillable = [
        'file_name',
        'file_path',
        'file_type',
    ];
}
