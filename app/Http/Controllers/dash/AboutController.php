<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use App\Models\about\AboutModel;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $page_title = 'পৌরসভা সম্পর্কে';
        $about = AboutModel::first();
        return view('dashboard.about.about', compact('page_title', 'about'));
    }

    public function store()
    {
        $validated = request()->validate([
            'about_institute' => 'required',
        ]);
        $about = AboutModel::firstOrNew();
        $about->about_institute = $validated['about_institute'];
        $about->save();

        return back()->with('success', 'সফলভাবে সেভ হয়েছে');
    }
}
