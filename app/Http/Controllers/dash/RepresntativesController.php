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
        $representatives = representatives::all();
        return view('dashboard.representatives.representatives', compact('page_title', 'representatives'));
    }

    public function createsrepresentative()
    {
        $page_title = 'নতুন জনপ্রতিনিধি যুক্ত করুন';
        return view('dashboard.representatives.create-representatives', compact('page_title'));
    }

    public function store(Request $request)
    {
        // Validation rules
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'word_number' => 'nullable|string|max:15',
            'office_phone' => 'required|string|max:15',
            'home_phone' => 'nullable|string|max:15',
            'fax' => 'nullable|string|max:15',
            'mobile' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'home_district' => 'nullable|string|max:255',
            'joining_date' => 'required|date',
            'page_url' => 'required|string|alpha_dash|max:255',
            'elected_type' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'presentaddress' => 'nullable|string|max:255',
            'permanentaddress' => 'nullable|string|max:255',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images/stuffs', 'public');
        }

        // Generate unique page_url
        $pageUrl = $request->page_url;
        $originalUrl = $pageUrl;
        $counter = 1;

        // Ensure the page_url is unique
        while (representatives::where('page_url', $pageUrl)->exists()) {
            $pageUrl = $originalUrl . '-' . $counter;
            $counter++;
        }
        $designationMap = [
            '1' => 'চেয়ারম্যান',
            '2' => 'মেম্বার',
            '3' => 'মেম্বার (মহিলা)',
        ];
        $designationText = $designationMap[$request->designation] ?? '';
        // Save the new representative's data
        $representatives = new representatives();
        $representatives->name = $request->name;
        $representatives->designation = $request->designation;
        $representatives->word_number = $request->word_number;
        $representatives->office_phone = $request->office_phone;
        $representatives->home_phone = $request->home_phone;
        $representatives->fax = $request->fax;
        $representatives->mobile = $request->mobile;
        $representatives->email = $request->email;
        $representatives->home_district = $request->home_district;
        $representatives->joining_date = $request->joining_date;
        $representatives->page_url = $pageUrl;
        $representatives->elected_type = $request->elected_type;
        $representatives->image = $imagePath;
        $representatives->presentaddress = $request->presentaddress;
        $representatives->permanentaddress = $request->permanentaddress;
        $representatives->save();

        // Redirect with a success message
        return redirect()->route('representativeslist')
            ->with('success', "সফলভাবে '{$request->name} - {$designationText}' জনপ্রদিনিধি যুক্ত হয়েছে");
    }


    public function edit($id)
    {
        $page_title = 'জনপ্রতিনিধির তথ্য সম্পাদনা করুন';
        $page = representatives::findOrFail($id);
        return view('dashboard.representatives.create-representatives', compact('page_title', 'page'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'word_number' => 'nullable|string|max:15',
            'office_phone' => 'required|string|max:15',
            'home_phone' => 'nullable|string|max:15',
            'fax' => 'nullable|string|max:15',
            'mobile' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'home_district' => 'nullable|string|max:255',
            'joining_date' => 'required|date',
            'page_url' => 'required|string|alpha_dash|max:255',
            'elected_type' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'presentaddress' => 'nullable|string|max:255',
            'permanentaddress' => 'nullable|string|max:255',
        ]);

        $representatives = representatives::findOrFail($id);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images/stuffs', 'public');
        }

        // Generate unique page_url
        $pageUrl = $request->page_url;
        $originalUrl = $pageUrl;
        $counter = 1;

        // Ensure the page_url is unique
        while (representatives::where('page_url', $pageUrl)->exists()) {
            $pageUrl = $originalUrl . '-' . $counter;
            $counter++;
        }

        $designationMap = [
            '1' => 'চেয়ারম্যান',
            '2' => 'মেম্বার',
            '3' => 'মেম্বার (মহিলা)',
        ];
        $designationText = $designationMap[$request->designation] ?? '';
        // Save the new representative's data
        $representatives->name = $request->name;
        $representatives->designation = $request->designation;
        $representatives->word_number = $request->word_number;
        $representatives->office_phone = $request->office_phone;
        $representatives->home_phone = $request->home_phone;
        $representatives->fax = $request->fax;
        $representatives->mobile = $request->mobile;
        $representatives->email = $request->email;
        $representatives->home_district = $request->home_district;
        $representatives->joining_date = $request->joining_date;
        $representatives->page_url = $pageUrl;
        $representatives->elected_type = $request->elected_type;
        $representatives->image = $imagePath;
        $representatives->presentaddress = $request->presentaddress;
        $representatives->permanentaddress = $request->permanentaddress;
        $representatives->save();

        // Redirect with a success message
        return redirect()->route('representativeslist')
            ->with('success', "সফলভাবে '{$request->name} - {$designationText}' জনপ্রদিনিধির তথ্য সংস্কার হয়েছে");
    }

    public function destroy($id)
    {
        $page = representatives::findOrFail($id); // Find the page by ID
        $name = $page->name; // Store page name for feedback
        $page->delete(); // Delete the page

        return redirect()->back()->with('success', "{$name} জনপ্রতিনিধির তথ্য সফলভাবে মুছে ফেলা হয়েছে।");
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
            representatives::where('page_url', $url)
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
