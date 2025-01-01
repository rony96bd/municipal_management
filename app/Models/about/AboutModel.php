<?php

namespace App\Models\about;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutModel extends Model
{
    use HasFactory;

    // Define the table associated with the model (optional if it follows Laravel naming conventions)
    protected $table = 'about';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'about_institute',
    ];
}
