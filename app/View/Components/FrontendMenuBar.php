<?php

namespace App\View\Components;

use App\Models\Menu;
use App\Models\MenuItem;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Cache;

class FrontendMenuBar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $items = menu('main-menu');
        $check_menu = Menu::all();
        $check_menu_item = MenuItem::all();
        return view('components.frontend-menu-bar', compact('items', 'check_menu', 'check_menu_item'));

        $items = Cache::rememberForever('frontend.menu.bar', function () {
            return menu('main-menu');
        });
        return view('components.frontend-menu-bar', compact('items'));
    }
}
