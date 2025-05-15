<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Services\AdminMenuItem;

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
        $user = Auth::user();
        $this->menu = [];
        $this->more = [];

        // Dashboard
        if ($user->can('dashboard.view')) {
            $this->addMenuItem(
                (new AdminMenuItem)
                    ->setLabel(__('Dashboard'))
                    ->setIcon('dashboard.svg')
                    ->setRoute(route('admin.dashboard'))
                    ->setActive(\Route::is('admin.dashboard'))
                    ->setId('dashboard')
                    ->setFilter('dashboard')
            );
        }

        // Roles & Permissions
        if ($user->can('role.create') || $user->can('role.view') || $user->can('role.edit') || $user->can('role.delete')) {
            $children = [];
            if ($user->can('role.view')) {
                $children[] = (new AdminMenuItem)
                    ->setLabel(__('Roles'))
                    ->setRoute(route('admin.roles.index'))
                    ->setActive(\Route::is('admin.roles.index') || \Route::is('admin.roles.edit'));
            }
            if ($user->can('role.create')) {
                $children[] = (new AdminMenuItem)
                    ->setLabel(__('New Role'))
                    ->setRoute(route('admin.roles.create'))
                    ->setActive(\Route::is('admin.roles.create'));
            }
            $this->addMenuItem(
                (new AdminMenuItem)
                    ->setLabel(__('Roles & Permissions'))
                    ->setIcon('key.svg')
                    ->setId('roles-submenu')
                    ->setActive(\Route::is('admin.roles.*'))
                    ->setChildren($children)
                    ->setFilter('roles')
            );
        }

        // Users
        if ($user->can('user.create') || $user->can('user.view') || $user->can('user.edit') || $user->can('user.delete')) {
            $children = [];
            if ($user->can('user.view')) {
                $children[] = (new AdminMenuItem)
                    ->setLabel(__('Users'))
                    ->setRoute(route('admin.users.index'))
                    ->setActive(\Route::is('admin.users.index') || \Route::is('admin.users.edit'));
            }
            if ($user->can('user.create')) {
                $children[] = (new AdminMenuItem)
                    ->setLabel(__('New User'))
                    ->setRoute(route('admin.users.create'))
                    ->setActive(\Route::is('admin.users.create'));
            }
            $this->addMenuItem(
                (new AdminMenuItem)
                    ->setLabel(__('User'))
                    ->setIcon('user.svg')
                    ->setId('users-submenu')
                    ->setActive(\Route::is('admin.users.*'))
                    ->setChildren($children)
                    ->setFilter('users')
            );
        }

        // Modules
        if ($user->can('module.view')) {
            $this->addMenuItem(
                (new AdminMenuItem)
                    ->setLabel(__('Modules'))
                    ->setIcon('three-dice.svg')
                    ->setRoute(route('admin.modules.index'))
                    ->setActive(\Route::is('admin.modules.index'))
                    ->setId('modules')
                    ->setFilter('modules')
            );
        }

        // Monitoring
        if ($user->can('pulse.view') || $user->can('actionlog.view')) {
            $children = [];
            if ($user->can('actionlog.view')) {
                $children[] = (new AdminMenuItem)
                    ->setLabel(__('Action Logs'))
                    ->setRoute(route('actionlog.index'))
                    ->setActive(\Route::is('actionlog.index'));
            }
            if ($user->can('pulse.view')) {
                $children[] = (new AdminMenuItem)
                    ->setLabel(__('Laravel Pulse'))
                    ->setRoute(route('pulse'))
                    ->setActive(false)
                    ->setTarget('_blank');
            }
            $this->addMenuItem(
                (new AdminMenuItem)
                    ->setLabel(__('Monitoring'))
                    ->setIcon('tv.svg')
                    ->setId('monitoring-submenu')
                    ->setActive(\Route::is('actionlog.*'))
                    ->setChildren($children)
                    ->setFilter('monitoring')
            );
        }

        // More group
        // Settings
        if ($user->can('settings.edit') || $user->can('translations.view')) {
            $children = [];
            if ($user->can('settings.edit')) {
                $children[] = (new AdminMenuItem)
                    ->setLabel(__('General Settings'))
                    ->setRoute(route('admin.settings.index'))
                    ->setActive(\Route::is('admin.settings.index'));
            }
            if ($user->can('translations.view') || $user->can('translations.edit')) {
                $children[] = (new AdminMenuItem)
                    ->setLabel(__('Translations'))
                    ->setRoute(route('admin.translations.index'))
                    ->setActive(\Route::is('admin.translations.*'));
            }
            $this->addMenuItem(
                (new AdminMenuItem)
                    ->setLabel(__('Settings'))
                    ->setIcon('settings.svg')
                    ->setId('settings-submenu')
                    ->setActive(\Route::is('admin.settings.*') || \Route::is('admin.translations.*'))
                    ->setChildren($children)
                    ->setFilter('settings'),
                'more'
            );
        }

        // Logout
        $this->addMenuItem(
            (new AdminMenuItem)
                ->setLabel(__('Logout'))
                ->setIcon('logout.svg')
                ->setRoute(route('logout'))
                ->setActive(false)
                ->setId('logout')
                ->setIsLogout(true)
                ->setFilter('logout'),
            'more'
        );

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
            } elseif (!empty($item['is_logout'])) {
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
