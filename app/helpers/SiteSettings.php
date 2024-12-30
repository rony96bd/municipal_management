<?php

use App\Models\SiteSettings;

if (!function_exists('getSiteSettings')) {
    function getSiteSettings()
    {
        return SiteSettings::first();
    }
}
