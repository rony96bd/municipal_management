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
        // Validate input fields
        $validateData = $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
        ]);

        // Create a new instance of BannerSlidderModel
        $slidder = new BannerSlidderModel();
        $slidder->title = $validateData['title'];

        // Handle image upload if present
        if ($request->hasFile('image')) {
            $image = $request->file('image'); // Get the uploaded image
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Generate a unique name

            // Move the image to the public directory (images/slidders)
            $image->move(public_path('images/slidders'), $imageName);

            // Store the image path in the database (for later retrieval)
            $slidder->image = 'images/slidders/' . $imageName;  // Save the relative path
        }

        // Save the BannerSlidderModel to the database
        $slidder->save();

        // Redirect or return response if needed
        return redirect()->back()->with('success', 'ব্যানার ইমের সফলভাবে যুক্ত করা হয়েছে');
    }
}
