@if (session('success'))
    <div class="alert alert-success marb-20">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger marb-20">
        {{ session('error') }}
    </div>
@endif
