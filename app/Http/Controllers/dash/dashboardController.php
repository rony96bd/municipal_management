<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function dashboard()
    {
        $page_title = 'ড্যাশবোর্ড';
        return view('dashboard.dashboard', compact('page_title'));
    }
}
