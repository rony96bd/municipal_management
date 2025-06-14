@extends('front-views.templates.othe-page-header')
@section('page-body')
    {{-- section --}}
    <section class="section">
        <div class="container">
            <div class="flex column gap-20">
                <h2 class="text-center">নিউজ বিস্তারিত</h2>
                <div class="flex column gap-20">
                    <div class="flex column gap-20">
                        <h3>বিষয়: {{ $news->topic }}</h3>
                        <p>{!! $news->description !!}</p>
                        @php
                            $extension = pathinfo($news->file_path, PATHINFO_EXTENSION);
                        @endphp

                        @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                            <p>
                                <img src="{{ url($news->file_path) }}" alt="Uploaded Image"
                                    style="max-width: 100%; height: auto;">
                            </p>
                        @elseif(strtolower($extension) === 'pdf')
                            <p>
                                <iframe src="{{ url($news->file_path) }}" width="100%" height="600px"></iframe>
                            </p>
                        @else
                            <p>Unsupported file type.</p>
                        @endif
                    </div>
                </div>
            </div>
    </section>
@endsection
