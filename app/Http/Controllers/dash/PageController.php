<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use App\Models\page\createpage;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function pagelist(Request $request)
    {
        $page_title = 'পাতা সমূহ';
        $search = $request->input('search'); // Get the search query

        // If there is a search query, filter the pages
        if ($search) {
            $pages = createpage::where('page_name', 'like', '%' . $search . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        } else {
            // If no search query, get all pages
            $pages = createpage::orderBy('created_at', 'desc')->paginate(20);
        }

        return view('dashboard.pages.pages', compact('page_title', 'pages', 'search'));
    }


    public function createpage()
    {
        $page_title = 'নতুন পাতা তৈরি করুন';
        return view('dashboard.pages.create-page', compact('page_title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_name' => 'required',
            'page_url' => 'required',
            'page_data' => 'required',
            'file_upload' => 'nullable|mimes:pdf,doc,docx,csv,xls,xlsx,jpg,jpeg,png|max:5048', // File can be null
        ]);

        $page = new createpage();

        $filePath = null;
        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Generate unique file name
            $file->move('pages', $fileName); // Save to public/attestments
            $filePath = 'pages/' . $fileName; // Save relative path for database
            $page->file_path = $filePath; // Save the file path or null if no file uploaded
        }

        // Generate a unique URL
        $page_url = $this->generateUniqueUrl($request->page_url);
        $page->page_name = $request->page_name;
        $page->page_url = $page_url;
        $page->page_data = $request->page_data;
        $page->save();

        return redirect()->back()->with('success', "সফলভাবে {$request->page_name} পাতা তৈরি হয়েছে");
    }

    public function edit($id)
    {
        $page_title = 'পাতা সম্পাদনা করুন';
        $page = createpage::findOrFail($id);
        return view('dashboard.pages.create-page', compact('page_title', 'page'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'page_name' => 'required',
            'page_url' => 'required',
            'page_data' => 'required',
            'file_upload' => 'nullable|mimes:pdf,doc,docx,csv,xls,xlsx|max:2048', // File can be null
        ]);

        // Find the existing page by ID
        $page = createpage::findOrFail($id);

        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Generate unique file name
            $file->move('pages', $fileName); // Save to public/attestments
            $filePath = 'pages/' . $fileName; // Save relative path for database
            $page->file_path = $filePath; // Save the file path or null if no file uploaded
        }

        // Generate a unique URL excluding the current page ID
        $page_url = $this->generateUniqueUrl($request->page_url, $id);

        // Update the page data
        $page->page_name = $request->page_name;
        $page->page_url = $page_url;
        $page->page_data = $request->page_data;
        $page->save();

        // Redirect with a success message
        return redirect()->route('pages')->with('success', "সফলভাবে {$request->page_name} পাতা আপডেট হয়েছে");
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
            createpage::where('page_url', $url)
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

    public function destroy($id)
    {
        $page = createpage::findOrFail($id); // Find the page by ID
        $page_name = $page->page_name; // Store page name for feedback
        $page->delete(); // Delete the page

        return redirect()->back()->with('success', "{$page_name} পাতা সফলভাবে মুছে ফেলা হয়েছে।");
    }


    // In your Controller (e.g., OfficialsController)
    public function updatePageOrder(Request $request)
    {
        $orderedIds = $request->input('orderedIds'); // This is the list of IDs from the client-side

        // Loop through the ordered IDs and update the 'order' field
        foreach ($orderedIds as $index => $id) {
            $official = createpage::find($id); // Find the official by ID
            if ($official) {
                $official->order = $index + 1; // Assuming 'order' is the field you want to update
                $official->save(); // Save the updated order
            }
        }

        return response()->json(['success' => true]);
    }
}
