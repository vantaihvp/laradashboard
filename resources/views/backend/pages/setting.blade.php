@extends('backend.layouts.app')

@section('title')
    {{ __('Settings - ' . config('app.name')) }}
@endsection

@php
    $isActionLogExist = false;
@endphp
@section('admin-content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: 'Settings' }">
            <!-- Page Header -->
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90" x-text="pageName">Settings</h2>

                <nav>
                    <ol class="flex items-center gap-1.5">
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                                href="{{ route('admin.dashboard') }}">
                                Home
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="text-sm text-gray-800 dark:text-white/90" x-text="pageName">Settings</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Action Logs Table -->
        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    @include('backend.pages.settings.tabs', [
                        'tabs' => [
                            'profile' => [
                                'title' => __('General Settings'),
                                'view' => 'backend.pages.settings.general-tab',
                                'data' => $settings,
                            ],
                            'content' => [
                                'title' => __('Content Settings'),
                                'view' => 'backend.pages.settings.content-settings',
                                'data' => $settings,
                            ]
                        ],
                    ])

                </div>
            </div>

        </div>

    </div>
@endsection


@if ($isActionLogExist)
@endif

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all tab buttons
        const tabButtons = document.querySelectorAll('[role="tab"]');

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabKey = this.getAttribute('data-tab'); // Get the selected tab key
                
                // Construct the new URL with the selected tab in the path
                const url = new URL(window.location);
                url.pathname = `/admin/settings/${tabKey}`;  // Update the path dynamically
                
                // Push the new URL to the browser history (without reloading the page)
                history.pushState(null, '', url);
                
                // Optional: Add code here to show the correct tab content based on the tab selection
                // For example, hide/show tab contents depending on the selected tab
            });
        });
    });
</script>

@endpush
