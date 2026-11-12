# PROGRESS (প্রতি ধাপ শেষে আপডেটকৃত)

শেষ আপডেট: 2026-11-12 — সকল ধাপ (Phase 1–9) সফলভাবে সম্পন্ন ও টেস্টকৃত।

## চেকলিস্ট
- [x] প্ল্যান (`PLAN.md`)
- [x] Phase 1: নমুনা বিশ্লেষণ → `SAMPLES.md` (২৯টি নমুনা বিশ্লেষিত, ২১নং পুরনো ফরম্যাট বাদে ২৮টি সক্রিয় ধরন)
- [x] Phase 2: Foundation (`packages/municipal/attestation/` প্যাকেজ, migrations, models, service provider, artisan `attestation:install`, সাইডবার মেনু)
- [x] Phase 3: টাইপ ও স্বাক্ষরকারী ম্যানেজমেন্ট (`TypeController`, `SignatoryController`, JSON/Repeater ফিল্ড সাপোর্ট)
- [x] Phase 4: সরাসরি প্রত্যয়ন তৈরি + প্রিন্ট (`CertificateController`, `MemoGenerator`, `SnapshotBuilder`, `print/default.blade.php`)
- [x] Phase 5: নাগরিক আবেদন ও ট্র্যাকিং (`ApplyController`, `TrackController`, লগইন ছাড়া আবেদন + ট্র্যাকিং নম্বর)
- [x] Phase 6: অ্যাডমিন আবেদন ম্যানেজমেন্ট (`ApplicationController` — এডিট, অনুমোদন→স্মারক ও সনদ জেনারেট, বাতিল, হস্তান্তর, অডিট লগ)
- [x] Phase 7: রেজিস্টার/রিপোর্ট ও QR যাচাই (`ReportController` + CSV এক্সপোর্ট, `VerifyController` `/attestation/verify/{code}`)
- [x] Phase 8: টেস্ট ও পলিশ (`AttestationSystemTest` — ৩টি টেস্ট পাস)
- [x] Phase 9: ক্লায়েন্টের `সনদের_সেবাসমূহ (2).html` অনুযায়ী আপগ্রেড:
  - ৫-কলামের গোলাকার লোগো/আইকন ব্যাজ গ্রিড ("সনদের সেবাসমূহ") + লাইভ সার্চ + ভাষাভিত্তিক ট্যাব (`সব সেবা`, `বাংলা প্রত্যয়ন`, `🌐 English সনদ`) — পাবলিক ও অ্যাডমিন উভয় পেজে।
  - ৩৬টি বাংলা প্রত্যয়ন + ১০টি English সনদ = মোট **৪৬টি সক্রিয় সনদ সেবা** সিডকৃত।
  - অ্যাডমিনে **Split-Screen Live A4 Preview** ও **"✎ সরাসরি এডিট" (`contenteditable`)** + **"📝 শিরোনাম, স্থির লেখা ও স্বাক্ষর এডিট করুন"** ওভাররাইড ব্লক।
  - **প্রমাণক সংযুক্তি (`📎 প্রমাণক সংযুক্তি`)** (৪টি মূল কাগজ + ৬টি ক্যাটাগরির অতিরিক্ত কাগজ আপলোড ও ভিউয়ার)।
  - প্রিন্ট ভিউতে লেটারহেড/প্যাড মোড টগল, সরাসরি এডিট এবং Word (`.doc`) ডাউনলোড বাটন।
  - **ডাইনামিক প্যাড মার্জিন কন্ট্রোল**: প্রিন্ট পেজের টুলবার থেকেই `+` / `−` বা প্রিসেট (`1.0"`, `1.5"`, `1.8"`, `2.0"`) চেপে লাইভ প্যাড ফাঁকা মার্জিন পরিবর্তন ও লোকালস্টোরেজে সংরক্ষণ; অ্যাডমিন টাইপ এডিট পেজেও প্রতি সনদে ডিফল্ট প্যাড মার্জিন নির্ধারণযোগ্য।

## নিশ্চিত সিদ্ধান্তসমূহ
- **পুনর্ব্যবহারযোগ্য প্যাকেজ**: `packages/municipal/attestation/` (`municipal/attestation`) — ইউনিয়ন পরিষদ বা অন্য যেকোনো প্রজেক্টে কপি করে `php artisan attestation:install` দিলেই চলবে।
- **ফন্ট ও প্রিন্ট**: `Noto Sans Bengali`, আধুনিক A4 প্রিন্ট ভিউ + QR যাচাই কোড + হেডার সহ/ছাড়া (প্যাড মোড) এবং জলছাপ অন/অফ টগল।
- **লোগো নীতি**: `SiteSettings->site_logo` সেট থাকলে সেটি, না থাকলে আলমডাঙ্গা পৌরসভার ডিফল্ট হলুদ সিল (`public/vendor/attestation/default-logo.jpg`)। রানটাইমে ডাইনামিক রেজোলিউশন (ক্যাশ ছাড়া)।
- **২২ নং (বিবাহিত প্রত্যয়ন)**: স্মারক সংক্ষেপ `"বিবাহিত প্রত্যয়ন"` এবং বডিতে `"উল্লেখিত ব্যক্তি **বিবাহিত**; তাঁর স্বামী/স্ত্রীর নাম **{{spouse_name}}**।"`।
- **১৫ নং (নিজ নামে বিদ্যুৎ সংযোগ না থাকা)**: স্বাক্ষর আপাতত প্রিসেট A (পৌর নির্বাহী কর্মকর্তা); অ্যাডমিন প্যানেল থেকে যেকোনো সময় পরিবর্তনযোগ্য।
- **০৪ নং (অভিভাবক সম্মতি পত্র)**: প্রিন্ট ভিউতে ২ জন অভিভাবকের স্বাক্ষর ব্লক যুক্ত।
- **স্মারক নং**: `আঃপৌঃ/{ধরনের নাম}/{বছর}/{ক্রম}` — প্রতি ধরন + প্রতি বছর আলাদা ক্রম, বছর পাল্টালে আবার `০১` থেকে শুরু (`attestation_sequences` টেবিলে DB lock সহ)।
- **ফি ও পেমেন্ট**: প্রতি ধরনে আলাদা ফি নির্ধারণযোগ্য; ম্যানুয়াল পেমেন্ট (`paid`/`unpaid`/`waived` + রসিদ নং)।

## পরিবর্তিত বিদ্যমান ফাইল (ন্যূনতম)
1. `composer.json` — `packages/municipal/attestation` path repository ও PSR-4 autoload যুক্ত
2. `bootstrap/providers.php` — `Municipal\Attestation\AttestationServiceProvider::class` যুক্ত
3. `resources/views/dashboard/templates/sidebar-nav.blade.php` — "প্রত্যয়ন" মেনু লিংক যুক্ত
4. `resources/views/dashboard/dashboard.blade.php` — ড্যাশবোর্ডে "প্রত্যয়ন ব্যবস্থাপনা" কার্ড যুক্ত

## টেস্ট ও রাউট যাচাই ফলাফল
- `php artisan route:list --path=attestation` → মোট **৩৭টি রাউট** নিবন্ধিত
- `php artisan test --filter=AttestationSystemTest` → **PASS (3 tests, 33 assertions)**
