<div class="sidebar-prev-box padl-100" style="max-width:550px; margin-left: auto; width:100%">
    <h2 class="fs-h2">সিঙ্গেল গ্রুপমেনু আইটেম প্রীভিউ</h2>
    <p>ড্রাগ ড্রপ করে মেনুর পজিশন ঠিক করুন</p>
    <div id="menu-list" class="sorable-list flex column mart-20 bradius-6px padar-20 background-gray gap-10">
        @if ($groupmenu)
            <div class="top-menu-box background-white position-relative padt-10 padb-10 padr-20 full-width bradius-6 overflow-hidden"
                data-id="{{ $groupmenu->id }}">
                <div class="flex row gap-5 jfs-ace">
                    <div class="drag-box flex center padl-20 padr-20 padt-10 padb-10 m-display-none">
                        @include('icons.drag')
                    </div>
                    <strong>গ্রুপ মেনু - {{ $groupmenu->group_label }}</strong>
                </div>
                <!-- Check for Submenus -->
                @if ($groupmenu->submenus->isEmpty())
                    <div class="sub-menu-wrapper submenu-empty text-center flex row center">
                        কোন তথ্য নেই
                    </div>
                @else
                    <div id="submenu-list" class="sub-menu-wrapper flex column gap-10">
                        @foreach ($groupmenu->submenus as $submenu)
                            <p class="submenu" data-id="{{ $submenu->id }}">
                                @if ($submenu->forigen)
                                    @if ($submenu->forigen_type === App\Models\officials\officials::class)
                                        {{ $submenu->forigen->offificial_name }} - <strong>(কর্মকর্তা)</strong>
                                    @elseif ($submenu->forigen_type === App\Models\representatives\representatives::class)
                                        {{ $submenu->forigen->name }} - <strong>(জনপ্রতিনিধী)</strong>
                                    @elseif ($submenu->forigen_type === App\Models\stuff\Stuff::class)
                                        {{ $submenu->forigen->stuff_name }} - <strong>(কর্মচারী)</strong>
                                    @elseif ($submenu->forigen_type === App\Models\page\createpage::class)
                                        {{ $submenu->forigen->page_name }} - <strong>(পেজ)</strong>
                                    @elseif ($submenu->forigen_type === App\Models\news\NewsModel::class)
                                        {{ $submenu->forigen->topic }} - <strong>(সংবাদ)</strong>
                                    @elseif ($submenu->forigen_type === App\Models\notice\NoticeModel::class)
                                        {{ $submenu->forigen->topic }} - <strong>(নোটিশ)</strong>
                                    @elseif ($submenu->forigen_type === App\Models\Service\SingleService::class)
                                        {{ $submenu->forigen->service_item_name }} - <strong>(সেবা)</strong>
                                    @endif
                                @endif
                                @if ($submenu->link_text)
                                    {{ $submenu->link_text }} - <strong>(
                                        @if ($submenu->tab == 0)
                                            স্ট্যাটিক পেজ
                                        @else
                                            কাস্টম সাবমেনু লিংক
                                        @endif
                                        )
                                    </strong>
                                @endif
                            </p>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <p>কোন মেনু আইটেম খুঁজে পাওয়া যায়নি।</p>
        @endif
    </div>
</div>
