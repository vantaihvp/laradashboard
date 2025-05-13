<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SiteNavigation;
use App\Models\SiteNavigationItem;
use App\Services\SiteNavigationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiteMenuItemController extends Controller
{
    public function __construct(
        private readonly SiteNavigationService $siteNavigationService
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $backendItems = $this->siteNavigationService->getBackEndNavigationItems();
        return view('backend.cms.site_navigation.list',compact('backendItems'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menu = SiteNavigationItem::findOrFail($id);
        return view('backend.cms.site_navigation.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $menu = SiteNavigationItem::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'menu_label' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'menu_order' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $menu->update($validator->validated());

        return redirect()->route('admin.menus.index')->with('success', __('Menu updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = SiteNavigationItem::findOrFail($id);
        $menu->delete();

        return redirect()->route('admin.menus.index')->with('success', __('Menu deleted successfully.'));
    }

    public function manage($menuId)
    {
        $menu = SiteNavigationItem::findOrFail($menuId);

        return view('backend.cms.site_navigation.manage', compact('menu'));
    }

    public function manageUpdate(Request $request, $menuId)
    {
        $menu = SiteNavigationItem::findOrFail($menuId);

        $order = $request->input('order');
        if (!$order) {
            return redirect()->back()->with('error', __('Invalid order data.'));
        }

        $orderArray = json_decode($order, true);

        if (!is_array($orderArray)) {
            return redirect()->back()->with('error', __('Invalid order format.'));
        }

        $this->updateMenuItemsOrder($orderArray, null);

        return redirect()->route('admin.menus.manage', $menuId)->with('success', __('Menu order updated successfully.'));
    }

    private function updateMenuItemsOrder(array $items, $parentId = null)
    {
        foreach ($items as $index => $item) {
            $menuItem = SiteNavigationItem::find($item['id']);
            if ($menuItem) {
                $menuItem->menu_order = $index + 1;
                $menuItem->parent_id = $parentId;
                $menuItem->save();

                if (isset($item['children']) && is_array($item['children'])) {
                    $this->updateMenuItemsOrder($item['children'], $menuItem->id);
                }
            }
        }
    }
}
