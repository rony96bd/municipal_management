@extends('front-views.templates.othe-page-header')

@section('page-body')
<div class="container py-4" style="max-width: 900px; margin: 24px auto; padding: 0 16px;">
    <h2 style="margin-bottom: 16px;">অনুসন্ধানের ফলাফল @if ($query !== ''): "{{ $query }}"@endif</h2>

    @php
        $total = $results['notices']->count() + $results['news']->count() + $results['pages']->count();
    @endphp

    @if ($query === '')
        <p>অনুগ্রহ করে অনুসন্ধানের জন্য কিছু লিখুন।</p>
    @elseif ($total === 0)
        <p>"{{ $query }}" এর জন্য কোনো ফলাফল পাওয়া যায়নি।</p>
    @else
        @if ($results['notices']->isNotEmpty())
            <h3>নোটিশ</h3>
            <ul>
                @foreach ($results['notices'] as $notice)
                    <li>
                        <a href="{{ route('notice-details', data_get($notice, 'page_url') ?? data_get($notice, 'id')) }}">{{ data_get($notice, 'topic') }}</a>
                    </li>
                @endforeach
            </ul>
        @endif

        @if ($results['news']->isNotEmpty())
            <h3>সংবাদ</h3>
            <ul>
                @foreach ($results['news'] as $item)
                    <li>
                        <a href="{{ route('news-details', data_get($item, 'page_url') ?? data_get($item, 'id')) }}">{{ data_get($item, 'topic') }}</a>
                    </li>
                @endforeach
            </ul>
        @endif

        @if ($results['pages']->isNotEmpty())
            <h3>পাতা</h3>
            <ul>
                @foreach ($results['pages'] as $page)
                    <li>
                        <a href="{{ route('page-details', data_get($page, 'page_url') ?? data_get($page, 'id')) }}">{{ data_get($page, 'page_name') }}</a>
                    </li>
                @endforeach
            </ul>
        @endif
    @endif
</div>
@endsection
