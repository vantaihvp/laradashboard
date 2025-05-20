<?php

namespace App\Services;

use App\Models\PostType;
use App\Models\Taxonomy;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ContentService
{
    /**
     * Register a new post type
     */
    public function registerPostType(array $args): ?PostType
    {
        // Default values
        $defaults = [
            'name' => null,
            'label' => null,
            'label_singular' => null,
            'description' => '',
            'public' => true,
            'has_archive' => true,
            'hierarchical' => false,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'supports_title' => true,
            'supports_editor' => true,
            'supports_thumbnail' => true,
            'supports_excerpt' => true,
            'supports_custom_fields' => true,
            'taxonomies' => []
        ];

        $args = array_merge($defaults, $args);

        // Required values
        if (empty($args['name'])) {
            return null;
        }

        // Set defaults for blank values
        if (empty($args['label'])) {
            $args['label'] = Str::plural(Str::title($args['name']));
        }

        if (empty($args['label_singular'])) {
            $args['label_singular'] = Str::title($args['name']);
        }

        // Convert taxonomies to array if needed
        if (is_string($args['taxonomies'])) {
            $args['taxonomies'] = explode(',', $args['taxonomies']);
        }

        // Create or update the post type
        $postType = PostType::updateOrCreate(
            ['name' => $args['name']],
            $args
        );

        // Clear cache
        $this->clearPostTypesCache();

        return $postType;
    }

    /**
     * Register a new taxonomy
     */
    public function registerTaxonomy(array $args, $postTypes = null): ?Taxonomy
    {
        // Default values
        $defaults = [
            'name' => null,
            'label' => null,
            'label_singular' => null,
            'description' => '',
            'public' => true,
            'hierarchical' => false,
            'show_in_menu' => true,
        ];

        $args = array_merge($defaults, $args);

        // Required values
        if (empty($args['name'])) {
            return null;
        }

        // Set defaults for blank values
        if (empty($args['label'])) {
            $args['label'] = Str::plural(Str::title($args['name']));
        }

        if (empty($args['label_singular'])) {
            $args['label_singular'] = Str::title($args['name']);
        }

        // Handle post types
        if (!empty($postTypes)) {
            if (is_string($postTypes)) {
                $postTypes = [$postTypes];
            } elseif (!is_array($postTypes)) {
                $postTypes = [];
            }
            
            $args['post_types'] = $postTypes;
        }

        // Create or update the taxonomy
        $taxonomy = Taxonomy::updateOrCreate(
            ['name' => $args['name']],
            $args
        );

        // Clear cache
        $this->clearTaxonomiesCache();

        return $taxonomy;
    }

    /**
     * Get all registered post types
     */
    public function getPostTypes()
    {
        return Cache::remember('post_types', 3600, function () {
            return PostType::all();
        });
    }

    /**
     * Get all registered taxonomies
     */
    public function getTaxonomies()
    {
        return Cache::remember('taxonomies', 3600, function () {
            return Taxonomy::all();
        });
    }

    /**
     * Clear post types cache
     */
    public function clearPostTypesCache()
    {
        Cache::forget('post_types');
    }

    /**
     * Clear taxonomies cache
     */
    public function clearTaxonomiesCache()
    {
        Cache::forget('taxonomies');
    }
}
