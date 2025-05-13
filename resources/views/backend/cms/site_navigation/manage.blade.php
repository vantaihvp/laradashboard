@extends('backend.layouts.app')

@section('title')
    {{ __('Manage Navigation') }} | {{ config('app.name') }}
@endsection

@section('admin-content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-lg font-semibold mb-4">{{ $menu->menu_label }}</h2>
    <form id="menu-order-form" action="{{ route('admin.menus.manage.update', $menu->id) }}" method="POST">
        @csrf
        <input type="hidden" name="order" id="menu-order-json">
        <ul id="menu-list" class="space-y-2">
            @foreach($menu->items as $item)
                @include('backend.cms.site_navigation.partials.menu-item', ['item' => $item])
            @endforeach
        </ul>
        <div class="mt-4">
            <button type="submit" class="btn-primary">{{ __('Save Order') }}</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    function serializeMenu(list) {
        let items = [];
        list.querySelectorAll(':scope > li').forEach(function(li) {
            let id = li.dataset.id;
            let childrenUl = li.querySelector(':scope > ul.menu-children');
            let children = childrenUl ? serializeMenu(childrenUl) : [];
            items.push({id: id, children: children});
        });
        return items;
    }

    new Sortable(document.getElementById('menu-list'), {
        group: 'nested',
        animation: 150,
        fallbackOnBody: true,
        swapThreshold: 0.65,
        handle: '.drag-handle',
    });

    document.querySelectorAll('.menu-children').forEach(function(el) {
        new Sortable(el, {
            group: 'nested',
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65,
            handle: '.drag-handle',
        });
    });

    document.getElementById('menu-order-form').addEventListener('submit', function(e) {
        let order = serializeMenu(document.getElementById('menu-list'));
        document.getElementById('menu-order-json').value = JSON.stringify(order);
    });
</script>
@endpush
