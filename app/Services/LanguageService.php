<?php

declare(strict_types=1);

namespace App\Services;


class LanguageService
{
    public function getAllLang(): array
    {
        $languages = ld_apply_filters('languages', [
            'bn' => [
                'name' => 'Bangla',
            ],
            'en' => [
                'name' => 'English',
            ],
        ]);

        foreach ($languages as $code => &$language) {
            $language['icon'] = "/images/flags/language-{$code}.svg";
        }

        return $languages;
    }
}
