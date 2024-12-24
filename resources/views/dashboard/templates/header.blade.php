<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('developers.png') }}" type="image/x-icon">
    <script src="https://cdn.tiny.cloud/1/w5vu2tz4pnqfzczmcofjbcky17ok19mug2ek9jmeozezjzjt/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: [
                // Core editing features
                'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media',
                'searchreplace', 'table', 'visualblocks', 'wordcount',

            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [{
                    value: 'First.Name',
                    title: 'First Name'
                },
                {
                    value: 'Email',
                    title: 'Email'
                },
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject(
                'See docs to implement AI Assistant')),
        });
    </script>
    @include('css-js-loaders.load-css')
    @notifyCss

    <title>
        @if (empty($page_title))
            ড্যাশবোর্ড - পৌরসভা ম্যানেজমেন্ট সিস্টেম - ফরায়েজী ক্রিয়েটিভ এজেন্সি
        @else
            {{ $page_title }} - আলমডাঙ্গা পৌরসভা
        @endif
    </title>
</head>

<body>
    @include('notify::components.notify')
    <main class="dashboard-body flex column gap-0">
        {{-- Dashboard Top Nav --}}
        @include('dashboard.templates.top-nav')
        {{-- Dashboard Left Nav and Main Box --}}
        <div class="flex row jst-ast dashmain-wrapper flex-auto">
            {{-- Sidebar Nav --}}
            @include('dashboard.templates.sidebar-nav')
            {{-- Dashboard Dom Conent Area --}}
            <div class="dash-main-area padar-20 flex-auto">
                {{-- All Content of Dashboard will be shownhere --}}
