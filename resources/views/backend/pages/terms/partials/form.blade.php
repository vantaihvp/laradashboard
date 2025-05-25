@csrf

<div x-data="slugGenerator('{{ old('name', $term ? $term->name : '') }}', '{{ old('slug', $term ? $term->slug : '') }}')">
    <!-- Name -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Name') }}</label>
        <input type="text" name="name" id="name" required x-model="title" 
            class="form-control">
    </div>

    <!-- Slug -->
    <div class="mt-2">
        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
            {{ __('Slug') }}
            <button type="button" @click="toggleSlugEdit" class="ml-2 text-xs text-gray-500 dark:text-gray-400 hover:text-brand-500 dark:hover:text-brand-400">
                <span x-show="!showSlugEdit">{{ __('Edit') }}</span>
                <span x-show="showSlugEdit">{{ __('Hide') }}</span>
            </button>
        </label>
        <div class="relative">
            <input type="text" name="slug" id="slug" x-model="slug" x-bind:readonly="!showSlugEdit" 
                class="form-control"
                placeholder="{{ __('Leave empty to auto-generate') }}" 
                x-bind:class="{'bg-gray-50 dark:bg-gray-800': !showSlugEdit}">
            <button type="button" @click="generateSlug" x-show="showSlugEdit" 
                class="absolute right-2 top-1/2 -translate-y-1/2 rounded-md bg-gray-100 px-2 py-1 text-xs text-gray-600 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                {{ __('Generate') }}
            </button>
        </div>
    </div>

    <!-- Description -->
    <div class="mt-2">
        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Description') }}</label>
        <textarea name="description" id="description" rows="3" 
            class="w-full rounded-lg border border-gray-300 bg-transparent p-4 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">{{ old('description', $term ? $term->description : '') }}</textarea>
    </div>

    @if($taxonomyModel->show_featured_image)
    <!-- Featured Image -->
    <div class="mt-2">
        <label for="featured_image" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Featured Image') }}</label>
        <input type="file" name="featured_image" id="featured_image" 
            class="w-full rounded-lg border border-gray-300 bg-transparent p-2 text-sm text-gray-800 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
            accept="image/*">
        
        @if($term && $term->featured_image)
        <div class="mt-3">
            <div class="mb-2">
                <img src="{{ Storage::url($term->featured_image) }}" alt="{{ $term->name }}" class="max-w-full h-auto max-h-40 rounded border dark:border-gray-700">
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="remove_featured_image" id="remove_featured_image" value="1" class="mr-2">
                <label for="remove_featured_image" class="text-sm text-gray-700 dark:text-gray-400">{{ __('Remove featured image') }}</label>
            </div>
        </div>
        @endif
    </div>
    @endif

    @if($taxonomyModel->hierarchical)
    <!-- Parent -->
    <div class="mt-2">
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
    <div class="flex justify-between gap-4 mt-4">
        <button type="submit" class="btn-primary">
            {{ $term ? __('Update') : __('Add New') }} {{ $taxonomyModel->label_singular }}
        </button>
        @if($term)
            <a href="{{ route('admin.terms.index', $taxonomy) }}" class="btn-default">
                {{ __('Cancel') }}
            </a>
        @endif
    </div>
</div>
