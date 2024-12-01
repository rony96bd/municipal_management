<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class frontController extends Controller
{
    public function index(){
        $page_title = 'স্বাগতম';
        return view('front-views.pages.index', compact('page_title'));
    }
}
