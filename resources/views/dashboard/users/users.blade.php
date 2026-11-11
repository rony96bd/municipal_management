@extends('dashboard.templates.main')
@section('dash-body')
    <style>
        .users-table-container {
            background: #ffffff;
            border-radius: 6px;
            border: 1px solid #dcdcdc;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .users-table-header {
            background-color: var(--primary-color, #000325);
            color: #ffffff;
            display: grid;
            grid-template-columns: 2fr 2.5fr 1.5fr 2fr;
            padding: 12px 20px;
            font-weight: 600;
            font-size: 15px;
        }
        .users-table-row {
            display: grid;
            grid-template-columns: 2fr 2.5fr 1.5fr 2fr;
            padding: 12px 20px;
            align-items: center;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s;
        }
        .users-table-row:last-child {
            border-bottom: none;
        }
        .users-table-row:hover {
            background-color: #f8fafc;
        }
        .user-name {
            font-weight: 600;
            color: var(--primary-color, #000325);
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .user-email a {
            color: var(--secondary-color, #3361d9);
            font-size: 15px;
            word-break: break-all;
        }
        .user-date {
            font-size: 14px;
            color: #64748b;
        }
        .user-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            flex-wrap: wrap;
        }
        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 14px;
            border-radius: 4px;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            font-weight: 500;
            border: none;
            line-height: 1.4;
        }
        .btn-action-primary {
            background-color: var(--primary-color, #000325);
            color: #ffffff !important;
        }
        .btn-action-primary:hover {
            opacity: 0.88;
        }
        .btn-action-secondary {
            background-color: var(--secondary-color, #3361d9);
            color: #ffffff !important;
        }
        .btn-action-secondary:hover {
            opacity: 0.88;
        }
        .btn-action-danger {
            background-color: var(--danger-color, #e74c3c);
            color: #ffffff !important;
        }
        .btn-action-danger:hover {
            opacity: 0.88;
        }
        .badge-current-user {
            background-color: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 600;
        }
        @media (max-width: 900px) {
            .users-table-header {
                display: none;
            }
            .users-table-row {
                grid-template-columns: 1fr;
                gap: 10px;
                padding: 16px;
            }
            .user-actions {
                justify-content: flex-start;
                margin-top: 8px;
            }
        }
    </style>

    <div class="flex column full-width gap-20">
        <div class="flex row jsb-ace full-width wrap gap-10">
            <div>
                <h2 class="fs-h2">{{ $page_title ?? 'ইউজার লিস্ট' }}</h2>
                <small class="color-paragraph" style="font-size: 14px;">মোট ইউজার: {{ $users->count() }} জন</small>
            </div>
            <a href="{{ route('create-user') }}"
                class="btn-action btn-action-primary padl-20 padr-20 padt-10 padb-10 bradius-4px font-weight-bold"
                style="font-size: 15px;">
                + নতুন ইউজার যুক্ত করুন
            </a>
        </div>

        <div class="users-table-container">
            <div class="users-table-header">
                <div>নাম</div>
                <div>ই-মেইল</div>
                <div>তৈরির তারিখ</div>
                <div style="text-align: right;">অ্যাকশন</div>
            </div>

            <div class="users-table-body">
                @forelse ($users as $user)
                    <div class="users-table-row" data-id="{{ $user->id }}">
                        <div class="user-name">
                            <span>{{ $user->name }}</span>
                            @if (auth()->id() === $user->id)
                                <span class="badge-current-user">বর্তমান একাউন্ট</span>
                            @endif
                        </div>

                        <div class="user-email">
                            <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                        </div>

                        <div class="user-date">
                            {{ $user->created_at ? $user->created_at->format('d M, Y') : '—' }}
                        </div>

                        <div class="user-actions">
                            <a href="{{ route('edit-user', $user->id) }}"
                                class="btn-action btn-action-primary"
                                title="ইউজার সম্পাদনা করুন">
                                সম্পাদনা
                            </a>

                            <a href="{{ route('change-password-user', $user->id) }}"
                                class="btn-action btn-action-secondary"
                                title="পাসওয়ার্ড পরিবর্তন করুন">
                                পাসওয়ার্ড
                            </a>

                            @if (auth()->id() !== $user->id)
                                <form action="{{ route('delete-user', $user->id) }}" method="POST"
                                    onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই ইউজারকে ({{ $user->name }}) মুছে ফেলতে চান?');"
                                    style="display:inline; margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn-action btn-action-danger"
                                        title="ইউজার মুছে ফেলুন">
                                        ডিলিট
                                    </button>
                                </form>
                            @else
                                <span style="font-size: 12px; color: #94a3b8; font-style: italic; padding: 4px 6px;">
                                    (সক্রিয়)
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="padar-20 text-center color-danger font-weight-bold">
                        কোন ইউজার পাওয়া যায় নি।
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
