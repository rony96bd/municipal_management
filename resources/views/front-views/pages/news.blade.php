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
                <h1>News</h1>
            </div>
            <div class="search-form">
                <form action="{{ route('news.list') }}" method="GET">
                    <input type="text" name="search" placeholder="Search news..." value="{{ request('search') }}">
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
                        @foreach ($news as $newsItem)
                            <tr>
                                <td>{{ englishToBanglaNumber($loop->iteration + ($news->currentPage() - 1) * $news->perPage()) }}
                                </td>
                                <td><a href="{{ url('/') }}/news/{{ $newsItem->page_url }}">{{ $newsItem->topic }}</a>
                                </td>
                                <td>{{ $newsItem->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination Links -->
                <div class="pagination">
                    {{ $news->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
