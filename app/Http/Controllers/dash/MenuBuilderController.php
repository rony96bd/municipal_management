<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuBuilderController extends Controller
{
    public function index($id)
    {
        $menu = Menu::findOrFail($id);
        return view('dashboard.menus.builder', compact('menu'));
    }

    public function itemCreate($id)
    {
        $menu = Menu::findOrFail($id);
        return view('dashboard.menus.item.form', compact('menu'));
    }

    public function itemStore(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $menu->items()->create($request->all());
        return redirect()->route('menus.builder', $menu->id);
    }
}
