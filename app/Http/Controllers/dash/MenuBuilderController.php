<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuItem;

class MenuBuilderController extends Controller
{
    use ValidatesRequests;

    public function index($id)
    {
        $menu = Menu::findOrFail($id);
        return view('dashboard.menus.builder', compact('menu'));
    }

    public function order($id)
    {
        $menu = Menu::findOrFail($id);
        $menuItemOrder = json_decode(request()->get('order'));
        $this->orderMenu($menuItemOrder, null);
    }

    private function orderMenu(array $menuItems, $parentId)
    {
        foreach ($menuItems as $index => $item) {
            $menuItem = MenuItem::findOrFail($item->id);
            $menuItem->update([
                'parent_id' => $parentId,
                'order' => $index + 1,
            ]);
            if (isset($item->children)) {
                $this->orderMenu($item->children, $menuItem->id);
            }
        }
    }

    public function itemCreate($id)
    {
        $menu = Menu::findOrFail($id);
        return view('dashboard.menus.item.form', compact('menu'));
    }

    public function itemStore(Request $request, $id)
    {
        $this->validate($request, [
            'divider_title' => 'nullable|string',
            'title' => 'nullable|string',
            'url' => 'nullable|string',
            'target' => 'nullable|string',
            'icon_class' => 'nullable|string',
        ]);

        $menu = Menu::findOrFail($id);

        $menu->menuItems()->create([
            'type' => $request->get('type'),
            'divider_title' => $request->get('divider_title'),
            'title' => $request->get('title'),
            'url' => $request->get('url'),
            'target' => $request->get('target'),
            'icon_class' => $request->get('icon_class'),
        ]);

        return redirect()->route('menus.builder', $menu->id)->with('success', "Menu Item Created Successfully");
    }


    /**
     * Edit menu item
     * @param $menuId
     * @param $itemId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function itemEdit($menuId, $itemId)
    {
        $menu = Menu::findOrFail($menuId);
        $menuItem = $menu->menuItems()->findOrFail($itemId);
        return view('dashboard.menus.item.form', compact('menu', 'menuItem'));
    }

    /**
     * Update menu item
     * @param Request $request
     * @param $menuId
     * @param $itemId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function itemUpdate(Request $request, $menuId, $itemId)
    {
        $menu = Menu::findOrFail($menuId);
        $menu->menuItems()->findOrFail($itemId)->update([
            'type' => $request->type,
            'title' => $request->title,
            'divider_title' => $request->divider_title,
            'url' => $request->url,
            'target' => $request->target,
            'icon_class' => $request->icon_class
        ]);
        return redirect()->route('menus.builder', $menu->id)->with('success', "Menu Updated Successfully");
    }

    /**
     * Delete a menu item
     * @param $menuId
     * @param $itemId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function itemDestroy($menuId, $itemId)
    {
        Menu::findOrFail($menuId)
            ->menuItems()
            ->findOrFail($itemId)
            ->delete();
        return redirect()->route('menus.builder', $menuId)->with('success', "Menu Item Deleted Successfully");
    }
}
