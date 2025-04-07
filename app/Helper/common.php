<?php

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

function add_setting(string $optionName, mixed $optionValue, bool $autoload = false): void
{
    app(App\Services\SettingService::class)->addSetting($optionName, $optionValue, $autoload);
}

function update_setting(string $optionName, mixed $optionValue, ?bool $autoload = null): bool
{
    return app(App\Services\SettingService::class)->updateSetting($optionName, $optionValue, $autoload);
}

function delete_setting(string $optionName): bool
{
    return app(App\Services\SettingService::class)->deleteSetting($optionName);
}

function get_setting(string $optionName): mixed
{
    return app(App\Services\SettingService::class)->getSetting($optionName);
}

function get_settings(int|bool|null $autoload = true): array
{
    return app(App\Services\SettingService::class)->getSettings($autoload);
}
