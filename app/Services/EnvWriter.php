<?php

declare(strict_types=1);

namespace App\Services;

class EnvWriter
{
    public function write($key, $value)
    {
        $path = base_path('.env');
        $file = file_get_contents($path);
        \Log::info("Writing to .env file: $key=$value");
        $file = preg_replace("/^$key=.*/m", "$key=$value", $file);
        file_put_contents($path, $file);
    }

    public function get($key)
    {
        $path = base_path('.env');
        $file = file_get_contents($path);
        preg_match("/^$key=(.*)/m", $file, $matches);
        return isset($matches[1]) ? trim($matches[1]) : null;
    }

    public function maybeWriteKeysToEnvFile($keys)
    {
        $availableKeys = $this->getAvailableKeys();

        // Stop if no keys are matching to availableKeys.
        if (empty($keys) || empty($availableKeys)) {
            return;
        }

        foreach ($keys as $key => $value) {
            if (array_key_exists($key, $availableKeys)) {
                $this->write($availableKeys[$key], $value);
            }
        }
    }

    public function getAvailableKeys()
    {
        return ld_apply_filters('available_keys', [
            'app_name' => 'APP_NAME',
        ]);
    }
}