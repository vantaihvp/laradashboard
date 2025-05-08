<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Enums\ActionType;
use App\Http\Controllers\Controller;
use App\Services\LanguageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TranslationController extends Controller
{
    /**
     * Available languages
     */
    protected array $languages = [];

    /**
     * Common translation groups
     */
    protected array $groups = [
        'json' => 'General',
        'auth' => 'Authentication',
        'pagination' => 'Pagination',
        'passwords' => 'Passwords',
        'validation' => 'Validation',
    ];

    /**
     * Constructor
     */
    public function __construct(private readonly LanguageService $languageService)
    {
        $this->languages = $this->languageService->getActiveLanguages();
    }

    /**
     * Display translation management interface.
     */
    public function index(): View
    {
        $this->checkAuthorization(auth()->user(), ['translations.view']);

        $languages = $this->languages;
        $groups = $this->groups;
        $selectedLang = request()->get('lang', 'bn');
        $selectedGroup = request()->get('group', 'json');

        // Get base English translations for the selected group
        $enTranslations = $this->getTranslations('en', $selectedGroup);

        // Get translations for selected language and group
        $translations = $this->getTranslations($selectedLang, $selectedGroup);

        // Get available translation files for both languages
        $availableGroups = $this->getAvailableTranslationGroups($selectedLang);

        // Get all available languages from the service
        $allLanguages = $this->languageService->getLanguageNames();

        // Calculate translation statistics
        $translationStats = $this->calculateTranslationStats($translations, $enTranslations, $selectedGroup);

        return view('backend.pages.translations.index', compact(
            'languages',
            'groups',
            'enTranslations',
            'translations',
            'selectedLang',
            'selectedGroup',
            'availableGroups',
            'allLanguages',
            'translationStats'
        ));
    }

    /**
     * Calculate statistics for translation progress
     */
    protected function calculateTranslationStats(array $translations, array $enTranslations, string $group): array
    {
        $totalKeys = 0;
        $nonEmptyTranslations = 0;

        if ($group === 'json') {
            $totalKeys = count($enTranslations);

            foreach ($translations as $key => $value) {
                if (isset($enTranslations[$key]) && !empty(trim((string)$value))) {
                    $nonEmptyTranslations++;
                }
            }
        } else {
            $totalKeys = $this->countTotalKeys($enTranslations);
            $nonEmptyTranslations = $this->countNonEmptyTranslations($translations, $enTranslations);
        }

        $missingTranslations = $totalKeys - $nonEmptyTranslations;
        $progressPercentage = $totalKeys > 0 ? ($nonEmptyTranslations / $totalKeys * 100) : 0;

        return [
            'totalKeys' => $totalKeys,
            'translated' => $nonEmptyTranslations,
            'missing' => $missingTranslations,
            'percentage' => $progressPercentage
        ];
    }

    /**
     * Count non-empty translations recursively in nested arrays
     */
    protected function countNonEmptyTranslations(array $translationArray, array $enArray): int
    {
        $count = 0;
        foreach ($enArray as $key => $value) {
            if (is_array($value)) {
                // Recurse into nested arrays
                if (isset($translationArray[$key]) && is_array($translationArray[$key])) {
                    $count += $this->countNonEmptyTranslations($translationArray[$key], $value);
                }
            } else if (isset($translationArray[$key]) && !empty(trim((string)$translationArray[$key]))) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * Count total keys recursively in nested arrays
     */
    protected function countTotalKeys(array $array): int
    {
        $count = 0;
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $count += $this->countTotalKeys($value);
            } else {
                $count++;
            }
        }
        return $count;
    }

    /**
     * Create a new language translation file.
     */
    public function create(Request $request): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['translations.edit']);

        $request->validate([
            'language_code' => 'required|string|max:10',
            'group' => 'required|string|max:30',
        ]);

        $lang = $request->input('language_code');
        $group = $request->input('group');

        // Check if language already exists
        if ($group === 'json' && File::exists(resource_path("lang/{$lang}.json"))) {
            return redirect()
                ->route('admin.translations.index', ['lang' => $lang, 'group' => $group])
                ->with('error', "Language file for {$lang} already exists.");
        }

        if ($group !== 'json' && File::exists(resource_path("lang/{$lang}/{$group}.php"))) {
            return redirect()
                ->route('admin.translations.index', ['lang' => $lang, 'group' => $group])
                ->with('error', "Translation group {$group} for {$lang} already exists.");
        }

        // Create language file based on group
        if ($group === 'json') {
            // Copy from English or create new
            if (File::exists(resource_path("lang/en.json"))) {
                // Read English JSON file
                $englishContent = File::get(resource_path("lang/en.json"));
                $englishTranslations = json_decode($englishContent, true) ?: [];

                // Create a new array with the same keys but empty values
                $emptyTranslations = [];
                foreach ($englishTranslations as $key => $value) {
                    $emptyTranslations[$key] = "";
                }

                // Save the new JSON file with empty values
                File::put(
                    resource_path("lang/{$lang}.json"),
                    json_encode($emptyTranslations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
                );
            } else {
                // Create empty JSON file
                File::put(resource_path("lang/{$lang}.json"), '{}');
            }
        } else {
            // Create group file
            if (File::exists(resource_path("lang/en/{$group}.php"))) {
                // If English exists, copy structure but with empty values
                $enTranslations = include(resource_path("lang/en/{$group}.php"));
                $emptyTranslations = $this->createEmptyTranslations($enTranslations);
                $this->createGroupTranslationFile($lang, $group, $emptyTranslations);
            } else {
                // Create with default translations but with empty values
                $defaultTranslations = $this->getDefaultTranslationsForGroup($group);
                $emptyTranslations = $this->createEmptyTranslations($defaultTranslations);
                $this->createGroupTranslationFile($lang, $group, $emptyTranslations);
            }
        }

        $languageName = $this->languageService->getLanguageNameByLocale($lang);

        $this->storeActionLog(ActionType::CREATED, [
            'translations' => "Created new translation file for {$languageName}, group: {$group}",
        ]);

        return redirect()
            ->route('admin.translations.index', ['lang' => $lang, 'group' => $group])
            ->with('success', "New language {$languageName} ({$group}) has been added successfully.");
    }

    /**
     * Recursively create array with same keys but empty values
     */
    protected function createEmptyTranslations(array $translations): array
    {
        $result = [];

        foreach ($translations as $key => $value) {
            if (is_array($value)) {
                $result[$key] = $this->createEmptyTranslations($value);
            } else {
                $result[$key] = '';
            }
        }

        return $result;
    }

    /**
     * Update translations.
     */
    public function update(Request $request): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['translations.edit']);

        $lang = $request->input('lang', 'bn');
        $group = $request->input('group', 'json');
        $translations = $request->input('translations', []);

        // Filter out empty translations for JSON files
        if ($group === 'json') {
            $translations = array_filter($translations, function ($value) {
                return $value !== null && $value !== '';
            });
        }

        // Save translations
        $this->saveTranslations($lang, $translations, $group);

        $languageName = $this->languages[$lang]['name'] ?? ucfirst($lang);

        // Count translations properly, accounting for nested arrays
        $translationCount = $group === 'json'
            ? count($translations)
            : $this->countTranslationsRecursively($translations);

        $this->storeActionLog(ActionType::UPDATED, [
            'translations' => "Updated {$languageName} translations for group '{$group}'",
            'count' => $translationCount
        ]);

        return redirect()
            ->route('admin.translations.index', ['lang' => $lang, 'group' => $group])
            ->with('success', "Translations for {$languageName} ({$group}) have been updated successfully.");
    }

    /**
     * Count translations recursively, including nested arrays
     */
    protected function countTranslationsRecursively(array $translations): int
    {
        $count = 0;

        foreach ($translations as $translation) {
            if (is_array($translation)) {
                $count += $this->countTranslationsRecursively($translation);
            } else {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Get translations from file.
     */
    protected function getTranslations(string $lang, string $group = 'json'): array
    {
        if ($group === 'json') {
            return $this->getJsonTranslations($lang);
        }

        return $this->getGroupTranslations($lang, $group);
    }

    /**
     * Get JSON translations.
     */
    protected function getJsonTranslations(string $lang): array
    {
        $path = resource_path("lang/{$lang}.json");

        if (!File::exists($path)) {
            if ($lang !== 'en') {
                // Create file with empty translations if it doesn't exist
                File::put($path, '{}');
            } else {
                // For English, create with default Laravel translations
                $defaultTranslations = [
                    'Welcome' => 'Welcome',
                    'Dashboard' => 'Dashboard',
                    'Login' => 'Login',
                    'Logout' => 'Logout',
                    'Register' => 'Register',
                    'Password' => 'Password',
                    'Email' => 'Email',
                ];
                File::put($path, json_encode($defaultTranslations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }
        }

        $content = File::get($path);
        return json_decode($content, true) ?: [];
    }

    /**
     * Get group translations from PHP files.
     */
    protected function getGroupTranslations(string $lang, string $group): array
    {
        $path = resource_path("lang/{$lang}/{$group}.php");

        // If the directory doesn't exist, create it
        if (!File::exists(resource_path("lang/{$lang}"))) {
            File::makeDirectory(resource_path("lang/{$lang}"), 0755, true);
        }

        // If file doesn't exist but English version does, copy structure from English
        if (!File::exists($path) && File::exists(resource_path("lang/en/{$group}.php"))) {
            $enTranslations = include(resource_path("lang/en/{$group}.php"));

            // Create file with empty translations or copy English structure
            $this->createGroupTranslationFile($lang, $group, $enTranslations);

            if (File::exists($path)) {
                return include($path);
            }

            return [];
        }

        // If file exists, return its contents
        if (File::exists($path)) {
            return include($path);
        }

        // If no file exists, create a default structure based on group
        $defaultTranslations = $this->getDefaultTranslationsForGroup($group);
        $this->createGroupTranslationFile($lang, $group, $defaultTranslations);

        return $defaultTranslations;
    }

    /**
     * Get default translations structure for a specific group.
     */
    protected function getDefaultTranslationsForGroup(string $group): array
    {
        switch ($group) {
            case 'auth':
                return [
                    'failed' => 'These credentials do not match our records.',
                    'password' => 'The provided password is incorrect.',
                    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
                ];
            case 'pagination':
                return [
                    'previous' => '&laquo; Previous',
                    'next' => 'Next &raquo;',
                ];
            case 'passwords':
                return [
                    'reset' => 'Your password has been reset!',
                    'sent' => 'We have emailed your password reset link.',
                    'throttled' => 'Please wait before retrying.',
                    'token' => 'This password reset token is invalid.',
                    'user' => "We can't find a user with that email address.",
                ];
            case 'validation':
                // Return just a few common validation messages as default
                return [
                    'accepted' => 'The :attribute must be accepted.',
                    'active_url' => 'The :attribute is not a valid URL.',
                    'after' => 'The :attribute must be a date after :date.',
                    'alpha' => 'The :attribute may only contain letters.',
                    'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
                    'required' => 'The :attribute field is required.',
                    'email' => 'The :attribute must be a valid email address.',
                ];
            default:
                return [];
        }
    }

    /**
     * Create a new group translation file.
     */
    protected function createGroupTranslationFile(string $lang, string $group, array $translations): void
    {
        $path = resource_path("lang/{$lang}/{$group}.php");

        // Prepare file content
        $content = "<?php\n\nreturn " . $this->varExport($translations, true) . ";\n";

        // Create the directory if it doesn't exist
        $directory = dirname($path);
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Write the file
        File::put($path, $content);
    }

    /**
     * Save translations to file.
     */
    protected function saveTranslations(string $lang, array $translations, string $group = 'json'): bool
    {
        if ($group === 'json') {
            return $this->saveJsonTranslations($lang, $translations);
        }

        return $this->saveGroupTranslations($lang, $group, $translations);
    }

    /**
     * Save JSON translations.
     */
    protected function saveJsonTranslations(string $lang, array $translations): bool
    {
        $path = resource_path("lang/{$lang}.json");

        // Sort translations alphabetically
        ksort($translations);

        // Save with pretty print
        return (bool) File::put(
            $path,
            json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

    /**
     * Save group translations to PHP files.
     */
    protected function saveGroupTranslations(string $lang, string $group, array $translations): bool
    {
        $path = resource_path("lang/{$lang}/{$group}.php");

        // Prepare file content
        $content = "<?php\n\nreturn " . $this->varExport($translations, true) . ";\n";

        // Create the directory if it doesn't exist
        $directory = dirname($path);
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Write the file
        return (bool) File::put($path, $content);
    }

    /**
     * Get all available translation groups for a language.
     */
    protected function getAvailableTranslationGroups(string $lang): array
    {
        $availableGroups = ['json'];

        // Check if language directory exists
        $langPath = resource_path("lang/{$lang}");
        if (File::exists($langPath)) {
            // Get all PHP files in the directory
            $files = File::files($langPath);
            foreach ($files as $file) {
                if ($file->getExtension() === 'php') {
                    $availableGroups[] = $file->getFilenameWithoutExtension();
                }
            }
        }

        // Check English directory for additional groups
        if ($lang !== 'en') {
            $enPath = resource_path("lang/en");
            if (File::exists($enPath)) {
                $files = File::files($enPath);
                foreach ($files as $file) {
                    if ($file->getExtension() === 'php') {
                        $group = $file->getFilenameWithoutExtension();
                        if (!in_array($group, $availableGroups)) {
                            $availableGroups[] = $group;
                        }
                    }
                }
            }
        }

        return $availableGroups;
    }

    /**
     * Better formatting for nested arrays when exporting to PHP.
     */
    protected function varExport($expression, bool $return = false): string
    {
        $export = var_export($expression, true);
        $patterns = [
            "/array \(/" => '[',
            "/^([ ]*)\)(,?)$/m" => '$1]$2',
            "/=>[ ]?\n[ ]+\[/" => '=> [',
            "/([ ]*)(\'[^\']+\') => ([\[\'])/" => '$1$2 => $3',
        ];
        $export = preg_replace(array_keys($patterns), array_values($patterns), $export);

        if ($return) {
            return $export;
        }

        echo $export;
        return '';
    }

    /**
     * Prepare nested translation data for form inputs.
     */
    protected function flattenTranslations(array $translations, string $prefix = ''): array
    {
        $result = [];

        foreach ($translations as $key => $value) {
            $newKey = $prefix ? "{$prefix}.{$key}" : $key;

            if (is_array($value)) {
                $result = array_merge($result, $this->flattenTranslations($value, $newKey));
            } else {
                $result[$newKey] = $value;
            }
        }

        return $result;
    }

    /**
     * Reconstruct nested array from flattened form inputs.
     */
    protected function unflattenTranslations(array $translations): array
    {
        $result = [];

        foreach ($translations as $key => $value) {
            $parts = explode('.', $key);
            $current = &$result;

            foreach ($parts as $i => $part) {
                if ($i === count($parts) - 1) {
                    $current[$part] = $value;
                } else {
                    if (!isset($current[$part]) || !is_array($current[$part])) {
                        $current[$part] = [];
                    }
                    $current = &$current[$part];
                }
            }

            unset($current);
        }

        return $result;
    }
}
