<style>
    // menu builder
    .menu-builder .dd {
        position: relative;
        display: block;
        margin: 0;
        padding: 0;
        max-width: inherit;
        list-style: none;
        font-size: 13px;
        line-height: 20px;
    }

    .menu-builder .dd .item_actions {
        z-index: 9;
        position: relative;
        top: 10px;
        right: 10px;
    }

    .menu-builder .dd .item_actions .edit {
        margin-right: 5px;
    }

    .menu-builder .dd-handle {
        display: block;
        height: 50px;
        margin: 5px 0;
        padding: 14px 25px;
        color: #333;
        text-decoration: none;
        font-weight: 700;
        border: 1px solid #ccc;
        background: #fafafa;
        border-radius: 3px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    .closed-sidebar:not(.closed-sidebar-mobile) .app-header .app-header__logo .navbar-brand {
        display: none;
    }
</style>

<ol class="dd-list">
    @forelse($menuItems as $item)
        <li class="dd-item" data-id="{{ $item->id }}">
            <div class="pull-right item_actions" style="float: right;">
                <form action="{{ route('menus.item.destroy', ['id' => $item->menu->id, 'itemId' => $item->id]) }}"
                    method="POST" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে মুছে ফেলতে চান?');"
                    style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="background-danger button-default-css color-white padt-10 padb-10 padr-20 padl-20 text-center bradius-3px">ডিলিট</button>
                </form>
                <a class="btn btn-sm btn-primary float-right edit"
                    href="{{ route('menus.item.edit', ['id' => $item->menu->id, 'itemId' => $item->id]) }}">
                    <i class="fas fa-edit"></i>
                    <span>Edit</span>
                </a>
            </div>
            <div class="dd-handle">
                @if ($item->type == 'divider')
                    <strong>Divider: {{ $item->divider_title }}</strong>
                @else
                    <span>{{ $item->title }}</span> <small class="url">{{ $item->url }}</small>
                @endif
            </div>
            @if (!$item->childs->isEmpty())
                <x-menu-builder :menuItems="$item->childs"/>
            @endif
        </li>
    @empty
        <div class="text-center">
            <strong>No menu item found.</strong>
        </div>
    @endforelse
</ol>

