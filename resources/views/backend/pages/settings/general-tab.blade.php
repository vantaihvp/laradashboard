<form method="POST" action="{{ route('admin.settings.store') }}" enctype="multipart/form-data">
    @csrf
    @include('backend.layouts.partials.messages')
    <div class="rounded-2xl border border-gray-200  dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-5 py-4 sm:px-6 sm:py-5">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                General Settings
            </h3>
        </div>
        <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">

            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Site Name
                </label>
                <input type="text" name="app_name" placeholder="Enter site name"
                    value="{{ config('settings.app_name') ?? '' }}"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
            </div>

            <div class=" flex gap-2">
                <div class=" w-1/2">
                    @if (config('settings.site_logo_lite') !== '')
                        <img src="{{ config('settings.site_logo_lite') ?? '' }}" class=" h-50" alt="">
                    @endif
                    <div class=" w-full">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Site Logo Full (Lite Version)
                        </label>
                        <input type="file" name="site_logo_lite"
                            class="focus:border-ring-brand-300 cursor-pointer focus:file:ring-brand-300 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:pr-3 file:pl-3.5 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400">
                    </div>
                </div>

                <div class=" w-1/2">
                    @if (config('settings.site_logo_dark') !== '')
                        <img src="{{ config('settings.site_logo_dark') ?? '' }}" class=" h-50" alt="">
                    @endif
                    <div class=" w-full">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Site Logo Full (Dark Version)
                        </label>
                        <input type="file" name="site_logo_dark"
                            class="focus:border-ring-brand-300 cursor-pointer focus:file:ring-brand-300 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:pr-3 file:pl-3.5 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400">
                    </div>
                </div>


                <div class=" w-1/2">
                    @if (config('settings.site_icon') !== '')
                        <img src="{{ config('settings.site_icon') ?? '' }}" class=" h-50" alt="">
                    @endif
                    <div class=" w-full">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Site Icon
                        </label>
                        <input type="file" name="site_icon"
                            class="focus:border-ring-brand-300 cursor-pointer focus:file:ring-brand-300 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:pr-3 file:pl-3.5 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400">
                    </div>
                </div>


                <div class=" w-1/2">
                    @if (config('settings.site_favicon') !== '')
                        <img src="{{ config('settings.site_favicon') ?? '' }}" class=" h-50" alt="">
                    @endif
                    <div class=" w-full">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Site Favicon
                        </label>
                        <input type="file" name="site_favicon"
                            class="focus:border-ring-brand-300 cursor-pointer focus:file:ring-brand-300 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:pr-3 file:pl-3.5 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400">
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] mt-4">
        <div class="px-5 py-4 sm:px-6 sm:py-5">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                Site Styling Settings
            </h3>
        </div>
        <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">

            <!-- Theme Primary Color -->
            <div class="flex gap-4">
                <div class="w-1/2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Theme Primary Color
                    </label>
                    <input type="color" name="theme_primary_color"
                        value="{{ config('settings.theme_primary_color') ?? '' }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                </div>

                <!-- Theme Secondary Color -->
                <div class="w-1/2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Theme Secondary Color
                    </label>
                    <input type="color" name="theme_secondary_color"
                        value="{{ config('settings.theme_secondary_color') ?? '' }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                </div>
            </div>

            <!-- Default Mode -->
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Default Mode
                </label>
                <select name="default_mode"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                    <option value="lite" {{ config('settings.default_mode') == 'lite' ? 'selected' : '' }}>Lite
                    </option>
                    <option value="dark"{{ config('settings.default_mode') == 'dark' ? 'selected' : '' }}>Dark
                    </option>
                    <option value="system"{{ config('settings.default_mode') == 'system' ? 'selected' : '' }}>System
                    </option>
                </select>
            </div>

            <!-- Header Navbar Background Color (Lite Mode) -->
            <div class="flex gap-4">
                <div class="w-1/2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Header Navbar Background Color (Lite Mode)
                    </label>
                    <input type="color" name="navbar_bg_lite" value="{{ config('settings.navbar_bg_lite') ?? '' }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                </div>

                <!-- Header Navbar Background Color (Dark Mode) -->
                <div class="w-1/2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Header Navbar Background Color (Dark Mode)
                    </label>
                    <input type="color" name="navbar_bg_dark" value="{{ config('settings.navbar_bg_dark') ?? '' }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                </div>
            </div>

            <!-- Header Navbar Text Color (Lite Mode) -->
            <div class="flex gap-4">
                <div class="w-1/2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Header Navbar Text Color (Lite Mode)
                    </label>
                    <input type="color" name="navbar_text_lite"
                        value="{{ config('settings.navbar_text_lite') ?? '' }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                </div>

                <!-- Header Navbar Text Color (Dark Mode) -->
                <div class="w-1/2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Header Navbar Text Color (Dark Mode)
                    </label>
                    <input type="color" name="navbar_text_dark"
                        value="{{ config('settings.navbar_text_dark') ?? '' }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                </div>
            </div>

            <!-- Header Sidebar Background Color (Lite Mode) -->
            <div class="flex gap-4">
                <div class="w-1/2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Header Sidebar Background Color (Lite Mode)
                    </label>
                    <input type="color" name="sidebar_bg_lite"
                        value="{{ config('settings.sidebar_bg_lite') ?? '' }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                </div>

                <!-- Header Sidebar Background Color (Dark Mode) -->
                <div class="w-1/2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Header Sidebar Background Color (Dark Mode)
                    </label>
                    <input type="color" name="sidebar_bg_dark"
                        value="{{ config('settings.sidebar_bg_dark') ?? '' }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                </div>
            </div>

            <!-- Header Sidebar Text Color (Lite Mode) -->
            <div class="flex gap-4">
                <div class="w-1/2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Header Sidebar Text Color (Lite Mode)
                    </label>
                    <input type="color" name="sidebar_text_lite"
                        value="{{ config('settings.sidebar_text_lite') ?? '' }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                </div>

                <!-- Header Sidebar Text Color (Dark Mode) -->
                <div class="w-1/2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Header Sidebar Text Color (Dark Mode)
                    </label>
                    <input type="color" name="sidebar_text_dark"
                        value="{{ config('settings.sidebar_text_dark') ?? '' }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                    class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Submit &nbsp;
                    <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
</form>
