<?php

namespace App\Http\Controllers\dash;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_title = 'Menu Builder';
        $menus = Menu::latest('id')->get();
        return view('dashboard.menus.index', compact('page_title', 'menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_title = 'নতুন মেন্যু তৈরি করুন';
        return view('dashboard.menus.create', compact('page_title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:menus',
            'description' => 'nullable|string',
        ]);

        Menu::create([
            'name' => Str::slug($request->get('name')),
            'description' => $request->get('description'),
            'deletable' => true,
        ]);

        return redirect()->route('menus.index')->with('success', "সফলভাবে মেন্যু তৈরি হয়েছে");
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {

        $page_title = 'মেন্যু ইডিট করুন';
        return view('dashboard.menus.create', compact('page_title', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:menus,name,' . $menu->id,
            'description' => 'nullable|string',
        ]);

        $menu->update([
            'name' => Str::slug($request->get('name')),
            'description' => $request->get('description'),
            'deletable' => true,
        ]);

        return redirect()->route('menus.index')->with('success', "সফলভাবে মেন্যু আপডেট হয়েছে");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        if ($menu->deletable == true) {
            $menu->delete();
            return redirect()->route('menus.index')->with('success', "মেন্যুটি সফলভাবে ডিলিট হয়েছে");
        } else {
            return redirect()->route('menus.index')->with('error', "এই মেন্যুটি ডিলিট করা যাবে না");
        }
    }
}
