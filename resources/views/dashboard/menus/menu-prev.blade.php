<div class="sidebar-prev-box padl-100" style="max-width:550px; margin-left: auto; width:100%">
    <h2 class="fs-h2">মেনু প্রীভিউ</h2>
    <p>ড্রাগ ড্রপ করে মেনুর পজিশন ঠিক করুন</p>
    <div id="menu-list" class="sorable-list flex column mart-20 bradius-6px padar-20 background-gray gap-10">
        @forelse ($top_menus as $top_menu)
            <div class="top-menu-box background-white position-relative padt-10 padb-10 padr-20 full-width bradius-6 overflow-hidden"
                data_id="{{ $top_menu->id }}">
                <div class="flex row gap-5 jfs-ace">
                    <div class="drag-box flex center padl-20 padr-20 padt-10 padb-10 m-display-none">
                        @include('icons.drag')
                    </div>

                    @if ($top_menu->forigen)
                        @switch($top_menu->forigen_type)
                            @case(App\Models\officials\officials::class)
                                {{ $top_menu->forigen->offificial_name }} - <strong>(কর্মকর্তা)</strong>
                            @break

                            @case(App\Models\representatives\representatives::class)
                                {{ $top_menu->forigen->name }} - <strong>(জনপ্রতিনিধী)</strong>
                            @break

                            @case(App\Models\stuff\Stuff::class)
                                {{ $top_menu->forigen->stuff_name }} - <strong>(কর্মচারী)</strong>
                            @break

                            @case(App\Models\page\createpage::class)
                                {{ $top_menu->forigen->page_name }} - <strong>(পেজ)</strong>
                            @break

                            @case(App\Models\news\NewsModel::class)
                                {{ $top_menu->forigen->topic }} - <strong>(সংবাদ)</strong>
                            @break

                            @case(App\Models\notice\NoticeModel::class)
                                {{ $top_menu->forigen->topic }} - <strong>(নোটিশ)</strong>
                            @break

                            @case(App\Models\Service\SingleService::class)
                                {{ $top_menu->forigen->service_item_name }} - <strong>(সেবা)</strong>
                            @break

                            @default
                        @endswitch
                    @endif

                    @if ($top_menu->link_text)
                        {{ $top_menu->link_text }} - <strong>(
                            @if ($top_menu->tab == 0)
                                স্ট্যাটিক পেজ
                            @else
                                কাস্টম লিংক
                            @endif
                            )
                        </strong>
                    @endif
                </div>

                <!-- Only show submenus or group menus based on conditions -->
                @if (!$top_menu->submenus->isEmpty() && $top_menu->groupmenus->isEmpty())
                    <!-- Show submenus only if there are no group menus -->
                    <div id="submenu-list" class="sub-menu-wrapper flex column gap-10">
                        @foreach ($top_menu->submenus as $submenu)
                            <div class="submenu simple-submenu position-relative" data_id="{{ $submenu->id }}">
                                @if ($submenu->forigen)
                                    @switch($submenu->forigen_type)
                                        @case(App\Models\officials\officials::class)
                                            {{ $submenu->forigen->offificial_name }} - <strong>(কর্মকর্তা)</strong>
                                        @break

                                        @case(App\Models\representatives\representatives::class)
                                            {{ $submenu->forigen->name }} - <strong>(জনপ্রতিনিধী)</strong>
                                        @break

                                        @case(App\Models\stuff\Stuff::class)
                                            {{ $submenu->forigen->stuff_name }} - <strong>(কর্মচারী)</strong>
                                        @break

                                        @case(App\Models\page\createpage::class)
                                            {{ $submenu->forigen->page_name }} - <strong>(পেজ)</strong>
                                        @break

                                        @case(App\Models\news\NewsModel::class)
                                            {{ $submenu->forigen->topic }} - <strong>(সংবাদ)</strong>
                                        @break

                                        @case(App\Models\notice\NoticeModel::class)
                                            {{ $submenu->forigen->topic }} - <strong>(নোটিশ)</strong>
                                        @break

                                        @case(App\Models\Service\SingleService::class)
                                            {{ $submenu->forigen->service_item_name }} - <strong>(সেবা)</strong>
                                        @break

                                        @default
                                    @endswitch
                                    <form action="{{ route('delete-singles-ubmenu', $submenu->id) }}" method="POST"
                                        onsubmit="return confirm('আপনি কি নিশ্চিতভাবে মুছে ফেলতে চান?');"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-sidebar">☓</button>
                                    </form>
                                @else
                                    {{ $submenu->link_text }} - <strong>(
                                        @if ($top_menu->tab == 0)
                                            স্ট্যাটিক পেজ
                                        @else
                                            কাস্টম সাবমেনু লিংক
                                        @endif
                                        )
                                    </strong>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @elseif ($top_menu->groupmenus->isNotEmpty() && $top_menu->submenus->isEmpty())
                    <!-- Show group menus only if there are no submenus -->
                    <div id="groupmenu-list-{{ $top_menu->id }}"
                        class="sub-menu-wrapper group-submenu-wrapper flex column gap-10">
                        @foreach ($top_menu->groupmenus as $groupmenu)
                            <div class="submenu group-menu flex column gap-10 position-relative"
                                data_id="{{ $groupmenu->id }}">
                                <p>{{ $groupmenu->group_label }} -
                                    <strong>(গ্রুপ মেনু)</strong>
                                </p>
                                <div id="group-submenu-list-{{ $top_menu->id }}"
                                    class="sub-menu-wrapper group-single-submenu-wrapper flex column gap-10">
                                    {{-- Group Submenus get loop here --}}
                                    {{-- This is loop item --}}
                                    @foreach ($groupmenu->submenus as $singlegroupmenuitem)
                                        <div class="submenu group-sub-menu position-relative"
                                            data_id="{{ $singlegroupmenuitem->id }}">
                                            @if ($singlegroupmenuitem->forigen)
                                                @if ($singlegroupmenuitem->forigen_type === App\Models\officials\officials::class)
                                                    {{ $singlegroupmenuitem->forigen->offificial_name }} -
                                                    <strong>(কর্মকর্তা)</strong>
                                                @elseif ($singlegroupmenuitem->forigen_type === App\Models\representatives\representatives::class)
                                                    {{ $singlegroupmenuitem->forigen->name }} -
                                                    <strong>(জনপ্রতিনিধী)</strong>
                                                @elseif ($singlegroupmenuitem->forigen_type === App\Models\stuff\Stuff::class)
                                                    {{ $singlegroupmenuitem->forigen->stuff_name }} -
                                                    <strong>(কর্মচারী)</strong>
                                                @elseif ($singlegroupmenuitem->forigen_type === App\Models\page\createpage::class)
                                                    {{ $singlegroupmenuitem->forigen->page_name }} -
                                                    <strong>(পেজ)</strong>
                                                @elseif ($singlegroupmenuitem->forigen_type === App\Models\news\NewsModel::class)
                                                    {{ $singlegroupmenuitem->forigen->topic }} -
                                                    <strong>(সংবাদ)</strong>
                                                @elseif ($singlegroupmenuitem->forigen_type === App\Models\notice\NoticeModel::class)
                                                    {{ $singlegroupmenuitem->forigen->topic }} -
                                                    <strong>(নোটিশ)</strong>
                                                @elseif ($singlegroupmenuitem->forigen_type === App\Models\Service\SingleService::class)
                                                    {{ $singlegroupmenuitem->forigen->service_item_name }} -
                                                    <strong>(সেবা)</strong>
                                                @endif
                                            @endif
                                            @if ($singlegroupmenuitem->link_text)
                                                {{ $singlegroupmenuitem->link_text }} - <strong>(
                                                    @if ($top_menu->tab == 0)
                                                        স্ট্যাটিক পেজ
                                                    @else
                                                        কাস্টম সাবমেনু লিংক
                                                    @endif
                                                    )
                                                </strong>
                                            @endif
                                            <form
                                                action="{{ route('delete-group-submenu', $singlegroupmenuitem->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('আপনি কি নিশ্চিতভাবে মুছে ফেলতে চান?');"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete-sidebar">☓</button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                                <a href="{{ route('single-group-menu', $groupmenu->id) }}"
                                    class="anchor font-weight-bold marl-auto mart-10">সিঙ্গেল
                                    গ্রুপ সাবমেনু</a>
                                <form action="{{ route('delete-menu-group', $groupmenu->id) }}" method="POST"
                                    onsubmit="return confirm('আপনি কি নিশ্চিতভাবে মুছে ফেলতে চান?');"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-sidebar">☓</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- If both submenus and group menus are empty -->
                    <div class="sub-menu-wrapper submenu-empty text-center flex row center">
                        কোন তথ্য নেই
                    </div>
                @endif

                <div class="flex row gap-10 jfe-ace mart-10">
                    @if ($top_menu->groupmenus->isNotEmpty())
                        <a href="{{ route('group-menu-page', $top_menu->id) }}" class="anchor font-weight-bold">গ্রুপ
                            সাবমেনু</a>
                    @endif
                    @if ($top_menu->submenus->isNotEmpty())
                        <a href="{{ route('add-single-submenu', $top_menu->id) }}"
                            class="anchor font-weight-bold">সিঙ্গেল
                            সাবমেনু</a>
                    @endif
                    @if ($top_menu->groupmenus->isEmpty() && $top_menu->submenus->isEmpty())
                        <a href="{{ route('group-menu-page', $top_menu->id) }}" class="anchor font-weight-bold">গ্রুপ
                            সাবমেনু</a> -
                        <a href="{{ route('add-single-submenu', $top_menu->id) }}"
                            class="anchor font-weight-bold">সিঙ্গেল সাবমেনু</a>
                    @endif
                </div>

                <form action="{{ route('delete-top-menu', $top_menu->id) }}" method="POST"
                    onsubmit="return confirm('আপনি কি নিশ্চিতভাবে মুছে ফেলতে চান?');" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-sidebar">☓</button>
                </form>
            </div>
            @empty
                <p class="color-warning">কোন মেনু যুক্ত করা নেয় যায়নি।</p>
            @endforelse
        </div>
    </div>

    {{-- Code for Top Menu --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to update the order of menus
            function updateOrder(orderedIds, menuId, route) {
                fetch(route, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            orderedIds: orderedIds,
                            menuId: menuId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('অর্ডার সফলভাবে আপডেট হয়েছে!');
                        } else {
                            alert('অর্ডার আপডেট করতে সমস্যা হয়েছে!');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('অর্ডার আপডেট করতে সমস্যা হয়েছে!');
                    });
            }

            // Top Menu
            new Sortable(document.getElementById('menu-list'), {
                animation: 150,
                onEnd(evt) {
                    const orderedIds = [];
                    const items = document.querySelectorAll('.top-menu-box');
                    items.forEach(item => {
                        orderedIds.push(item.getAttribute('data_id'));
                    });
                    updateOrder(orderedIds, null, '{{ route('update-main-menu-order') }}');
                }
            });

            // Group Menu
            const groupmenus = document.querySelectorAll('.group-submenu-wrapper');
            groupmenus.forEach(groupmenu => {
                new Sortable(groupmenu, {
                    animation: 150,
                    onEnd(evt) {
                        const grouporderedIds = [];
                        const groupitems = groupmenu.querySelectorAll('.group-menu');
                        groupitems.forEach(groupitem => {
                            grouporderedIds.push(groupitem.getAttribute('data_id'));
                        });
                        updateOrder(grouporderedIds, groupmenu.getAttribute('data_id'),
                            '{{ route('update-group-menu-order') }}');
                    }
                });
            });

            // Single Sub Group Menu
            const subgroupmenus = document.querySelectorAll('.group-single-submenu-wrapper');
            subgroupmenus.forEach(subgroupmenu => {
                new Sortable(subgroupmenu, {
                    animation: 150,
                    onEnd(evt) {
                        const subgrouporderedIds = [];
                        const subgroupitems = subgroupmenu.querySelectorAll('.group-sub-menu');
                        subgroupitems.forEach(subgroupitem => {
                            subgrouporderedIds.push(subgroupitem.getAttribute('data_id'));
                        });
                        updateOrder(subgrouporderedIds, subgroupmenu.getAttribute('data_id'),
                            '{{ route('update-group-submenu-order') }}');
                    }
                });
            });

            // Sub Menu
            const submenus = document.querySelectorAll('.sub-menu-wrapper');
            submenus.forEach(submenu => {
                new Sortable(submenu, {
                    animation: 150,
                    onEnd(evt) {
                        const SuborderedIds = [];
                        const Subitems = submenu.querySelectorAll('.simple-submenu');
                        Subitems.forEach(Subitem => {
                            SuborderedIds.push(Subitem.getAttribute('data_id'));
                        });
                        updateOrder(SuborderedIds, submenu.getAttribute('data_id'),
                            '{{ route('update-submenu-order') }}');
                    }
                });
            });
        });
    </script>
