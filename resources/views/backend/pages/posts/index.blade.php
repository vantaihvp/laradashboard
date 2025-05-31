@extends('backend.layouts.app')

@section('title')
    {{ $postTypeModel->label }} | {{ config('app.name') }}
@endsection

@section('admin-content')
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ $postTypeModel->label }}</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li>
                    <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.dashboard') }}">
                        {{ __('Home') }}
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li class="text-sm text-gray-800 dark:text-white/90">{{ $postTypeModel->label }}</li>
            </ol>
        </nav>
    </div>

    <!-- Posts Table -->
    <div class="space-y-6">
        <x-messages />
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 sm:px-6 sm:py-5 flex justify-between items-center">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ $postTypeModel->label }}</h3>

                <div class="flex items-center gap-2">
                    @include('backend.partials.search-form', [
                        'placeholder' => __('Search by title'),
                    ])

                    <!-- Filters dropdown -->
                    <div class="flex items-center justify-center">
                        <button id="statusDropdownButton" data-dropdown-toggle="statusDropdown" class="btn-default flex items-center justify-center gap-2" type="button">
                            <i class="bi bi-sliders"></i>
                            {{ __('Filters') }}
                            <i class="bi bi-chevron-down"></i>
                        </button>

                        <!-- Status dropdown menu -->
                        <div id="statusDropdown" class="z-10 hidden w-56 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                            <h6 class="mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Status') }}</h6>
                            <ul class="space-y-2">
                                <li class="cursor-pointer text-sm text-gray-700 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600 px-2 py-1 rounded {{ !request('status') ? 'bg-gray-200 dark:bg-gray-600' : '' }}"
                                    onclick="window.location.href='{{ route('admin.posts.index', ['postType' => $postType, 'search' => request('search'), 'category' => request('category')]) }}'">
                                    {{ __('All Status') }}
                                </li>
                                @foreach (['draft', 'publish', 'pending', 'future', 'private'] as $status)
                                    <li class="cursor-pointer text-sm text-gray-700 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600 px-2 py-1 rounded {{ $status === request('status') ? 'bg-gray-200 dark:bg-gray-600' : '' }}"
                                        onclick="window.location.href='{{ route('admin.posts.index', ['postType' => $postType, 'status' => $status, 'search' => request('search'), 'category' => request('category')]) }}'">
                                        {{ ucfirst($status) }}
                                    </li>
                                @endforeach
                            </ul>
                            
                            @if($postType === 'post' && count($categories) > 0)
                                <h6 class="mb-2 mt-4 text-sm font-medium text-gray-900 dark:text-white">{{ __('Categories') }}</h6>
                                <ul class="space-y-2">
                                    <li class="cursor-pointer text-sm text-gray-700 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600 px-2 py-1 rounded {{ !request('category') ? 'bg-gray-200 dark:bg-gray-600' : '' }}"
                                        onclick="window.location.href='{{ route('admin.posts.index', ['postType' => $postType, 'status' => request('status'), 'search' => request('search')]) }}'">
                                        {{ __('All Categories') }}
                                    </li>
                                    @foreach ($categories as $category)
                                        <li class="cursor-pointer text-sm text-gray-700 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600 px-2 py-1 rounded {{ $category->id == request('category') ? 'bg-gray-200 dark:bg-gray-600' : '' }}"
                                            onclick="window.location.href='{{ route('admin.posts.index', ['postType' => $postType, 'status' => request('status'), 'search' => request('search'), 'category' => $category->id]) }}'">
                                            {{ $category->name }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    @if (auth()->user()->can('post.create'))
                        <a href="{{ route('admin.posts.create', $postType) }}" class="btn-primary">
                            <i class="bi bi-plus-circle mr-2"></i>
                            {{ __('New') }} {{ $postTypeModel->label_singular }}
                        </a>
                    @endif
                </div>
            </div>
            <div class="space-y-3 border-t border-gray-100 dark:border-gray-800 overflow-x-auto">
                <table id="dataTable" class="w-full dark:text-gray-400">
                    <thead class="bg-light text-capitalize">
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th width="5%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('ID') }}</th>
                            <th width="30%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">
                                <div class="flex items-center">
                                    {{ __('Title') }}
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => request()->sort === 'title' ? '-title' : 'title']) }}" class="ml-1">
                                        @if(request()->sort === 'title')
                                            <i class="bi bi-sort-alpha-down text-primary"></i>
                                        @elseif(request()->sort === '-title')
                                            <i class="bi bi-sort-alpha-up text-primary"></i>
                                        @else
                                            <i class="bi bi-arrow-down-up text-gray-400"></i>
                                        @endif
                                    </a>
                                </div>
                            </th>
                            <th width="15%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Author') }}</th>
                            @if($postType === 'post')
                                <th width="15%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Categories') }}</th>
                            @endif
                            <th width="10%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">
                                <div class="flex items-center">
                                    {{ __('Status') }}
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => request()->sort === 'status' ? '-status' : 'status']) }}" class="ml-1">
                                        @if(request()->sort === 'status')
                                            <i class="bi bi-sort-alpha-down text-primary"></i>
                                        @elseif(request()->sort === '-status')
                                            <i class="bi bi-sort-alpha-up text-primary"></i>
                                        @else
                                            <i class="bi bi-arrow-down-up text-gray-400"></i>
                                        @endif
                                    </a>
                                </div>
                            </th>
                            <th width="10%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">
                                <div class="flex items-center">
                                    {{ __('Date') }}
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => request()->sort === 'created_at' ? '-created_at' : 'created_at']) }}" class="ml-1">
                                        @if(request()->sort === 'created_at')
                                            <i class="bi bi-sort-numeric-down text-primary"></i>
                                        @elseif(request()->sort === '-created_at')
                                            <i class="bi bi-sort-numeric-up text-primary"></i>
                                        @else
                                            <i class="bi bi-arrow-down-up text-gray-400"></i>
                                        @endif
                                    </a>
                                </div>
                            </th>
                            <th width="15%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-center px-5">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $post)
                            <tr class="{{ $loop->index + 1 != count($posts) ?  'border-b border-gray-100 dark:border-gray-800' : '' }}">
                                <td class="px-5 py-4 sm:px-6">{{ $post->id }}</td>
                                <td class="px-5 py-4 sm:px-6">
                                    @if (auth()->user()->can('post.edit'))
                                        <a href="{{ route('admin.posts.edit', [$postType, $post->id]) }}" class="text-gray-800 dark:text-white font-medium hover:text-primary dark:hover:text-primary">
                                            {{ $post->title }}
                                        </a>
                                    @else
                                        {{ $post->title }}
                                    @endif
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    {{ $post->user->name }}
                                </td>
                                @if($postType === 'post')
                                    <td class="px-5 py-4 sm:px-6">
                                        @foreach($post->categories as $category)
                                            <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full mr-1 mb-1 dark:bg-gray-700 dark:text-white">
                                                {{ $category->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                @endif
                                <td class="px-5 py-4 sm:px-6">
                                    <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium 
                                        {{ $post->status === 'publish' ? 'text-green-800 bg-green-100 dark:bg-green-900/20 dark:text-green-400' : '' }}
                                        {{ $post->status === 'draft' ? 'text-gray-800 bg-gray-100 dark:bg-gray-700 dark:text-gray-300' : '' }}
                                        {{ $post->status === 'pending' ? 'text-orange-800 bg-orange-100 dark:bg-orange-900/20 dark:text-orange-400' : '' }}
                                        {{ $post->status === 'future' ? 'text-blue-800 bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400' : '' }}
                                        {{ $post->status === 'private' ? 'text-purple-800 bg-purple-100 dark:bg-purple-900/20 dark:text-purple-400' : '' }}
                                        rounded-full">
                                        {{ ucfirst($post->status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    @if($post->published_at)
                                        {{ $post->published_at->format('M d, Y') }}
                                    @else
                                        {{ $post->created_at->format('M d, Y') }}
                                    @endif
                                </td>
                                <td class="px-5 py-4 sm:px-6 text-center flex items-center justify-center gap-1">
                                    @if (auth()->user()->can('post.edit'))
                                        <a data-tooltip-target="tooltip-edit-{{ $post->id }}" class="btn-default !p-3" href="{{ route('admin.posts.edit', [$postType, $post->id]) }}">
                                            <i class="bi bi-pencil text-sm"></i>
                                        </a>
                                        <div id="tooltip-edit-{{ $post->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            {{ __('Edit') }}
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    @endif

                                    @if (auth()->user()->can('post.view'))
                                        <a data-tooltip-target="tooltip-view-{{ $post->id }}" class="btn-success !p-3" href="{{ route('admin.posts.show', [$postType, $post->id]) }}">
                                            <i class="bi bi-eye text-sm"></i>
                                        </a>
                                        <div id="tooltip-view-{{ $post->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            {{ __('View') }}
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    @endif

                                    @if (auth()->user()->can('post.delete'))
                                        <div x-data="{ deleteModalOpen: false }">
                                            <a x-on:click="deleteModalOpen = true" data-tooltip-target="tooltip-delete-{{ $post->id }}" class="btn-danger !p-3" href="javascript:void(0);">
                                                <i class="bi bi-trash text-sm"></i>
                                            </a>
                                            <div id="tooltip-delete-{{ $post->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                                {{ __('Delete') }}
                                                <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>

                                            <x-modals.confirm-delete
                                                id="delete-modal-{{ $post->id }}"
                                                title="{{ __('Delete') }} {{ strtolower($postTypeModel->label_singular) }}"
                                                content="{{ __('Are you sure you want to delete this') }} {{ strtolower($postTypeModel->label_singular) }}?"
                                                formId="delete-form-{{ $post->id }}"
                                                formAction="{{ route('admin.posts.destroy', [$postType, $post->id]) }}"
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
                                <td colspan="7" class="px-5 py-4 sm:px-6 text-center">
                                    <span class="text-gray-500 dark:text-gray-400">{{ __('No') }} {{ strtolower($postTypeModel->label) }} {{ __('found') }}</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="my-4 px-4 sm:px-6">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
