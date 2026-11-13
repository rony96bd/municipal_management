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
        .btn-action-secondary {
            background-color: var(--secondary-color, #3361d9);
            color: #ffffff !important;
        }
        .btn-action-secondary:hover {
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
        .password-section-box {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 6px;
            padding: 16px;
            margin-top: 10px;
            margin-bottom: 20px;
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
            <div>
                <h2 class="fs-h2">{{ $page_title ?? 'ইউজার তথ্য সম্পাদনা করুন' }}</h2>
                <small class="color-paragraph" style="font-size: 14px;">ইউজার: <strong>{{ $user->name }}</strong> ({{ $user->email }})</small>
            </div>
            <div class="flex row gap-10 wrap">
                <a href="{{ route('change-password-user', $user->id) }}" class="btn-action btn-action-secondary">
                    পাসওয়ার্ড পরিবর্তন পেজ
                </a>
                <a href="{{ route('users-list') }}" class="btn-action btn-action-outline">
                    &larr; ইউজার তালিকায় ফিরে যান
                </a>
            </div>
        </div>

        <div class="user-card">
            <form action="{{ route('update-user', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="user-form-group">
                    <label for="name" class="user-label">ইউজারের নাম <span class="color-danger">*</span></label>
                    <input type="text" name="name" id="name" class="user-input"
                        value="{{ old('name', $user->name) }}" placeholder="ইউজারের পুরো নাম" required autofocus>
                    @error('name')
                        <small class="color-danger fs-base">{{ $message }}</small>
                    @enderror
                </div>

                <div class="user-form-group">
                    <label for="email" class="user-label">ই-মেইল ঠিকানা <span class="color-danger">*</span></label>
                    <input type="email" name="email" id="email" class="user-input"
                        value="{{ old('email', $user->email) }}" placeholder="example@domain.com" required>
                    @error('email')
                        <small class="color-danger fs-base">{{ $message }}</small>
                    @enderror
                </div>

                <div class="user-form-group">
                    <label for="role" class="user-label">ইউজারের ভূমিকা (Role) <span class="color-danger">*</span></label>
                    <select name="role" id="role" class="user-input" required>
                        <option value="admin" {{ old('role', $user->role ?? 'admin') === 'admin' ? 'selected' : '' }}>সুপার অ্যাডমিন (Admin)</option>
                        <option value="staff" {{ old('role', $user->role ?? 'admin') === 'staff' ? 'selected' : '' }}>স্টাফ / অপারেটর (Staff)</option>
                    </select>
                    @error('role')
                        <small class="color-danger fs-base">{{ $message }}</small>
                    @enderror
                </div>

                <div class="password-section-box">
                    <div class="marb-10">
                        <span class="user-label">পাসওয়ার্ড পরিবর্তন (ঐচ্ছিক)</span>
                        <p style="font-size: 13px; color: #64748b; margin-top: 3px;">
                            পাসওয়ার্ড পরিবর্তন করতে না চাইলে নিচের ঘর দুটি ফাঁকা রাখুন। পরিবর্তন করতে চাইলে কমপক্ষে ৮ অক্ষরের নতুন পাসওয়ার্ড দিন।
                        </p>
                    </div>

                    <div class="form-grid-2">
                        <div class="user-form-group" style="margin-bottom: 0;">
                            <label for="password" class="user-label" style="font-size: 14px;">নতুন পাসওয়ার্ড</label>
                            <input type="password" name="password" id="password" class="user-input"
                                placeholder="নতুন পাসওয়ার্ড দিন">
                            @error('password')
                                <small class="color-danger fs-base">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="user-form-group" style="margin-bottom: 0;">
                            <label for="password_confirmation" class="user-label" style="font-size: 14px;">নতুন পাসওয়ার্ড নিশ্চিত করুন</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="user-input"
                                placeholder="পুনরায় নতুন পাসওয়ার্ড লিখুন">
                        </div>
                    </div>
                </div>

                <div class="flex row gap-10 mart-10">
                    <button type="submit" class="btn-action btn-action-primary">
                        তথ্য আপডেট করুন
                    </button>
                    <a href="{{ route('users-list') }}" class="btn-action btn-action-outline">
                        বাতিল
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
