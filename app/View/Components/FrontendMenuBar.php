<?php

namespace App\View\Components;

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
        return view('components.frontend-menu-bar', compact('items'));

        // $items = Cache::rememberForever('frontend.menu.bar', function () {
        //     return menu('main-menu');
        // });
        return view('components.frontend-menu-bar', compact('items'));
    }
}
