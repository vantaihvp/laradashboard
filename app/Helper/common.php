<?php

use Illuminate\Foundation\Vite;
use Illuminate\Support\Facades\Vite as ViteFacade;

function get_module_asset_paths(): array
{
    $paths = [];

    if (file_exists('build/manifest.json')) {
        $files = json_decode(file_get_contents('build/manifest.json'), true);

        foreach ($files as $file) {
            $paths[] = $file['src'];
        }
    }

    return $paths;
}

if (! function_exists('module_vite_compile')) {
    /**
     * support for vite hot reload overriding manifest file.
     */
    function module_vite_compile(string $module, string $asset, ?string $hotFilePath = null, $manifestFile = '.vite/manifest.json'): Vite
    {
        return ViteFacade::useHotFile($hotFilePath ?: storage_path('vite.hot'))
            ->useBuildDirectory($module)
            ->useManifestFilename($manifestFile)
            ->withEntryPoints([$asset]);
    }
}