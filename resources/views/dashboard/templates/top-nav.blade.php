<div class="header-top flex row gap-10 jsb-ace background-primary color-white padar-20">
    <div class="flex row gap-20 jsb-ace">
        <a class="dashboard-top-nav flex row gap-5 jsb-ace" href="{{ route('homepage') }}" class="anchor"
            target="_black">@include('icons.visit-site') View Site</a>
        <a class="dashboard-top-nav flex row gap-5 jsb-ace" href="{{ route('dashboard') }}"
            class="anchor">@include('icons.dashboard')Dashboard</a>
        <a class="dashboard-top-nav flex row gap-5 jsb-ace" href="{{ route('dashboard') }}"
            class="anchor">@include('icons.users')Users</a>
    </div>
    <div class="flex row gap-20 jsb-ace">
        <div class="dash-power flex row center position-relative">
            <div
                class="profile-action background-white display-none column bradius-6px position-absolute overflow-hidden">
                <a href="#" class="anchor color-primary padar-10">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                    <button type="submit" class="anchor color-primary padar-10">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
