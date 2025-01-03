<?php

namespace App\Http\Controllers\dash;

use App\Models\news\NewsModel;
use App\Models\notice\NoticeModel;
use App\Models\officials\officials;
use App\Models\page\createpage;
use App\Models\representatives\representatives;
use App\Models\Service\SingleService;
use App\Models\sidebar\SidebarModel;
use App\Models\stuff\Stuff;
use Illuminate\Support\Facades\Validator; // Add this at the top of the file
use Illuminate\Http\Request;

use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use App\Models\menu\GroupMenuModel;
use App\Models\menu\GroupSubmenuModel;
use App\Models\menu\MenuModel;
use App\Models\menu\SubMenuModel;

class MenuController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_title = 'মেনু সেটিংস';
        $officials = officials::all();
        $stuffs = Stuff::all();
        $representatives = representatives::all();
        $pages = createpage::all();
        $notices = NoticeModel::all();
        $news = NewsModel::all();
        $services = SingleService::all();
        $top_menus = MenuModel::with(['submenus', 'groupmenus.submenus'])->orderByRaw('CONVERT(`order`, SIGNED) ASC')->get();
        return view('dashboard.menus.index', compact('page_title', 'officials', 'stuffs', 'representatives', 'pages', 'notices', 'news', 'services', 'top_menus'));
    }

    public function storetopmenu(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'officials' => 'nullable|exists:officials,id|unique:top_menus,forigen_id,NULL,id,forigen_type,' . officials::class,
            'stuffs' => 'nullable|exists:stuffs,id|unique:top_menus,forigen_id,NULL,id,forigen_type,' . Stuff::class,
            'representatives' => 'nullable|exists:representatives,id|unique:top_menus,forigen_id,NULL,id,forigen_type,' . representatives::class,
            'page' => 'nullable|exists:pages,id|unique:top_menus,forigen_id,NULL,id,forigen_type,' . createpage::class,
            'notice' => 'nullable|exists:notices,id|unique:top_menus,forigen_id,NULL,id,forigen_type,' . NoticeModel::class,
            'news' => 'nullable|exists:news,id|unique:top_menus,forigen_id,NULL,id,forigen_type,' . NewsModel::class,
            'service' => 'nullable|exists:single_services,id|unique:top_menus,forigen_id,NULL,id,forigen_type,' . SingleService::class,
            'order' => 'nullable|string',
            'link_text' => 'nullable|string',
            'link_url' => 'nullable|string',
            'tab' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator)
                ->with('error', 'তথ্য ইতমধ্যে যুক্ত আছে');
        }

        $TopMenu = new MenuModel();

        // Set other sidebar fields
        $TopMenu->link_text = $request->link_text;
        $TopMenu->link_url = $request->link_url;
        $TopMenu->tab = $request->tab;

        // Handle the polymorphic relationship for 'forigen'
        if ($request->has('officials')) {
            $TopMenu->forigen_type = officials::class;
            $TopMenu->forigen_id = $request->officials;
        } elseif ($request->has('stuffs')) {
            $TopMenu->forigen_type = Stuff::class;
            $TopMenu->forigen_id = $request->stuffs;
        } elseif ($request->has('representatives')) {
            $TopMenu->forigen_type = representatives::class;
            $TopMenu->forigen_id = $request->representatives;
        } elseif ($request->has('page')) {
            $TopMenu->forigen_type = createpage::class;
            $TopMenu->forigen_id = $request->page;
        } elseif ($request->has('notice')) {
            $TopMenu->forigen_type = NoticeModel::class;
            $TopMenu->forigen_id = $request->notice;
        } elseif ($request->has('news')) {
            $TopMenu->forigen_type = NewsModel::class;
            $TopMenu->forigen_id = $request->news;
        } elseif ($request->has('service')) {
            $TopMenu->forigen_type = SingleService::class;
            $TopMenu->forigen_id = $request->service;
        }

        // Save the new sidebar
        $TopMenu->save();

        return redirect()->back()->with('success', 'টপ মেনু সফলভাবে যুক্ত হয়েছে');
    }

    public function addsimplesubmenu($id)
    {
        $topmenu = MenuModel::find($id); // Query a single menu by ID
        $page_title = 'সিঙ্গেল সাব মেনু যোগ করুন';
        $officials = officials::all();
        $stuffs = Stuff::all();
        $representatives = representatives::all();
        $pages = createpage::all();
        $notices = NoticeModel::all();
        $news = NewsModel::all();
        $services = SingleService::all();
        return view('dashboard.menus.single-submenu', compact(
            'page_title',
            'officials',
            'stuffs',
            'representatives',
            'pages',
            'notices',
            'news',
            'services',
            'topmenu'
        ));
    }

    public function storesimplesubmenu(Request $request)
    {

        // Validation rules
        $validator = Validator::make($request->all(), [
            'officials' => [
                'nullable',
                'exists:officials,id',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = SubMenuModel::where('forigen_type', officials::class)
                        ->where('forigen_id', $value)
                        ->where('top_menu_id', $request->top_menu_id)
                        ->exists();
                    if ($exists) {
                        $fail('The selected official is already assigned to this top menu.');
                    }
                },
            ],
            'stuffs' => [
                'nullable',
                'exists:stuffs,id',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = SubMenuModel::where('forigen_type', Stuff::class)
                        ->where('forigen_id', $value)
                        ->where('top_menu_id', $request->top_menu_id)
                        ->exists();
                    if ($exists) {
                        $fail('The selected stuff is already assigned to this top menu.');
                    }
                },
            ],
            'representatives' => [
                'nullable',
                'exists:representatives,id',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = SubMenuModel::where('forigen_type', representatives::class)
                        ->where('forigen_id', $value)
                        ->where('top_menu_id', $request->top_menu_id)
                        ->exists();
                    if ($exists) {
                        $fail('The selected representative is already assigned to this top menu.');
                    }
                },
            ],
            'page' => [
                'nullable',
                'exists:pages,id',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = SubMenuModel::where('forigen_type', createpage::class)
                        ->where('forigen_id', $value)
                        ->where('top_menu_id', $request->top_menu_id)
                        ->exists();
                    if ($exists) {
                        $fail('The selected page is already assigned to this top menu.');
                    }
                },
            ],
            'notice' => [
                'nullable',
                'exists:notices,id',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = SubMenuModel::where('forigen_type', NoticeModel::class)
                        ->where('forigen_id', $value)
                        ->where('top_menu_id', $request->top_menu_id)
                        ->exists();
                    if ($exists) {
                        $fail('The selected notice is already assigned to this top menu.');
                    }
                },
            ],
            'news' => [
                'nullable',
                'exists:news,id',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = SubMenuModel::where('forigen_type', NewsModel::class)
                        ->where('forigen_id', $value)
                        ->where('top_menu_id', $request->top_menu_id)
                        ->exists();
                    if ($exists) {
                        $fail('The selected news is already assigned to this top menu.');
                    }
                },
            ],
            'service' => [
                'nullable',
                'exists:single_services,id',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = SubMenuModel::where('forigen_type', SingleService::class)
                        ->where('forigen_id', $value)
                        ->where('top_menu_id', $request->top_menu_id)
                        ->exists();
                    if ($exists) {
                        $fail('The selected service is already assigned to this top menu.');
                    }
                },
            ],
            'order' => 'nullable|string',
            'link_text' => 'nullable|string',
            'link_url' => 'nullable|string',
            'tab' => 'nullable|string',
            'top_menu_id' => 'required|exists:top_menus,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator)
                ->with('error', 'তথ্য ইতমধ্যে যুক্ত আছে');
        }

        $SimpleSubMenu = new SubMenuModel();

        // Set other sidebar fields
        $SimpleSubMenu->link_text = $request->link_text;
        $SimpleSubMenu->link_url = $request->link_url;
        $SimpleSubMenu->tab = $request->tab;
        $SimpleSubMenu->top_menu_id = $request->top_menu_id;

        // Handle the polymorphic relationship for 'forigen'
        if ($request->has('officials')) {
            $SimpleSubMenu->forigen_type = officials::class;
            $SimpleSubMenu->forigen_id = $request->officials;
        } elseif ($request->has('stuffs')) {
            $SimpleSubMenu->forigen_type = Stuff::class;
            $SimpleSubMenu->forigen_id = $request->stuffs;
        } elseif ($request->has('representatives')) {
            $SimpleSubMenu->forigen_type = representatives::class;
            $SimpleSubMenu->forigen_id = $request->representatives;
        } elseif ($request->has('page')) {
            $SimpleSubMenu->forigen_type = createpage::class;
            $SimpleSubMenu->forigen_id = $request->page;
        } elseif ($request->has('notice')) {
            $SimpleSubMenu->forigen_type = NoticeModel::class;
            $SimpleSubMenu->forigen_id = $request->notice;
        } elseif ($request->has('news')) {
            $SimpleSubMenu->forigen_type = NewsModel::class;
            $SimpleSubMenu->forigen_id = $request->news;
        } elseif ($request->has('service')) {
            $SimpleSubMenu->forigen_type = SingleService::class;
            $SimpleSubMenu->forigen_id = $request->service;
        }

        // Save the new sidebar
        $SimpleSubMenu->save();

        return redirect()->back()->with('success', 'টপ মেনু সফলভাবে যুক্ত হয়েছে');
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

    // Group Menu
    public function groupmenupage($id)
    {
        $topmenu = MenuModel::find($id); // Query a single menu by ID
        $page_title = 'সাবমেনু গ্রুপ যুক্ত করুন';

        // Corrected query to check for top_menu_id matching the id of the topmenu
        $groupmenus = GroupMenuModel::where('top_menu_id', $topmenu->id) // Use $topmenu->id to reference the ID
            ->orderByRaw('CONVERT(`order`, SIGNED) ASC')
            ->get();

        return view('dashboard.menus.group-menu', compact(
            'page_title',
            'topmenu',
            'groupmenus',
        ));
    }

    public function storegroupmenu(Request $request)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'group_label' => 'required|string',
            'top_menu_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator)
                ->with('error', 'একটি সমস্যা হয়েছে - পুনরায় চেষ্টা করুন');
        }
        $groupmenu = new GroupMenuModel();
        $groupmenu->group_label = $request->group_label;
        $groupmenu->top_menu_id = $request->top_menu_id;
        $groupmenu->save();
        return redirect()->back()->with('success', 'গ্রুপ মেনু সফলভাবে যুক্ত হয়েছে');
    }

    // Single GroupMenu
    public function singlegroupmenu($id)
    {
        // Fetch the group menu with its submenus and related 'forigen' models
        $groupmenu = GroupMenuModel::with('submenus.forigen')->find($id);

        // Handle the case where the group menu does not exist
        if (!$groupmenu) {
            return redirect()->back()->with('error', 'Menu not found.');
        }

        $page_title = 'সিঙ্গেল গ্রুপমেনু আইটেম যুক্ত করুন';

        // Fetch additional related data
        $officials = officials::all();
        $stuffs = Stuff::all();
        $representatives = representatives::all();
        $pages = createpage::all();
        $notices = NoticeModel::all();
        $news = NewsModel::all();
        $services = SingleService::all();

        // Pass data to the view
        return view('dashboard.menus.single-group-menu', compact(
            'groupmenu',
            'page_title',
            'officials',
            'stuffs',
            'representatives',
            'pages',
            'notices',
            'news',
            'services'
        ));
    }




    public function storesinglegroupmenu(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'officials' => [
                'nullable',
                'exists:officials,id',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = GroupSubmenuModel::where('forigen_type', officials::class)
                        ->where('forigen_id', $value)
                        ->where('group_menu_id', $request->group_menu_id)
                        ->exists();
                    if ($exists) {
                        $fail('The selected official is already assigned to this group menu.');
                    }
                },
            ],
            'stuffs' => [
                'nullable',
                'exists:stuffs,id',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = GroupSubmenuModel::where('forigen_type', Stuff::class)
                        ->where('forigen_id', $value)
                        ->where('group_menu_id', $request->group_menu_id)
                        ->exists();
                    if ($exists) {
                        $fail('The selected stuff is already assigned to this group menu.');
                    }
                },
            ],
            'representatives' => [
                'nullable',
                'exists:representatives,id',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = GroupSubmenuModel::where('forigen_type', representatives::class)
                        ->where('forigen_id', $value)
                        ->where('group_menu_id', $request->group_menu_id)
                        ->exists();
                    if ($exists) {
                        $fail('The selected representative is already assigned to this group menu.');
                    }
                },
            ],
            'page' => [
                'nullable',
                'exists:pages,id',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = GroupSubmenuModel::where('forigen_type', createpage::class)
                        ->where('forigen_id', $value)
                        ->where('group_menu_id', $request->group_menu_id)
                        ->exists();
                    if ($exists) {
                        $fail('The selected page is already assigned to this group menu.');
                    }
                },
            ],
            'notice' => [
                'nullable',
                'exists:notices,id',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = GroupSubmenuModel::where('forigen_type', NoticeModel::class)
                        ->where('forigen_id', $value)
                        ->where('group_menu_id', $request->group_menu_id)
                        ->exists();
                    if ($exists) {
                        $fail('The selected notice is already assigned to this group menu.');
                    }
                },
            ],
            'news' => [
                'nullable',
                'exists:news,id',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = GroupSubmenuModel::where('forigen_type', NewsModel::class)
                        ->where('forigen_id', $value)
                        ->where('group_menu_id', $request->group_menu_id)
                        ->exists();
                    if ($exists) {
                        $fail('The selected news is already assigned to this group menu.');
                    }
                },
            ],
            'service' => [
                'nullable',
                'exists:single_services,id',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = GroupSubmenuModel::where('forigen_type', SingleService::class)
                        ->where('forigen_id', $value)
                        ->where('group_menu_id', $request->group_menu_id)
                        ->exists();
                    if ($exists) {
                        $fail('The selected service is already assigned to this group menu.');
                    }
                },
            ],
            'order' => 'nullable|string',
            'link_text' => 'nullable|string',
            'link_url' => 'nullable|string',
            'tab' => 'nullable|string',
            'group_menu_id' => 'required|exists:group_menus,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator)
                ->with('error', 'তথ্য ইতমধ্যে যুক্ত আছে');
        }

        $GroupSubmenu = new GroupSubmenuModel();

        // Set other fields
        $GroupSubmenu->link_text = $request->link_text;
        $GroupSubmenu->link_url = $request->link_url;
        $GroupSubmenu->tab = $request->tab;
        $GroupSubmenu->group_menu_id = $request->group_menu_id;

        // Handle the polymorphic relationship for 'forigen'
        if ($request->has('officials')) {
            $GroupSubmenu->forigen_type = officials::class;
            $GroupSubmenu->forigen_id = $request->officials;
        } elseif ($request->has('stuffs')) {
            $GroupSubmenu->forigen_type = Stuff::class;
            $GroupSubmenu->forigen_id = $request->stuffs;
        } elseif ($request->has('representatives')) {
            $GroupSubmenu->forigen_type = representatives::class;
            $GroupSubmenu->forigen_id = $request->representatives;
        } elseif ($request->has('page')) {
            $GroupSubmenu->forigen_type = createpage::class;
            $GroupSubmenu->forigen_id = $request->page;
        } elseif ($request->has('notice')) {
            $GroupSubmenu->forigen_type = NoticeModel::class;
            $GroupSubmenu->forigen_id = $request->notice;
        } elseif ($request->has('news')) {
            $GroupSubmenu->forigen_type = NewsModel::class;
            $GroupSubmenu->forigen_id = $request->news;
        } elseif ($request->has('service')) {
            $GroupSubmenu->forigen_type = SingleService::class;
            $GroupSubmenu->forigen_id = $request->service;
        }

        // Save the new group submenu
        $GroupSubmenu->save();

        return redirect()->back()->with('success', 'গ্রুপ মেনু সফলভাবে যুক্ত হয়েছে');
    }


    // All Delete Methods
    public function deletetopmenu($id)
    {
        $topmenu = MenuModel::find($id);
        if ($topmenu) {
            $topmenu->delete();
            return redirect()->back()->with('success', 'মেনু সফলভাবে মুছে ফেলা হয়েছে');
        }
        return redirect()->back()->with('error', 'মেনু মুছে ফেলা যায়নি');
    }

    public function deletesinglesubmenu($id)
    {
        $singsubmenu = SubMenuModel::find($id);
        if ($singsubmenu) {
            $singsubmenu->delete();
            return redirect()->back()->with('success', 'সাবমেনু সফলভাবে মুছে ফেলা হয়েছে');
        }
        return redirect()->back()->with('error', 'সাবমেনু মুছে ফেলা যায়নি');
    }
    public function deletemenugroup($id)
    {
        $singsubmenu = GroupMenuModel::find($id);
        if ($singsubmenu) {
            $singsubmenu->delete();
            return redirect()->back()->with('success', 'মেনু গ্রুপ সফলভাবে মুছে ফেলা হয়েছে');
        }
        return redirect()->back()->with('error', 'মেনু গ্রুপ মুছে ফেলা যায়নি');
    }
    public function deletegroupsubmenu($id)
    {
        $singsubmenu = GroupSubmenuModel::find($id);
        if ($singsubmenu) {
            $singsubmenu->delete();
            return redirect()->back()->with('success', 'মেনু গ্রুপ সফলভাবে মুছে ফেলা হয়েছে');
        }
        return redirect()->back()->with('error', 'মেনু গ্রুপ মুছে ফেলা যায়নি');
    }
}
