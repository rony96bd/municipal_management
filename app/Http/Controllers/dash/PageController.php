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

        $page = new createpage();
        $page->page_name = $request->page_name;
        $page->page_url = $request->page_url;
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

        $page = createpage::findOrFail($id);  // Find the page by its ID
        $page->page_name = $request->page_name;
        $page->page_url = $request->page_url;
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
}
