<?php

namespace App\Providers;

use App\Services\ContentService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\QueryException;

class ContentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ContentService::class, function ($app) {
            return new ContentService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Skip registering post types and taxonomies if tables don't exist yet
        try {
            if (!$this->tablesExist(['post_types', 'taxonomies'])) {
                return;
            }
            
            // Register default post types
            $this->registerDefaultPostTypes();
            
            // Register default taxonomies
            $this->registerDefaultTaxonomies();
        } catch (QueryException $e) {
            // Handle database connection issues or other query-related errors
            // Just exit gracefully for now
            return;
        }
    }

    /**
     * Check if the specified tables exist in the database
     *
     * @param array $tables Table names to check
     * @return bool True if all tables exist, false otherwise
     */
    protected function tablesExist(array $tables): bool
    {
        foreach ($tables as $table) {
            if (!Schema::hasTable($table)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Register default post types
     */
    protected function registerDefaultPostTypes(): void
    {
        $contentService = app(ContentService::class);

        // Register post type
        $contentService->registerPostType([
            'name' => 'post',
            'label' => 'Posts',
            'label_singular' => 'Post',
            'description' => 'Default post type for blog entries',
            'taxonomies' => ['category', 'tag']
        ]);

        // Register page type
        $contentService->registerPostType([
            'name' => 'page',
            'label' => 'Pages',
            'label_singular' => 'Page',
            'description' => 'Default post type for static pages',
            'has_archive' => false,
            'hierarchical' => true,
            'supports_excerpt' => false,
            'taxonomies' => []
        ]);

        // Allow other plugins/modules to register post types
        ld_do_action('register_post_types', $contentService);
    }

    /**
     * Register default taxonomies
     */
    protected function registerDefaultTaxonomies(): void
    {
        $contentService = app(ContentService::class);

        // Register category taxonomy
        $contentService->registerTaxonomy([
            'name' => 'category',
            'label' => 'Categories',
            'label_singular' => 'Category',
            'description' => 'Default taxonomy for categorizing posts',
            'hierarchical' => true,
        ], 'post');

        // Register tag taxonomy
        $contentService->registerTaxonomy([
            'name' => 'tag',
            'label' => 'Tags',
            'label_singular' => 'Tag',
            'description' => 'Default taxonomy for tagging posts',
            'hierarchical' => false,
        ], 'post');

        // Allow other plugins/modules to register taxonomies
        ld_do_action('register_taxonomies', $contentService);
    }
}
