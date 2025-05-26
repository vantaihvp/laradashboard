@extends('backend.layouts.app')

@section('title')
    {{ __('Roles') }} | {{ config('app.name') }}
@endsection

@section('admin-content')
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div x-data="{ pageName: '{{ __('Roles') }}' }">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ __('Roles') }}</h2>
            <nav>
                <ol class="flex items-center gap-1.5">
                    <li>
                        <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.dashboard') }}">
                            {{ __('Home') }}
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                    <li class="text-sm text-gray-800 dark:text-white/90">{{ __('Roles') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Roles Table -->
    <div class="space-y-6">
        @include('backend.layouts.partials.messages')
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 sm:px-6 sm:py-5 flex justify-between items-center">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ __('Roles') }}</h3>

                @include('backend.partials.search-form', [
                    'placeholder' => __('Search by role name'),
                ])

                @if (auth()->user()->can('role.create'))
                    <a href="{{ route('admin.roles.create') }}" class="btn-primary">
                        <i class="bi bi-plus-circle mr-2"></i>
                        {{ __('New Role') }}
                    </a>
                @endif
            </div>
            <div class="space-y-3 border-t border-gray-100 dark:border-gray-800 overflow-x-auto">
                <table id="dataTable" class="w-full dark:text-gray-400">
                    <thead class="bg-light text-capitalize">
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th width="5%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Sl') }}</th>
                            <th width="10%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Name') }}</th>
                            <th width="8%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Users') }}</th>
                            <th width="35%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white">{{ __('Permissions') }}</th>
                            <th width="12%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                            <tr class="{{ $loop->index + 1 != count($roles) ?  'border-b border-gray-100 dark:border-gray-800' : '' }}">
                                <td class="px-5 py-4 sm:px-6">{{ $loop->index + 1 }}</td>
                                <td class="px-5 py-4 sm:px-6">
                                    @if (auth()->user()->can('role.edit'))
                                        <a href="{{ route('admin.roles.edit', $role->id) }}" data-tooltip-target="tooltip-role-name-{{ $role->id }}" class="text-gray-800 dark:text-white hover:text-primary dark:hover:text-primary">
                                            {{ $role->name }}
                                        </a>
                                        <div id="tooltip-role-name-{{ $role->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            {{ __('Edit Role') }}
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    @else
                                        {{ $role->name }}
                                    @endif

                                    <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('Total Permissions:') }} {{ $role->permissions->count() }}
                                    </div>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <a href="{{ route('admin.users.index', ['role' => $role->name]) }}" class="inline-flex items-center gap-1 text-sm text-primary hover:underline" data-tooltip-target="tooltip-users-role-{{ $role->id }}">
                                        <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-white">
                                            {{ $role->user_count }}
                                        </span>
                                    </a>
                                    <div id="tooltip-users-role-{{ $role->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                        {{ __('View') }} {{ $role->name }} {{ __('Users') }}
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <div x-data="{ showAll: false }">
                                        <div>
                                            @foreach ($role->permissions->take(7) as $permission)
                                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-800 dark:text-white">
                                                    {{ $permission->name }}
                                                </span>
                                            @endforeach
                                            <template x-if="showAll">
                                                <div>
                                                    @foreach ($role->permissions->skip(7) as $permission)
                                                        <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-800 dark:text-white">
                                                            {{ $permission->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </template>
                                        </div>
                                        @if ($role->permissions->count() > 7)
                                            <button @click="showAll = !showAll" class="text-primary text-sm mt-2">
                                                <span x-show="!showAll">+{{ $role->permissions->count() - 7 }} {{ __('more') }}</span>
                                                <span x-show="showAll">{{ __('Show less') }}</span>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                                <td class="flex items-center justify-center px-5 py-4 sm:px-6 text-center gap-1">
                                    @if (auth()->user()->can('role.edit') && $role->name != 'Superadmin')
                                        <div>
                                            <a data-tooltip-target="tooltip-edit-role-{{ $role->id }}" class="btn-default !p-3" href="{{ route('admin.roles.edit', $role->id) }}">
                                                <i class="bi bi-pencil text-sm"></i>
                                            </a>
                                            <div id="tooltip-edit-role-{{ $role->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                                {{ __('Edit Role') }}
                                                <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>
                                        </div>
                                    @endif

                                    @if (auth()->user()->can('role.delete') && $role->name != 'Superadmin')
                                        <div x-data="{ deleteModalOpen: false }">
                                            <a x-on:click="deleteModalOpen = true" data-tooltip-target="tooltip-delete-role-{{ $role->id }}" class="btn-danger !p-3" href="javascript:void(0);">
                                                <i class="bi bi-trash text-sm"></i>
                                            </a>

                                            <div id="tooltip-delete-role-{{ $role->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                                {{ __('Delete Role') }}
                                                <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>

                                            <x-modals.confirm-delete
                                                id="delete-modal-{{ $role->id }}"
                                                title="{{ __('Delete Role') }}"
                                                content="{{ __('Are you sure you want to delete this role?') }}"
                                                formId="delete-form-{{ $role->id }}"
                                                formAction="{{ route('admin.roles.destroy', $role->id) }}"
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
                                <td colspan="4" class="px-5 py-4 sm:px-6 text-center">
                                    <span class="text-gray-500 dark:text-gray-400">{{ __('No roles found') }}</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="my-4 px-4 sm:px-6">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
