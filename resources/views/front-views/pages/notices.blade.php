@extends('front-views.templates.othe-page-header')
@section('page-body')
    <style>
        /* Custom CSS */
        .search-form {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }

        .search-form input[type="text"] {
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .search-form button {
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }

        .search-form button:hover {
            background-color: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f8f9fa;
            color: #333;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination li a {
            padding: 8px 12px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        .pagination li a:hover {
            background-color: #0056b3;
        }

        .pagination .active a {
            background-color: #0056b3;
        }
    </style>
    <section class="section">
        <div class="container">
            <div>
                <h1>Notice</h1>
            </div>
            <div class="search-form">
                <form action="{{ route('notices') }}" method="GET">
                    <input type="text" name="search" placeholder="Search Notices..." value="{{ request('search') }}">
                    <button type="submit">Search</button>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ক্রমিক</th>
                            <th>নোটিশ</th>
                            <th>প্রকাশের তারিখ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notices as $notice)
                            <tr>
                                <td>{{ englishToBanglaNumber(($notices->currentPage() - 1) * $notices->perPage() + $loop->iteration) }}</td>
                                <td>{{ $notice->topic }}</td>
                                <td>{{ $notice->created_at }}</td>
                            </tr>
                        @endforeach
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
