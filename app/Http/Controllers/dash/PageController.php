<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use App\Models\page\createpage;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function pagelist()
    {
        $page_title = 'পাতা সমূহ';
        $pages = createpage::all();
        return view('dashboard.pages.pages', compact('page_title', 'pages'));
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
        ]);

        // Generate a unique URL
        $page_url = $this->generateUniqueUrl($request->page_url);

        $page = new createpage();
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
        ]);

        $page = createpage::findOrFail($id);

        // Generate a unique URL excluding the current page ID
        $page_url = $this->generateUniqueUrl($request->page_url, $id);

        $page->page_name = $request->page_name;
        $page->page_url = $page_url;
        $page->page_data = $request->page_data;
        $page->save();

        return redirect()->route('pages')->with('success', "সফলভাবে {$request->page_name} পাতা আপডেট হয়েছে");
    }

    public function destroy($id)
    {
        $page = createpage::findOrFail($id); // Find the page by ID
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
}
