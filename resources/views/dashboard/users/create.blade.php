@extends('dashboard.templates.main')
@section('dash-body')
    <style>
        .user-card {
            background: #ffffff;
            border: 1px solid #dcdcdc;
            border-radius: 6px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            max-width: 750px;
        }
        .user-form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 18px;
        }
        .user-label {
            font-weight: 600;
            font-size: 15px;
            color: var(--primary-color, #000325);
        }
        .user-input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            font-size: 15px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
            background: #fff;
        }
        .user-input:focus {
            border-color: var(--secondary-color, #3361d9);
            box-shadow: 0 0 0 3px rgba(51, 97, 217, 0.15);
        }
        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 15px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            font-weight: 600;
            border: none;
            line-height: 1.3;
        }
        .btn-action-primary {
            background-color: var(--primary-color, #000325);
            color: #ffffff !important;
        }
        .btn-action-primary:hover {
            opacity: 0.9;
        }
        .btn-action-outline {
            background-color: transparent;
            color: var(--primary-color, #000325) !important;
            border: 1px solid #cbd5e1;
        }
        .btn-action-outline:hover {
            background-color: #f1f5f9;
        }
        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        @media (max-width: 650px) {
            .form-grid-2 {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
    </style>

    <div class="flex column full-width gap-20">
        <div class="flex row jsb-ace full-width wrap gap-10">
            <h2 class="fs-h2">{{ $page_title ?? 'নতুন ইউজার তৈরি করুন' }}</h2>
            <a href="{{ route('users-list') }}" class="btn-action btn-action-outline">
                &larr; ইউজার তালিকায় ফিরে যান
            </a>
        </div>

        <div class="user-card">
            <form action="{{ route('store-user') }}" method="POST">
                @csrf

                <div class="user-form-group">
                    <label for="name" class="user-label">ইউজারের নাম <span class="color-danger">*</span></label>
                    <input type="text" name="name" id="name" class="user-input"
                        value="{{ old('name') }}" placeholder="যেমন: মোঃ আব্দুল্লাহ" required autofocus>
                    @error('name')
                        <small class="color-danger fs-base">{{ $message }}</small>
                    @enderror
                </div>

                <div class="user-form-group">
                    <label for="email" class="user-label">ই-মেইল ঠিকানা <span class="color-danger">*</span></label>
                    <input type="email" name="email" id="email" class="user-input"
                        value="{{ old('email') }}" placeholder="example@domain.com" required>
                    @error('email')
                        <small class="color-danger fs-base">{{ $message }}</small>
                    @enderror
                </div>

                <div class="user-form-group">
                    <label for="role" class="user-label">ইউজারের ভূমিকা (Role) <span class="color-danger">*</span></label>
                    <select name="role" id="role" class="user-input" required>
                        <option value="admin" {{ old('role', 'admin') === 'admin' ? 'selected' : '' }}>সুপার অ্যাডমিন (Admin)</option>
                        <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>স্টাফ / অপারেটর (Staff)</option>
                    </select>
                    @error('role')
                        <small class="color-danger fs-base">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-grid-2">
                    <div class="user-form-group">
                        <label for="password" class="user-label">পাসওয়ার্ড <span class="color-danger">*</span> (কমপক্ষে ৮ অক্ষর)</label>
                        <input type="password" name="password" id="password" class="user-input"
                            placeholder="পাসওয়ার্ড লিখুন" required>
                        @error('password')
                            <small class="color-danger fs-base">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="user-form-group">
                        <label for="password_confirmation" class="user-label">পাসওয়ার্ড নিশ্চিত করুন <span class="color-danger">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="user-input"
                            placeholder="পুনরায় পাসওয়ার্ড লিখুন" required>
                    </div>
                </div>

                <div class="flex row gap-10 mart-10">
                    <button type="submit" class="btn-action btn-action-primary">
                        ইউজার যুক্ত করুন
                    </button>
                    <a href="{{ route('users-list') }}" class="btn-action btn-action-outline">
                        বাতিল
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
