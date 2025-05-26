@extends('backend.layouts.app')

@section('title')
    {{ __('Edit') }} {{ $postTypeModel->label_singular }} | {{ config('settings.app_name') !== '' ? config('settings.app_name') : config('app.name') }}
@endsection

@section('admin-content')
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ __('Edit') }} {{ $postTypeModel->label_singular }}</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li>
                    <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.dashboard') }}">
                        {{ __('Home') }}
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li>
                    <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.posts.index', $postType) }}">
                        {{ $postTypeModel->label }}
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li class="text-sm text-gray-800 dark:text-white/90">{{ __('Edit') }} {{ $postTypeModel->label_singular }}</li>
            </ol>
        </nav>
    </div>

    @include('backend.layouts.partials.messages')

    <!-- Edit Post Form -->
    {!! ld_apply_filters('before_post_form', '') !!}
    <form action="{{ route('admin.posts.update', [$postType, $post->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('backend.pages.posts.partials.form')
    </form>
    {!! ld_apply_filters('after_post_form', '') !!}
</div>
@endsection

@push('scripts')
<x-quill-editor :editor-id="'content'" />
@endpush
