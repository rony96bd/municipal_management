<div class="sidebar-prev-box padl-100" style="max-width:550px; margin-left: auto; width:100%">
    <h2 class="fs-h2">সিঙ্গেল মেনু প্রীভিউ</h2>
    <p>ড্রাগ ড্রপ করে মেনুর পজিশন ঠিক করুন</p>
    <div id="group-menu-list" class="sorable-list flex column mart-20 bradius-6px padar-20 background-gray gap-10">
        @if ($groupmenus && $groupmenus->isNotEmpty())
            @foreach ($groupmenus as $groupmenu)
                <div class="top-menu-box background-white position-relative padt-10 padb-10 padr-20 full-width bradius-6 flex row jfs-ace bradius-6px overflow-hidden"
                    data_id="{{ $groupmenu->id }}">
                    <div class="drag-box flex center padl-20 padr-20 padt-10 padb-10 m-display-none">
                        @include('icons.drag')
                    </div>
                    {{ $groupmenu->group_label }}
                </div>
            @endforeach
        @else
            <div class="sub-menu-wrapper submenu-empty text-center flex row center">গ্রুপ সাবমেনু নেই</div>
        @endif
    </div>
</div>
