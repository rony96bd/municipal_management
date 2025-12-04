@extends('front-views.templates.othe-page-header')

@section('page-body')
    <style>
        .single-post-wrapper {
            max-width: 900px;
            margin: 0 auto 40px auto;
        }

        .single-post-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .single-post-image img,
        .single-post-gallery img {
            width: 100%;
            display: block;
            object-fit: cover;
            max-height: 520px;
        }

        .single-post-gallery {
            padding: 10px 22px 0 22px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .single-post-gallery img {
            max-width: 180px;
            border-radius: 6px;
        }

        .single-post-content {
            padding: 18px 22px 24px 22px;
        }

        .single-post-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .single-post-meta {
            font-size: 13px;
            color: #888;
            margin-bottom: 14px;
        }

        .single-post-text {
            font-size: 15px;
            line-height: 1.8;
            color: #333;
            white-space: pre-wrap;
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
            <div class="single-post-wrapper">
                <div class="marb-20" style="text-align: center;">
                    <h1 style="font-size:28px;font-weight:700;margin-bottom:4px;">
                        IUGIP প্রকল্পসমূহ
                    </h1>
                    <p style="font-size:14px;color:#666;">
                        এখানে IUGIP প্রকল্পের আওতাভুক্ত একক পোস্টের বিস্তারিত তথ্য দেখানো হচ্ছে।
                    </p>
                </div>

                <div class="single-post-card">
                    @if ($post->images && $post->images->count())
                        <div class="single-post-image">
                            <img src="{{ asset($post->images->first()->image_path) }}" alt="{{ $post->title }}"
                                class="clickable-post-image">
                        </div>
                        @if ($post->images->count() > 1)
                            <div class="single-post-gallery">
                                @foreach ($post->images->slice(1) as $image)
                                    <img src="{{ asset($image->image_path) }}" alt="{{ $post->title }}"
                                        class="clickable-post-image">
                                @endforeach
                            </div>
                        @endif
                    @endif
                    <div class="single-post-content">
                        <div class="single-post-title">
                            {{ $post->title }}
                        </div>
                        <div class="single-post-meta">
                            {{ $post->created_at?->format('d M Y, h:i A') }}
                        </div>
                        <div class="single-post-text">
                            {!! nl2br(e($post->content ?? '')) !!}
                        </div>
                    </div>
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
