@extends('backend.layouts.app')

@section('title')
    {{ __('Navigation') }} | {{ config('app.name') }}
@endsection

@section('admin-content')

<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div x-data="{ pageName: {{ __('Navigation') }} }">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                {{ __('Navigation') }}
            </h2>
            <nav>
                <ol class="flex items-center gap-1.5">
                    <li>
                        <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.dashboard') }}">
                            {{ __('Home') }}
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                    <li class="text-sm text-gray-800 dark:text-white/90">{{ __('Navigation') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Navigation Table -->
    <div class="space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
          <div class="px-5 py-4 sm:px-6 sm:py-5 flex justify-between items-center">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ __('Navigation Items') }}</h3>
                {{-- Optionally add a search or create button for navigation items --}}
            </div>
            <div class="space-y-3 border-t border-gray-100 dark:border-gray-800 overflow-x-auto">
                @include('backend.layouts.partials.messages')
                <table id="dataTable" class="w-full dark:text-gray-400">
                    <thead class="bg-light text-capitalize">
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th width="5%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Sl') }}</th>
                            <th width="25%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Title') }}</th>
                            <th width="25%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('URL') }}</th>
                            <th width="15%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Order') }}</th>
                            <th width="15%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Status') }}</th>
                            <th width="15%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($backendItems as $item)
                            <tr class="{{ $loop->index + 1 != count($backendItems) ?  'border-b border-gray-100 dark:border-gray-800' : '' }}">
                                <td class="px-5 py-4 sm:px-6">{{ $loop->iteration }}</td>
                                <td class="px-5 py-4 sm:px-6">
                                    {{ $item->menu_label ?? '' }}
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <a href="{{ $item->link ?? '#' }}" class="text-blue-600 hover:underline">
                                        {{ $item->link ?? '' }}
                                    </a>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    {{ $item->menu_order ?? '' }}
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    @if ($item->status)
                                        <span class="inline-block px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">{{ __('Active') }}</span>
                                    @else
                                        <span class="inline-block px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded">{{ __('Inactive') }}</span>
                                    @endif
                                </td>
                                <td class="flex px-5 py-4 sm:px-6 text-center gap-1">
                                    <a href="{{ route('admin.menus.edit', $item->id) }}" class="btn-default !p-3" title="{{ __('Edit') }}">
                                        <i class="bi bi-pencil text-sm"></i>
                                    </a>
                                    <form action="{{ route('admin.menus.destroy', $item->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this item?') }}');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger !p-3" title="{{ __('Delete') }}">
                                            <i class="bi bi-trash text-sm"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.menus.manage', $item->id) }}" class="btn-warning !p-3" title="{{ __('Manage') }}">
                                        <i class="bi bi-list-task text-sm"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <p class="text-gray-500 dark:text-gray-400">{{ __('No navigation items found.') }}</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- No pagination for now, add if needed --}}
            </div>
        </div>
    </div>
</div>
@endsection
