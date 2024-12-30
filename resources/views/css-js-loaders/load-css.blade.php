<link rel="stylesheet" href="{{ asset('css/main.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/site-css.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.css"
    integrity="sha512-WLnZn2zeYB0crLeiqeyqmdh7tqN5UfBiJv9cYWL9nkUoAUMG5flJnjWGeeKIs8eqy8nMGGbMvDdpwKajJAWZ3Q=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css"
    integrity="sha512-yOW3WV01iPnrQrlHYlpnfVooIAQl/hujmnCmiM3+u8F/6cCgA3BdFjqQfu8XaOtPilD/yYBJR3Io4PO8QUQKWA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

@if (request()->header('User-Agent') &&
        (strpos(request()->header('User-Agent'), 'Mobile') !== false || request()->header('User-Agent') === 'iPhone'))
    <link rel="stylesheet" href="{{ asset('css/mobile-main.min.css') }}">
@endif

@php
    $siteSettings = \App\Models\SiteSettings::first();
    $googleFont = !empty($siteSettings->google_font) ? $siteSettings->google_font : null;
@endphp

{{-- Load Google Font dynamically if available --}}
@if ($googleFont)
    <link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $googleFont) }}&display=swap"
        rel="stylesheet">
@else
    {{-- Default Font (Tiro Bangla) --}}
    <link href="https://fonts.googleapis.com/css2?family=Tiro+Bangla&display=swap" rel="stylesheet">
@endif

<style>
    :root {
        --primary-color: {{ !empty($siteSettings->primary_color) ? $siteSettings->primary_color : '#000325' }};
        --secondary-color: {{ !empty($siteSettings->secondary_color) ? $siteSettings->secondary_color : '#3361d9' }};
        --paragraph-color: {{ !empty($siteSettings->paragraph_color) ? $siteSettings->paragraph_color : '#333333' }};
        --link-color: {{ !empty($siteSettings->link_color) ? $siteSettings->link_color : '#ffffff' }};
        --button-color: {{ !empty($siteSettings->button_color) ? $siteSettings->button_color : '#0A3981' }};
        --danger-color: {{ !empty($siteSettings->danger_color) ? $siteSettings->danger_color : '#e74c3c' }};
        --alert-color: {{ !empty($siteSettings->alert_color) ? $siteSettings->alert_color : '#f39c12' }};
        --success-color: {{ !empty($siteSettings->success_color) ? $siteSettings->success_color : '#4fff00' }};
        --warning-color: {{ !empty($siteSettings->warning_color) ? $siteSettings->warning_color : '#f39c12' }};
        --black-color: {{ !empty($siteSettings->black_color) ? $siteSettings->black_color : '#000000' }};
        --white-color: {{ !empty($siteSettings->white_color) ? $siteSettings->white_color : '#ffffff' }};
        --background-gray: {{ !empty($siteSettings->background_gray) ? $siteSettings->background_gray : '#f2f2f2' }};
    }

    @if ($googleFont)
        body {
            font-family: '{{ $googleFont }}', sans-serif !important;
        }
    @else
        body {
            font-family: "Tiro Bangla", serif;
        }
    @endif
</style>
