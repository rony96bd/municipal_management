@extends('front-views.templates.othe-page-header')

@section('page-body')
    <style>
        .posts-wrapper {
            max-width: 900px;
            margin: 0 auto 40px auto;
        }

        .post-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .post-image img {
            width: 100%;
            display: block;
            object-fit: cover;
            max-height: 420px;
        }

        .post-content {
            padding: 16px 20px 20px 20px;
        }

        .post-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .post-meta {
            font-size: 13px;
            color: #888;
            margin-bottom: 10px;
        }

        .post-text {
            font-size: 15px;
            line-height: 1.7;
            color: #333;
        }

        .post-attachment-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #b22222;
            background: #fff4f4;
            border-radius: 999px;
            padding: 4px 10px;
            margin-top: 6px;
        }

        .post-attachment-badge svg {
            width: 14px;
            height: 14px;
        }

        .post-read-more {
            display: inline-block;
            margin-top: 8px;
            font-size: 14px;
            color: #0d6efd;
            text-decoration: none;
        }

        .post-read-more:hover {
            text-decoration: underline;
        }

        /* Simple image lightbox */
        .image-lightbox-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .image-lightbox-overlay.active {
            display: flex;
        }

        .image-lightbox-overlay img {
            max-width: 90vw;
            max-height: 90vh;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.6);
        }

        .image-lightbox-close {
            position: absolute;
            top: 20px;
            right: 25px;
            font-size: 32px;
            color: #fff;
            cursor: pointer;
        }
    </style>

    <section class="section">
        <div class="container">
            <div class="posts-wrapper">
                <div class="marb-20" style="text-align: center;">
                    <h1 style="font-size:28px;font-weight:700;margin-bottom:4px;">
                        IUGIP প্রকল্পসমূহ
                    </h1>
                    <p style="font-size:14px;color:#666;">
                        এখানে IUGIP প্রকল্পের আওতাভুক্ত সকল তথ্য, অগ্রগতি ও সম্পর্কিত পোস্টগুলো প্রদর্শিত হচ্ছে।
                    </p>
                </div>

                @foreach ($posts as $post)
                    <div class="post-card">
                        @if ($post->images && $post->images->count())
                            <div class="post-image">
                                <img src="{{ asset($post->images->first()->image_path) }}" alt="{{ $post->title }}"
                                    class="clickable-post-image">
                            </div>
                            @if ($post->images->count() > 1)
                                <div class="padl-20 padr-20 padt-10 padb-0">
                                    <div class="flex row gap-10 flex-wrap">
                                        @foreach ($post->images->slice(1) as $image)
                                            <img src="{{ asset($image->image_path) }}" alt="{{ $post->title }}"
                                                class="clickable-post-image"
                                                style="max-width: 120px; border-radius:4px;">
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif
                        <div class="post-content">
                            <div class="post-title">
                                <a href="{{ url('/IUGIP-Projects/' . $post->page_url) }}">{{ $post->title }}</a>
                            </div>
                            <div class="post-meta">
                                {{ $post->created_at?->format('d M Y, h:i A') }}
                            </div>
                            <div class="post-text">
                                {!! nl2br(e(Str::limit($post->content ?? '', 220, ' ...'))) !!}
                            </div>

                            @if ($post->attachment_path)
                                <div class="mart-5">
                                    <span class="post-attachment-badge">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#b22222">
                                            <path
                                                d="M16.5 6.75V15a4.5 4.5 0 1 1-9 0V5.25a3 3 0 1 1 6 0V14a1.5 1.5 0 1 1-3 0V7.5" />
                                        </svg>
                                        <span>সংযুক্ত PDF আছে</span>
                                    </span>
                                </div>
                            @endif

                            <a class="post-read-more" href="{{ url('/IUGIP-Projects/' . $post->page_url) }}">পুরো পোস্ট
                                দেখুন</a>
                        </div>
                    </div>
                @endforeach

                <div class="pagination">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </section>

    {{-- Single simple image lightbox for this page --}}
    <div id="image-lightbox-overlay" class="image-lightbox-overlay">
        <span class="image-lightbox-close">&times;</span>
        <img id="image-lightbox-image" src="" alt="">
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('image-lightbox-overlay');
            const overlayImg = document.getElementById('image-lightbox-image');
            const closeBtn = overlay.querySelector('.image-lightbox-close');

            function openLightbox(src, alt) {
                overlayImg.src = src;
                overlayImg.alt = alt || '';
                overlay.classList.add('active');
            }

            function closeLightbox() {
                overlay.classList.remove('active');
                overlayImg.src = '';
            }

            document.body.addEventListener('click', function(e) {
                const img = e.target.closest('.clickable-post-image');
                if (img) {
                    e.preventDefault();
                    openLightbox(img.src, img.alt);
                }
            });

            closeBtn.addEventListener('click', closeLightbox);
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    closeLightbox();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeLightbox();
                }
            });
        });
    </script>
@endsection
