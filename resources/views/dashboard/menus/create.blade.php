@extends('dashboard.templates.main')
@section('dash-body')
    <h2 class="fs-h2 marb-20">@php
        echo $page_title;
    @endphp</h2>
    @if (session('success'))
        <div class="alert alert-success marb-20">
            {{ session('success') }}
        </div>
    @endif
    <form id="roleFrom" role="form" method="POST"
        action="{{ isset($menu) ? route('menus.update', $menu->id) : route('menus.store') }}">
        @csrf
        @if (isset($menu))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    placeholder="Enter menu name (e.g. admin)" value="{{ isset($menu) ? $menu->name : old('name') }}"
                    required autofocus>
                @error('name')
                    <span class="invalid-feedback" style="color: red;" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control @error('name') is-invalid @enderror" id="description" name="description">{{ isset($menu) ? $menu->description : old('description') }}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="button" class="btn btn-danger" onClick="resetForm('roleFrom')">
                <i class="fas fa-redo"></i>
                <span>Reset</span>
            </button>
            <button type="submit" class="btn btn-primary">
                @isset($menu)
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
@endsection
