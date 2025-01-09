<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    // Specify the table if it's different from the default pluralized name
    protected $table = 'site_settings';

    // Set the fillable attributes for mass assignment
    protected $fillable = [
        'site_name',
        'meta_description',
        'site_logo',
        'site_banner',
        'primary_color',
        'secondary_color',
        'paragraph_color',
        'danger_color',
        'alert_color',
        'success_color',
        'warning_color',
        'background_gray',
        'google_font',  // Add google_font to the fillable array
    ];

    // Optional: Specify the attributes that should be cast to specific types
    protected $casts = [
        'primary_color' => 'string',
        'secondary_color' => 'string',
        'paragraph_color' => 'string',
        'danger_color' => 'string',
        'alert_color' => 'string',
        'success_color' => 'string',
        'warning_color' => 'string',
        'background_gray' => 'string',
        'google_font' => 'string',  // Optionally cast google_font to string
    ];
}
