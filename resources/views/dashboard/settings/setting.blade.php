@extends('dashboard.templates.main')
@section('dash-body')
    @include('dashboard.forms.site-settings')
    @php
        $siteSettings = \App\Models\SiteSettings::first();
    @endphp
    @if (!empty($siteSettings))
        <form action="{{ route('site-settings.reset') }}" method="POST"
            onsubmit="return confirm('Are you sure you want to reset the site settings and remove the images?');">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="anchor flex center primary-button background-danger color-white padl-20 padr-20 padt-10 padb-10 bradius-3px mart-20 marl-auto button-default-css">Reset
                Site Settings</button>
        </form>
    @endif
@endsection
