@extends('front-views.templates.othe-page-header')
@section('page-body')
    {{-- section --}}
    <section class="section">
        <div class="container">
            <div class="flex column gap-20">
                <h2 class="text-center">বিজ্ঞপ্তি</h2>
                <div class="flex column gap-20">
                    <div class="flex column gap-20">
                        <h3>বিষয়: {{ $notice->topic }}</h3>
                        <p>{!! $notice->description !!}</p>
                        @php
                            $extension = pathinfo($notice->file_path, PATHINFO_EXTENSION);
                        @endphp

                        @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                            <style>
                                .img-magnifier-container {
                                    position: relative;
                                }

                                .img-magnifier-glass {
                                    position: absolute;
                                    border: 3px solid #000;
                                    border-radius: 50%;
                                    cursor: none;
                                    width: 100px;
                                    height: 100px;
                                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
                                    background-repeat: no-repeat;
                                    background-position: center;
                                    background-size: 200%;
                                    z-index: 1000;
                                    display: none;
                                }
                            </style>

                            <div class="img-magnifier-container">
                                <img id="image" src="{{ url($notice->file_path) }}" alt="Uploaded Image"
                                    style="max-width: 100%; height: auto;">
                                <div id="magnifier" class="img-magnifier-glass"></div>
                            </div>
                        @elseif(strtolower($extension) === 'pdf')
                            <p>
                                <iframe src="{{ url($notice->file_path) }}" width="100%" height="600px"></iframe>
                            </p>
                        @else
                            <p>Unsupported file type.</p>
                        @endif

                    </div>
                </div>
            </div>
    </section>
@endsection
