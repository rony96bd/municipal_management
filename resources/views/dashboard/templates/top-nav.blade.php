<div
    class="header-top flex row gap-10 jsb-ace background-primary color-white padt-10 padb-10 padl-20 padr-20 z-index-10 border-solid border-bottom-1px border-left-0px border-right-0px border-top-0px border-color-secondary">
    <div class="flex row gap-20 jsb-ace">
        <a class="dashboard-top-nav flex row gap-5 jsb-ace" href="{{ route('homepage') }}" class="anchor" target="_black">
            <img class="dash-site-logo" src="url('{{ !empty($settings->site_logo) ? asset($settings->site_logo) : asset('images/assets/logo.png') }}')" alt="
            @if (!empty($siteSettings->site_name)) {{ $siteSettings->site_name }}
            @else
            পৌরসভা ম্যানেজমেন্ট সিস্টেম
            @endif">
            <p class="fs-16-20">
                @if (!empty($siteSettings->site_name))
                    {{ $siteSettings->site_name }}
                @else
                    পৌরসভা ম্যানেজমেন্ট সিস্টেম
                @endif
            </p>
        </a>
        {{-- <a class="dashboard-top-nav flex row gap-5 jsb-ace" href="{{ route('dashboard') }}"
            class="anchor">@include('icons.dashboard')Dashboard</a> --}}
        {{-- <a class="dashboard-top-nav flex row gap-5 jsb-ace" href="{{ route('dashboard') }}"
            class="anchor">@include('icons.users')Users</a> --}}
        <p id="clear-cache-btn" class="dashboard-top-nav flex row gap-5 jsb-ace anchor">
            @include('icons.dashboard-icons.clear-cache')Clear Cache</p>
    </div>
    <div class="flex row gap-20 jsb-ace">
        <div class="dash-power flex row center position-relative"
            style="background-image: url({{ asset('images/assets/user.jpg') }})">
            <div
                class="profile-action background-white display-none column bradius-6px position-absolute overflow-hidden">
                <a href="{{ route('profile.edit') }}" class="anchor color-primary padar-10">Profile</a>
                <form method="POST" action="{{ route('logout') }}" class="flex full-width">
                    @csrf

                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();"
                        class="anchor color-primary padar-10 full-width">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </div>
        </div>
    </div>
</div>
