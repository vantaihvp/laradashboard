<div class="rounded-2xl border border-gray-200  dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="px-5 py-4 sm:px-6 sm:py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            {{ __('General Settings') }}
        </h3>
    </div>
    <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">

        <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                {{ __('Site Name') }}
            </label>
            <input type="text" name="app_name" placeholder="{{ __('Enter site name') }}"
                value="{{ config('settings.app_name') ?? '' }}"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
        </div>

        <div class=" flex gap-2">
            <div class=" w-1/2">
                @if (config('settings.site_logo_lite') !== '' && !empty(config('settings.site_logo_lite')))
                    <img src="{{ config('settings.site_logo_lite') ?? '' }}" class=" h-50" alt="">
                @endif
                <div class=" w-full">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        {{ __('Site Logo Full (Lite Version)') }}
                    </label>
                    <input type="file" name="site_logo_lite"
                        class="focus:border-ring-brand-300 cursor-pointer focus:file:ring-brand-300 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:px-4 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400 px-4">
                </div>
            </div>

            <div class=" w-1/2">
                @if (config('settings.site_logo_dark') !== '' && !empty(config('settings.site_logo_dark')))
                    <img src="{{ config('settings.site_logo_dark') ?? '' }}" class=" h-50" alt="">
                @endif
                <div class=" w-full">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        {{ __('Site Logo Full (Dark Version)') }}
                    </label>
                    <input type="file" name="site_logo_dark"
                        class="focus:border-ring-brand-300 cursor-pointer focus:file:ring-brand-300 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:px-4 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400 px-4">
                </div>
            </div>


            <div class=" w-1/2">
                @if (config('settings.site_icon') !== ''  && !empty(config('settings.site_icon')))
                    <img src="{{ config('settings.site_icon') ?? '' }}" class=" h-50" alt="">
                @endif
                <div class=" w-full">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        {{ __('Site Icon') }}
                    </label>
                    <input type="file" name="site_icon"
                        class="focus:border-ring-brand-300 cursor-pointer focus:file:ring-brand-300 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:px-4 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400 px-4">
                </div>
            </div>


            <div class=" w-1/2">
                @if (config('settings.site_favicon') !== '' && !empty(config('settings.site_favicon')))
                    <img src="{{ config('settings.site_favicon') ?? '' }}" class=" h-50" alt="">
                @endif
                <div class=" w-full">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        {{ __('Site Favicon') }}
                    </label>
                    <input type="file" name="site_favicon"
                        class="focus:border-ring-brand-300 cursor-pointer focus:file:ring-brand-300 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:px-4 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400 px-4">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] mt-4">
    <div class="px-5 py-4 sm:px-6 sm:py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            {{ __('Site Styling Settings') }}
        </h3>
    </div>
    <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Theme Primary Color -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                    {{ __('Theme Primary Color') }}
                </label>
                <div class="flex gap-2 items-center">
                    <div class="relative">
                        <input type="color" id="color-picker-theme_primary_color" name="theme_primary_color"
                            value="{{ config('settings.theme_primary_color') ?? '' }}"
                            class="h-11 w-11 cursor-pointer dark:border-gray-700"
                            data-tooltip-target="tooltip-theme_primary_color" onchange="syncColor('theme_primary_color')">
                        <div id="tooltip-theme_primary_color" role="tooltip"
                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                            {{ __('Choose color') }}
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </div>
                    <input type="text" id="input-theme_primary_color" name="theme_primary_color_text"
                        value="{{ config('settings.theme_primary_color') ?? '#ffffff' }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        placeholder="#ffffff" oninput="syncColor('theme_primary_color', true)">
                </div>
            </div>

            <!-- Theme Secondary Color -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                    {{ __('Theme Secondary Color') }}
                </label>
                <div class="flex gap-2 items-center">
                    <div class="relative">
                        <input type="color" id="color-picker-theme_secondary_color" name="theme_secondary_color"
                            value="{{ config('settings.theme_secondary_color') ?? '' }}"
                            class="h-11 w-11 cursor-pointer dark:border-gray-700"
                            data-tooltip-target="tooltip-theme_secondary_color" onchange="syncColor('theme_secondary_color')">
                        <div id="tooltip-theme_secondary_color" role="tooltip"
                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                            {{ __('Choose color') }}
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </div>
                    <input type="text" id="input-theme_secondary_color" name="theme_secondary_color_text"
                        value="{{ config('settings.theme_secondary_color') ?? '#ffffff' }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        placeholder="#ffffff" oninput="syncColor('theme_secondary_color', true)">
                </div>
            </div>
        </div>

        <!-- Default Mode -->
        <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                {{ __('Default Mode') }}
            </label>
            <select name="default_mode"
                class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                <option value="lite" {{ config('settings.default_mode') == 'lite' ? 'selected' : '' }}>{{ __('Lite') }}
                </option>
                <option value="dark"{{ config('settings.default_mode') == 'dark' ? 'selected' : '' }}>{{ __('Dark') }}
                </option>
                <option value="system"{{ config('settings.default_mode') == 'system' ? 'selected' : '' }}>{{ __('System') }}
                </option>
            </select>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Lite Mode Colors -->
            <div>
                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-4">{{ __('Lite Mode Colors') }}</h4>

                <!-- Navbar Background Color (Lite Mode) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                        {{ __('Navbar Background Color') }}
                    </label>
                    <div class="flex gap-2 items-center">
                        <div class="relative">
                            <input type="color" id="color-picker-navbar_bg_lite" name="navbar_bg_lite"
                                value="{{ config('settings.navbar_bg_lite') ?? '' }}"
                                class="h-11 w-11 cursor-pointer dark:border-gray-700"
                                data-tooltip-target="tooltip-navbar_bg_lite" onchange="syncColor('navbar_bg_lite')">
                            <div id="tooltip-navbar_bg_lite" role="tooltip"
                                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                {{ __('Choose color') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                        <input type="text" id="input-navbar_bg_lite" name="navbar_bg_lite_text"
                            value="{{ config('settings.navbar_bg_lite') ?? '#ffffff' }}"
                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                            placeholder="#ffffff" oninput="syncColor('navbar_bg_lite', true)">
                    </div>
                </div>

                <!-- Sidebar Background Color (Lite Mode) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                        {{ __('Sidebar Background Color') }}
                    </label>
                    <div class="flex gap-2 items-center">
                        <div class="relative">
                            <input type="color" id="color-picker-sidebar_bg_lite" name="sidebar_bg_lite"
                                value="{{ config('settings.sidebar_bg_lite') ?? '' }}"
                                class="h-11 w-11 cursor-pointer dark:border-gray-700"
                                data-tooltip-target="tooltip-sidebar_bg_lite" onchange="syncColor('sidebar_bg_lite')">
                            <div id="tooltip-sidebar_bg_lite" role="tooltip"
                                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                {{ __('Choose color') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                        <input type="text" id="input-sidebar_bg_lite" name="sidebar_bg_lite_text"
                            value="{{ config('settings.sidebar_bg_lite') ?? '#ffffff' }}"
                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                            placeholder="#ffffff" oninput="syncColor('sidebar_bg_lite', true)">
                    </div>
                </div>

                <!-- Navbar Text Color (Lite Mode) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                        {{ __('Navbar Text Color') }}
                    </label>
                    <div class="flex gap-2 items-center">
                        <div class="relative">
                            <input type="color" id="color-picker-navbar_text_lite" name="navbar_text_lite"
                                value="{{ config('settings.navbar_text_lite') ?? '' }}"
                                class="h-11 w-11 cursor-pointer dark:border-gray-700"
                                data-tooltip-target="tooltip-navbar_text_lite" onchange="syncColor('navbar_text_lite')">
                            <div id="tooltip-navbar_text_lite" role="tooltip"
                                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                {{ __('Choose color') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                        <input type="text" id="input-navbar_text_lite" name="navbar_text_lite_text"
                            value="{{ config('settings.navbar_text_lite') ?? '#ffffff' }}"
                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                            placeholder="#ffffff" oninput="syncColor('navbar_text_lite', true)">
                    </div>
                </div>

                <!-- Sidebar Text Color (Lite Mode) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                        {{ __('Sidebar Text Color') }}
                    </label>
                    <div class="flex gap-2 items-center">
                        <div class="relative">
                            <input type="color" id="color-picker-sidebar_text_lite" name="sidebar_text_lite"
                                value="{{ config('settings.sidebar_text_lite') ?? '' }}"
                                class="h-11 w-11 cursor-pointer dark:border-gray-700"
                                data-tooltip-target="tooltip-sidebar_text_lite" onchange="syncColor('sidebar_text_lite')">
                            <div id="tooltip-sidebar_text_lite" role="tooltip"
                                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                {{ __('Choose color') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                        <input type="text" id="input-sidebar_text_lite" name="sidebar_text_lite_text"
                            value="{{ config('settings.sidebar_text_lite') ?? '#ffffff' }}"
                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                            placeholder="#ffffff" oninput="syncColor('sidebar_text_lite', true)">
                    </div>
                </div>
            </div>

            <!-- Dark Mode Colors -->
            <div>
                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-4">{{ __('Dark Mode Colors') }}</h4>

                <!-- Navbar Background Color (Dark Mode) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                        {{ __('Navbar Background Color') }}
                    </label>
                    <div class="flex gap-2 items-center">
                        <div class="relative">
                            <input type="color" id="color-picker-navbar_bg_dark" name="navbar_bg_dark"
                                value="{{ config('settings.navbar_bg_dark') ?? '' }}"
                                class="h-11 w-11 cursor-pointer dark:border-gray-700"
                                data-tooltip-target="tooltip-navbar_bg_dark" onchange="syncColor('navbar_bg_dark')">
                            <div id="tooltip-navbar_bg_dark" role="tooltip"
                                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                {{ __('Choose color') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                        <input type="text" id="input-navbar_bg_dark" name="navbar_bg_dark_text"
                            value="{{ config('settings.navbar_bg_dark') ?? '#ffffff' }}"
                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                            placeholder="#ffffff" oninput="syncColor('navbar_bg_dark', true)">
                    </div>
                </div>

                <!-- Sidebar Background Color (Dark Mode) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                        {{ __('Sidebar Background Color') }}
                    </label>
                    <div class="flex gap-2 items-center">
                        <div class="relative">
                            <input type="color" id="color-picker-sidebar_bg_dark" name="sidebar_bg_dark"
                                value="{{ config('settings.sidebar_bg_dark') ?? '' }}"
                                class="h-11 w-11 cursor-pointer dark:border-gray-700"
                                data-tooltip-target="tooltip-sidebar_bg_dark" onchange="syncColor('sidebar_bg_dark')">
                            <div id="tooltip-sidebar_bg_dark" role="tooltip"
                                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                {{ __('Choose color') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                        <input type="text" id="input-sidebar_bg_dark" name="sidebar_bg_dark_text"
                            value="{{ config('settings.sidebar_bg_dark') ?? '#ffffff' }}"
                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                            placeholder="#ffffff" oninput="syncColor('sidebar_bg_dark', true)">
                    </div>
                </div>

                <!-- Navbar Text Color (Dark Mode) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                        {{ __('Navbar Text Color') }}
                    </label>
                    <div class="flex gap-2 items-center">
                        <div class="relative">
                            <input type="color" id="color-picker-navbar_text_dark" name="navbar_text_dark"
                                value="{{ config('settings.navbar_text_dark') ?? '' }}"
                                class="h-11 w-11 cursor-pointer dark:border-gray-700"
                                data-tooltip-target="tooltip-navbar_text_dark" onchange="syncColor('navbar_text_dark')">
                            <div id="tooltip-navbar_text_dark" role="tooltip"
                                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                {{ __('Choose color') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                        <input type="text" id="input-navbar_text_dark" name="navbar_text_dark_text"
                            value="{{ config('settings.navbar_text_dark') ?? '#ffffff' }}"
                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                            placeholder="#ffffff" oninput="syncColor('navbar_text_dark', true)">
                    </div>
                </div>

                <!-- Sidebar Text Color (Dark Mode) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                        {{ __('Sidebar Text Color') }}
                    </label>
                    <div class="flex gap-2 items-center">
                        <div class="relative">
                            <input type="color" id="color-picker-sidebar_text_dark" name="sidebar_text_dark"
                                value="{{ config('settings.sidebar_text_dark') ?? '' }}"
                                class="h-11 w-11 cursor-pointer dark:border-gray-700"
                                data-tooltip-target="tooltip-sidebar_text_dark" onchange="syncColor('sidebar_text_dark')">
                            <div id="tooltip-sidebar_text_dark" role="tooltip"
                                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                {{ __('Choose color') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                        <input type="text" id="input-sidebar_text_dark" name="sidebar_text_dark_text"
                            value="{{ config('settings.sidebar_text_dark') ?? '#ffffff' }}"
                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                            placeholder="#ffffff" oninput="syncColor('sidebar_text_dark', true)">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function syncColor(field, fromInput = false) {
        const colorPicker = document.getElementById(`color-picker-${field}`);
        const textInput = document.getElementById(`input-${field}`);
        if (fromInput) {
            colorPicker.value = textInput.value;
        } else {
            textInput.value = colorPicker.value;
        }
    }
</script>
