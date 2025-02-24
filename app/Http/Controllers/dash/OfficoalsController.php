<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use App\Models\officials\officials;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OfficoalsController extends Controller
{
    public function officialslist()
    {
        $page_title = 'কর্মকর্তা সমূহ';
        $officials = officials::orderBy('order', 'asc')->get();
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

            // Generate the file name using the post ID after saving the official
            $imageName = time() . '-' . $request->page_url . '.' . $image->getClientOriginalExtension();

            // Save the image to the public folder, within the 'images/officials' directory
            $image->move('images/officials', $imageName);

            // Set the image path
            $imagePath = 'images/officials/' . $imageName;
        }

        // Generate unique page_url
        $pageUrl = $request->page_url;
        $originalUrl = $pageUrl;
        $counter = 1;

        // Check if the page_url already exists
        while (officials::where('page_url', $pageUrl)->exists()) {
            $pageUrl = $originalUrl . '-' . $counter;
            $counter++;
        }

        $slug = Str::slug($request->stuff_name);
        $randomNumber = mt_rand(1000, 9999);
        // Save the new official's data
        $official = new officials();
        $official->offificial_name = $request->offificial_name;
        $official->designation = $request->designation;
        $official->bcs = $request->bcs;
        $official->bcsid = $request->bcsid;
        $official->edu = $request->edu;
        $official->office_phone = $request->office_phone;
        $official->home_phone = $request->home_phone;
        $official->fax = $request->fax;
        $official->mobile = $request->mobile;
        $official->email = $request->email;
        $official->nid = $request->nid;
        $official->first_joining = $request->first_joining;
        $official->prl_date = $request->prl_date;
        $official->first_designation = $request->first_designation;
        $official->home_district = $request->home_district;
        $official->joining_date = $request->joining_date;
        $official->page_url = $slug . '-' . $randomNumber;
        $official->image = $imagePath;  // Save the image path
        $official->save();

        // Redirect back with success message
        return redirect()->route('officialslist')->with('success', "সফলভাবে {$request->offificial_name} কর্মকর্তা যুক্ত হয়েছে");
    }




    public function edit($id)
    {
        $page_title = 'কর্মকর্তার তথ্য সম্পাদনা করুন';
        $page = officials::findOrFail($id);
        return view('dashboard.officials.create-officials', compact('page_title', 'page'));
    }

    public function update(Request $request, $id)
    {
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

        $official = officials::findOrFail($id);

        // Handle image upload
        $imagePath = $official->image; // Keep the current image if no new one is uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Generate the new filename with a timestamp and the page_url
            $imageName = time() . '-' . $request->id . '.' . $image->getClientOriginalExtension();

            // Move the image to the public folder with the new filename
            $image->move('images/officials', $imageName);

            // Set the image path
            $imagePath = 'images/officials/' . $imageName;

            $official->image = $imagePath;   // Save the image path (if updated)
        }

        // Update the official's data
        $official->offificial_name = $request->offificial_name;
        $official->designation = $request->designation;
        $official->bcs = $request->bcs;
        $official->bcsid = $request->bcsid;
        $official->office_phone = $request->office_phone;
        $official->home_phone = $request->home_phone;
        $official->fax = $request->fax;
        $official->mobile = $request->mobile;
        $official->email = $request->email;
        $official->nid = $request->nid;
        $official->first_joining = $request->first_joining;
        $official->prl_date = $request->prl_date;
        $official->first_designation = $request->first_designation;
        $official->home_district = $request->home_district;
        $official->joining_date = $request->joining_date;
        $official->save();

        return redirect()->route('officialslist')->with('success', "সফলভাবে কর্মকর্তার '{$request->offificial_name}' এর তথ্য আপডেট হয়েছে");
    }



    public function destroy($id)
    {
        $page = officials::findOrFail($id); // Find the page by ID
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


    // In your Controller (e.g., OfficialsController)
    public function updateOrder(Request $request)
    {
        $orderedIds = $request->input('orderedIds'); // This is the list of IDs from the client-side

        // Loop through the ordered IDs and update the 'order' field
        foreach ($orderedIds as $index => $id) {
            $official = officials::find($id); // Find the official by ID
            if ($official) {
                $official->order = $index + 1; // Assuming 'order' is the field you want to update
                $official->save(); // Save the updated order
            }
        }

        return response()->json(['success' => true]);
    }
}
