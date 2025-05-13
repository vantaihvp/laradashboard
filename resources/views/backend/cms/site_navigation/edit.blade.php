@extends('backend.layouts.app')

@section('title')
    {{ __('Edit Menu') }} | {{ config('app.name') }}
@endsection

@section('admin-content')
<div class="max-w-xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-lg font-semibold mb-4">{{ __('Edit Menu') }}</h2>
    <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block mb-1 font-medium">{{ __('Title') }}</label>
            <input type="text" name="menu_label" value="{{ old('menu_label', $menu->menu_label) }}" class="form-input w-full" required>
            @error('menu_label') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium">{{ __('URL') }}</label>
            <input type="text" name="link" value="{{ old('link', $menu->link) }}" class="form-input w-full">
            @error('link') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium">{{ __('Order') }}</label>
            <input type="number" name="menu_order" value="{{ old('menu_order', $menu->menu_order) }}" class="form-input w-full">
            @error('menu_order') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium">{{ __('Status') }}</label>
            <select name="status" class="form-select w-full">
                <option value="1" {{ old('status', $menu->status) == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                <option value="0" {{ old('status', $menu->status) == 0 ? 'selected' : '' }}>{{ __('Inactive') }}</option>
            </select>
            @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="flex gap-2">
            <button type="submit" class="btn-primary">{{ __('Update') }}</button>
            <a href="{{ route('admin.menus.index') }}" class="btn-secondary">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
@endsection
