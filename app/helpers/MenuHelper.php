<?php

use App\Models\menu\MenuModel;

if (!function_exists('getTopMenus')) {
    /**
     * Fetch top menus along with submenus and groupmenus.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function getTopMenus()
    {
        return MenuModel::with([
            'submenus' => function ($query) {
                $query->orderByRaw('CONVERT(`order`, SIGNED) ASC'); // Order submenus by their order field
            },
            'groupmenus' => function ($query) {
                $query->with(['submenus' => function ($query) {
                    $query->orderByRaw('CONVERT(`order`, SIGNED) ASC'); // Order submenus of groupmenus
                }])->orderByRaw('CONVERT(`order`, SIGNED) ASC'); // Order groupmenus if needed
            }
        ])
            ->orderByRaw('CONVERT(`order`, SIGNED) ASC') // Order the top-level menus as well
            ->get();
    }
}
