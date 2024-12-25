<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\officials\Officials;
use Illuminate\Http\Request;

class frontController extends Controller
{
    public function index()
    {
        $page_title = 'স্বাগতম';
        return view('front-views.pages.index', compact('page_title'));
    }

    public function officers()
    {
        $page_title = 'কর্মচারী বৃন্দ';
        $officers = Officials::all();
        return view('front-views.pages.officers', compact('page_title', 'officers'));
    }
}
