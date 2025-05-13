<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SiteNavigation;
use Illuminate\Database\Eloquent\Collection;


class SiteNavigationService
{
    public function getFrontEndNavigationItems(): Collection
    {
        return SiteNavigation::where('menu_type', 'frontend')
            ->where('status', true)
            ->get();
    }

    public function getBackEndNavigationItems(): Collection
    {
        return SiteNavigation::where('menu_type', 'backend')
            ->get();
    }
}
