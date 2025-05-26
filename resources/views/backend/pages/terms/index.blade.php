@extends('backend.layouts.app')

@section('title')
    {{ $taxonomyModel->label }} | {{ config('app.name') }}
@endsection

@section('admin-content')
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ $taxonomyModel->label }}</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li>
                    <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.dashboard') }}">
                        {{ __('Home') }}
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li class="text-sm text-gray-800 dark:text-white/90">{{ $taxonomyModel->label }}</li>
            </ol>
        </nav>
    </div>

    <!-- Two Column Layout: Form and List -->
    @include('backend.layouts.partials.messages')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Column -->
        <div class="lg:col-span-1 space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                        {{ $term ? __('Edit') : __('Add New') }} {{ $taxonomyModel->label_singular }}
                    </h3>
                </div>
                <div class="p-5 space-y-5 sm:p-6">
                    <form action="{{ route('admin.terms.store', $taxonomy) }}" method="POST" enctype="multipart/form-data">
                        @include('backend.pages.terms.partials.form')
                    </form>
                </div>
            </div>
        </div>

        <!-- Terms List Column -->
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5 flex justify-between items-center border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ $taxonomyModel->label }}</h3>
                    @include('backend.partials.search-form', [
                        'placeholder' => __('Search') . ' ' . strtolower($taxonomyModel->label),
                    ])
                </div>
                <div class="space-y-3 border-t border-gray-100 dark:border-gray-800 overflow-x-auto">
                    <table id="dataTable" class="w-full dark:text-gray-400">
                        <thead class="bg-light text-capitalize">
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <th width="25%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Name') }}</th>
                                <th width="20%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Slug') }}</th>
                                @if($taxonomyModel->show_featured_image)
                                <th width="15%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Image') }}</th>
                                @endif
                                <th width="10%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Count') }}</th>
                                <th width="10%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-center px-5">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($terms as $termItem)
                                <tr class="{{ $loop->index + 1 != count($terms) ?  'border-b border-gray-100 dark:border-gray-800' : '' }}">
                                    <td class="px-5 py-4 sm:px-6">
                                        @if (auth()->user()->can('term.edit'))
                                            <a href="{{ route('admin.terms.edit', ['taxonomy' => $taxonomy, 'term' => $termItem->id]) }}" class="hover:text-primary transition-colors">
                                                {{ $termItem->name }}
                                            </a>
                                        @else
                                            {{ $termItem->name }}
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <code class="text-sm px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded">{{ $termItem->slug }}</code>
                                    </td>
                                    @if($taxonomyModel->show_featured_image)
                                    <td class="px-5 py-4 sm:px-6">
                                        @if($termItem->featured_image)
                                            <img src="{{ Storage::url($termItem->featured_image) }}" alt="{{ $termItem->name }}" class="h-10 w-auto rounded">
                                        @else
                                            <span class="text-gray-400">{{ __('None') }}</span>
                                        @endif
                                    </td>
                                    @endif
                                    <td class="px-5 py-4 sm:px-6">
                                        {{ $termItem->posts->count() }}
                                    </td>
                                    <td class="px-5 py-4 sm:px-6 text-center flex items-center justify-center gap-1">
                                        @if (auth()->user()->can('term.edit'))
                                            <a data-tooltip-target="tooltip-edit-{{ $termItem->id }}" class="btn-default !p-3" href="{{ route('admin.terms.edit', ['taxonomy' => $taxonomy, 'term' => $termItem->id]) }}">
                                                <i class="bi bi-pencil text-sm"></i>
                                            </a>
                                            <div id="tooltip-edit-{{ $termItem->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                                {{ __('Edit') }}
                                                <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>
                                        @endif

                                        @if (auth()->user()->can('term.delete'))
                                            <div x-data="{ deleteModalOpen: false }">
                                                <a x-on:click="deleteModalOpen = true" data-tooltip-target="tooltip-delete-{{ $termItem->id }}" class="btn-danger !p-3" href="javascript:void(0);">
                                                    <i class="bi bi-trash text-sm"></i>
                                                </a>
                                                <div id="tooltip-delete-{{ $termItem->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                                    {{ __('Delete') }}
                                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                                </div>

                                                <x-modals.confirm-delete
                                                    id="delete-modal-{{ $termItem->id }}"
                                                    title="{{ __('Delete') }} {{ strtolower($taxonomyModel->label_singular) }}"
                                                    content="{{ __('Are you sure you want to delete this') }} {{ strtolower($taxonomyModel->label_singular) }}?"
                                                    formId="delete-form-{{ $termItem->id }}"
                                                    formAction="{{ route('admin.terms.destroy', [$taxonomy, $termItem->id]) }}"
                                                    modalTrigger="deleteModalOpen"
                                                    cancelButtonText="{{ __('No, cancel') }}"
                                                    confirmButtonText="{{ __('Yes, Confirm') }}"
                                                />
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <td colspan="5" class="px-5 py-4 sm:px-6 text-center">
                                        <span class="text-gray-500 dark:text-gray-400">{{ __('No') }} {{ strtolower($taxonomyModel->label) }} {{ __('found') }}</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="my-4 px-4 sm:px-6">
                        {{ $terms->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
@endpush
@endsection
