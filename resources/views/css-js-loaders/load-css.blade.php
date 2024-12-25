<link rel="stylesheet" href="{{ asset('css/main.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/site-css.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.css" integrity="sha512-WLnZn2zeYB0crLeiqeyqmdh7tqN5UfBiJv9cYWL9nkUoAUMG5flJnjWGeeKIs8eqy8nMGGbMvDdpwKajJAWZ3Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css" integrity="sha512-yOW3WV01iPnrQrlHYlpnfVooIAQl/hujmnCmiM3+u8F/6cCgA3BdFjqQfu8XaOtPilD/yYBJR3Io4PO8QUQKWA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
{{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
{{-- <link rel="stylesheet" href="{{ url('/repositories/municipal_management/public/css/main.min.css') }}"> --}}
@if (request()->header('User-Agent') &&
        (strpos(request()->header('User-Agent'), 'Mobile') !== false || request()->header('User-Agent') === 'iPhone'))
    <link rel="stylesheet" href="{{ asset('css/mobile-main.min.css') }}">
    {{-- <link rel="stylesheet" href="../repositories/municipal_management/public/css/mobile-main.min.css"> --}}
@endif

<style>
    @import url('https://fonts.googleapis.com/css2?family=Anek+Bangla:wght@100..800&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Parkinsans:wght@300..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Tiro+Bangla:ital@0;1&display=swap');
</style>
