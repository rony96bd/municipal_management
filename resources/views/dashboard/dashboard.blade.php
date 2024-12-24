@extends('dashboard.templates.main')
@section('dash-body')
    <div class="dashboard-menu-wrapper grid gap-20">
        {{-- Single Grid Menu --}}
        <a href="{{ route('officialslist') }}" class="anchor grid-menu flex row gap-0 bradius-6px jfs-ace overflow-hidden">
            <div class="grid-menu-icon-box padar-20 flex row center background-primary">
                @include('icons.dashboard-icons.officials')
            </div>
            <div class="flex-column padar-20">
                <strong class="grid-menu-name">কর্মকর্তা</strong>
                <p class="grid-menu-name">নতুন কর্মকর্তা যুক্ত করুন, কর্মকর্তার তালিকা ও তথ্য পরিবর্তন করুন</p>
            </div>
        </a>
        {{-- Single Grid Menu --}}
        <a href="{{ route('stuffslist') }}" class="anchor grid-menu flex row gap-0 bradius-6px jfs-ace overflow-hidden">
            <div class="grid-menu-icon-box padar-20 flex row center background-primary">
                @include('icons.dashboard-icons.office-stuff')
            </div>
            <div class="flex-column padar-20">
                <strong class="grid-menu-name">কর্মচারী</strong>
                <p class="grid-menu-name">নতুন কর্মচারী যুক্ত করুন, কর্মচারী তালিকা ও তথ্য পরিবর্তন করুন</p>
            </div>
        </a>

    </div>
@endsection
