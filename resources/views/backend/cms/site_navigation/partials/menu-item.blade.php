<li class="border rounded p-2 bg-gray-50 flex items-center gap-2 justify-between" data-id="{{ $item->id }}">
    <div class="flex items-center gap-2">
        <span class="drag-handle cursor-move mr-2 text-gray-400"><i class="bi bi-list"></i></span>
        <span>{{ $item->menu_label }}</span>
    </div>
    <div class="flex items-center gap-1">
        <a href="{{ route('admin.menu-item.edit', $item->id) }}" class="btn-default !p-2" title="{{ __('Edit Menu Item') }}">
            <i class="bi bi-pencil"></i>
        </a>
        <form action="{{ route('admin.menu-item.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ __('Are you sure you want to delete this item?') }}');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger !p-2" title="{{ __('Delete Menu Item') }}">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    </div>
    @if ($item->items && $item->items->count())
        <ul class="menu-children ml-6 mt-2 space-y-2 w-full">
            @foreach($item->items as $child)
                @include('backend.cms.site_navigation.partials.menu-item', ['item' => $child])
            @endforeach
        </ul>
    @endif
</li>
