<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\officials\Officials;
use App\Models\representatives\representatives;
use App\Models\stuff\Stuff;
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

    public function officerDetails($page_url)
    {
        $officer = Officials::where('page_url', $page_url)->first();
        $page_title = $officer->offificial_name;
        return view('front-views.pages.singe-pages.officials', compact('page_title', 'officer'));
    }

    public function stuffs()
    {
        $page_title = 'কর্মচারী বৃন্দ';
        $stuffs = Stuff::all();
        return view('front-views.pages.stuffs', compact('page_title', 'stuffs'));
    }

    public function stuffDetails($page_url)
    {
        $stuff = Stuff::where('page_url', $page_url)->first();
        $page_title = $stuff->stuff_name;
        return view('front-views.pages.singe-pages.stuff', compact('page_title', 'stuff'));
    }

    public function representatives()
    {
        $page_title = 'জনপ্রদিনিধী';
        $representatives = representatives::all();
        return view('front-views.pages.representatives', compact('page_title', 'representatives'));
    }

    public function representativeDetails($page_url)
    {
        $representative = representatives::where('page_url', $page_url)->first();
        $page_title = $representative->name;
        return view('front-views.pages.singe-pages.representative', compact('page_title', 'representative'));
    }
}
