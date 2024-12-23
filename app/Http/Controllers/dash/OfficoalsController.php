<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use App\Models\officials\officials;
use Illuminate\Http\Request;

class OfficoalsController extends Controller
{
    public function officialslist()
    {
        $page_title = 'কর্মকর্তা সমূহ';
        $officials = officials::all();
        return view('dashboard.officials.officials', compact('page_title', 'officials'));
    }

    public function createofficial()
    {
        $page_title = 'নতুন কর্মকর্তা যুক্ত করুন';
        return view('dashboard.officials.create-officials', compact('page_title'));
    }

    public function store(Request $request)
    {
        // Validation rules
        $request->validate([
            'offificial_name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'bcs' => 'nullable|string|max:255',
            'bcsid' => 'nullable|string|max:255',
            'office_phone' => 'required|string|max:15',
            'home_phone' => 'required|string|max:15',
            'fax' => 'nullable|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'home_district' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'page_url' => 'required|string|alpha_dash|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images/officials', 'public');
        }

        // Generate unique page_url
        $pageUrl = $request->page_url;
        $originalUrl = $pageUrl;
        $counter = 1;

        // Check if the page_url already exists
        while (Officials::where('page_url', $pageUrl)->exists()) {
            $pageUrl = $originalUrl . '-' . $counter;
            $counter++;
        }

        // Save the new official's data
        $official = new Officials();
        $official->offificial_name = $request->offificial_name;
        $official->designation = $request->designation;
        $official->bcs = $request->bcs;
        $official->bcsid = $request->bcsid;
        $official->office_phone = $request->office_phone;
        $official->home_phone = $request->home_phone;
        $official->fax = $request->fax;
        $official->mobile = $request->mobile;
        $official->email = $request->email;
        $official->home_district = $request->home_district;
        $official->joining_date = $request->joining_date;
        $official->page_url = $pageUrl;  // Assign the unique page_url
        $official->image = $imagePath;
        $official->save();

        // Redirect back with success message
        return redirect()->route('officialslist')->with('success', "সফলভাবে {$request->offificial_name} কর্মকর্তা যুক্ত হয়েছে");
    }



    // public function edit($id)
    // {
    //     $page_title = 'পাতা সম্পাদনা করুন';
    //     $page = officials::findOrFail($id);
    //     return view('dashboard.pages.create-page', compact('page_title', 'page'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'page_name' => 'required',
    //         'page_url' => 'required',
    //         'page_data' => 'required',
    //     ]);

    //     $page = officials::findOrFail($id);

    //     // Generate a unique URL excluding the current page ID
    //     $page_url = $this->generateUniqueUrl($request->page_url, $id);

    //     $page->page_name = $request->page_name;
    //     $page->page_url = $page_url;
    //     $page->page_data = $request->page_data;
    //     $page->save();

    //     return redirect()->route('pages')->with('success', "সফলভাবে {$request->page_name} পাতা আপডেট হয়েছে");
    // }

    public function destroy($id)
    {
        $page = officials::findOrFail($id); // Find the page by ID
        $page_name = $page->page_name; // Store page name for feedback
        $page->delete(); // Delete the page

        return redirect()->back()->with('success', "{$page_name} পাতা সফলভাবে মুছে ফেলা হয়েছে।");
    }

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
            officials::where('page_url', $url)
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
