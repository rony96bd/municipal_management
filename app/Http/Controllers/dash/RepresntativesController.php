<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use App\Models\representatives\representatives;
use Illuminate\Http\Request;

class RepresntativesController extends Controller
{
    public function representativesslist()
    {
        $page_title = 'কর্মচারী বৃন্দ';
        // $representatives = representatives::all();
        return view('dashboard.representatives.stuffs.representatives', compact('page_title'));
    }

    public function createsrepresentative()
    {
        $page_title = 'নতুন জনপ্রতিনিধি যুক্ত করুন';
        return view('dashboard.representatives.create-representatives', compact('page_title'));
    }

    // public function store(Request $request)
    // {
    //     // Validation rules
    //     $request->validate([
    //         'stuff_name' => 'required|string|max:255',
    //         'designation' => 'required|string|max:255',
    //         'office_phone' => 'required|string|max:15',
    //         'home_phone' => 'nullable|string|max:15',
    //         'mobile' => 'required|string|max:15',
    //         'email' => 'required|email|max:255',
    //         'home_district' => 'nullable|string|max:255',
    //         'joining_date' => 'nullable|date',
    //         'page_url' => 'required|string|alpha_dash|max:255',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);
    //     // Handle image upload
    //     $imagePath = null;
    //     if ($request->hasFile('image')) {
    //         $image = $request->file('image');
    //         $imagePath = $image->store('images/stuffs', 'public');
    //     }

    //     // Generate unique page_url
    //     $pageUrl = $request->page_url;
    //     $originalUrl = $pageUrl;
    //     $counter = 1;

    //     // Check if the page_url already exists
    //     while (Stuff::where('page_url', $pageUrl)->exists()) {
    //         $pageUrl = $originalUrl . '-' . $counter;
    //         $counter++;
    //     }

    //     // Save the new stuff's data
    //     $stuff = new Stuff();
    //     $stuff->stuff_name = $request->stuff_name;
    //     $stuff->designation = $request->designation;
    //     $stuff->office_phone = $request->office_phone;
    //     $stuff->home_phone = $request->home_phone;
    //     $stuff->mobile = $request->mobile;
    //     $stuff->email = $request->email;
    //     $stuff->home_district = $request->home_district;
    //     $stuff->joining_date = $request->joining_date;
    //     $stuff->page_url = $pageUrl; // Assign the unique page_url
    //     $stuff->image = $imagePath;
    //     $stuff->save();

    //     // Redirect back with success message
    //     return redirect()->route('stuffslist')->with('success', "সফলভাবে '{$request->stuff_name}' কর্মচারী যুক্ত হয়েছে");
    // }




    // public function edit($id)
    // {
    //     $page_title = 'কর্মকর্তার তথ্য সম্পাদনা করুন';
    //     $page = Stuff::findOrFail($id);
    //     return view('dashboard.officials.create-officials', compact('page_title', 'page'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'stuff_name' => 'required|string|max:255',
    //         'designation' => 'required|string|max:255',
    //         'office_phone' => 'required|string|max:15',
    //         'home_phone' => 'nullable|string|max:15',
    //         'mobile' => 'required|string|max:15',
    //         'email' => 'required|email|max:255',
    //         'home_district' => 'nullable|string|max:255',
    //         'joining_date' => 'nullable|date',
    //         'page_url' => 'required|string|alpha_dash|max:255',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $stuff = Stuff::findOrFail($id);

    //     // Handle image upload
    //     $imagePath = null;
    //     if ($request->hasFile('image')) {
    //         $image = $request->file('image');
    //         $imagePath = $image->store('images/stuffs', 'public');
    //     }

    //     // Generate unique page_url
    //     $pageUrl = $request->page_url;
    //     $originalUrl = $pageUrl;
    //     $counter = 1;

    //     // Check if the page_url already exists
    //     while (Stuff::where('page_url', $pageUrl)->exists()) {
    //         $pageUrl = $originalUrl . '-' . $counter;
    //         $counter++;
    //     }

    //     // Save the new stuff's data
    //     $stuff->stuff_name = $request->stuff_name;
    //     $stuff->designation = $request->designation;
    //     $stuff->office_phone = $request->office_phone;
    //     $stuff->home_phone = $request->home_phone;
    //     $stuff->mobile = $request->mobile;
    //     $stuff->email = $request->email;
    //     $stuff->home_district = $request->home_district;
    //     $stuff->joining_date = $request->joining_date;
    //     $stuff->page_url = $pageUrl; // Assign the unique page_url
    //     $stuff->image = $imagePath;
    //     $stuff->save();

    //     return redirect()->route('officialslist')->with('success', "সফলভাবে কর্মচারী '{$request->offificial_name}' এর তথ্য আপডেট হয়েছে");
    // }

    // public function destroy($id)
    // {
    //     $page = Stuff::findOrFail($id); // Find the page by ID
    //     $page_name = $page->page_name; // Store page name for feedback
    //     $page->delete(); // Delete the page

    //     return redirect()->back()->with('success', "{$page_name} কর্মকর্তার তথ্য সফলভাবে মুছে ফেলা হয়েছে।");
    // }

    /**
     * Generate a unique page URL by appending a counter if needed.
     *
     * @param string $url
     * @param int|null $excludeId
     * @return string
     */
    private function generateUniqueUrl($url, $excludeId = null)
    {
        $originalUrl = $url;
        $counter = 2;

        while (
            Stuff::where('page_url', $url)
            ->when($excludeId, function ($query) use ($excludeId) {
                return $query->where('id', '!=', $excludeId);
            })
            ->exists()
        ) {
            $url = "{$originalUrl}-{$counter}";
            $counter++;
        }

        return $url;
    }
}
