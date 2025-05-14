@php
    use App\Services\SidebarMenuService;
    $menuService = app(SidebarMenuService::class);
    $menus = $menuService->getMenu();
    $mainMenus = $menus['main'] ?? [];
    $moreMenus = $menus['more'] ?? [];
@endphp

<nav
    x-data="{
        isDark: document.documentElement.classList.contains('dark'),
        textColor: '',
        submenus: {},
        toggleSubmenu(id) {
            this.submenus[id] = !this.submenus[id];
        },
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
    class="transition-all duration-300 ease-in-out"
>
    <div>
        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400 px-5">
            {{ __('Menu') }}
        </h3>
        <ul class="flex flex-col mb-6">
            {!! ld_apply_filters('sidebar_menu_before_all', '') !!}
            {!! $menuService->render($mainMenus, 'textColor') !!}
            {!! ld_apply_filters('sidebar_menu_after_all', '') !!}
        </ul>
    </div>

    <div>
        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400 px-5">
            {{ __('More') }}
        </h3>
        <ul class="flex flex-col mb-6">
            {!! ld_apply_filters('sidebar_more_before_all', '') !!}
            {!! $menuService->render($moreMenus, 'textColor') !!}
            {!! ld_apply_filters('sidebar_more_after_all', '') !!}
        </ul>
    </div>
</nav>
