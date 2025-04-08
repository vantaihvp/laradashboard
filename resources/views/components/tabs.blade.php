<div class="mb-4 border-b border-gray-200 dark:border-gray-700">
    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" 
        data-tabs-toggle="#default-styled-tab-content" 
        data-tabs-active-classes="text-purple-600 hover:text-purple-600 dark:text-purple-500 dark:hover:text-purple-500 border-purple-600 dark:border-purple-500" 
        data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300" 
        role="tablist">
        @foreach ($tabs as $key => $tab)
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" 
                        id="{{ $key }}-tab" 
                        data-tabs-target="#{{ $key }}" 
                        type="button" 
                        role="tab" 
                        aria-controls="{{ $key }}" 
                        aria-selected="false">
                    {{ $tab['title'] }}
                </button>
            </li>
        @endforeach
    </ul>
</div>
<div id="default-styled-tab-content">
    @foreach ($tabs as $key => $tab)
        <div class="hidden p-4 rounded-lg dark:bg-gray-800" id="{{ $key }}" role="tabpanel" aria-labelledby="{{ $key }}-tab">
            @if (isset($tab['view']))
                @include($tab['view'], $tab['data'] ?? [])
            @else
                {!! $tab['content'] !!}
            @endif
        </div>
    @endforeach
</div>
