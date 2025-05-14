<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class SidebarMenuService
{
    public function getMenu()
    {
        $user = Auth::user();

        // Example: Add an "About" menu before Dashboard using a filter
        ld_add_filter('sidebar_menu_before_dashboard', function ($value) {
            return $value . '<li class="hover:menu-item-active"><a href="' . url('/about') . '" class="menu-item group menu-item-inactive"><span class="menu-item-text">About</span></a></li>';
        });

        $menu = [];

        // Dashboard
        if ($user->can('dashboard.view')) {
            $menu[] = [
                'label' => __('Dashboard'),
                'icon' => 'dashboard.svg',
                'route' => route('admin.dashboard'),
                'active' => \Route::is('admin.dashboard'),
                'id' => 'dashboard',
                'children' => [],
                'filter' => 'dashboard',
            ];
        }

        // Roles & Permissions
        if ($user->can('role.create') || $user->can('role.view') || $user->can('role.edit') || $user->can('role.delete')) {
            $children = [];
            if ($user->can('role.view')) {
                $children[] = [
                    'label' => __('Roles'),
                    'route' => route('admin.roles.index'),
                    'active' => \Route::is('admin.roles.index') || \Route::is('admin.roles.edit'),
                ];
            }
            if ($user->can('role.create')) {
                $children[] = [
                    'label' => __('New Role'),
                    'route' => route('admin.roles.create'),
                    'active' => \Route::is('admin.roles.create'),
                ];
            }
            $menu[] = [
                'label' => __('Roles & Permissions'),
                'icon' => 'key.svg',
                'id' => 'roles-submenu',
                'route' => null,
                'active' => \Route::is('admin.roles.*'),
                'children' => $children,
                'filter' => 'roles',
            ];
        }

        // Users
        if ($user->can('user.create') || $user->can('user.view') || $user->can('user.edit') || $user->can('user.delete')) {
            $children = [];
            if ($user->can('user.view')) {
                $children[] = [
                    'label' => __('Users'),
                    'route' => route('admin.users.index'),
                    'active' => \Route::is('admin.users.index') || \Route::is('admin.users.edit'),
                ];
            }
            if ($user->can('user.create')) {
                $children[] = [
                    'label' => __('New User'),
                    'route' => route('admin.users.create'),
                    'active' => \Route::is('admin.users.create'),
                ];
            }
            $menu[] = [
                'label' => __('User'),
                'icon' => 'user.svg',
                'id' => 'users-submenu',
                'route' => null,
                'active' => \Route::is('admin.users.*'),
                'children' => $children,
                'filter' => 'users',
            ];
        }

        // Modules
        if ($user->can('module.view')) {
            $menu[] = [
                'label' => __('Modules'),
                'icon' => 'three-dice.svg',
                'route' => route('admin.modules.index'),
                'active' => \Route::is('admin.modules.index'),
                'id' => 'modules',
                'children' => [],
                'filter' => 'modules',
            ];
        }

        // Monitoring
        if ($user->can('pulse.view') || $user->can('actionlog.view')) {
            $children = [];
            if ($user->can('actionlog.view')) {
                $children[] = [
                    'label' => __('Action Logs'),
                    'route' => route('actionlog.index'),
                    'active' => \Route::is('actionlog.index'),
                ];
            }
            if ($user->can('pulse.view')) {
                $children[] = [
                    'label' => __('Laravel Pulse'),
                    'route' => route('pulse'),
                    'active' => false,
                    'target' => '_blank',
                ];
            }
            $menu[] = [
                'label' => __('Monitoring'),
                'icon' => 'tv.svg',
                'id' => 'monitoring-submenu',
                'route' => null,
                'active' => \Route::is('actionlog.*'),
                'children' => $children,
                'filter' => 'monitoring',
            ];
        }

        // More group
        $more = [];

        // Settings
        if ($user->can('settings.edit') || $user->can('translations.view')) {
            $children = [];
            if ($user->can('settings.edit')) {
                $children[] = [
                    'label' => __('General Settings'),
                    'route' => route('admin.settings.index'),
                    'active' => \Route::is('admin.settings.index'),
                ];
            }
            if ($user->can('translations.view') || $user->can('translations.edit')) {
                $children[] = [
                    'label' => __('Translations'),
                    'route' => route('admin.translations.index'),
                    'active' => \Route::is('admin.translations.*'),
                ];
            }
            $more[] = [
                'label' => __('Settings'),
                'icon' => 'settings.svg',
                'id' => 'settings-submenu',
                'route' => null,
                'active' => \Route::is('admin.settings.*') || \Route::is('admin.translations.*'),
                'children' => $children,
                'filter' => 'settings',
            ];
        }

        // Logout
        $more[] = [
            'label' => __('Logout'),
            'icon' => 'logout.svg',
            'route' => route('logout'),
            'active' => false,
            'id' => 'logout',
            'children' => [],
            'filter' => 'logout',
            'is_logout' => true,
        ];

        // Allow filters to modify the menu
        $menu = ld_apply_filters('sidebar_menu', $menu);
        $more = ld_apply_filters('sidebar_menu_more', $more);

        return [
            'main' => $menu,
            'more' => $more,
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
