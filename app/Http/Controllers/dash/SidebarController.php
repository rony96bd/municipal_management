<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use App\Models\news\NewsModel;
use App\Models\notice\NoticeModel;
use App\Models\officials\officials;
use App\Models\page\createpage;
use App\Models\representatives\representatives;
use App\Models\Service\Service;
use App\Models\Service\SingleService;
use App\Models\sidebar\SidebarModel;
use App\Models\stuff\Stuff;
use Illuminate\Support\Facades\Validator; // Add this at the top of the file
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SidebarController extends Controller
{
    public function index()
    {
        $page_title = 'সাইডবার';
        $officials = officials::all();
        $stuffs = Stuff::all();
        $representatives = representatives::all();
        $pages = createpage::all();
        $notices = NoticeModel::all();
        $news = NewsModel::all();
        $services = SingleService::all();
        $sidebars = SidebarModel::orderByRaw('CONVERT(`order`, SIGNED) ASC')->get();
        return view('dashboard.sidebar.sidebar', compact('page_title', 'officials', 'stuffs', 'representatives', 'pages', 'notices', 'news', 'services', 'sidebars'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'officials' => 'nullable|exists:officials,id|unique:sidebars,forigen_id,NULL,id,forigen_type,' . officials::class,
            'stuffs' => 'nullable|exists:stuffs,id|unique:sidebars,forigen_id,NULL,id,forigen_type,' . Stuff::class,
            'representatives' => 'nullable|exists:representatives,id|unique:sidebars,forigen_id,NULL,id,forigen_type,' . representatives::class,
            'page' => 'nullable|exists:pages,id|unique:sidebars,forigen_id,NULL,id,forigen_type,' . createpage::class,
            'noice' => 'nullable|exists:notices,id|unique:sidebars,forigen_id,NULL,id,forigen_type,' . NoticeModel::class,
            'news' => 'nullable|exists:news,id|unique:sidebars,forigen_id,NULL,id,forigen_type,' . NewsModel::class,
            'service' => 'nullable|exists:single_services,id|unique:sidebars,forigen_id,NULL,id,forigen_type,' . SingleService::class,
            'order' => 'nullable|string',
            'gap' => 'nullable|string',
            'sidebar_title' => 'nullable|string',
            'link_text' => 'nullable|string',
            'link_url' => 'nullable|string',
            'tab' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator)
                ->with('error', 'তথ্য ইতমধ্যে যুক্ত আছে');
        }

        $sidebar = new SidebarModel();

        // Set other sidebar fields
        $sidebar->gap = $request->gap;
        $sidebar->sidebar_title = $request->sidebar_title;
        $sidebar->link_text = $request->link_text;
        $sidebar->link_url = $request->link_url;
        $sidebar->tab = $request->tab;

        // Handle the polymorphic relationship for 'forigen'
        if ($request->has('officials')) {
            $sidebar->forigen_type = officials::class;
            $sidebar->forigen_id = $request->officials;
        } elseif ($request->has('stuffs')) {
            $sidebar->forigen_type = Stuff::class;
            $sidebar->forigen_id = $request->stuffs;
        } elseif ($request->has('representatives')) {
            $sidebar->forigen_type = representatives::class;
            $sidebar->forigen_id = $request->representatives;
        } elseif ($request->has('page')) {
            $sidebar->forigen_type = createpage::class;
            $sidebar->forigen_id = $request->page;
        } elseif ($request->has('noice')) {
            $sidebar->forigen_type = NoticeModel::class;
            $sidebar->forigen_id = $request->noice;
        } elseif ($request->has('news')) {
            $sidebar->forigen_type = NewsModel::class;
            $sidebar->forigen_id = $request->news;
        } elseif ($request->has('service')) {
            $sidebar->forigen_type = SingleService::class;
            $sidebar->forigen_id = $request->service;
        }

        // Handle image upload if an image is provided
        if ($request->hasFile('image')) {
            // Save the sidebar model first to generate the ID
            $sidebar->save(); // Save the model to get the ID

            // Get the uploaded image
            $image = $request->file('image');

            // Generate the new file name based on the sidebar ID
            $imageName = 'sidebar-image-' . $sidebar->id . '.' . $image->getClientOriginalExtension(); // Generate name like sidebar-image-id.extension

            // Save the image in the public directory
            $imagePath = $image->move(public_path('uploads/sidebar/'), $imageName);

            // Assign the image path to the sidebar model
            $sidebar->image = 'uploads/sidebar/' . $imageName; // Store path relative to the public folder

            // Save the updated sidebar model with the image path
            $sidebar->save();
        }

        // Save the new sidebar
        $sidebar->save();

        return redirect()->back()->with('success', 'তথ্য সফলভাবে যুক্ত হয়েছে');
    }


    public function updatesidebarOrder(Request $request)
    {
        $orderedIds = $request->input('orderedIds');
        foreach ($orderedIds as $index => $id) {
            $sidebar = SidebarModel::find($id); // Find the official by ID
            if ($sidebar) {
                $sidebar->order = $index + 1; // Assuming 'order' is the field you want to update
                $sidebar->save(); // Save the updated order
            }
        }

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $sidebar = SidebarModel::find($id);
        if ($sidebar) {
            $sidebar->delete();
            return redirect()->back()->with('success', 'তথ্য সফলভাবে মুছে ফেলা হয়েছে');
        }
        return redirect()->back()->with('error', 'তথ্য মুছে ফেলা যায়নি');
    }
}
