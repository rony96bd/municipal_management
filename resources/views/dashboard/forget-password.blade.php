@extends('dashboard.login-templates.main')
@section('login-content')
    <div class="login-form padar-40 bradius-6px font-weight-bold">
        <div class="color-primary text-center marb-10 color-danger">
            {{ __('পাসওয়ার্ড ভুলে গেছেন? কোন সমস্যা নেয়। নিচে আপনার ইমেইল লিখে পাসওয়ার্ড রিসোট বাটনে ক্লিক করুন। আপনি কিছুক্ষণের মধ্যেই একটি ইমেইল পেয়ে যাবেন আপনার নতুন পাসওয়ার্ড তৈরি করার জন্যে।') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class=" font-weight-medium color-danger text-center marb-10" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="flex column gap-0">
                <x-input-label for="email" :value="__('ই-মেইল')" class="color-primary font-weight-bold" />
                <x-text-input id="email" class="login-field padl-20 padr-20 padt-10 padb-10 background-white bradius-3px"
                    type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class=" color-danger" />
            </div>

            <div>
                <x-primary-button
                    class="padar-10 bradius-3px color-white background-primary full-width text-center mart-10 font-weight-medium">
                    {{ __('পাসওয়ার্ড রিসেট লিঙ্ক পাঠান') }}
                </x-primary-button>
            </div>
        </form>
    </div>
@endsection
