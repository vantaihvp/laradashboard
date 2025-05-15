<?php

namespace App\Services\MenuService;

use App\Services\MenuService\AdminMenuItem;

class SidebarMenuService
{
    protected $menu = [];
    protected $more = [];

    public function addMenuItem(AdminMenuItem $item, $group = 'main')
    {
        if ($group === 'main') {
            $this->menu[] = $item;
        } else {
            $this->more[] = $item;
        }
    }

    public function getMenu()
    {
        $this->menu = [];
        $this->more = [];

        // Dashboard
        $dashboard = (new AdminMenuItem)
            ->setLabel(__('Dashboard'))
            ->setIcon('dashboard.svg')
            ->setRoute(route('admin.dashboard'))
            ->setActive(\Route::is('admin.dashboard'))
            ->setId('dashboard')
            ->setFilter('dashboard')
            ->setPriority(2)
            ->isPermission('dashboard.view');
        if ($dashboard) {
            $this->addMenuItem($dashboard);
        }

        // Roles & Permissions
        $children = [];
        $rolesView = (new AdminMenuItem)
            ->setLabel(__('Roles'))
            ->setRoute(route('admin.roles.index'))
            ->setActive(\Route::is('admin.roles.index') || \Route::is('admin.roles.edit'))
            ->setPriority(2)
            ->isPermission('role.view');
        if ($rolesView) {
            $children[] = $rolesView;
        }
        $rolesCreate = (new AdminMenuItem)
            ->setLabel(__('New Role'))
            ->setRoute(route('admin.roles.create'))
            ->setActive(\Route::is('admin.roles.create'))
            ->setPriority(1)
            ->isPermission('role.create');
        if ($rolesCreate) {
            $children[] = $rolesCreate;
        }
        $rolesParent = (new AdminMenuItem)
            ->setLabel(__('Roles & Permissions'))
            ->setIcon('key.svg')
            ->setId('roles-submenu')
            ->setActive(\Route::is('admin.roles.*'))
            ->setChildren($children)
            ->setFilter('roles')
            ->setPriority(1)
            ->isPermission(['role.create', 'role.view', 'role.edit', 'role.delete']);
        if ($rolesParent && count($children)) {
            $this->addMenuItem($rolesParent);
        }

        // Users
        $children = [];
        $usersView = (new AdminMenuItem)
            ->setLabel(__('Users'))
            ->setRoute(route('admin.users.index'))
            ->setActive(\Route::is('admin.users.index') || \Route::is('admin.users.edit'))
            ->setPriority(2)
            ->isPermission('user.view');
        if ($usersView) {
            $children[] = $usersView;
        }

        
        $usersCreate = (new AdminMenuItem)
            ->setLabel(__('New User'))
            ->setRoute(route('admin.users.create'))
            ->setActive(\Route::is('admin.users.create'))
            ->setPriority(1)
            ->isPermission('user.create');
        if ($usersCreate) {
            $children[] = $usersCreate;
        }


        $usersParent = (new AdminMenuItem)
            ->setLabel(__('User'))
            ->setIcon('user.svg')
            ->setId('users-submenu')
            ->setActive(\Route::is('admin.users.*'))
            ->setChildren($children)
            ->setFilter('users')
            ->setPriority(1)
            ->isPermission(['user.create', 'user.view', 'user.edit', 'user.delete']);
        if ($usersParent && count($children)) {
            $this->addMenuItem($usersParent);
        }

        // Modules
        $modules = (new AdminMenuItem)
            ->setLabel(__('Modules'))
            ->setIcon('three-dice.svg')
            ->setRoute(route('admin.modules.index'))
            ->setActive(\Route::is('admin.modules.index'))
            ->setId('modules')
            ->setFilter('modules')
            ->setPriority(1)
            ->isPermission('module.view');
        if ($modules) {
            $this->addMenuItem($modules);
        }

        // Monitoring
        $children = [];
        $actionLogs = (new AdminMenuItem)
            ->setLabel(__('Action Logs'))
            ->setRoute(route('actionlog.index'))
            ->setActive(\Route::is('actionlog.index'))
            ->setPriority(2)
            ->isPermission('actionlog.view');
        if ($actionLogs) {
            $children[] = $actionLogs;
        }
        $pulse = (new AdminMenuItem)
            ->setLabel(__('Laravel Pulse'))
            ->setRoute(route('pulse'))
            ->setActive(false)
            ->setTarget('_blank')
            ->setPriority(1)
            ->isPermission('pulse.view');
        if ($pulse) {
            $children[] = $pulse;
        }
        $monitoringParent = (new AdminMenuItem)
            ->setLabel(__('Monitoring'))
            ->setIcon('tv.svg')
            ->setId('monitoring-submenu')
            ->setActive(\Route::is('actionlog.*'))
            ->setChildren($children)
            ->setFilter('monitoring')
            ->setPriority(1)
            ->isPermission(['pulse.view', 'actionlog.view']);
        if ($monitoringParent && count($children)) {
            $this->addMenuItem($monitoringParent);
        }

        // More group
        // Settings
        $children = [];
        $generalSettings = (new AdminMenuItem)
            ->setLabel(__('General Settings'))
            ->setRoute(route('admin.settings.index'))
            ->setActive(\Route::is('admin.settings.index'))
            ->setPriority(2)
            ->isPermission('settings.edit');
        if ($generalSettings) {
            $children[] = $generalSettings;
        }
        $translations = (new AdminMenuItem)
            ->setLabel(__('Translations'))
            ->setRoute(route('admin.translations.index'))
            ->setActive(\Route::is('admin.translations.*'))
            ->setPriority(1)
            ->isPermission(['translations.view', 'translations.edit']);
        if ($translations) {
            $children[] = $translations;
        }
        $settingsParent = (new AdminMenuItem)
            ->setLabel(__('Settings'))
            ->setIcon('settings.svg')
            ->setId('settings-submenu')
            ->setActive(\Route::is('admin.settings.*') || \Route::is('admin.translations.*'))
            ->setChildren($children)
            ->setFilter('settings')
            ->setPriority(5)
            ->isPermission(['settings.edit', 'translations.view']);
        if ($settingsParent && count($children)) {
            $this->addMenuItem($settingsParent, 'more');
        }

        // Logout
        $this->addMenuItem(
            (new AdminMenuItem)
                ->setLabel(__('Logout'))
                ->setIcon('logout.svg')
                ->setRoute(route('logout'))
                ->setActive(false)
                ->setId('logout')
                ->setFilter('logout')
                ->setPriority(1),
            'more'
        );

        // Sort by priority (higher first)
        usort($this->menu, function ($a, $b) {
            return $b->toArray()['priority'] <=> $a->toArray()['priority'];
        });
        usort($this->more, function ($a, $b) {
            return $b->toArray()['priority'] <=> $a->toArray()['priority'];
        });

        // Allow filters to modify the menu
        $mainMenu = array_map(function ($item) {
            return $item->toArray();
        }, $this->menu);
        $moreMenu = array_map(function ($item) {
            return $item->toArray();
        }, $this->more);

        $mainMenu = ld_apply_filters('sidebar_menu', $mainMenu);
        $moreMenu = ld_apply_filters('sidebar_menu_more', $moreMenu);

        return [
            'main' => $mainMenu,
            'more' => $moreMenu,
        ];
    }

    public function render($menus, $textColorVar = 'textColor', $submenusVar = 'submenus')
    {
        $html = '';
        foreach ($menus as $item) {
            // Filter before menu
            $html .= ld_apply_filters('sidebar_menu_before_' . ($item['filter'] ?? ($item['id'] ?? \Str::slug($item['label']))), '');

            if (!empty($item['children'])) {
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
            } elseif ($item['id'] === 'logout') {
                $html .= '<li class="hover:menu-item-active">';
                $html .= '<form method="POST" action="' . $item['route'] . '">';
                $html .= csrf_field();
                $html .= '<button :style="`color: ${' . $textColorVar . '}`" type="submit" class="menu-item group w-full text-left menu-item-inactive">';
                if (!empty($item['icon'])) {
                    $html .= '<img src="' . asset('images/icons/' . $item['icon']) . '" alt="' . e($item['label']) . '" class="menu-item-icon dark:invert">';
                }
                $html .= '<span class="menu-item-text">' . e($item['label']) . '</span>';
                $html .= '</button>';
                $html .= '</form>';
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
            $html .= ld_apply_filters('sidebar_menu_after_' . ($item['filter'] ?? ($item['id'] ?? \Str::slug($item['label']))), '');
        }
        return $html;
    }
}
