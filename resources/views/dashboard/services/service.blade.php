@extends('dashboard.templates.main')
@section('dash-body')
    <div class="flex column full-width gap-20">
        <a href="{{ route('create-service') }}"
            class="outline-button padl-20 padr-20 padt-10 padb-10 border-solid border-1px border-color solid bradius-3px width-max-content">নতুন
            সেবা যুক্ত করুন</a>

        <div class="flex full-width justify-content-end flex column gap-10 mart-20 bradius-3px overflow-hidden">
            <h2 class="fs-h2">সেবা সমূহ</h2>

            <div id="main-service-list" class="sortable-list flex column gap-20">
                @forelse ($services as $service)
                    <div class="main-service-repeater flex column main-drag-box gap-0 border-solid border-1px border-color-primary bradius-3px overflow-hidden"
                        data-id="{{ $service->service_id }}">
                        <div
                            class="page-header background-primary color-white grid grid-col-5 border-color-primary full-width gap-20 padl-20 padr-20 padt-10 padb-10 m-display-none">
                            <h3 class="fs-h3 font-weight-bold">সেবার নাম</h3>
                            <h3 class="fs-h3 font-weight-bold grid-span-2">পাতার ইউ.আর.এল</h3>
                            <h3 class="fs-h3 font-weight-bold grid-span-2 text-center">অ্যাকশান</h3>
                        </div>
                        <div
                            class="page-repeater grid grid-col-5 border-color-primary full-width gap-10 m-grid-col-1 m-gap-0">
                            <div class="flex row">
                                <div class="drag-box flex center padl-20 padr-20 padt-10 padb-10 m-display-none">
                                    @include('icons.drag')
                                </div>
                                <a href="{{ url('/service') }}/{{ $service->page_url }}"
                                    class="fs-h3 padt-10 padb-10 padl-0 padr-20 m-padl-20"
                                    target="_blank"><strong>{{ $service->service_name }}</strong><br>{{ $service->service_description }}</a>
                            </div>
                            <a class="fs-base padt-10 padb-10 padl-20 padr-20 flex row jst-ace grid-span-2"
                                href="{{ url('/service') }}/{{ $service->page_url }}"
                                target="_blank">{{ url('/service') }}/{{ $service->page_url }}</a>
                            <div
                                class="flex row jfe-ace gap-10 padt-10 padb-10 padl-20 padr-20 m-column m-jst-ast grid-span-2">
                                <div class="anchor copy-url drag-box flex center padl-20 padr-20 padt-10 padb-10 m-display-none"
                                    data_link="{{ url('/service') }}/{{ $service->page_url }}" title="ইউ আর এল কপি করুন">
                                    @include('icons.copy-link')
                                </div>
                                @if ($service->singleServices->count() < 4)
                                    <a href="{{ route('service-configure', $service->page_url) }}"
                                        class="background-success color-primary padt-10 padb-10 padr-20 padl-20 text-center bradius-3px">
                                        কনফিগার করুন
                                    </a>
                                @else
                                    <p class="background-success color-primary padt-10 padb-10 padr-20 padl-20 text-center bradius-3px disabled-button"
                                        title="সর্বোচ্চ ‘৪টি’ সার্ভিস ইতমধ্যে যুক্ত করা হয়েছে।">
                                        কনফিগার করুন
                                    </p>
                                @endif
                                <a href="{{ route('edit-service', $service->service_id) }}"
                                    class="background-primary color-white padt-10 padb-10 padr-20 padl-20 text-center bradius-3px">সম্পাদনা
                                    করুন</a>
                                <form action="{{ route('delete-service', $service->service_id) }}" method="POST"
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
                        <div id="single-service-list" class="sortable-list flex column gap-0">
                            {{-- Single Service Items --}}
                            @forelse ($service->singleServices as $singleservice)
                                <div class="page-repeater grid grid-col-5 border-color-primary full-width gap-10 m-grid-col-1 m-gap-0"
                                    data-id="{{ $singleservice->id }}">
                                    <div class="flex row">
                                        <div class="drag-box flex center padl-20 padr-20 padt-10 padb-10 m-display-none">
                                            @include('icons.sub-item')
                                        </div>
                                        <a href="{{ url('/service') }}/{{ $service->page_url }}/{{ $singleservice->page_url }}"
                                            class="fs-h3 padt-10 padb-10 padl-0 padr-20 m-padl-20 flex column jcc-ais"
                                            target="_blank"><strong>{{ $singleservice->service_item_name }}</strong></a>
                                    </div>
                                    <a class="fs-base padt-10 padb-10 padl-20 padr-20 flex row jst-ace grid-span-2"
                                        href="{{ url('/service') }}/{{ $service->page_url }}/{{ $singleservice->page_url }}"
                                        target="_blank">{{ url('/service') }}/{{ $service->page_url }}/{{ $singleservice->page_url }}</a>
                                    <div
                                        class="flex row jfe-ace gap-10 padt-10 padb-10 padl-20 padr-20 m-column m-jst-ast grid-span-2">
                                        <div class="anchor copy-url drag-box flex center padl-20 padr-20 padt-10 padb-10 m-display-none"
                                            data_link="{{ url('/service') }}/{{ $service->page_url }}/{{ $singleservice->page_url }}"
                                            title="ইউ আর এল কপি করুন">
                                            @include('icons.copy-link')
                                        </div>
                                        <a href="{{ route('edit-single-service-item', $singleservice->id) }}"
                                            class="background-primary color-white padt-10 padb-10 padr-20 padl-20 text-center bradius-3px">সম্পাদনা
                                            করুন</a>
                                        <form action="{{ route('delete-single-service', $singleservice->id) }}"
                                            method="POST" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে মুছে ফেলতে চান?');"
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
                                <p class="padar-20 text-center full-width color-warning">‘{{ $service->service_name }}’ এর
                                    অধীনে
                                    কোন সেবা যুক্ত
                                    করা নেয়</p>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <p class="padar-20 text-center color-warning grid-span-2 full-width">কোন সেবা যুক্ত করা নেয়</p>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize SortableJS for the main-service-list with specific drag-boxes
            const sortableMain = new Sortable(document.getElementById('main-service-list'), {
                animation: 150, // Smooth drag transition
                handle: '.main-drag-box', // Only drag when clicking on the drag box (specific to main service)
                forceFallback: true, // Force fallback to prevent selection issues
                onStart(evt) {
                    // Prevent content selection during drag operation
                    document.body.style.userSelect = 'none';
                },
                onEnd(evt) {
                    // Re-enable content selection after drag operation
                    document.body.style.userSelect = 'auto';

                    // Reorder the items based on the new order
                    const orderedIds = [];
                    const items = document.querySelectorAll('.main-service-repeater');
                    items.forEach(item => {
                        orderedIds.push(item.getAttribute('data-id'));
                    });

                    // Send the new order to the server for updating the database
                    updateOrder(orderedIds, 'main-service'); // Send specific type for clarity
                }
            });

            // Initialize SortableJS for each sub-service list inside each main service
            document.querySelectorAll('.main-service-repeater').forEach(serviceContainer => {
                const singleServiceList = serviceContainer.querySelector('#single-service-list');
                if (singleServiceList) {
                    new Sortable(singleServiceList, {
                        animation: 150, // Smooth drag transition
                        handle: '.drag-box', // Only drag when clicking on the drag box (specific to sub service)
                        forceFallback: true, // Force fallback to prevent selection issues
                        onStart(evt) {
                            // Prevent content selection during drag operation
                            document.body.style.userSelect = 'none';
                        },
                        onEnd(evt) {
                            // Re-enable content selection after drag operation
                            document.body.style.userSelect = 'auto';

                            // Reorder the items based on the new order
                            const orderedIds = [];
                            const items = singleServiceList.querySelectorAll('.page-repeater');
                            items.forEach(item => {
                                orderedIds.push(item.getAttribute('data-id'));
                            });

                            // Send the new order to the server for updating the database
                            updateOrder(orderedIds,
                                'sub-service'); // Send specific type for clarity
                        }
                    });
                }
            });

            // Function to update the order of items in the database
            function updateOrder(orderedIds, type) {
                // Determine the appropriate route based on the type
                const route = type === 'main-service' ?
                    '{{ route('update-service-order') }}' :
                    '{{ route('update-sin-service-order') }}';

                fetch(route, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            orderedIds: orderedIds,
                            type: type
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(type === 'main-service' ?
                                'সার্ভিস সফলভাবে রিঅর্ডার করা হয়েছে।' :
                                'সিঙ্গেল সার্ভিস সফলভাবে রিঅর্ডার করা হয়েছে।');
                        } else {
                            alert('Failed to update the order. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('একটি সমস্যা হয়েছে পুনরায় চেষ্টা করুন।');
                    });
            }






        });
    </script>

@endsection
