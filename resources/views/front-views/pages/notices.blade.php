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
                                <td>{{ englishToBanglaNumber(($notices->currentPage() - 1) * $notices->perPage() + $loop->iteration) }}
                                </td>
                                <td>{{ $notice->topic }}</td>
                                <td>{{ $notice->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination Links -->
                Pagination Links:
                @if ($notices->hasPages())
                    <ul class="pagination pagination-sm">
                        {{-- Previous Page Link --}}
                        @if ($notices->onFirstPage())
                            <li class="disabled"><span>&laquo;</span></li>
                        @else
                            <li><a href="{{ $notices->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($notices as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <li class="disabled"><span>{{ $element }}</span></li>
                            @endif

                            {{-- Array of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $notices->currentPage())
                                        <li class="active"><span>{{ $page }}</span></li>
                                    @else
                                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($notices->hasMorePages())
                            <li><a href="{{ $notices->nextPageUrl() }}" rel="next">&raquo;</a></li>
                        @else
                            <li class="disabled"><span>&raquo;</span></li>
                        @endif
                    </ul>
                @endif
                <!-- Pagination Links -->
                <div class="pagination">
                    {{ $notices->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
