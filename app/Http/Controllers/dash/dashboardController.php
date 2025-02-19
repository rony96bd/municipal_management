<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSettings;

class dashboardController extends Controller
{
    public function dashboard()
    {
        $page_title = 'ড্যাশবোর্ড';
        $settings = SiteSettings::first();
        return view('dashboard.dashboard', compact('page_title'));
    }
}
