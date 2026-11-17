@extends(config('attestation.admin_layout', 'dashboard.templates.main'))
@section(config('attestation.admin_section', 'dash-body'))
    <div class="att-wrap">
        @include('attestation::admin._nav')

        <div class="att-card">
            <div class="att-card-header">
                <h1 class="att-title">{{ $page_title }}</h1>
                <a href="{{ route('attestation.types.index') }}" class="att-btn att-btn-outline">← তালিকায় ফিরে যান</a>
            </div>

            <form method="POST" action="{{ $type->exists ? route('attestation.types.update', $type) : route('attestation.types.store') }}">
                @csrf
                @if ($type->exists)
                    @method('PUT')
                @endif

                <div class="att-grid att-grid-3">
                    <div class="att-field">
                        <label>প্রত্যয়নের শিরোনাম (নাম) *</label>
                        <input type="text" name="name" class="att-input" required value="{{ old('name', $type->name) }}" placeholder="যেমন: বৈবাহিক অবস্থার প্রত্যয়ন পত্র">
                    </div>

                    <div class="att-field">
                        <label>স্মারক নং-এ ব্যবহৃত নাম *</label>
                        <input type="text" name="memo_name" class="att-input" required value="{{ old('memo_name', $type->memo_name) }}" placeholder="যেমন: বিবাহিত প্রত্যয়ন">
                    </div>

                    <div class="att-field">
                        <label>URL Slug (ইংরেজি)</label>
                        <input type="text" name="slug" class="att-input" value="{{ old('slug', $type->slug) }}" placeholder="bibahit-pratyayan">
                    </div>

                    <div class="att-field">
                        <label>প্রত্যয়ন-প্রাপকের অবস্থা</label>
                        <select name="subject_status" class="att-select">
                            <option value="living" {{ old('subject_status', $type->subject_status) === 'living' ? 'selected' : '' }}>জীবিত (Living)</option>
                            <option value="deceased" {{ old('subject_status', $type->subject_status) === 'deceased' ? 'selected' : '' }}>মৃত ব্যক্তি (Deceased)</option>
                            <option value="either" {{ old('subject_status', $type->subject_status) === 'either' ? 'selected' : '' }}>উভয় (Either)</option>
                        </select>
                    </div>

                    <div class="att-field">
                        <label>নির্ধারিত ফি (টাকায়)</label>
                        <input type="number" step="0.01" name="fee" class="att-input" value="{{ old('fee', $type->fee ?? 0) }}">
                    </div>

                    <div class="att-field">
                        <label>ক্রম নম্বর (Order)</label>
                        <input type="number" name="order" class="att-input" value="{{ old('order', $type->order ?? 0) }}">
                    </div>

                    <div class="att-field">
                        <label>সেবার আইকন / ইমোজি (Icon)</label>
                        <input type="text" name="icon" class="att-input" value="{{ old('icon', $type->icon ?? '📜') }}" placeholder="যেমন: 📜, 💍, 🏠">
                    </div>

                    <div class="att-field">
                        <label>ভাষা (Language)</label>
                        <select name="language" class="att-select">
                            <option value="bn" {{ old('language', $type->language ?? 'bn') === 'bn' ? 'selected' : '' }}>বাংলা (Bangla)</option>
                            <option value="en" {{ old('language', $type->language ?? 'bn') === 'en' ? 'selected' : '' }}>🌐 English (ইংরেজি)</option>
                        </select>
                    </div>

                    <div class="att-field">
                        <label>প্যাডে উপরে ফাঁকা মার্জিন (ইঞ্চি — ডিফল্ট: 1.5)</label>
                        <input type="number" step="0.1" min="0" max="6" name="pad_top" class="att-input" value="{{ old('pad_top', $type->print_options['pad_top'] ?? 1.5) }}" placeholder="1.5">
                    </div>
                </div>

                <div class="att-field">
                    <label>Person Block ফিল্ডসমূহ (টিক চিহ্নিত ফিল্ডগুলো ফর্ম ও সনদে দেখাবে)</label>
                    <div style="display:flex;flex-wrap:wrap;gap:14px;background:#f8fafc;padding:12px;border-radius:8px;border:1px solid #e2e8f0;">
                        @php $selectedPerson = old('person_fields', $type->person_fields ?? []); @endphp
                        @foreach ($personFields as $pfKey => $pfLabel)
                            <label style="display:inline-flex;align-items:center;gap:6px;font-weight:500;cursor:pointer;">
                                <input type="checkbox" name="person_fields[]" value="{{ $pfKey }}" {{ in_array($pfKey, $selectedPerson) ? 'checked' : '' }}>
                                {{ $pfLabel }} (<code>{{ $pfKey }}</code>)
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="att-field">
                    <label>বডি টেমপ্লেট (Body Template — <code>@{{placeholder}}</code> ও <code>**বোল্ড**</code> ব্যবহার করুন)</label>
                    <textarea name="body_template" rows="4" class="att-textarea exclude-tyne">{{ old('body_template', $type->body_template) }}</textarea>
                    <small style="color:#64748b;">Person placeholders: <code>@{{applicant_name}}</code>, <code>@{{father_name}}</code>, <code>@{{mother_name}}</code>, <code>@{{spouse_name}}</code>, <code>@{{id_no}}</code>, <code>@{{ward_no}}</code>, <code>@{{mohalla}}</code> + অতিরিক্ত ফিল্ডের key।</small>
                </div>

                <div class="att-field">
                    <label>সমাপনী দোয়া / মঙ্গল কামনা লাইন (Closing Line)</label>
                    <input type="text" name="closing_line" class="att-input" value="{{ old('closing_line', $type->closing_line) }}">
                </div>

                <div class="att-field">
                    <label>অতিরিক্ত ডাইনামিক ফিল্ডসমূহ (JSON Array — টেক্সট, সিলেক্ট, অথবা Repeater টেবিল)</label>
                    <textarea name="fields_json" rows="7" class="att-textarea exclude-tyne" style="font-family:monospace;font-size:13px;">{{ old('fields_json', json_encode($type->fields ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) }}</textarea>
                </div>

                <div class="att-field">
                    <label>স্বাক্ষরকারী স্লট (১–৩ জন)</label>
                    <div class="att-grid att-grid-3">
                        @php $slots = old('signatories', $type->signatories ?? []); @endphp
                        @for ($i = 0; $i < 3; $i++)
                            @php $slot = $slots[$i] ?? []; @endphp
                            <div style="background:#f8fafc;padding:12px;border-radius:8px;border:1px solid #e2e8f0;">
                                <strong>স্বাক্ষর স্লট #{{ $i + 1 }}</strong>
                                <div class="att-field" style="margin-top:8px;">
                                    <label>স্বাক্ষরকারী নির্বাচন করুন</label>
                                    <select name="signatories[{{ $i }}][signatory_id]" class="att-select">
                                        <option value="">-- প্রিসেট বা ফাঁকা --</option>
                                        @foreach ($signatories as $sig)
                                            <option value="{{ $sig->id }}"
                                                {{ (!empty($slot['signatory_id']) && (int)$slot['signatory_id'] === $sig->id) || (!empty($slot['preset_key']) && $slot['preset_key'] === $sig->preset_key) ? 'selected' : '' }}>
                                                [{{ $sig->preset_key }}] {{ $sig->designation }} {{ $sig->name ? "({$sig->name})" : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="att-field" style="margin-bottom:0;">
                                    <label>কাস্টম পদবী ওভাররাইড (ঐচ্ছিক)</label>
                                    <input type="text" name="signatories[{{ $i }}][designation]" class="att-input" value="{{ $slot['designation'] ?? '' }}" placeholder="ফাঁকা রাখলে নির্বাচিত পদবী বসবে">
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <div style="background:#f8fafc;padding:16px;border-radius:8px;border:1px solid #e2e8f0;margin:20px 0;">
                    <h3 style="margin:0 0 12px 0;font-size:15px;color:#0f6b3a;font-weight:700;">🖨️ প্রিন্ট লেআউট ও প্রদর্শন অপশন</h3>
                    
                    <div style="display:flex;flex-wrap:wrap;gap:20px;margin-bottom:16px;">
                        <label style="display:inline-flex;align-items:center;gap:6px;font-weight:600;cursor:pointer;">
                            <input type="checkbox" name="with_header" value="1" {{ old('with_header', $type->print_options['with_header'] ?? true) ? 'checked' : '' }}>
                            প্রিন্টে লেটারহেড (হেডার) ছাপাবে
                        </label>
                        <label style="display:inline-flex;align-items:center;gap:6px;font-weight:600;cursor:pointer;">
                            <input type="checkbox" name="watermark" value="1" {{ old('watermark', $type->print_options['watermark'] ?? true) ? 'checked' : '' }}>
                            জলছাপ (Watermark) লোগো দেখাবে
                        </label>
                        <label style="display:inline-flex;align-items:center;gap:6px;font-weight:600;cursor:pointer;">
                            <input type="checkbox" name="is_public" value="1" {{ old('is_public', $type->is_public ?? true) ? 'checked' : '' }}>
                            নাগরিক অনলাইনে আবেদন করতে পারবে
                        </label>
                        <label style="display:inline-flex;align-items:center;gap:6px;font-weight:600;cursor:pointer;">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $type->is_active ?? true) ? 'checked' : '' }}>
                            সক্রিয় (Active)
                        </label>
                    </div>

                    @php
                        $curFont = old('print_font', $type->print_options['font_family'] ?? '');
                        $curFontSize = old('print_font_size', $type->print_options['font_size'] ?? '14px');
                        $curLineHeight = old('print_line_height', $type->print_options['line_height'] ?? '1.8');
                        $curSpacing = old('print_spacing', $type->print_options['section_spacing'] ?? 'normal');
                    @endphp

                    <div class="att-grid att-grid-4" style="margin-top:14px;">
                        <div class="att-field">
                            <label>ডিফল্ট ফন্ট</label>
                            <select name="print_font" class="att-select">
                                <option value="" {{ empty($curFont) ? 'selected' : '' }}>ওয়েবসাইটের ফন্ট (ডিফল্ট)</option>
                                <option value="Tiro Bangla" {{ $curFont === 'Tiro Bangla' ? 'selected' : '' }}>Tiro Bangla (টিরো বাংলা)</option>
                                <option value="Hind Siliguri" {{ $curFont === 'Hind Siliguri' ? 'selected' : '' }}>Hind Siliguri (হিন্দ শিলিগুড়ি)</option>
                                <option value="Noto Sans Bengali" {{ $curFont === 'Noto Sans Bengali' ? 'selected' : '' }}>Noto Sans Bengali (নোতো সান্স)</option>
                                <option value="Noto Serif Bengali" {{ $curFont === 'Noto Serif Bengali' ? 'selected' : '' }}>Noto Serif Bengali (নোতো সেরিফ)</option>
                                <option value="Anek Bangla" {{ $curFont === 'Anek Bangla' ? 'selected' : '' }}>Anek Bangla (অনেক বাংলা)</option>
                                <option value="Baloo Da 2" {{ $curFont === 'Baloo Da 2' ? 'selected' : '' }}>Baloo Da 2 (বালু দা)</option>
                                <option value="'Kalpurush', 'SolaimanLipi', sans-serif" {{ str_contains($curFont, 'Kalpurush') ? 'selected' : '' }}>Kalpurush / SolaimanLipi</option>
                            </select>
                        </div>
                        <div class="att-field">
                            <label>ডিফল্ট ফন্ট সাইজ</label>
                            <select name="print_font_size" class="att-select">
                                <option value="15px" {{ $curFontSize === '15px' ? 'selected' : '' }}>১৫ px (বড়)</option>
                                <option value="14.5px" {{ $curFontSize === '14.5px' ? 'selected' : '' }}>১৪.৫ px</option>
                                <option value="14px" {{ $curFontSize === '14px' || empty($curFontSize) ? 'selected' : '' }}>১৪ px (স্ট্যান্ডার্ড)</option>
                                <option value="13.5px" {{ $curFontSize === '13.5px' ? 'selected' : '' }}>১৩.৫ px</option>
                                <option value="13px" {{ $curFontSize === '13px' ? 'selected' : '' }}>১৩ px (লেখা বেশি হলে উপযুক্ত)</option>
                                <option value="12.5px" {{ $curFontSize === '12.5px' ? 'selected' : '' }}>১২.৫ px</option>
                                <option value="12px" {{ $curFontSize === '12px' ? 'selected' : '' }}>১২ px (অনেক বড় লেখার জন্য)</option>
                            </select>
                        </div>
                        <div class="att-field">
                            <label>ডিফল্ট লাইন হাইট</label>
                            <select name="print_line_height" class="att-select">
                                <option value="1.95" {{ (string)$curLineHeight === '1.95' ? 'selected' : '' }}>১.৯৫ (খোলামেলা)</option>
                                <option value="1.85" {{ (string)$curLineHeight === '1.85' ? 'selected' : '' }}>১.৮৫</option>
                                <option value="1.8" {{ (string)$curLineHeight === '1.8' || empty($curLineHeight) ? 'selected' : '' }}>১.৮০ (স্ট্যান্ডার্ড)</option>
                                <option value="1.7" {{ (string)$curLineHeight === '1.7' ? 'selected' : '' }}>১.৭০</option>
                                <option value="1.6" {{ (string)$curLineHeight === '1.6' ? 'selected' : '' }}>১.৬০ (আঁটোসাঁটো)</option>
                                <option value="1.5" {{ (string)$curLineHeight === '1.5' ? 'selected' : '' }}>১.৫০ (কমপ্যাক্ট)</option>
                            </select>
                        </div>
                        <div class="att-field">
                            <label>ডিফল্ট স্পেসিং</label>
                            <select name="print_spacing" class="att-select">
                                <option value="compact" {{ $curSpacing === 'compact' ? 'selected' : '' }}>আঁটোসাঁটো (Compact)</option>
                                <option value="normal" {{ $curSpacing === 'normal' || empty($curSpacing) ? 'selected' : '' }}>স্বাভাবিক (Normal)</option>
                                <option value="spacious" {{ $curSpacing === 'spacious' ? 'selected' : '' }}>খোলামেলা (Spacious)</option>
                            </select>
                        </div>
                    </div>

                    <p style="margin:10px 0 0 0;font-size:12.5px;color:#64748b;line-height:1.5;">
                        💡 <strong>পরামর্শ:</strong> যেসব সনদে লেখার পরিমাণ বেশি (যেমন: অনাপত্তি সনদ, ওয়ারিশান ইত্যাদি), সেগুলোতে ফন্ট সাইজ ১৩px বা লাইন হাইট ১.৬৫ এবং স্পেসিং আঁটোসাঁটো নির্বাচন করলে স্বাক্ষরের জায়গায় লেখা ঢুকে যাওয়া রোধ হবে। এছাড়া প্রিন্ট প্রিভিউ পেজ থেকেও তাৎক্ষণিক পরিবর্তন করা যাবে।
                    </p>
                </div>

                <button type="submit" class="att-btn att-btn-primary">💾 সংরক্ষণ করুন</button>
            </form>
        </div>
    </div>
@endsection
