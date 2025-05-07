@extends('dashboard.templates.main')
@section('dash-body')
<style>
    span.relative {
        padding-right: 15px;
    }

</style>
    <div class="flex column full-width gap-20">
        <a href="{{ route('create-page') }}"
            class="outline-button padl-20 padr-20 padt-10 padb-10 border-solid border-1px border-color solid bradius-3px width-max-content">নতুন
            পাতা খুলুন</a>

        <div class="flex full-width justify-content-end flex column gap-10 mart-20 bradius-3px overflow-hidden">
            <h2 class="fs-h2">সকল পাতা</h2>
            <div class="flex column gap-0 border-solid border-1px border-color-primary bradius-3px overflow-hidden">
                <div
                    class="page-header background-primary color-white grid grid-col-3 border-color-primary full-width gap-20 padl-20 padr-20 padt-10 padb-10 m-display-none">
                    <h3 class="fs-h3 font-weight-bold">পাতার নাম</h3>
                    <h3 class="fs-h3 font-weight-bold">পাতার ইউ.আর.এল</h3>
                    <h3 class="fs-h3 font-weight-bold text-center">অ্যাকশান</h3>
                </div>
                <div id="page-list" class="sortable-list flex column gap-0">
                    @forelse ($pages as $page)
                        <div class="page-repeater grid grid-col-3 border-color-primary full-width gap-10 m-grid-col-1 m-gap-0"
                            data-id="{{ $page->id }}">
                            <div class="flex row">
                                <div class="drag-box flex center padl-20 padr-20 padt-10 padb-10 m-display-none">
                                    @include('icons.drag')
                                </div>
                                <a href="{{ url('/page') }}/{{ $page->page_url }}"
                                    class="fs-h3 padt-10 padb-10 padl-0 padr-20 flex row jst-ace flex-auto m-padl-20"
                                    target="_blank">{{ $page->page_name }}</a>
                            </div>
                            <a class="fs-base padt-10 padb-10 padl-20 padr-20 flex row jst-ace"
                                href="{{ url('/page') }}/{{ $page->page_url }}"
                                target="_blank">{{ url('/page') }}/{{ $page->page_url }}</a>
                            <div class="flex row jfe-ace gap-10 padt-10 padb-10 padl-20 padr-20 m-column m-jst-ast">
                                <div class="anchor copy-url drag-box flex center padl-20 padr-20 padt-10 padb-10 m-display-none"
                                    data_link="{{ url('/page') }}/{{ $page->page_url }}" title="পাতার ইউ আর এল কপি করুন">
                                    @include('icons.copy-link')
                                </div>
                                <a href="{{ route('edit-page', $page->id) }}"
                                    class="background-primary color-white padt-10 padb-10 padr-20 padl-20 text-center bradius-3px">সম্পাদনা
                                    করুন</a>
                                <form action="{{ route('delete-page', $page->id) }}" method="POST"
                                    onsubmit="return confirm('আপনি কি নিশ্চিতভাবে মুছে ফেলতে চান?');"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="background-danger button-default-css color-white padt-10 padb-10 padr-20 padl-20 text-center bradius-3px full-width">ডিলিট
                                        করুন</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        কোন তথ্য পাওয়া যায় নি
                    @endforelse
                </div>
                <!-- Pagination Links -->
                <div class="padt-20">
                    {{ $pages->links() }}
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize SortableJS
            const sortable = new Sortable(document.getElementById('page-list'), {
                animation: 150, // Smooth drag transition
                onEnd(evt) {
                    // Reorder the officials based on the new order
                    const orderedIds = [];
                    const items = document.querySelectorAll('.page-repeater');
                    items.forEach(item => {
                        orderedIds.push(item.getAttribute('data-id'));
                    });

                    // Send the new order to the server for updating the database
                    updateOrder(orderedIds);
                }
            });

            // Function to update the order
            function updateOrder(orderedIds) {
                fetch('{{ route('update-page-order') }}', {
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
