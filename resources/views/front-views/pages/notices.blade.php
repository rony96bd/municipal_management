@extends('front-views.templates.othe-page-header')
@section('page-body')
    <section class="section">
        <div class="container grid grid-col-5 m-grid-col-1 gap-20">
            <div class="container mt-5">
                <h1>Notice</h1>
                <form action="" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search products..."
                            value="">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- @forelse ($notices as $notice)
                <a href="{{ url('/') }}/notice/{{ $notice->page_url }}" class="flex column gap-0 overflow-hidden bradius-10px border-solid border-1px border-gray">
                    <div class="flex column padar-20 background-gray flex-auto full-width jfs-ais gap-0">
                        @if (!empty($notice->topic))
                            <h3 class="text-center">{{ $notice->topic }}</h3>
                        @endif

                        @if (!empty($notice->description))
                            <p class="text-center">{{ $notice->description }}</p>
                        @endif

                        @if (!empty($notice->created_at))
                            <p class="text-center mart-10"><strong>{{ $notice->created_at }} BCS</strong></p>
                        @endif
                    </div>

                </a>
            @empty
            @endforelse --}}
        </div>
    </section>
@endsection
