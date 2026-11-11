@extends('dashboard.templates.main')
@section('dash-body')
    <style>
        .user-card {
            background: #ffffff;
            border: 1px solid #dcdcdc;
            border-radius: 6px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            max-width: 650px;
        }
        .user-info-banner {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 16px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
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
    </style>

    <div class="flex column full-width gap-20">
        <div class="flex row jsb-ace full-width wrap gap-10">
            <h2 class="fs-h2">{{ $page_title ?? 'ইউজার পাসওয়ার্ড পরিবর্তন' }}</h2>
            <div class="flex row gap-10">
                <a href="{{ route('edit-user', $user->id) }}" class="btn-action btn-action-outline">
                    সম্পাদনা পেজ
                </a>
                <a href="{{ route('users-list') }}" class="btn-action btn-action-outline">
                    &larr; ইউজার তালিকায় ফিরে যান
                </a>
            </div>
        </div>

        <div class="user-card">
            <div class="user-info-banner">
                <div>
                    <span style="font-size: 13px; color: #64748b; display: block;">নির্বাচিত ইউজার</span>
                    <strong style="font-size: 17px; color: var(--primary-color, #000325);">{{ $user->name }}</strong>
                    <span style="color: #64748b; font-size: 14px; margin-left: 6px;">({{ $user->email }})</span>
                </div>
                @if (auth()->id() === $user->id)
                    <span class="badge-current-user" style="background-color: #e0f2fe; color: #0369a1; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                        আপনার একাউন্ট
                    </span>
                @endif
            </div>

            <form action="{{ route('update-password-user', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="user-form-group">
                    <label for="password" class="user-label">নতুন পাসওয়ার্ড <span class="color-danger">*</span> (কমপক্ষে ৮ অক্ষর)</label>
                    <input type="password" name="password" id="password" class="user-input"
                        placeholder="নতুন পাসওয়ার্ড লিখুন" required autofocus>
                    @error('password')
                        <small class="color-danger fs-base">{{ $message }}</small>
                    @enderror
                </div>

                <div class="user-form-group">
                    <label for="password_confirmation" class="user-label">নতুন পাসওয়ার্ড নিশ্চিত করুন <span class="color-danger">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="user-input"
                        placeholder="পুনরায় নতুন পাসওয়ার্ড লিখুন" required>
                </div>

                <div class="flex row gap-10 mart-20">
                    <button type="submit" class="btn-action btn-action-primary">
                        পাসওয়ার্ড আপডেট করুন
                    </button>
                    <a href="{{ route('users-list') }}" class="btn-action btn-action-outline">
                        বাতিল
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
