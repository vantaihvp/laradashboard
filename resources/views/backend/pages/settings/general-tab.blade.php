@php echo ld_apply_filters('settings_general_tab_before_section_start', '') @endphp
<div class="rounded-2xl border border-gray-200 dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="px-5 py-4 sm:px-6 sm:py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            {{ __('General Settings') }}
        </h3>
    </div>
    <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
        <div class="flex">
            <div class="md:basis-1/2 relative">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    {{ __('Site Name') }}
                </label>
                <input type="text" name="app_name" placeholder="{{ __('Enter site name') }}"
                    value="{{ config('settings.app_name') ?? '' }}" @if (config('app.demo_mode', false)) disabled @endif
                    class="form-control" data-tooltip-target="tooltip-app-name">
                <div id="tooltip-app-name" role="tooltip"
                    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                    {{ __('Editing site name is disabled in demo mode.') }}
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Column 1: Site Logo Full Lite and Dark -->
            <div>
                <div class="mt-2">
                    @if (config('settings.site_logo_lite') !== '' && !empty(config('settings.site_logo_lite')))
                        <img src="{{ config('settings.site_logo_lite') ?? '' }}" alt=""
                            class="bg-gray-200 p-2 dark:bg-gray-800 max-h-[80px]">
                    @endif
                    <div class="w-full mt-2">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            {{ __('Site Logo Full (Lite Version)') }}
                        </label>
                        <input type="file" name="site_logo_lite" class="form-control">
                    </div>
                </div>

                <div class="mt-2">
                    @if (config('settings.site_logo_dark') !== '' && !empty(config('settings.site_logo_dark')))
                        <img src="{{ config('settings.site_logo_dark') ?? '' }}" alt=""
                            class="bg-gray-200 p-2 dark:bg-gray-800 max-h-[80px]">
                    @endif
                    <div class="w-full mt-4">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            {{ __('Site Logo Full (Dark Version)') }}
                        </label>
                        <input type="file" name="site_logo_dark" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Column 2: Site Icon and Favicon -->
            <div>
                <div class="mt-2">
                    @if (config('settings.site_icon') !== '' && !empty(config('settings.site_icon')))
                        <img src="{{ config('settings.site_icon') ?? '' }}" alt=""
                            class="bg-gray-200 p-2 dark:bg-gray-800 max-h-[80px]">
                    @endif
                    <div class="w-full">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            {{ __('Site Icon') }}
                        </label>
                        <input type="file" name="site_icon" class="form-control">
                    </div>
                </div>

                <div class="mt-2">
                    @if (config('settings.site_favicon') !== '' && !empty(config('settings.site_favicon')))
                        <img src="{{ config('settings.site_favicon') ?? '' }}" alt=""
                            class="bg-gray-200 p-2 dark:bg-gray-800 max-h-[80px]">
                    @endif
                    <div class="w-full mt-4">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            {{ __('Site Favicon') }}
                        </label>
                        <input type="file" name="site_favicon" class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php echo ld_apply_filters('settings_general_tab_before_section_end', '') @endphp
</div>
@php echo ld_apply_filters('settings_general_tab_after_section_end', '') @endphp
