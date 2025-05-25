@csrf

<!-- Name -->
<div class="mb-4">
    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Name') }}</label>
    <input type="text" name="name" id="name" required value="{{ old('name', $term ? $term->name : '') }}" 
        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
</div>

<!-- Slug -->
<div class="mb-4">
    <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Slug') }}</label>
    <input type="text" name="slug" id="slug" value="{{ old('slug', $term ? $term->slug : '') }}" 
        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
        placeholder="{{ __('Leave empty to auto-generate') }}">
</div>

<!-- Description -->
<div class="mb-4">
    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Description') }}</label>
    <textarea name="description" id="description" rows="3" 
        class="w-full rounded-lg border border-gray-300 bg-transparent p-4 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">{{ old('description', $term ? $term->description : '') }}</textarea>
</div>

@if($taxonomyModel->hierarchical)
<!-- Parent -->
<div class="mb-4">
    <label for="parent_id" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Parent') }} {{ $taxonomyModel->label_singular }}</label>
    <select name="parent_id" id="parent_id" 
        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
        <option value="">{{ __('None') }}</option>
        @foreach($parentTerms as $parentTerm)
            @if(!$term || $parentTerm->id !== $term->id)
                <option value="{{ $parentTerm->id }}" {{ old('parent_id', $term ? $term->parent_id : null) == $parentTerm->id ? 'selected' : '' }}>
                    {{ $parentTerm->name }}
                </option>
            @endif
        @endforeach
    </select>
</div>
@endif

<!-- Submit Button -->
<div class="flex justify-between gap-4">
    <button type="submit" class="btn-primary">
        {{ $term ? __('Update') : __('Add New') }} {{ $taxonomyModel->label_singular }}
    </button>
    @if($term)
        <a href="{{ route('admin.terms.index', $taxonomy) }}" class="btn-default">
            {{ __('Cancel') }}
        </a>
    @endif
</div>
