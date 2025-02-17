<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\about\AboutModel;
use App\Models\banner_slidder\BannerSlidderModel;
use App\Models\gallery\GalleryModel;
use App\Models\news\NewsModel;
use App\Models\notice\NoticeModel;
use App\Models\officials\officials;
use App\Models\page\createpage;
use App\Models\representatives\representatives;
use App\Models\stuff\Stuff;
use App\Models\Service\Service;
use App\Models\sidebar\SidebarModel;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $page_title = 'স্বাগতম';
        $services = Service::with('singleServices')->get();
        $notices = NoticeModel::orderBy('order', 'asc')->get();
        $news = NewsModel::orderBy('order', 'asc')->paginate(10);
        $officials = officials::orderBy('order', 'asc')->get();
        $official = officials::where('order', 1)->first();
        $representatives = representatives::orderBy('order', 'asc')->get();
        $about = AboutModel::first();
        $galleries = GalleryModel::orderBy('order', 'asc')->paginate(6);
        $slidders = BannerSlidderModel::orderBy('order', 'asc')->paginate(5);
        $sidebars = SidebarModel::orderByRaw('CONVERT(`order`, SIGNED) ASC')->get();
        return view('front-views.pages.index', compact('page_title', 'services', 'notices', 'officials', 'representatives', 'official', 'about', 'galleries', 'slidders', 'news', 'sidebars'));
    }

    public function officers()
    {
        $page_title = 'কর্মকর্তাবৃন্দ';
        $officers = officials::all();
        return view('front-views.pages.officers', compact('page_title', 'officers'));
    }

    public function officerDetails($page_url)
    {
        $officer = officials::where('page_url', $page_url)->first();
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

    public function singlepage($page_url)
    {
        $page = createpage::where('page_url', $page_url)->first();
        $page_title = $page->page_name;
        return view('front-views.pages.singe-pages.single-page', compact('page_title', 'page'));
    }
}
