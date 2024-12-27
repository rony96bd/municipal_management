<div class="header-top flex row gap-10 jsb-ace background-primary color-white padt-10 padb-10 padl-20 padr-20">
    <div class="flex row gap-20 jsb-ace">
        <a class="dashboard-top-nav flex row gap-5 jsb-ace" href="{{ route('homepage') }}" class="anchor" target="_black">
            <img class="dash-site-logo" src="{{ asset('images/assets/logo.png') }}" alt="Logo">
            <p class="fs-16-20">আলমডাঙ্গা পৌরসভা</p>
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
