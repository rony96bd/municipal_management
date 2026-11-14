<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use App\Models\banner_slidder\BannerSlidderModel;
use Illuminate\Http\Request;

class BannerSlidderController extends Controller
{
    public function index()
    {
        $page_title = 'ব্যানার স্লাইডার';
        return view('dashboard.slidder.slidder', compact('page_title'));
    }
    public function create()
    {
        $page_title = 'ব্যানার স্লাইডার তৈরি করুন';
        return view('dashboard.slidder.create-slidder', compact('page_title'));
    }
    public function store(Request $request)
    {
        // Validate input fields (allows up to 15MB, compressed to print/web quality)
        $validateData = $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
        ]);

        // Create a new instance of BannerSlidderModel
        $slidder = new BannerSlidderModel();
        $slidder->title = $validateData['title'];

        // Handle image upload if present
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ext = strtolower($image->getClientOriginalExtension() ?: 'jpg');
            $imageName = time() . '.' . $ext;
            $targetPath = public_path('images/slidders/' . $imageName);

            $optimizer = new \App\Services\ImageOptimizer();
            $optimizer->optimizeUploadedFile($image, $targetPath);

            $slidder->image = 'images/slidders/' . $imageName;
        }

        // Save the BannerSlidderModel to the database
        $slidder->save();

        // Redirect or return response if needed
        return redirect()->back()->with('success', 'ব্যানার সফলভাবে যুক্ত করা হয়েছে');
    }
}
