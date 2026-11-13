@extends('front-views.templates.othe-page-header')

@section('page-body')
    @include('front-views.templates.detail-card-styles')

    @php
        $hasFile = !empty($notice->file_path);
        $extension = $hasFile ? strtolower(pathinfo($notice->file_path, PATHINFO_EXTENSION)) : '';
        $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true);
        $isPdf = $extension === 'pdf';

        $formattedDate = '';
        if (!empty($notice->created_at)) {
            $day = englishToBanglaNumber($notice->created_at->format('d'));
            $month = convertMonthToBangla((int) $notice->created_at->format('n'));
            $year = englishToBanglaNumber($notice->created_at->format('Y'));
            $formattedDate = "{$day} {$month}, {$year}";
        }

        $cleanDescription = trim(strip_tags($notice->description ?? ''));
    @endphp

    <section class="section">
        <div class="container">
            <div class="detail-wrapper">
                {{-- Top Action & Breadcrumb Bar --}}
                <div class="detail-top-bar">
                    <a href="{{ route('notices') }}" class="detail-back-btn">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 19L8 12L15 5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span>সকল নোটিশ দেখুন</span>
                    </a>
                </div>

                {{-- Main Notice Card --}}
                <div class="detail-card">
                    {{-- Header Banner --}}
                    <div class="detail-card-header">
                        <div class="detail-header-tag">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M13.73 21a2 2 0 0 1-3.46 0" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <span>নোটিশ বোর্ড</span>
                        </div>

                        <h2 class="detail-card-title">
                            বিষয়: {{ $notice->topic }}
                        </h2>

                        <div class="detail-meta-row">
                            @if ($formattedDate)
                                <div class="detail-meta-item">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"
                                            stroke-width="2" />
                                        <line x1="16" y1="2" x2="16" y2="6"
                                            stroke-width="2" stroke-linecap="round" />
                                        <line x1="8" y1="2" x2="8" y2="6"
                                            stroke-width="2" stroke-linecap="round" />
                                        <line x1="3" y1="10" x2="21" y2="10"
                                            stroke-width="2" />
                                    </svg>
                                    <span>প্রকাশের তারিখ: {{ $formattedDate }}</span>
                                </div>
                            @endif

                            @if ($hasFile)
                                <div class="detail-meta-item">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span>সংযুক্ত ফাইল: {{ strtoupper($extension ?: 'FILE') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="detail-card-body">
                        @if ($cleanDescription !== '')
                            <div class="detail-content-box">
                                {!! \App\Support\HtmlSanitizer::clean($notice->description) !!}
                            </div>
                        @endif

                        @if ($hasFile)
                            <div class="detail-attachment-section">
                                <div class="detail-attachment-toolbar">
                                    <div class="detail-attachment-label">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <polyline points="14 2 14 8 20 8" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span>সংযুক্ত বিজ্ঞপ্তি ({{ strtoupper($extension) }})</span>
                                    </div>

                                    <div class="detail-attachment-actions">
                                        <a href="{{ asset($notice->file_path) }}" target="_blank" rel="noopener"
                                            class="detail-btn detail-btn-outline">
                                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                <polyline points="15 3 21 3 21 9" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <line x1="10" y1="14" x2="21" y2="3"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <span>নতুন ট্যাবে খুলুন</span>
                                        </a>

                                        <a href="{{ asset($notice->file_path) }}" download
                                            class="detail-btn detail-btn-primary">
                                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <polyline points="7 10 12 15 17 10" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <line x1="12" y1="15" x2="12" y2="3"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <span>ডাউনলোড করুন</span>
                                        </a>
                                    </div>
                                </div>

                                @if ($isImage)
                                    <div class="detail-image-viewer">
                                        <img src="{{ asset($notice->file_path) }}" alt="{{ $notice->topic }}"
                                            class="clickable-detail-image">
                                    </div>
                                @elseif ($isPdf)
                                    <iframe src="{{ asset($notice->file_path) }}" class="detail-pdf-viewer"
                                        title="{{ $notice->topic }}"></iframe>
                                @else
                                    <div class="detail-file-fallback">
                                        <p>এই সংযুক্ত ফাইলটি ({{ strtoupper($extension) }}) দেখতে বা সংরক্ষণ করতে নিচের বাটনে ক্লিক করুন।</p>
                                        <a href="{{ asset($notice->file_path) }}" download
                                            class="detail-btn detail-btn-primary">
                                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <polyline points="7 10 12 15 17 10" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <line x1="12" y1="15" x2="12" y2="3"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <span>ফাইল ডাউনলোড করুন</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @elseif ($cleanDescription === '')
                            <p style="text-align: center; color: #777; padding: 20px 0;">
                                এই বিজ্ঞপ্তিতে কোনো অতিরিক্ত বিবরণ বা সংযুক্ত ফাইল যুক্ত করা হয়নি।
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="detail-lightbox-overlay" class="detail-lightbox-overlay">
        <span class="detail-lightbox-close">&times;</span>
        <img id="detail-lightbox-image" src="" alt="">
    </div>

    @include('front-views.templates.detail-card-scripts')
@endsection
