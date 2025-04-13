<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Artisan;

class CacheService
{
    public function clearCache(): void
    {
        $this->clearConfigCache();
        $this->clearRouteCache();
        $this->clearViewCache();
        $this->clearApplicationCache();
    }

    private function clearConfigCache(): void
    {
        Artisan::call('config:cache');
    }
    private function clearRouteCache(): void
    {
        Artisan::call('route:cache');
    }
    private function clearViewCache(): void
    {
        Artisan::call('view:clear');
    }
    private function clearApplicationCache(): void
    {
        Artisan::call('cache:clear');
    }
}