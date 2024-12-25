@extends('dashboard.templates.main')
@section('dash-body')
    <h2 class="fs-h2 marb-20">
        @isset($menuItem)
            {{ 'Edit Menu Item' }}
        @else
            Create Menu Item to (<code>{{ $menu->name }}</code>)
        @endisset
    </h2>
    @if (session('success'))
        <div class="alert alert-success marb-20">
            {{ session('success') }}
        </div>
    @endif
    <form id="itemFrom" role="form" method="POST"
        action="{{ isset($menuItem) ? route('menus.item.update', ['id' => $menu->id, 'itemId' => $menuItem->id]) : route('menus.item.store', $menu->id) }}">
        @csrf
        @isset($menuItem)
            @method('PUT')
        @endisset
        <div class="card-body">
            <h5 class="fs-h5 marb-20">Manage Menu Item</h5>

            <div class="form-group">
                <label for="type">Type</label>
                <select class="custom-select" id="type" name="type">
                    <option value="item"
                        @isset($menuItem) {{ $menuItem->type == 'item' ? 'selected' : '' }} @endisset>
                        Menu Item
                    </option>
                    <option value="divider"
                        @isset($menuItem) {{ $menuItem->type == 'divider' ? 'selected' : '' }} @endisset>
                        Divider
                    </option>
                </select>
            </div>

            <div id="divider_fields">
                <div class="form-group">
                    <label for="divider_title">Title of the Divider</label>
                    <input type="text" class="form-control @error('divider_title') is-invalid @enderror"
                        id="divider_title" name="divider_title" placeholder="Divider Title"
                        value="{{ isset($menuItem) ? $menuItem->divider_title : old('divider_title') }}" autofocus>
                    @error('divider_title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div id="item_fields">
                <div class="form-group">
                    <label for="title">Title of the Menu Item</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" placeholder="Title" value="{{ isset($menuItem) ? $menuItem->title : old('title') }}"
                        autofocus>
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="url">URL for the Menu Item</label>
                    <input type="text" class="form-control @error('url') is-invalid @enderror" id="url"
                        name="url" placeholder="URL" value="{{ isset($menuItem) ? $menuItem->url : old('url') }}">
                    @error('url')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="target">Open In</label>
                    <select name="target" id="target" class="form-control @error('target') is-invalid @enderror">
                        <option value="_self"
                            @isset($menuItem) {{ $menuItem->target == '_self' ? 'selected' : '' }} @endisset>
                            Same Tab/Window
                        </option>
                        <option value="_blank"
                            @isset($menuItem) {{ $menuItem->target == '_blank' ? 'selected' : '' }} @endisset>
                            New Tab/Window
                        </option>
                    </select>
                    @error('target')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="icon_class">Font Icon class for the Menu Item <a target="_blank"
                            href="https://fontawesome.com/">(Use
                            a Fontawesome Font Class)</a> </label>
                    <input type="text" class="form-control @error('icon_class') is-invalid @enderror" id="icon_class"
                        name="icon_class" placeholder="Icon Class (optional)"
                        value="{{ isset($menuItem) ? $menuItem->icon_class : old('icon_class') }}" autofocus>
                    @error('icon_class')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <button type="button" class="btn btn-danger" onClick="resetForm('itemFrom')">
                <i class="fas fa-redo"></i>
                <span>Reset</span>
            </button>

            <button type="submit" class="btn btn-primary">
                @isset($menuItem)
                    <i class="fas fa-arrow-circle-up"></i>
                    <span>Update</span>
                @else
                    <i class="fas fa-plus-circle"></i>
                    <span>Create</span>
                @endisset
            </button>

        </div>
        <!-- /.card-body -->
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const typeSelect = document.querySelector('select[name="type"]');
            const dividerFields = document.getElementById('divider_fields');
            const itemFields = document.getElementById('item_fields');

            // Function to toggle visibility of fields
            function setItemType() {
                if (!typeSelect || !dividerFields || !itemFields) {
                    console.error('Required elements are missing in the DOM.');
                    return;
                }

                if (typeSelect.value === 'divider') {
                    dividerFields.classList.remove('display-none');
                    itemFields.classList.add('display-none');
                } else {
                    dividerFields.classList.add('display-none');
                    itemFields.classList.remove('display-none');
                }
            }

            // Event listener for changes in the dropdown
            if (typeSelect) {
                typeSelect.addEventListener('change', setItemType);
            }

            // Initialize the visibility on page load
            setItemType();
        });
    </script>
@endsection
