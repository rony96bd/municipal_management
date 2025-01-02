@extends('dashboard.templates.main')
@section('dash-body')
    <div class="flex grid grid-col-2 m-grid-col-1 full-width gap-100">
        <div class="flex full-width justify-content-end flex column gap-20 bradius-3px">
            <h2 class="fs-h2">সাইডবারে যুক্ত করতে পারবেন যে সমস্ত তথ্য</h2>
            <div class="grid grid-col-3 m-grid-col-1 gap-10">
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.sidebar-forms.officials')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.sidebar-forms.representatives')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.sidebar-forms.stuffs')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.sidebar-forms.page')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.sidebar-forms.notice')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.sidebar-forms.news')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.sidebar-forms.service')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.sidebar-forms.sidebar-name')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.sidebar-forms.image')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.sidebar-forms.custom-link')
                </div>

                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray flex column jfe-ais">
                    @include('dashboard.forms.sidebar-forms.gap')
                </div>
            </div>
        </div>
        <div class="sidebar-prev-box padl-100" style="max-width:400px; margin-left: auto; width:100%">
            <h2 class="fs-h2">সাইডবার প্রীভিউ</h2>
            <p>সাইডবারের তথ্য ড্রাগ করে প্রয়োজন অনুযায়ী সাজিয়ে নিন</p>
            @include('dashboard.sidebar.sidebar-prev')
        </div>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize SortableJS
            const sortable = new Sortable(document.getElementById('sidebar-list'), {
                animation: 150, // Smooth drag transition
                onEnd(evt) {
                    // Reorder the officials based on the new order
                    const orderedIds = [];
                    const items = document.querySelectorAll('.page-repeater');

                    // Collect the data-id of each item in the new order
                    items.forEach(item => {
                        orderedIds.push(item.getAttribute('data-id'));
                    });

                    // Send the new order to the server for updating the database
                    updateOrder(orderedIds);
                }
            });

            // Function to update the order
            function updateOrder(orderedIds) {
                fetch('{{ route('update-sidebar-order') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            orderedIds: orderedIds
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('অর্ডার সফলভাবে আপডেট হয়েছে!');
                        } else {
                            alert('অর্ডার আপডেট করতে সমস্যা হয়েছে!');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('অর্ডার আপডেট করতে সমস্যা হয়েছে!');
                    });
            }
        });
    </script>
@endsection
