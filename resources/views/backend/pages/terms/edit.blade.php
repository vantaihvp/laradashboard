@extends('backend.layouts.app')

@section('title')
    {{ __('Edit') }} {{ $taxonomyModel->label_singular }} | {{ config('app.name') }}
@endsection

@section('admin-content')
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ __('Edit') }} {{ $taxonomyModel->label_singular }}</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li>
                    <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.dashboard') }}">
                        {{ __('Home') }}
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li>
                    <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.terms.index', $taxonomy) }}">
                        {{ $taxonomyModel->label }}
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li class="text-sm text-gray-800 dark:text-white/90">{{ __('Edit') }} {{ $taxonomyModel->label_singular }}</li>
            </ol>
        </nav>
    </div>

    <div class="max-w-4xl mx-auto">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                    {{ __('Edit') }} {{ $taxonomyModel->label_singular }}
                </h3>
            </div>
            <div class="p-5 space-y-5 sm:p-6">
                @include('backend.layouts.partials.messages')
                
                <form action="{{ route('admin.terms.update', [$taxonomy, $term->id]) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @include('backend.pages.terms.partials.form')
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<x-quill-editor :editor-id="'description'" />
@endpush
@endsection
