<?php

namespace App\Services\MenuService;

use App\Services\MenuService\AdminMenuItem;
use Cache;

class SidebarMenuService
{
    protected $groups = [];

    public function addMenuItem(AdminMenuItem $menuItem, $group = null)
    {
        $group = $group ?: $this->getDefaultGroup();
        if (!isset($this->groups[$group])) {
            $this->groups[$group] = [];
        }
        $this->groups[$group][] = $menuItem;
    }

    protected function getDefaultGroup()
    {
        // Always use the first group, or 'main' if none exists yet
        return count($this->groups) ? array_keys($this->groups)[0] : 'main';
    }

    public function getMenu()
    {
        $userId = auth()->id();
        return \Cache::remember("sidebar_menu_" . $userId, now()->addMinutes(5), function () {
            $this->groups = [];

            $this->addMenuItem(
                (new AdminMenuItem())
                    ->setLabel(__('Dashboard'))
                    ->setIcon('dashboard.svg')
                    ->setRoute(route('admin.dashboard'))
                    ->setActive(\Route::is('admin.dashboard'))
                    ->setId('dashboard')
                    ->setPriority(10)
                    ->setPermission('dashboard.view')
            );

            $this->addMenuItem(
                (new AdminMenuItem())
                    ->setLabel(__('Roles & Permissions'))
                    ->setIcon('key.svg')
                    ->setId('roles-submenu')
                    ->setActive(\Route::is('admin.roles.*'))
                    ->setChildren(
                        [
                            (new AdminMenuItem())
                                ->setLabel(__('Roles'))
                                ->setRoute(route('admin.roles.index'))
                                ->setActive(\Route::is('admin.roles.index') || \Route::is('admin.roles.edit'))
                                ->setPriority(10)
                                ->setPermission('role.view'),
                            (new AdminMenuItem())
                                ->setLabel(__('New Role'))
                                ->setRoute(route('admin.roles.create'))
                                ->setActive(\Route::is('admin.roles.create'))
                                ->setPriority(20)
                                ->setPermission('role.create')
                        ]
                    )
                    ->setPriority(20)
            );

            $this->addMenuItem(
                (new AdminMenuItem())
                    ->setLabel(__('User'))
                    ->setIcon('user.svg')
                    ->setId('users-submenu')
                    ->setActive(\Route::is('admin.users.*'))
                    ->setChildren(
                        [
                            (new AdminMenuItem())
                                ->setLabel(__('Users'))
                                ->setRoute(route('admin.users.index'))
                                ->setActive(\Route::is('admin.users.index') || \Route::is('admin.users.edit'))
                                ->setPriority(20)
                                ->setPermission('user.view'),
                            (new AdminMenuItem())
                                ->setLabel(__('New User'))
                                ->setRoute(route('admin.users.create'))
                                ->setActive(\Route::is('admin.users.create'))
                                ->setPriority(10)
                                ->setPermission('user.create')
                        ]
                    )
                    ->setPriority(10)
                    ->setPermission(['user.create', 'user.view', 'user.edit', 'user.delete'])
            );

            $this->addMenuItem(
                (new AdminMenuItem())
                    ->setLabel(__('Modules'))
                    ->setIcon('three-dice.svg')
                    ->setRoute(route('admin.modules.index'))
                    ->setActive(\Route::is('admin.modules.index'))
                    ->setId('modules')
                    ->setPriority(1)
                    ->setPermission('module.view')
            );

            $this->addMenuItem(
                (new AdminMenuItem())
                    ->setLabel(__('Monitoring'))
                    ->setIcon('tv.svg')
                    ->setId('monitoring-submenu')
                    ->setActive(\Route::is('actionlog.*'))
                    ->setChildren(
                        [
                            (new AdminMenuItem())
                                ->setLabel(__('Action Logs'))
                                ->setRoute(route('actionlog.index'))
                                ->setActive(\Route::is('actionlog.index'))
                                ->setPriority(20)
                                ->setPermission('actionlog.view'),
                            (new AdminMenuItem())
                                ->setLabel(__('Laravel Pulse'))
                                ->setRoute(route('pulse'))
                                ->setActive(false)
                                ->setTarget('_blank')
                                ->setPriority(10)
                                ->setPermission('pulse.view')
                        ]
                    )
                    ->setPriority(1)
                    ->setPermission(['pulse.view', 'actionlog.view'])
            );

            $this->addMenuItem(
                (new AdminMenuItem())
                    ->setLabel(__('Settings'))
                    ->setIcon('settings.svg')
                    ->setId('settings-submenu')
                    ->setActive(\Route::is('admin.settings.*') || \Route::is('admin.translations.*'))
                    ->setChildren(
                        [
                            (new AdminMenuItem())
                                ->setLabel(__('General Settings'))
                                ->setRoute(route('admin.settings.index'))
                                ->setActive(\Route::is('admin.settings.index'))
                                ->setPriority(20)
                                ->setPermission('settings.edit'),
                            (new AdminMenuItem())
                                ->setLabel(__('Translations'))
                                ->setRoute(route('admin.translations.index'))
                                ->setActive(\Route::is('admin.translations.*'))
                                ->setPriority(10)
                                ->setPermission(['translations.view', 'translations.edit'])
                        ]
                    )
                    ->setPriority(1)
                    ->setPermission(['settings.edit', 'translations.view']),
                'Settings'
            );

            $this->addMenuItem(
                (new AdminMenuItem())
                    ->setLabel(__('Logout'))
                    ->setIcon('logout.svg')
                    ->setRoute(route('logout'))
                    ->setActive(false)
                    ->setId('logout')
                    ->setPriority(1)
                    ->withHtml('
                        <li class="hover:menu-item-active">
                            <form method="POST" action="' . route('logout') . '">
                                ' . csrf_field() . '
                                <button type="submit" class="menu-item group w-full text-left menu-item-inactive">
                                    <img src="' . asset('images/icons/logout.svg') . '" alt="Logout" class="menu-item-icon dark:invert">
                                    <span class="menu-item-text">' . __('Logout') . '</span>
                                </button>
                            </form>
                        </li>
                    '),
                'Settings'
            );

            // Sort each group by priority (ascending - lower priority number first)
            foreach ($this->groups as &$groupItems) {
                usort($groupItems, function ($a, $b) {
                    return $a->toArray()['priority'] <=> $b->toArray()['priority'];
                });
            }

            // Allow filters to modify the menu
            $result = [];
            foreach ($this->groups as $group => $items) {
                $menuArr = array_map(function ($item) {
                    return $item->toArray();
                    // return $item;
                }, $items);
                $result[$group] = ld_apply_filters('sidebar_menu_' . strtolower($group), $menuArr);
            }

            return $result;
        });
    }

    /**
     * @param array<AdminMenuItem> $menus Array of menu items or arrays from toArray()
     * @param string $textColorVar Alpine.js variable for text color
     * @param string $submenusVar Alpine.js variable for submenus state
     * @return string Rendered HTML
     */
    public function render($menus, $textColorVar = 'textColor', $submenusVar = 'submenus')
    {
        $html = '';
        foreach ($menus as $item) {
            // Skip items that the user doesn't have permission to see
            // if (!empty($item->getPermissions()) && !$this->userHasPermission($item->getPermissions())) {
            //     continue;
            // }

            // Filter before menu
            $filterKey = $item['id'] ?? (\Str::slug($item['label']) ?? '');
            $html .= ld_apply_filters('sidebar_menu_before_' . $filterKey, '');

            if (!empty($item['isCustomHtml']) && $item['isCustomHtml'] === true) {
                $html .= $item['customHtml'];
            } elseif (!empty($item['children'])) {
                // Skip submenu if no child items are visible
                $visibleChildren = array_filter($item['children'], function($child) {
                    return empty($child['permissions']) || $this->userHasPermission($child['permissions']);
                });

                if (empty($visibleChildren)) {
                    continue;
                }

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

    /**
     * Check if the current user has any of the required permissions
     *
     * @param array $permissions
     * @return bool
     */
    protected function userHasPermission(array $permissions): bool
    {
        if (empty($permissions)) {
            return true;
        }

        $user = auth()->user();
        if (!$user) {
            return false;
        }

        foreach ($permissions as $permission) {
            if ($user->can($permission)) {
                return true;
            }
        }

        return false;
    }
}
