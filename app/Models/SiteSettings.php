<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    protected $table = 'site_settings';

    // Specify fillable fields if you want to use mass assignment
    protected $fillable = ['site_name', 'site_logo', 'meta_description'];
}
