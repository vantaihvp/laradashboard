<?php

namespace App\Services\MenuService;

use App\Services\MenuService\AdminMenuItem;
use App\Services\ContentService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;

class AdminMenuService
{
    /**
     * @var AdminMenuItem[][]
     */
    protected array $groups = [];

    /**
     * Add a menu item to the admin sidebar.
     *
     * @param AdminMenuItem|array $item The menu item or configuration array
     * @param string|null $group The group to add the item to
     * @return void
     * @throws \InvalidArgumentException
     */
    public function addMenuItem(AdminMenuItem|array $item, ?string $group = null)
    {
        $group = $group ?: __('Main');
        $menuItem = $this->createAdminMenuItem($item);
        if (!isset($this->groups[$group])) {
            $this->groups[$group] = [];
        }

        if ($menuItem->userHasPermission()) {
            $this->groups[$group][] = $menuItem;
        }
    }

    protected function createAdminMenuItem(AdminMenuItem|array $data): AdminMenuItem
    {
        if ($data instanceof AdminMenuItem) {
            return $data;
        }

        $menuItem = new AdminMenuItem();

        if (isset($data['children']) && is_array($data['children'])) {
            $data['children'] = array_map(
                fn($child) => auth()->user()->hasAnyPermission($child['permissions'] ?? [])
                ? $this->createAdminMenuItem($child)
                : null,
                $data['children']
            );

            // Filter out null values (items without permission).
            $data['children'] = array_filter($data['children']);
        }

        return $menuItem->setAttributes($data);
    }

    public function getMenu()
    {
        $this->addMenuItem([
            'label' => __('Dashboard'),
            'icon' => 'dashboard.svg',
            'route' => route('admin.dashboard'),
            'active' => Route::is('admin.dashboard'),
            'id' => 'dashboard',
            'priority' => 1,
            'permissions' => 'dashboard.view'
        ]);

        // Content Management Menu
        try {
            if (Schema::hasTable('post_types') && Schema::hasTable('taxonomies')) {
                $this->addContentManagementMenuItems();
            }
        } catch (QueryException $e) {
            // Skip adding content management menu items if tables don't exist
        }

        $this->addMenuItem([
            'label' => __('Roles & Permissions'),
            'icon' => 'key.svg',
            'id' => 'roles-submenu',
            'active' => Route::is('admin.roles.*'),
            'priority' => 20,
            'permissions' => ['role.create', 'role.view', 'role.edit', 'role.delete'],
            'children' => [
                [
                    'label' => __('Roles'),
                    'route' => route('admin.roles.index'),
                    'active' => Route::is('admin.roles.index') || Route::is('admin.roles.edit'),
                    'priority' => 10,
                    'permissions' => 'role.view'
                ],
                [
                    'label' => __('New Role'),
                    'route' => route('admin.roles.create'),
                    'active' => Route::is('admin.roles.create'),
                    'priority' => 20,
                    'permissions' => 'role.create'
                ],
                [
                    'label' => __('Permissions'),
                    'route' => route('admin.permissions.index'),
                    'active' => Route::is('admin.permissions.index') || Route::is('admin.permissions.show'),
                    'priority' => 30,
                    'permissions' => 'role.view'
                ]
            ]
        ]);

        $this->addMenuItem([
            'label' => __('User'),
            'icon' => 'user.svg',
            'id' => 'users-submenu',
            'active' => Route::is('admin.users.*'),
            'priority' => 20,
            'permissions' => ['user.create', 'user.view', 'user.edit', 'user.delete'],
            'children' => [
                [
                    'label' => __('Users'),
                    'route' => route('admin.users.index'),
                    'active' => Route::is('admin.users.index') || Route::is('admin.users.edit'),
                    'priority' => 20,
                    'permissions' => 'user.view'
                ],
                [
                    'label' => __('New User'),
                    'route' => route('admin.users.create'),
                    'active' => Route::is('admin.users.create'),
                    'priority' => 10,
                    'permissions' => 'user.create'
                ]
            ]
        ]);

        $this->addMenuItem([
            'label' => __('Modules'),
            'icon' => 'three-dice.svg',
            'route' => route('admin.modules.index'),
            'active' => Route::is('admin.modules.index'),
            'id' => 'modules',
            'priority' => 30,
            'permissions' => 'module.view'
        ]);

        $this->addMenuItem([
            'label' => __('Monitoring'),
            'icon' => 'tv.svg',
            'id' => 'monitoring-submenu',
            'active' => Route::is('admin.actionlog.*'),
            'priority' => 40,
            'permissions' => ['pulse.view', 'actionlog.view'],
            'children' => [
                [
                    'label' => __('Action Logs'),
                    'route' => route('admin.actionlog.index'),
                    'active' => Route::is('admin.actionlog.index'),
                    'priority' => 20,
                    'permissions' => 'actionlog.view'
                ],
                [
                    'label' => __('Laravel Pulse'),
                    'route' => route('pulse'),
                    'active' => false,
                    'target' => '_blank',
                    'priority' => 10,
                    'permissions' => 'pulse.view'
                ]
            ]
        ]);

        $this->addMenuItem([
            'label' => __('Settings'),
            'icon' => 'settings.svg',
            'id' => 'settings-submenu',
            'active' => Route::is('admin.settings.*') || Route::is('admin.translations.*'),
            'priority' => 1,
            'permissions' => ['settings.edit', 'translations.view'],
            'children' => [
                [
                    'label' => __('General Settings'),
                    'route' => route('admin.settings.index'),
                    'active' => Route::is('admin.settings.index'),
                    'priority' => 20,
                    'permissions' => 'settings.edit'
                ],
                [
                    'label' => __('Translations'),
                    'route' => route('admin.translations.index'),
                    'active' => Route::is('admin.translations.*'),
                    'priority' => 10,
                    'permissions' => ['translations.view', 'translations.edit']
                ]
            ]
        ], __('More'));

        $this->addMenuItem([
            'label' => __('Logout'),
            'icon' => 'logout.svg',
            'route' => route('admin.dashboard'),
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
        ], __('More'));

        $this->groups = ld_apply_filters('admin_menu_groups_before_sorting', $this->groups);

        $this->sortMenuItemsByPriority();
        return $this->applyFiltersToMenuItems();
    }

