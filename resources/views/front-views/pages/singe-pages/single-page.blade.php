@extends('front-views.templates.othe-page-header')

@section('page-body')
    <link rel="stylesheet" href="{{ asset('css/detail-card.css') }}?v={{ filemtime(public_path('css/detail-card.css')) }}">

    @php
        $extension = $page->file_path ? strtolower(pathinfo($page->file_path, PATHINFO_EXTENSION)) : '';
        $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true);
        $isPdf = $extension === 'pdf';
        $hasFile = !empty($page->file_path);

        $bnDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        $enDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $dateSource = $page->updated_at ?? $page->created_at;
        $formattedDate = $dateSource
            ? str_replace($enDigits, $bnDigits, $dateSource->format('d/m/Y'))
            : null;

        $cleanContent = \App\Support\HtmlSanitizer::clean($page->page_data);
    @endphp

    <section class="section">
        <div class="container">
            <div class="detail-wrapper">
                {{-- Top Navigation Bar --}}
                <div class="detail-top-bar">
                    <a href="{{ route('homepage') }}" class="detail-back-btn">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 12H5M12 19l-7-7 7-7" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <span>মূল পাতায় ফিরে যান</span>
                    </a>

                    <span class="detail-breadcrumb-badge">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            style="width:15px;height:15px;stroke:currentColor;">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <polyline points="14 2 14 8 20 8" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <span>পৌরসভার তথ্য পাতা</span>
                    </span>
                </div>

                {{-- Main Page Card --}}
                <div class="detail-card">
                    {{-- Header Banner --}}
                    <div class="detail-card-header">
                        <div class="detail-header-tag">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span>তথ্য ও নথিপত্র</span>
                        </div>

                        <h2 class="detail-card-title">{{ $page->page_name }}</h2>

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
                                    <span>হালনাগাদ: {{ $formattedDate }}</span>
                                </div>
                            @endif

                            @if ($hasFile)
                                <div class="detail-meta-item">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span>সংযুক্ত নথি: {{ strtoupper($extension ?: 'FILE') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="detail-card-body">
                        @if ($cleanContent !== '')
                            <div class="detail-content-box">
                                {!! $cleanContent !!}
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
                                        <span>সংযুক্ত নথি ({{ strtoupper($extension ?: 'FILE') }})</span>
                                    </div>

                                    <div class="detail-attachment-actions">
                                        <a href="{{ asset($page->file_path) }}" target="_blank" rel="noopener"
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

                                        <a href="{{ asset($page->file_path) }}" download
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
                                        <img src="{{ asset($page->file_path) }}" alt="{{ $page->page_name }}"
                                            class="clickable-detail-image">
                                    </div>
                                @elseif ($isPdf)
                                    <iframe src="{{ asset($page->file_path) }}" class="detail-pdf-viewer"
                                        title="{{ $page->page_name }}"></iframe>
                                @else
                                    <div class="detail-file-fallback">
                                        <p>এই সংযুক্ত ফাইলটি ({{ strtoupper($extension ?: 'FILE') }}) দেখতে বা সংরক্ষণ করতে নিচের বাটনে ক্লিক করুন।</p>
                                        <a href="{{ asset($page->file_path) }}" download
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
                        @elseif ($cleanContent === '')
                            <p style="text-align: center; color: #777; padding: 20px 0;">
                                এই পাতায় কোনো অতিরিক্ত বিবরণ বা সংযুক্ত ফাইল যুক্ত করা হয়নি।
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

    <script src="{{ asset('js/detail-lightbox.js') }}?v={{ filemtime(public_path('js/detail-lightbox.js')) }}" defer></script>
@endsection
