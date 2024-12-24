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
}