    /**
     * Add content management menu items
     */
    protected function addContentManagementMenuItems(): void
    {
        // Get all registered post types from content service
        $contentService = app(ContentService::class);
        $postTypes = $contentService->getPostTypes();
        $taxonomies = $contentService->getTaxonomies();

        // Add main content management menu
        $children = [];

        // Add post types to children
        foreach ($postTypes as $postType) {
            if ($postType->show_in_menu) {
                $children[] = [
                    'label' => $postType->label,
                    'route' => route('admin.posts.index', $postType->name),
                    'active' => Route::is('admin.posts.*') && request()->postType === $postType->name,
                    'priority' => 10 + $postType->id,
                    'permissions' => 'post.view'
                ];
            }
        }

        // Add taxonomies to children
        foreach ($taxonomies as $taxonomy) {
            if ($taxonomy->show_in_menu) {
                $children[] = [
                    'label' => $taxonomy->label,
                    'route' => route('admin.terms.index', $taxonomy->name),
                    'active' => Route::is('admin.terms.*') && request()->taxonomy === $taxonomy->name,
                    'priority' => 50 + $taxonomy->id, // Prioritize after post types
                    'permissions' => 'term.view'
                ];
            }
        }

        if (!empty($children)) {
            $this->addMenuItem([
                'label' => __('Content'),
                'icon' => 'document-text.svg',
                'id' => 'content-submenu',
                'active' => Route::is('admin.posts.*') || Route::is('admin.terms.*'),
                'priority' => 10,
                'permissions' => ['post.view', 'term.view'],
                'children' => $children
            ]);
        }
    }

    protected function sortMenuItemsByPriority(): void
    {
        foreach ($this->groups as &$groupItems) {
            usort($groupItems, function ($a, $b) {
                return (int) $a->priority <=> (int) $b->priority;
            });
        }
    }

    protected function applyFiltersToMenuItems(): array
    {
        $result = [];
        foreach ($this->groups as $group => $items) {
            // Filter items by permission.
            $filteredItems = array_filter($items, function (AdminMenuItem $item) {
                return $item->userHasPermission();
            });

            // Apply filters that might add/modify menu items.
            $filteredItems = ld_apply_filters('sidebar_menu_' . strtolower($group), $filteredItems);
            
            // Only add the group if it has items after filtering.
            if (!empty($filteredItems)) {
                $result[$group] = $filteredItems;
            }
        }

        return $result;
    }

    public function shouldExpandSubmenu(AdminMenuItem $menuItem): bool
    {
        // If the parent menu item is active, expand the submenu.
        if ($menuItem->active) {
            return true;
        }

        // Check if any child menu item is active.
        foreach ($menuItem->children as $child) {
            if ($child->active) {
                return true;
            }
        }

        return false;
    }

    public function render(array $groupItems): string
    {
        $html = '';
        foreach ($groupItems as $menuItem) {
            $filterKey = $menuItem->id ?? Str::slug($menuItem->label) ?? '';
            $html .= ld_apply_filters('sidebar_menu_before_' . $filterKey, '');

            $html .= view('backend.layouts.partials.menu-item', [
                'item' => $menuItem,
            ])->render();

            $html .= ld_apply_filters('sidebar_menu_after_' . $filterKey, '');
        }

        return $html;
    }
}
