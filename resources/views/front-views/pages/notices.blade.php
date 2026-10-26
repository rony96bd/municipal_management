@extends('front-views.templates.othe-page-header')

@section('page-body')
    <style>
        .notices-page-wrapper {
            max-width: 1060px;
            margin: 0 auto 40px auto;
        }

        /* Header & Search Banner */
        .notices-hero-card {
            background: linear-gradient(135deg, var(--primary-color, #000325) 0%, var(--secondary-color, #3361d9) 100%);
            color: var(--white-color, #ffffff);
            border-radius: 10px;
            padding: 28px 30px;
            margin-bottom: 24px;
            box-shadow: 0 4px 20px rgba(0, 3, 37, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .notices-hero-info {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .notices-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            width: max-content;
            background: rgba(255, 255, 255, 0.16);
            color: var(--white-color, #ffffff);
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 13px;
        }

        .notices-hero-badge svg {
            width: 15px;
            height: 15px;
            stroke: currentColor;
        }

        .notices-hero-title {
            font-size: clamp(22px, 2.4vw, 28px);
            font-weight: 700;
            margin: 0;
            color: var(--white-color, #ffffff);
        }

        .notices-hero-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.85);
            margin: 0;
        }

        /* Search Form */
        .notices-search-form {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.12);
            padding: 6px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.22);
            backdrop-filter: blur(6px);
            min-width: 320px;
            max-width: 100%;
        }

        .notices-search-input {
            flex: 1;
            border: none;
            background: var(--white-color, #ffffff);
            color: var(--paragraph-color, #333333);
            padding: 10px 14px;
            border-radius: 6px;
            font-size: 15px;
            min-width: 180px;
        }

        .notices-search-input::placeholder {
            color: #777;
        }

        .notices-search-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 18px;
            background-color: var(--primary-color, #000325);
            color: var(--white-color, #ffffff);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            white-space: nowrap;
        }

        .notices-search-btn:hover {
            background-color: var(--secondary-color, #3361d9);
        }

        .notices-search-btn svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
        }

        .notices-reset-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 12px;
            background-color: rgba(231, 76, 60, 0.9);
            color: var(--white-color, #ffffff);
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s ease-in-out;
            white-space: nowrap;
        }

        .notices-reset-btn:hover {
            background-color: #c0392b;
        }

        /* Table Card */
        .notices-list-card {
            background: var(--white-color, #ffffff);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 3, 37, 0.07);
            border: 1px solid rgba(0, 3, 37, 0.08);
            overflow: hidden;
        }

        .notices-table {
            width: 100%;
            border-collapse: collapse;
        }

        .notices-table thead tr {
            background-color: var(--primary-color, #000325);
            color: var(--white-color, #ffffff);
        }

        .notices-table th {
            padding: 15px 20px;
            text-align: left;
            font-size: 16px;
            font-weight: 600;
            border: none;
        }

        .notices-table th.col-sl {
            width: 85px;
            text-align: center;
        }

        .notices-table th.col-date {
            width: 190px;
        }

        .notices-table th.col-action {
            width: 210px;
            text-align: right;
        }

        .notices-table tbody tr {
            border-bottom: 1px solid rgba(0, 3, 37, 0.08);
            transition: background-color 0.2s ease-in-out;
        }

        .notices-table tbody tr:nth-child(even) {
            background-color: rgba(242, 242, 242, 0.45);
        }

        .notices-table tbody tr:hover {
            background-color: rgba(51, 97, 217, 0.06);
        }

        .notices-table tbody tr:last-child {
            border-bottom: none;
        }

        .notices-table td {
            padding: 16px 20px;
            vertical-align: middle;
            color: var(--paragraph-color, #333333);
            font-size: 16px;
        }

        .notice-sl-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 8px;
            border-radius: 8px;
            background-color: rgba(51, 97, 217, 0.1);
            color: var(--secondary-color, #3361d9);
            font-weight: 700;
            font-size: 15px;
        }

        .notice-topic-cell {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .notice-topic-icon {
            width: 36px;
            height: 36px;
            min-width: 36px;
            border-radius: 8px;
            background-color: rgba(0, 3, 37, 0.06);
            color: var(--primary-color, #000325);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 2px;
        }

        .notice-topic-icon svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
        }

        .notice-topic-content {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .notice-topic-link {
            color: var(--primary-color, #000325);
            font-weight: 600;
            font-size: 17px;
            text-decoration: none;
            line-height: 1.45;
            transition: color 0.2s ease-in-out;
        }

        .notice-topic-link:hover {
            color: var(--secondary-color, #3361d9);
        }

        .notice-file-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            width: max-content;
            font-size: 12px;
            font-weight: 500;
            padding: 2px 8px;
            border-radius: 4px;
            background-color: rgba(51, 97, 217, 0.1);
            color: var(--secondary-color, #3361d9);
        }

        .notice-date-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            color: #555;
        }

        .notice-date-badge svg {
            width: 15px;
            height: 15px;
            stroke: var(--secondary-color, #3361d9);
        }

        .notice-action-group {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
        }

        .notice-action-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
            white-space: nowrap;
        }

        .notice-action-btn svg {
            width: 15px;
            height: 15px;
            stroke: currentColor;
        }

        .notice-view-btn {
            background-color: var(--primary-color, #000325);
            color: var(--white-color, #ffffff);
        }

        .notice-view-btn:hover {
            background-color: var(--secondary-color, #3361d9);
            color: var(--white-color, #ffffff);
        }

        .notice-download-btn {
            background-color: rgba(51, 97, 217, 0.1);
            color: var(--secondary-color, #3361d9);
            border: 1px solid rgba(51, 97, 217, 0.25);
            padding: 7px 10px;
        }

        .notice-download-btn:hover {
            background-color: var(--secondary-color, #3361d9);
            color: var(--white-color, #ffffff);
        }

        /* Empty State */
        .notices-empty-state {
            padding: 48px 20px;
            text-align: center;
            color: #666;
        }

        .notices-empty-state svg {
            width: 48px;
            height: 48px;
            stroke: var(--secondary-color, #3361d9);
            opacity: 0.6;
            margin-bottom: 12px;
        }

        .notices-empty-state h3 {
            font-size: 20px;
            color: var(--primary-color, #000325);
            margin-bottom: 6px;
        }

        /* Pagination */
        .notices-pagination-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            padding: 18px 22px;
            background-color: var(--background-gray, #f2f2f2);
            border-top: 1px solid rgba(0, 3, 37, 0.08);
        }

        .notices-pagination-info {
            font-size: 14px;
            color: #555;
        }

        .notices-pagination {
            display: flex;
            align-items: center;
            gap: 6px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .notices-pagination li a,
        .notices-pagination li span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 12px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            background-color: var(--white-color, #ffffff);
            color: var(--primary-color, #000325);
            border: 1px solid rgba(0, 3, 37, 0.12);
            transition: all 0.2s ease-in-out;
        }

        .notices-pagination li a:hover {
            background-color: var(--secondary-color, #3361d9);
            color: var(--white-color, #ffffff);
            border-color: var(--secondary-color, #3361d9);
        }

        .notices-pagination li.active span {
            background-color: var(--primary-color, #000325);
            color: var(--white-color, #ffffff);
            border-color: var(--primary-color, #000325);
        }

        .notices-pagination li.disabled span {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Responsive Mobile Cards */
        @media (max-width: 768px) {
            .notices-hero-card {
                padding: 20px 18px;
            }

            .notices-search-form {
                width: 100%;
                min-width: 0;
                flex-wrap: wrap;
            }

            .notices-table thead {
                display: none;
            }

            .notices-table,
            .notices-table tbody,
            .notices-table tr,
            .notices-table td {
                display: block;
                width: 100%;
            }

            .notices-table tbody tr {
                padding: 16px;
            }

            .notices-table td {
                padding: 6px 0;
            }

            .notices-table td.col-sl {
                display: none;
            }

            .notice-action-group {
                justify-content: flex-start;
                margin-top: 8px;
            }
        }
    </style>

    <section class="section">
        <div class="container">
            <div class="notices-page-wrapper">
                {{-- Hero Header & Search Bar --}}
                <div class="notices-hero-card">
                    <div class="notices-hero-info">
                        <span class="notices-hero-badge">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M13.73 21a2 2 0 0 1-3.46 0" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <span>দাফতরিক বিজ্ঞপ্তি</span>
                        </span>
                        <h1 class="notices-hero-title">নোটিশ বোর্ড</h1>
                        <p class="notices-hero-subtitle">পৌরসভার সকল দাফতরিক নোটিশ, বিজ্ঞপ্তি ও আদেশসমূহ</p>
                    </div>

                    <form action="{{ route('notices') }}" method="GET" class="notices-search-form">
                        <input type="text" name="search" class="notices-search-input"
                            placeholder="নোটিশের বিষয় লিখে খুঁজুন..." value="{{ request('search') }}">
                        <button type="submit" class="notices-search-btn">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="11" cy="11" r="8" stroke-width="2" />
                                <line x1="21" y1="21" x2="16.65" y2="16.65" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                            <span>খুঁজুন</span>
                        </button>
                        @if (request()->filled('search'))
                            <a href="{{ route('notices') }}" class="notices-reset-btn" title="সার্চ রিসেট করুন">
                                রিসেট
                            </a>
                        @endif
                    </form>
                </div>

                {{-- Notices Table Card --}}
                <div class="notices-list-card">
                    @if ($notices->count() > 0)
                        <table class="notices-table">
                            <thead>
                                <tr>
                                    <th class="col-sl">ক্রমিক</th>
                                    <th>নোটিশের বিষয়</th>
                                    <th class="col-date">প্রকাশের তারিখ</th>
                                    <th class="col-action">অ্যাকশন</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notices as $notice)
                                    @php
                                        $serial = ($notices->currentPage() - 1) * $notices->perPage() + $loop->iteration;
                                        $serialBangla = englishToBanglaNumber(str_pad($serial, 2, '0', STR_PAD_LEFT));

                                        $formattedDate = '';
                                        if (!empty($notice->created_at)) {
                                            $day = englishToBanglaNumber($notice->created_at->format('d'));
                                            $month = convertMonthToBangla((int) $notice->created_at->format('n'));
                                            $year = englishToBanglaNumber($notice->created_at->format('Y'));
                                            $formattedDate = "{$day} {$month}, {$year}";
                                        }

                                        $hasFile = !empty($notice->file_path);
                                        $ext = $hasFile ? strtoupper(pathinfo($notice->file_path, PATHINFO_EXTENSION)) : '';
                                    @endphp
                                    <tr>
                                        <td class="col-sl" style="text-align: center;">
                                            <span class="notice-sl-badge">{{ $serialBangla }}</span>
                                        </td>
                                        <td>
                                            <div class="notice-topic-cell">
                                                <div class="notice-topic-icon">
                                                    <svg viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <polyline points="14 2 14 8 20 8" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </div>
                                                <div class="notice-topic-content">
                                                    <a href="{{ url('/notice/' . $notice->page_url) }}"
                                                        class="notice-topic-link">
                                                        {{ $notice->topic }}
                                                    </a>
                                                    @if ($hasFile)
                                                        <span class="notice-file-pill">
                                                            সংযুক্তি: {{ $ext ?: 'FILE' }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($formattedDate)
                                                <span class="notice-date-badge">
                                                    <svg viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <rect x="3" y="4" width="18" height="18" rx="2"
                                                            ry="2" stroke-width="2" />
                                                        <line x1="16" y1="2" x2="16" y2="6"
                                                            stroke-width="2" stroke-linecap="round" />
                                                        <line x1="8" y1="2" x2="8" y2="6"
                                                            stroke-width="2" stroke-linecap="round" />
                                                        <line x1="3" y1="10" x2="21" y2="10"
                                                            stroke-width="2" />
                                                    </svg>
                                                    <span>{{ $formattedDate }}</span>
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="notice-action-group">
                                                @if ($hasFile)
                                                    <a href="{{ asset($notice->file_path) }}" download
                                                        class="notice-action-btn notice-download-btn"
                                                        title="সংযুক্ত ফাইল ডাউনলোড করুন">
                                                        <svg viewBox="0 0 24 24" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                            <polyline points="7 10 12 15 17 10" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                            <line x1="12" y1="15" x2="12" y2="3"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    </a>
                                                @endif
                                                <a href="{{ url('/notice/' . $notice->page_url) }}"
                                                    class="notice-action-btn notice-view-btn">
                                                    <span>বিস্তারিত</span>
                                                    <svg viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M9 18l6-6-6-6" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Pagination Footer --}}
                        @if ($notices->hasPages())
                            <div class="notices-pagination-wrapper">
                                <div class="notices-pagination-info">
                                    মোট {{ englishToBanglaNumber($notices->total()) }} টি নোটিশের মধ্যে
                                    {{ englishToBanglaNumber($notices->firstItem()) }} -
                                    {{ englishToBanglaNumber($notices->lastItem()) }} দেখানো হচ্ছে
                                </div>
                                <ul class="notices-pagination">
                                    {{-- Previous Page Link --}}
                                    @if ($notices->onFirstPage())
                                        <li class="disabled"><span>&laquo; পূর্ববর্তী</span></li>
                                    @else
                                        <li>
                                            <a href="{{ $notices->appends(request()->query())->previousPageUrl() }}"
                                                rel="prev">&laquo; পূর্ববর্তী</a>
                                        </li>
                                    @endif

                                    {{-- Page Numbers --}}
                                    @for ($page = 1; $page <= $notices->lastPage(); $page++)
                                        @if ($page == $notices->currentPage())
                                            <li class="active"><span>{{ englishToBanglaNumber($page) }}</span></li>
                                        @elseif (
                                            $page == 1 ||
                                                $page == $notices->lastPage() ||
                                                abs($page - $notices->currentPage()) <= 2)
                                            <li>
                                                <a
                                                    href="{{ $notices->appends(request()->query())->url($page) }}">{{ englishToBanglaNumber($page) }}</a>
                                            </li>
                                        @elseif (abs($page - $notices->currentPage()) == 3)
                                            <li class="disabled"><span>...</span></li>
                                        @endif
                                    @endfor

                                    {{-- Next Page Link --}}
                                    @if ($notices->hasMorePages())
                                        <li>
                                            <a href="{{ $notices->appends(request()->query())->nextPageUrl() }}"
                                                rel="next">পরবর্তী &raquo;</a>
                                        </li>
                                    @else
                                        <li class="disabled"><span>পরবর্তী &raquo;</span></li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                    @else
                        <div class="notices-empty-state">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke-width="1.5" />
                                <line x1="12" y1="8" x2="12" y2="12" stroke-width="1.5"
                                    stroke-linecap="round" />
                                <line x1="12" y1="16" x2="12.01" y2="16" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                            <h3>কোনো নোটিশ পাওয়া যায়নি</h3>
                            <p>
                                @if (request()->filled('search'))
                                    "{{ request('search') }}" বিষয়ে কোনো নোটিশ খুঁজে পাওয়া যায়নি।
                                @else
                                    বর্তমানে কোনো প্রকাশিত নোটিশ নেই।
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
