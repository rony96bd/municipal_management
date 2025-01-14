@extends('dashboard.templates.main')
@section('dash-body')
    <div class="media-wrapper flex column gap-20">
        <div class="media-upload">
            @include('dashboard.forms.media.media-upload')
        </div>
        <div class="media-wrapper">
            {{-- Media Uploads --}}
            <div class="single-media-uploads padar-10">
                @forelse ($medias as $media)
                    <div class="media-item position-relative">
                        @if (str_starts_with($media->mime_type, 'image/'))
                            <a href="{{ url('/' . $media->file_path) }}" class="anchor mediafile"
                                data-file="{{ $media }}">
                                <img src="{{ url('/' . $media->file_path) }}" alt="Media Uploads" />
                            </a>
                        @elseif ($media->mime_type === 'application/pdf')
                            <a href="{{ url('/' . $media->file_path) }}" class="anchor mediafile"
                                data-file="{{ $media }}">
                                <div class="media-icon">PDF</div>
                            </a>
                        @elseif (in_array($media->mime_type, [
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            ]))
                            <a href="{{ url('/' . $media->file_path) }}" class="anchor mediafile"
                                data-file="{{ $media }}">
                                <div class="media-icon">DOC</div>
                            </a>
                        @else
                            <p class="color-warning">Unsupported file type</p>
                        @endif
                        <form action="{{ route('media-destroy', $media->id) }}" method="POST"
                            onsubmit="return confirm('আপনি কি নিশ্চিতভাবে মুছে ফেলতে চান?');" style="display:inline;"
                            class="position-absolute top-0 right-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-sidebar">X</button>
                        </form>
                    </div>
                @empty
                    <p class="color-warning">কোন ফাইল আপলোড করা নেয়</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Popup Modal --}}
    <div id="mediaPopup" class="modal hidden">
        <span class="modal-backdrop"></span>
        <div class="modal-content flex row gap-0 position-relative">
            <div class="media-preview">
                <img id="mediaImage" src="" alt="Media Preview" class="hidden" />
                <iframe id="mediaPDF" class="hidden"></iframe>
            </div>
            <div class="navbox position-relative flex column">
                <button class="close-btn position-absolute top-20 right-20">&times;</button>
                <div class="media-details flex column gap-5 jfs-ais">
                    <p><strong>File Name:</strong>
                        <span id="mediaFileName"></span>
                    </p>
                    <p><strong>File Link:</strong></p>
                    <p id="mediaFileLink"></p>
                    <div class="flex row gap-10">
                        <button id="copyLinkBtn"
                            class="padar-5 border-solid border-1px border-color-primary bradius-6px">Copy</button>
                    </div>

                </div>
                <div class="modal-navigation mart-auto full-width flex row jsb-ace">
                    <button id="prevMedia" class="btn">Previous</button>
                    <button id="nextMedia" class="btn">Next</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('mediaPopup');
            const mediaImage = document.getElementById('mediaImage');
            const mediaPDF = document.getElementById('mediaPDF');
            const mediaFileName = document.getElementById('mediaFileName');
            const mediaFileLink = document.getElementById('mediaFileLink');
            const copyLinkBtn = document.getElementById('copyLinkBtn');
            const closeBtn = document.querySelector('.close-btn');
            const prevMedia = document.getElementById('prevMedia');
            const nextMedia = document.getElementById('nextMedia');

            const placeholderMessage = document.createElement('p');
            placeholderMessage.id = 'placeholderMessage';
            placeholderMessage.textContent = 'No preview available for this file.';
            placeholderMessage.classList.add('hidden'); // Initially hidden
            modal.querySelector('.media-preview').appendChild(placeholderMessage);

            let currentIndex = 0;
            const mediaFiles = Array.from(document.querySelectorAll('.mediafile'));

            function updateModal(index) {
                const file = JSON.parse(mediaFiles[index].dataset.file);
                const mimeType = file.mime_type;

                mediaFileName.textContent = file.file_name;
                mediaFileLink.textContent = `${window.location.origin}/${file.file_path}`;

                // Reset all views
                mediaImage.classList.add('hidden');
                mediaPDF.classList.add('hidden');
                placeholderMessage.classList.add('hidden');

                if (mimeType.startsWith('image/')) {
                    mediaImage.src = `${window.location.origin}/${file.file_path}`;
                    mediaImage.classList.remove('hidden');
                } else if (mimeType === 'application/pdf') {
                    mediaPDF.src = `${window.location.origin}/${file.file_path}`;
                    mediaPDF.classList.remove('hidden');
                } else if (
                    mimeType === 'application/msword' ||
                    mimeType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                ) {
                    placeholderMessage.classList.remove('hidden');
                }

                modal.classList.remove('hidden');
            }

            mediaFiles.forEach((media, index) => {
                media.addEventListener('click', (e) => {
                    e.preventDefault();
                    currentIndex = index;
                    updateModal(currentIndex);
                });
            });

            copyLinkBtn.addEventListener('click', () => {
                const linkText = mediaFileLink.textContent;
                navigator.clipboard.writeText(linkText).then(() => {
                    alert('Link copied!');
                });
            });

            closeBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
            });

            prevMedia.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + mediaFiles.length) % mediaFiles.length;
                updateModal(currentIndex);
            });

            nextMedia.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % mediaFiles.length;
                updateModal(currentIndex);
            });
        });
    </script>
@endsection
