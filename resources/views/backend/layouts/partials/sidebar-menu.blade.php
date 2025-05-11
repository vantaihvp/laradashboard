@php $user = Auth::user(); @endphp
<nav
    x-data="{
        isDark: document.documentElement.classList.contains('dark'),
        textColor: '',
        init() {
            this.updateColor();
            const observer = new MutationObserver(() => this.updateColor());
            observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
        },
        updateColor() {
            this.isDark = document.documentElement.classList.contains('dark');
            this.textColor = this.isDark 
                ? '{{ config('settings.sidebar_text_dark') }}' 
                : '{{ config('settings.sidebar_text_lite') }}';
        }
    }"
    x-init="init()"
>
    <div>
        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
            {{ __('Menu') }}
        </h3>

        <ul class="flex flex-col gap-4 mb-6">
            @if ($user->can('dashboard.view'))
                <li>
                    <a :style="`color: ${textColor}`" href="{{ route('admin.dashboard') }}"
                        class="menu-item group {{ Route::is('admin.dashboard') ? 'menu-item-active' : 'menu-item-inactive' }}">
                        <i class="bi bi-grid text-xl text-center"></i>
                        <span>{{ __('Dashboard') }}</span>
                    </a>
                </li>
            @endif
            @php echo ld_apply_filters('sidebar_menu_after_dashboard', '') @endphp

            @if ($user->can('role.create') || $user->can('role.view') || $user->can('role.edit') || $user->can('role.delete'))
                <li>
                    <button :style="`color: ${textColor}`"
                        class="menu-item group w-full text-left {{ Route::is('admin.roles.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                        type="button" onclick="toggleSubmenu('roles-submenu')">
                        <img src="{{ asset('images/icons/key.svg') }}" alt="Roles Icon" class="dark:invert">
                        <span :style="`color: ${textColor}`"> {{ __('Roles & Permissions') }}</span>
                        <i class="bi bi-chevron-down ml-auto"></i>
                    </button>
                    <ul id="roles-submenu"
                        class="submenu {{ Route::is('admin.roles.*') ? '' : 'hidden' }} pl-12 mt-2 space-y-2">
                        @if ($user->can('role.view'))
                            <li>
                                <a :style="`color: ${textColor}`" href="{{ route('admin.roles.index') }}"
                                    class="block px-4 py-2 rounded-lg {{ Route::is('admin.roles.index') || Route::is('admin.roles.edit') ? 'menu-item-active' : 'menu-item-inactive' }}">
                                    {{ __('Roles') }}
                                </a>
                            </li>
                        @endif
                        @if ($user->can('role.create'))
                            <li>
                                <a :style="`color: ${textColor}`" href="{{ route('admin.roles.create') }}"
                                    class="block px-4 py-2 rounded-lg {{ Route::is('admin.roles.create') ? 'menu-item-active' : 'menu-item-inactive' }}">
                                    {{ __('New Role') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @php echo ld_apply_filters('sidebar_menu_after_roles', '') @endphp

            @if ($user->can('user.create') || $user->can('user.view') || $user->can('user.edit') || $user->can('user.delete'))
                <li>
                    <button :style="`color: ${textColor}`"
                        class="menu-item group w-full text-left {{ Route::is('admin.users.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                        type="button" onclick="toggleSubmenu('users-submenu')">
                        <img src="{{ asset('images/icons/user.svg') }}" alt="Roles Icon" class="dark:invert">
                        <span>{{ __('User') }}</span>
                        <i class="bi bi-chevron-down ml-auto"></i>
                    </button>
                    <ul id="users-submenu"
                        class="submenu {{ Route::is('admin.users.*') ? '' : 'hidden' }} pl-12 mt-2 space-y-2">
                        @if ($user->can('user.view'))
                            <li>
                                <a :style="`color: ${textColor}`" href="{{ route('admin.users.index') }}"
                                    class="block px-4 py-2 rounded-lg {{ Route::is('admin.users.index') || Route::is('admin.users.edit') ? 'menu-item-active' : 'menu-item-inactive' }}">
                                    {{ __('Users') }}
                                </a>
                            </li>
                        @endif
                        @if ($user->can('user.create'))
                            <li>
                                <a :style="`color: ${textColor}`" href="{{ route('admin.users.create') }}"
                                    class="block px-4 py-2 rounded-lg {{ Route::is('admin.users.create') ? 'menu-item-active' : 'menu-item-inactive' }}">
                                    {{ __('New User') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @php echo ld_apply_filters('sidebar_menu_after_users', '') @endphp

            @if ($user->can('module.view'))
                <li>
                    <a :style="`color: ${textColor}`" href="{{ route('admin.modules.index') }}"
                        class="menu-item group {{ Route::is('admin.modules.index') ? 'menu-item-active' : 'menu-item-inactive' }}">
                        <img src="{{ asset('images/icons/three-dice.svg') }}" alt="Roles Icon" class="dark:invert">
                        <span>{{ __('Modules') }}</span>
                    </a>
                </li>
            @endif
            @php echo ld_apply_filters('sidebar_menu_after_modules', '') @endphp

            @if ($user->can('pulse.view') || $user->can('actionlog.view'))
                <li>
                    <button :style="`color: ${textColor}`"
                        class="menu-item group w-full text-left {{ Route::is('actionlog.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                        type="button" onclick="toggleSubmenu('monitoring-submenu')">
                        <img src="{{ asset('images/icons/tv.svg') }}" alt="Roles Icon" class="dark:invert">
                        <span>{{ __('Monitoring') }}</span>
                        <i class="bi bi-chevron-down ml-auto"></i>
                    </button>
                    <ul id="monitoring-submenu"
                        class="submenu {{ Route::is('actionlog.*') ? '' : 'hidden' }} pl-12 mt-2 space-y-2">
                        @if ($user->can('actionlog.view'))
                            <li>
                                <a href="{{ route('actionlog.index') }}"
                                    class="block px-4 py-2 rounded-lg {{ Route::is('actionlog.index') ? 'menu-item-active' : 'menu-item-inactive text-white' }}">
                                    <span :style="`color: ${textColor}`">{{ __('Action Logs') }}</span>
                                </a>
                            </li>
                        @endif

                        @if ($user->can('pulse.view'))
                            <li>
                                <a href="{{ route('pulse') }}" class="block px-4 py-2 rounded-lg menu-item-inactive"
                                    target="_blank">
                                    <span :style="`color: ${textColor}`">{{ __('Laravel Pulse') }}</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @php echo ld_apply_filters('sidebar_menu_after_monitoring', '') @endphp
        </ul>
    </div>

    <!-- Others Group -->
    <div>
        <h3 :style="`color: ${textColor}`" class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
            {{ __('More') }}
        </h3>

        <ul class="flex flex-col gap-4 mb-6">
            @if ($user->can('settings.edit') || $user->can('translations.view'))
                <li>
                    <button :style="`color: ${textColor}`"
                        class="menu-item group w-full text-left {{ Route::is('admin.settings.*') || Route::is('admin.translations.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                        type="button" onclick="toggleSubmenu('settings-submenu')">
                        <img src="{{ asset('images/icons/settings.svg') }}" alt="Roles Icon" class="dark:invert">
                        <span>{{ __('Settings') }}</span>
                        <i class="bi bi-chevron-down ml-auto"></i>
                    </button>
                    <ul id="settings-submenu"
                        class="submenu {{ Route::is('admin.settings.*') || Route::is('admin.translations.*') ? '' : 'hidden' }} pl-12 mt-2 space-y-2">
                        @if ($user->can('settings.edit'))
                            <li>
                                <a :style="`color: ${textColor}`" href="{{ route('admin.settings.index') }}"
                                    class="block px-4 py-2 rounded-lg {{ Route::is('admin.settings.index') ? 'menu-item-active' : 'menu-item-inactive' }}">
                                    {{ __('General Settings') }}
                                </a>
                            </li>
                        @endif
                        @canany(['translations.view', 'translations.edit'])
                            <li>
                                <a :style="`color: ${textColor}`" href="{{ route('admin.translations.index') }}"
                                    class="block px-4 py-2 rounded-lg {{ Route::is('admin.translations.*') ? 'menu-item-active' : 'menu-item-inactive' }}">
                                    {{ __('Translations') }}
                                </a>
                            </li>
                        @endcanany
                    </ul>
                </li>
            @endif

            <!-- Logout Menu Item -->
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button :style="`color: ${textColor}`" type="submit"
                        class="menu-item group w-full text-left menu-item-inactive">
                        <img src="{{ asset('images/icons/logout.svg') }}" alt="Roles Icon" class="dark:invert">
                        <span>
                            {{ __('Logout') }}
                        </span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>

<script>
    function toggleSubmenu(submenuId) {
        const submenu = document.getElementById(submenuId);
        submenu.classList.toggle('hidden');
    }
</script>
