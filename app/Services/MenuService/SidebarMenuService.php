<?php

namespace App\Services\MenuService;

use App\Services\MenuService\AdminMenuItem;

class SidebarMenuService
{
    protected $groups = [];

    /**
     * Add a menu item to the sidebar.
     *
     * @param AdminMenuItem|array $item The menu item or configuration array
     * @param string|null $group The group to add the item to
     * @return void
     * @throws \InvalidArgumentException
     */
    public function addMenuItem($item, $group = null)
    {
        // If item is an array, convert it to AdminMenuItem
        if (is_array($item)) {
            $menuItem = $this->createFromArray($item);
        } else if ($item instanceof AdminMenuItem) {
            $menuItem = $item;
        } else {
            throw new \InvalidArgumentException('MenuItem must be an array or AdminMenuItem instance');
        }
        
        if (!isset($this->groups[$group])) {
            $this->groups[$group] = [];
        }
        $this->groups[$group][] = $menuItem;
    }

    /**
     * Create an AdminMenuItem from an array configuration.
     *
     * @param array $data Configuration data
     * @return AdminMenuItem
     */
    protected function createFromArray(array $data): AdminMenuItem
    {
        $menuItem = new AdminMenuItem();
        if (isset($data['children']) && is_array($data['children'])) {
            $children = [];
            foreach ($data['children'] as $child) {
                $children[] = $this->createFromArray($child);
            }
            $data['children'] = $children;
        }
        
        return $menuItem->Html($data);
    }

    public function getMenu()
    {
        $this->groups = [];

        $this->addMenuItem([
            'label' => __('Dashboard'),
            'icon' => 'dashboard.svg',
            'route' => route('admin.dashboard'),
            'active' => \Route::is('admin.dashboard'),
            'id' => 'dashboard',
            'priority' => 1,
            'permission' => 'dashboard.view'
        ]);


        $this->addMenuItem([
            'label' => __('Roles & Permissions'),
            'icon' => 'key.svg',
            'id' => 'roles-submenu',
            'active' => \Route::is('admin.roles.*'),
            'children' => [
                [
                    'label' => __('Roles'),
                    'route' => route('admin.roles.index'),
                    'active' => \Route::is('admin.roles.index') || \Route::is('admin.roles.edit'),
                    'priority' => 20,
                    'permission' => 'role.view'
                ],
                [
                    'label' => __('New Role'),
                    'route' => route('admin.roles.create'),
                    'active' => \Route::is('admin.roles.create'),
                    'priority' => 10,
                    'permission' => 'role.create'
                ]
            ],
            'priority' => 10,
            'permission' => ['role.create', 'role.view', 'role.edit', 'role.delete']
        ]);


        $this->addMenuItem([
            'label' => __('User'),
            'icon' => 'user.svg',
            'id' => 'users-submenu',
            'active' => \Route::is('admin.users.*'),
            'children' => [
                [
                    'label' => __('Users'),
                    'route' => route('admin.users.index'),
                    'active' => \Route::is('admin.users.index') || \Route::is('admin.users.edit'),
                    'priority' => 20,
                    'permission' => 'user.view'
                ],
                [
                    'label' => __('New User'),
                    'route' => route('admin.users.create'),
                    'active' => \Route::is('admin.users.create'),
                    'priority' => 10,
                    'permission' => 'user.create'
                ]
            ],
            'priority' => 20,
            'permission' => ['user.create', 'user.view', 'user.edit', 'user.delete']
        ]);

        $this->addMenuItem([
            'label' => __('Modules'),
            'icon' => 'three-dice.svg',
            'route' => route('admin.modules.index'),
            'active' => \Route::is('admin.modules.index'),
            'id' => 'modules',
            'priority' => 30,
            'permission' => 'module.view'
        ]);

        $this->addMenuItem([
            'label' => __('Monitoring'),
            'icon' => 'tv.svg',
            'id' => 'monitoring-submenu',
            'active' => \Route::is('actionlog.*'),
            'children' => [
                [
                    'label' => __('Action Logs'),
                    'route' => route('actionlog.index'),
                    'active' => \Route::is('actionlog.index'),
                    'priority' => 20,
                    'permission' => 'actionlog.view'
                ],
                [
                    'label' => __('Laravel Pulse'),
                    'route' => route('pulse'),
                    'active' => false,
                    'target' => '_blank',
                    'priority' => 10,
                    'permission' => 'pulse.view'
                ]
            ],
            'priority' => 40,
            'permission' => ['pulse.view', 'actionlog.view']
        ]);


        $this->addMenuItem([
            'label' => __('Settings'),
            'icon' => 'settings.svg',
            'id' => 'settings-submenu',
            'active' => \Route::is('admin.settings.*') || \Route::is('admin.translations.*'),
            'children' => [
                [
                    'label' => __('General Settings'),
                    'route' => route('admin.settings.index'),
                    'active' => \Route::is('admin.settings.index'),
                    'priority' => 20,
                    'permission' => 'settings.edit'
                ],
                [
                    'label' => __('Translations'),
                    'route' => route('admin.translations.index'),
                    'active' => \Route::is('admin.translations.*'),
                    'priority' => 10,
                    'permission' => ['translations.view', 'translations.edit']
                ]
            ],
            'priority' => 1,
            'permission' => ['settings.edit', 'translations.view']
        ], 'Settings');


        $this->addMenuItem([
            'label' => __('Logout'),
            'icon' => 'logout.svg',
            'route' => route('logout'),
            'active' => false,
            'id' => 'logout',
            'priority' => 1,
            'html' => '
                <li class="hover:menu-item-active">
                    <form method="POST" action="' . route('logout') . '">
                        ' . csrf_field() . '
                        <button type="submit" class="menu-item group w-full text-left menu-item-inactive text-black dark:text-white hover:text-black">
                            <img src="' . asset('images/icons/logout.svg') . '" alt="Logout" class="menu-item-icon dark:invert">
                            <span class="menu-item-text">' . __('Logout') . '</span>
                        </button>
                    </form>
                </li>
            '
        ], 'Settings');

        // Sort each group by priority (lower first)
        foreach ($this->groups as &$groupItems) {
            usort($groupItems, function ($a, $b) {
                return $a->toArray()['priority'] <=> $b->toArray()['priority'];
            });
        }

        // Add filters so that developers can modify the menu
        $result = [];
        foreach ($this->groups as $group => $items) {
            $menuArr = array_map(function ($item) {
                return $item->toArray();
            }, $items);
            $result[$group] = ld_apply_filters('sidebar_menu_' . strtolower($group), $menuArr);
        }

        return $result;
    }

