@extends('dashboard.templates.main')
@section('dash-body')

    <h2 class="fs-h2 marb-20">
        @php
            echo 'Menu Builder - ' . $menu->name;
        @endphp</h2>
    @if (session('success'))
        <div class="alert alert-success marb-20">
            {{ session('success') }}
        </div>
    @endif
    <div class="flex column full-width gap-20">
        <a href="{{ route('menus.item.create', $menu->id) }}"
            class="outline-button padl-20 padr-20 padt-10 padb-10 border-solid border-1px border-color solid bradius-3px width-max-content">
            @include('icons.plus') মেন্যু আইটেম তৈরি করুন</a>

        <div class="flex full-width justify-content-end flex column gap-10 mart-20 bradius-3px overflow-hidden">
            <h2 class="fs-h2">সকল মেন্যু আইটেম</h2>
            <div class="row">
                <div class="col-12">
                    {{-- how to use callout --}}
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">How To Use:</h5>
                            <p>You can output a menu anywhere on your site by calling <code>menu('name')</code></p>
                        </div>
                    </div>

                    <div class="main-card mb-3 card">
                        <div class="card-body menu-builder">
                            <h5 class="card-title">Drag and drop the menu Items below to re-arrange them.</h5>
                            <div class="dd">
                                <ol>
                                    @forelse ($menu->menuItems as $item)
                                        <li>
                                            <span>{{ $item->title }}</span>
                                        </li>
                                    @empty
                                        <div class="text-center">
                                            <strong>No menu items found.</strong>
                                        </div>
                                    @endforelse
                                </ol>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>

    @endsection

