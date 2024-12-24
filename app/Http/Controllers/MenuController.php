<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

use Illuminate\Foundation\Validation\ValidatesRequests;

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
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        Menu::create([
            'name' => $request->name,
            'description' => $request->description,
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        //
    }
}