    public function render($menus, $textColorVar = 'textColor', $submenusVar = 'submenus')
    {
        $html = '';
        foreach ($menus as $item) {
            // Filter before menu
            $filterKey = $item['id'] ?? (\Str::slug($item['label']) ?? '');
            $html .= ld_apply_filters('sidebar_menu_before_' . $filterKey, '');

            // If HTML content is provided, use it directly
            if (!empty($item['html'])) {
                $html .= $item['html'];
            } else if (!empty($item['children'])) {
                $submenuId = $item['id'] ?? \Str::slug($item['label']) . '-submenu';
                $isActive = $item['active'] ? 'menu-item-active' : 'menu-item-inactive';
                $html .= '<li x-data class="hover:menu-item-active">';
                $html .= '<button :style="`color: ${' . $textColorVar . '}`" class="menu-item group w-full text-left ' . $isActive . '" type="button" @click="toggleSubmenu(\'' . $submenuId . '\')">';
                if (!empty($item['icon'])) {
                    $html .= '<img src="' . asset('images/icons/' . $item['icon']) . '" alt="' . e($item['label']) . '" class="menu-item-icon dark:invert">';
                }
                $html .= '<span class="menu-item-text">' . e($item['label']) . '</span>';
                $html .= '<img src="' . asset('images/icons/chevron-down.svg') . '" alt="Arrow" class="menu-item-arrow dark:invert transition-transform duration-300" :class="' . $submenusVar . '[\'' . $submenuId . '\'] ? \'rotate-180\' : \'\'">';
                $html .= '</button>';
                $html .= '<ul id="' . $submenuId . '" x-show="' . $submenusVar . '[\'' . $submenuId . '\']"
                        x-transition:enter="transition-all ease-in-out duration-300"
                        x-transition:enter-start="opacity-0 max-h-0"
                        x-transition:enter-end="opacity-100 max-h-[500px]"
                        x-transition:leave="transition-all ease-in-out duration-300"
                        x-transition:leave-start="opacity-100 max-h-[500px]"
                        x-transition:leave-end="opacity-0 max-h-0"
                        class="submenu pl-12 mt-2 space-y-2 overflow-hidden">';
                $html .= $this->render($item['children'], $textColorVar, $submenusVar);
                $html .= '</ul>';
                $html .= '</li>';
            } else {
                $isActive = $item['active'] ? 'menu-item-active' : 'menu-item-inactive';
                $target = !empty($item['target']) ? ' target="' . e($item['target']) . '"' : '';
                $html .= '<li class="hover:menu-item-active">';
                $html .= '<a :style="`color: ${' . $textColorVar . '}`" href="' . ($item['route'] ?? '#') . '" class="menu-item group ' . $isActive . '"' . $target . '>';
                if (!empty($item['icon'])) {
                    $html .= '<img src="' . asset('images/icons/' . $item['icon']) . '" alt="' . e($item['label']) . '" class="menu-item-icon dark:invert">';
                }
                $html .= '<span class="menu-item-text">' . e($item['label']) . '</span>';
                $html .= '</a>';
                $html .= '</li>';
            }

            // Filter after menu
            $html .= ld_apply_filters('sidebar_menu_after_' . $filterKey, '');
        }
        return $html;
    }
}
