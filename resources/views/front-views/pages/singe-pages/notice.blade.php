@extends('front-views.templates.othe-page-header')

@section('page-body')
    <style>
        .notice-detail-wrapper {
            max-width: 960px;
            margin: 0 auto 40px auto;
        }

        .notice-top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 18px;
        }

        .notice-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 6px;
            background-color: var(--background-gray, #f2f2f2);
            color: var(--primary-color, #000325);
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            border: 1px solid rgba(0, 3, 37, 0.12);
            transition: all 0.2s ease-in-out;
        }

        .notice-back-btn:hover {
            background-color: var(--primary-color, #000325);
            color: var(--white-color, #ffffff);
            border-color: var(--primary-color, #000325);
        }

        .notice-back-btn svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
        }

        .notice-breadcrumb-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            color: var(--secondary-color, #3361d9);
            background-color: rgba(51, 97, 217, 0.08);
            border: 1px solid rgba(51, 97, 217, 0.2);
            padding: 6px 14px;
            border-radius: 999px;
            font-weight: 500;
        }

        .notice-detail-card {
            background: var(--white-color, #ffffff);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 3, 37, 0.08);
            border: 1px solid rgba(0, 3, 37, 0.08);
            overflow: hidden;
        }

        .notice-card-header {
            background: linear-gradient(135deg, var(--primary-color, #000325) 0%, var(--secondary-color, #3361d9) 100%);
            color: var(--white-color, #ffffff);
            padding: 26px 28px;
            position: relative;
        }

        .notice-header-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.16);
            color: var(--white-color, #ffffff);
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 13px;
            margin-bottom: 12px;
            backdrop-filter: blur(4px);
        }

        .notice-header-tag svg {
            width: 15px;
            height: 15px;
            stroke: currentColor;
        }

        .notice-card-title {
            font-size: clamp(20px, 2.2vw, 26px);
            font-weight: 600;
            line-height: 1.45;
            margin: 0 0 14px 0;
            color: var(--white-color, #ffffff);
        }

        .notice-meta-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 18px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.88);
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            padding-top: 12px;
        }

        .notice-meta-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .notice-meta-item svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            opacity: 0.9;
        }

        .notice-card-body {
            padding: 26px 28px 30px 28px;
        }

        .notice-description-box {
            background-color: var(--background-gray, #f2f2f2);
            border-left: 4px solid var(--secondary-color, #3361d9);
            border-radius: 0 8px 8px 0;
            padding: 18px 22px;
            margin-bottom: 24px;
            color: var(--paragraph-color, #333333);
            font-size: 16px;
            line-height: 1.8;
        }

        .notice-description-box p {
            margin: 0 0 10px 0;
        }

        .notice-description-box p:last-child {
            margin-bottom: 0;
        }

        .notice-attachment-section {
            border: 1px solid rgba(0, 3, 37, 0.12);
            border-radius: 8px;
            overflow: hidden;
            background-color: #fafbfc;
        }

        .notice-attachment-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            padding: 14px 20px;
            background-color: var(--background-gray, #f2f2f2);
            border-bottom: 1px solid rgba(0, 3, 37, 0.1);
        }

        .notice-attachment-label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            font-weight: 600;
            color: var(--primary-color, #000325);
        }

        .notice-attachment-label svg {
            width: 20px;
            height: 20px;
            stroke: var(--secondary-color, #3361d9);
        }

        .notice-attachment-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .notice-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }

        .notice-btn svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
        }

        .notice-btn-outline {
            background-color: var(--white-color, #ffffff);
            color: var(--secondary-color, #3361d9);
            border: 1px solid var(--secondary-color, #3361d9);
        }

        .notice-btn-outline:hover {
            background-color: var(--secondary-color, #3361d9);
            color: var(--white-color, #ffffff);
        }

        .notice-btn-primary {
            background-color: var(--primary-color, #000325);
            color: var(--white-color, #ffffff);
            border: 1px solid var(--primary-color, #000325);
        }

        .notice-btn-primary:hover {
            background-color: var(--secondary-color, #3361d9);
            border-color: var(--secondary-color, #3361d9);
            color: var(--white-color, #ffffff);
        }

        .notice-pdf-viewer {
            width: 100%;
            height: 820px;
            border: none;
            display: block;
            background-color: #525659;
        }

        .notice-image-viewer {
            padding: 20px;
            text-align: center;
            background-color: var(--white-color, #ffffff);
        }

        .notice-image-viewer img {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            cursor: zoom-in;
        }

        .notice-file-fallback {
            padding: 36px 20px;
            text-align: center;
            background-color: var(--white-color, #ffffff);
        }

        .notice-file-fallback p {
            color: var(--paragraph-color, #333333);
            margin-bottom: 16px;
            font-size: 15px;
        }

        /* Lightbox for notice images */
        .notice-lightbox-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.85);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .notice-lightbox-overlay.active {
            display: flex;
        }

        .notice-lightbox-overlay img {
            max-width: 92vw;
            max-height: 92vh;
            border-radius: 6px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.6);
        }

        .notice-lightbox-close {
            position: absolute;
            top: 20px;
            right: 28px;
            font-size: 36px;
            color: #fff;
            cursor: pointer;
            line-height: 1;
        }

        @media (max-width: 768px) {
            .notice-card-header {
                padding: 20px 18px;
            }

            .notice-card-body {
                padding: 18px;
            }

            .notice-pdf-viewer {
                height: 520px;
            }

            .notice-attachment-toolbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .notice-attachment-actions {
                width: 100%;
            }

            .notice-btn {
                flex: 1;
                justify-content: center;
            }
        }
    </style>

    @php
        $hasFile = !empty($notice->file_path);
        $extension = $hasFile ? strtolower(pathinfo($notice->file_path, PATHINFO_EXTENSION)) : '';
        $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
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
            <div class="notice-detail-wrapper">
                {{-- Top Action & Breadcrumb Bar --}}
                <div class="notice-top-bar">
                    <a href="{{ route('notices') }}" class="notice-back-btn">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 19L8 12L15 5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span>সকল নোটিশ দেখুন</span>
                    </a>
                </div>

                {{-- Main Notice Card --}}
                <div class="notice-detail-card">
                    {{-- Header Banner --}}
                    <div class="notice-card-header">
                        <div class="notice-header-tag">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M13.73 21a2 2 0 0 1-3.46 0" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <span>নোটিশ বোর্ড</span>
                        </div>

                        <h2 class="notice-card-title">
                            বিষয়: {{ $notice->topic }}
                        </h2>

                        <div class="notice-meta-row">
                            @if ($formattedDate)
                                <div class="notice-meta-item">
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
                                <div class="notice-meta-item">
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
                    <div class="notice-card-body">
                        @if ($cleanDescription !== '')
                            <div class="notice-description-box">
                                {!! $notice->description !!}
                            </div>
                        @endif

                        @if ($hasFile)
                            <div class="notice-attachment-section">
                                <div class="notice-attachment-toolbar">
                                    <div class="notice-attachment-label">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <polyline points="14 2 14 8 20 8" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span>সংযুক্ত বিজ্ঞপ্তি ({{ strtoupper($extension) }})</span>
                                    </div>

                                    <div class="notice-attachment-actions">
                                        <a href="{{ asset($notice->file_path) }}" target="_blank" rel="noopener"
                                            class="notice-btn notice-btn-outline">
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
                                            class="notice-btn notice-btn-primary">
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
                                    <div class="notice-image-viewer">
                                        <img src="{{ asset($notice->file_path) }}" alt="{{ $notice->topic }}"
                                            class="clickable-notice-image">
                                    </div>
                                @elseif ($isPdf)
                                    <iframe src="{{ asset($notice->file_path) }}" class="notice-pdf-viewer"
                                        title="{{ $notice->topic }}"></iframe>
                                @else
                                    <div class="notice-file-fallback">
                                        <p>এই সংযুক্ত ফাইলটি ({{ strtoupper($extension) }}) দেখতে বা সংরক্ষণ করতে নিচের বাটনে ক্লিক করুন।</p>
                                        <a href="{{ asset($notice->file_path) }}" download
                                            class="notice-btn notice-btn-primary">
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

    @if ($isImage)
        <div id="notice-lightbox-overlay" class="notice-lightbox-overlay">
            <span class="notice-lightbox-close">&times;</span>
            <img id="notice-lightbox-image" src="" alt="">
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const overlay = document.getElementById('notice-lightbox-overlay');
                const overlayImg = document.getElementById('notice-lightbox-image');
                const closeBtn = overlay.querySelector('.notice-lightbox-close');

                document.body.addEventListener('click', function(e) {
                    const img = e.target.closest('.clickable-notice-image');
                    if (img) {
                        overlayImg.src = img.src;
                        overlayImg.alt = img.alt || '';
                        overlay.classList.add('active');
                    }
                });

                closeBtn.addEventListener('click', function() {
                    overlay.classList.remove('active');
                    overlayImg.src = '';
                });

                overlay.addEventListener('click', function(e) {
                    if (e.target === overlay) {
                        overlay.classList.remove('active');
                        overlayImg.src = '';
                    }
                });

                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        overlay.classList.remove('active');
                        overlayImg.src = '';
                    }
                });
            });
        </script>
    @endif
@endsection
