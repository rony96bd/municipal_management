@extends('dashboard.login-templates.main')
@section('login-content')
    <div class="login-form padar-40 bradius-6px">
        <x-auth-session-status class="color-danger" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="form-container flex column gap-10">
            @csrf

            <!-- Email Address -->
            <div class="flex column gap-0">
                <x-input-label for="email" :value="__('ই-মেইল')" class="form-label color-primary font-weight-bold" />
                <x-text-input id="email" class="login-field padl-20 padr-20 padt-10 padb-10 background-white bradius-3px"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="form-error mt-2" />
            </div>

            <!-- Password -->
            <div class="flex column gap-0">
                <x-input-label for="password" :value="__('পাসওয়ার্ড')" class="form-label color-primary font-weight-bold" />
                <x-text-input id="password"
                    class="login-field padl-20 padr-20 padt-10 padb-10 background-white bradius-3px" type="password"
                    name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="form-error mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="form-group mt-4">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" class="checkbox display-none" name="remember">
                    <span
                        class="remember-btn font-weight-bold color-primary padl-30 position-relative flex jst-ace">{{ __('লগ-ইন রাখুন') }}</span>
                </label>
            </div>

            <div class="form-group flex column gap-20">
                <x-primary-button class="padar-10 bradius-3px color-white background-primary">
                    {{ __('লগ-ইন') }}
                </x-primary-button>

                @if (Route::has('password.request'))
                    <a class="color-danger fs-base font-weight-bold" href="{{ route('password.request') }}">
                        {{ __('পাসওয়ার্ড ভুলে গেছেন?') }}
                    </a>
                @endif
            </div>
        </form>
    </div>
    <p class="color-primary text-center">Developed & Maintained by: <a href="https://forayeji.com" target="_blank"
            class="color-secondary">Forayeji
            Creative
            Agency</a></p>
    <p>
    @endsection
