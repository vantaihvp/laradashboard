<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteNavigationSeeder extends Seeder
{
    public function run()
    {
        $navigationItems = [
            [
                'id' => '1',
                'menu_label' => 'Dashboard',
                'link' => '/admin/dashboard',
                'menu_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '2',
                'menu_label' => 'Roles & Permissions',
                'link' => '',
                'menu_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '3',
                'menu_label' => 'Roles',
                'link' => '/admin/roles',
                'parent_id' => '2',
                'menu_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '4',
                'menu_label' => 'New Role',
                'link' => '/admin/roles/create',
                'parent_id' => '2',
                'menu_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '5',
                'menu_label' => 'User',
                'link' => '',
                'menu_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '6',
                'menu_label' => 'Users',
                'link' => '/admin/users',
                'parent_id' => '5',
                'menu_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '7',
                'menu_label' => 'New User',
                'link' => '/admin/users/create',
                'parent_id' => '5',
                'menu_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '8',
                'menu_label' => 'Modules',
                'link' => '/admin/modules',
                'menu_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '9',
                'menu_label' => 'Monitoring',
                'link' => '',
                'menu_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '10',
                'menu_label' => 'Action Logs',
                'link' => '/actionlog',
                'parent_id' => '9',
                'menu_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '11',
                'menu_label' => 'Laravel Pulse',
                'link' => '/pulse',
                'parent_id' => '9',
                'menu_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '12',
                'menu_label' => 'Settings',
                'link' => '',
                'menu_order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '13',
                'menu_label' => 'General Settings',
                'link' => '/admin/settings',
                'parent_id' => '12',
                'menu_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '14',
                'menu_label' => 'Translations',
                'link' => '/admin/translations',
                'parent_id' => '12',
                'menu_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '15',
                'menu_label' => 'CMS',
                'link' => '',
                'menu_order' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '16',
                'menu_label' => 'Site Menu',
                'link' => '/admin/menus',
                'parent_id' => '15',
                'menu_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '17',
                'menu_label' => 'Logout',
                'link' => '/logout',
                'menu_order' => 99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        $parentMap = [];
        foreach ($navigationItems as $item) {
            if (!isset($item['parent_id'])) {
                $parent = $item;
                unset($parent['id']);
                $navigationId = DB::table('site_navigations')->insertGetId($parent);
                $parentMap[$item['id']] = $navigationId;
            }
        }

        foreach ($navigationItems as $item) {
            if (isset($item['parent_id']) && !empty($item['parent_id']) && isset($parentMap[$item['parent_id']])) {
                $child = $item;
                unset($child['id']);
                $child['navigation_id'] = $parentMap[$item['parent_id']];
                DB::table('site_navigation_items')->insert($child);
            }
        }
    }
}
