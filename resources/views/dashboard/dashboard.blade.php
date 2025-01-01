@extends('dashboard.templates.main')
@section('dash-body')
    <div class="dashboard-menu-wrapper grid gap-20">
        {{-- Page Grid Menu --}}
        <a href="{{ route('pages') }}" class="anchor grid-menu flex row gap-0 bradius-6px jfs-ace overflow-hidden">
            <div class="grid-menu-icon-box padar-20 flex row center background-primary">
                @include('icons.dashboard-icons.page')
            </div>
            <div class="flex-column padar-20">
                <strong class="grid-menu-name">পেজ</strong>
                <p class="grid-menu-name">নতুন পেজ যুক্ত করুন, পেজ এর তালিকা ও তথ্য পরিবর্তন করুন</p>
            </div>
        </a>
        {{-- Notice Grid Menu --}}
        <a href="{{ route('notice') }}" class="anchor grid-menu flex row gap-0 bradius-6px jfs-ace overflow-hidden">
            <div class="grid-menu-icon-box padar-20 flex row center background-primary">
                @include('icons.notice')
            </div>
            <div class="flex-column padar-20">
                <strong class="grid-menu-name">নোটিশ</strong>
                <p class="grid-menu-name">নতুন নোটিশ যুক্ত করুন, নোটিশ এর তালিকা ও তথ্য পরিবর্তন করুন</p>
            </div>
        </a>
        {{-- News Grid Menu --}}
        <a href="{{ route('news') }}" class="anchor grid-menu flex row gap-0 bradius-6px jfs-ace overflow-hidden">
            <div class="grid-menu-icon-box padar-20 flex row center background-primary">
                @include('icons.news')
            </div>
            <div class="flex-column padar-20">
                <strong class="grid-menu-name">নিউজ</strong>
                <p class="grid-menu-name">নতুন নিউজ যুক্ত করুন, নিউজ এর তালিকা ও তথ্য পরিবর্তন করুন</p>
            </div>
        </a>
        {{-- Officer Grid Menu --}}
        <a href="{{ route('officialslist') }}" class="anchor grid-menu flex row gap-0 bradius-6px jfs-ace overflow-hidden">
            <div class="grid-menu-icon-box padar-20 flex row center background-primary">
                @include('icons.dashboard-icons.officials')
            </div>
            <div class="flex-column padar-20">
                <strong class="grid-menu-name">কর্মকর্তা</strong>
                <p class="grid-menu-name">নতুন কর্মকর্তা যুক্ত করুন, কর্মকর্তার তালিকা ও তথ্য পরিবর্তন করুন</p>
            </div>
        </a>
        {{-- Stuff Grid Menu --}}
        <a href="{{ route('stuffslist') }}" class="anchor grid-menu flex row gap-0 bradius-6px jfs-ace overflow-hidden">
            <div class="grid-menu-icon-box padar-20 flex row center background-primary">
                @include('icons.dashboard-icons.office-stuff')
            </div>
            <div class="flex-column padar-20">
                <strong class="grid-menu-name">কর্মচারী</strong>
                <p class="grid-menu-name">নতুন কর্মচারী যুক্ত করুন, কর্মচারী তালিকা ও তথ্য পরিবর্তন করুন</p>
            </div>
        </a>
        {{-- Representative Grid Menu --}}
        <a href="{{ route('representativeslist') }}"
            class="anchor grid-menu flex row gap-0 bradius-6px jfs-ace overflow-hidden">
            <div class="grid-menu-icon-box padar-20 flex row center background-primary">
                @include('icons.dashboard-icons.representative')
            </div>
            <div class="flex-column padar-20">
                <strong class="grid-menu-name">জনপ্রতিনিধি</strong>
                <p class="grid-menu-name">জনপ্রতিনিধি যুক্ত করুন, তালিকা ও তথ্য পরিবর্তন করুন</p>
            </div>
        </a>
        {{-- Services Grid Menu --}}
        <a href="{{ route('services') }}" class="anchor grid-menu flex row gap-0 bradius-6px jfs-ace overflow-hidden">
            <div class="grid-menu-icon-box padar-20 flex row center background-primary">
                @include('icons.dashboard-icons.service')
            </div>
            <div class="flex-column padar-20">
                <strong class="grid-menu-name">সেবা সমূহ</strong>
                <p class="grid-menu-name">নতুন সেবা যুক্ত করুন, সেবা তালিকা ও তথ্য পরিবর্তন করুন</p>
            </div>
        </a>
        {{-- Services Grid Menu --}}
        <a href="{{ route('about') }}" class="anchor grid-menu flex row gap-0 bradius-6px jfs-ace overflow-hidden">
            <div class="grid-menu-icon-box padar-20 flex row center background-primary">
                @include('icons.dashboard-icons.about')
            </div>
            <div class="flex-column padar-20">
                <strong class="grid-menu-name">পৌরসভা সম্পর্কে</strong>
                <p class="grid-menu-name">পৌরসভা সম্পর্কে সংক্ষিপ্ত বিবরণ</p>
            </div>
        </a>
        {{-- Services Grid Menu --}}
        <a href="{{ route('services') }}" class="anchor grid-menu flex row gap-0 bradius-6px jfs-ace overflow-hidden">
            <div class="grid-menu-icon-box padar-20 flex row center background-primary">
                @include('icons.dashboard-icons.sidebar')
            </div>
            <div class="flex-column padar-20">
                <strong class="grid-menu-name">সাইডবার রেজিস্টার</strong>
                <p class="grid-menu-name">সাইডবার রেজিস্টার ও সাইডবারের তথ্য আপডেট করুন</p>
            </div>
        </a>


    </div>
@endsection
