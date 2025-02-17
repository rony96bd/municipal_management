<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use App\Models\stuff\Stuff;
use Illuminate\Http\Request;

class StuffsController extends Controller
{
    public function stuffslist()
    {
        $page_title = 'কর্মচারী বৃন্দ';
        $stuffs = Stuff::orderBy('order', 'asc')->get();
        return view('dashboard.stuffs.stuffs', compact('page_title', 'stuffs'));
    }

    public function createstuff()
    {
        $page_title = 'নতুন কর্মচারী যুক্ত করুন';
        return view('dashboard.stuffs.create-stuff', compact('page_title'));
    }

    public function store(Request $request)
    {
        // Validation rules
        $request->validate([
            'stuff_name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'office_phone' => 'required|string|max:15',
            'home_phone' => 'nullable|string|max:15',
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
            $imagePath = $image->store('images/stuffs', 'public');
        }

        // Generate unique page_url
        $pageUrl = $request->page_url;
        $originalUrl = $pageUrl;
        $counter = 1;

        // Check if the page_url already exists
        while (Stuff::where('page_url', $pageUrl)->exists()) {
            $pageUrl = $originalUrl . '-' . $counter;
            $counter++;
        }

        // Save the new stuff's data
        $stuff = new Stuff();
        $stuff->stuff_name = $request->stuff_name;
        $stuff->designation = $request->designation;
        $stuff->office_phone = $request->office_phone;
        $stuff->home_phone = $request->home_phone;
        $stuff->mobile = $request->mobile;
        $stuff->email = $request->email;
        $stuff->home_district = $request->home_district;
        $stuff->joining_date = $request->joining_date;
        $stuff->page_url = $pageUrl; // Assign the unique page_url
        $stuff->image = $imagePath;
        $stuff->save();

        // Redirect back with success message
        return redirect()->route('stuffslist')->with('success', "সফলভাবে '{$request->stuff_name}' কর্মচারী যুক্ত হয়েছে");
    }

    public function edit($id)
    {
        $page_title = 'কর্মচারীর তথ্য সম্পাদনা করুন';
        $page = Stuff::findOrFail($id);
        return view('dashboard.stuffs.create-stuff', compact('page_title', 'page'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'stuff_name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'home_district' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'page_url' => 'required|string|alpha_dash|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $stuff = Stuff::findOrFail($id);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images/stuffs', 'public');
        }

        // Get the original page_url from the request
        $pageUrl = $request->page_url;

        // Check if the page_url exists for any other Stuff record, but not for the current one
        $existingStuff = Stuff::where('page_url', $pageUrl)
            ->where('id', '!=', $id) // Exclude the current Stuff's ID
            ->first();

        if ($existingStuff) {
            // If the page_url exists for another Stuff, append a counter
            $originalUrl = $pageUrl;
            $counter = 1;

            // Find a unique page_url by appending a counter
            while (Stuff::where('page_url', $pageUrl)->exists()) {
                $pageUrl = $originalUrl . '-' . $counter;
                $counter++;
            }
        }

        // Save the updated Stuff data
        $stuff->stuff_name = $request->stuff_name;
        $stuff->designation = $request->designation;
        $stuff->office_phone = $request->office_phone;
        $stuff->home_phone = $request->home_phone;
        $stuff->mobile = $request->mobile;
        $stuff->email = $request->email;
        $stuff->home_district = $request->home_district;
        $stuff->joining_date = $request->joining_date;
        $stuff->page_url = $pageUrl;  // Assign the updated page_url
        $stuff->image = $imagePath;
        $stuff->save();

        return redirect()->route('stuffslist')->with('success', "সফলভাবে কর্মচারী '{$request->stuff_name}' এর তথ্য আপডেট হয়েছে");
    }

    public function destroy($id)
    {
        $page = Stuff::findOrFail($id); // Find the page by ID
        $page_name = $page->page_name; // Store page name for feedback
        $page->delete(); // Delete the page

        return redirect()->back()->with('success', "{$page_name} কর্মকর্তার তথ্য সফলভাবে মুছে ফেলা হয়েছে।");
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



    // In your Controller (e.g., OfficialsController)
    public function updateOrder(Request $request)
    {
        $orderedIds = $request->input('orderedIds'); // This is the list of IDs from the client-side

        // Loop through the ordered IDs and update the 'order' field
        foreach ($orderedIds as $index => $id) {
            $official = Stuff::find($id); // Find the official by ID
            if ($official) {
                $official->order = $index + 1; // Assuming 'order' is the field you want to update
                $official->save(); // Save the updated order
            }
        }

        return response()->json(['success' => true]);
    }
}
