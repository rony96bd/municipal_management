<?php

namespace App\Models\notice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeModel extends Model
{
    use HasFactory;

    // Define the table associated with the model (optional if it follows Laravel naming conventions)
    protected $table = 'notices';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'topic',
        'description',
        'file_path',
    ];
}
