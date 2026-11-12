<?php

namespace Municipal\Attestation\Support;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class AttachmentHelper
{
    public static function coreSlots(): array
    {
        return [
            'nid'       => 'এনআইডি কার্ড (NID)',
            'birth'     => 'অনলাইন জন্ম নিবন্ধন',
            'passport'  => 'পাসপোর্ট (থাকলে)',
            'affidavit' => 'এফিডেভিট কপি (থাকলে)',
        ];
    }

    public static function categories(): array
    {
        return [
            'পরিচয় ও নাগরিকত্ব' => [
                'জাতীয় পরিচয়পত্র (NID)',
                'অনলাইন জন্ম নিবন্ধন সনদ',
                'পাসপোর্টের কপি',
                'সদ্য তোলা পাসপোর্ট সাইজ ছবি',
                'নাগরিকত্ব / হোল্ডিং ট্যাক্স রশিদ',
                'পুরাতন ভোটার আইডি / স্লিপ',
            ],
            'পারিবারিক ও সামাজিক' => [
                'কাবিননামা / নিকাহনামা',
                'স্বামী বা স্ত্রীর এনআইডি কপি',
                'মৃত্যু নিবন্ধন সনদ / হাসপাতালের ডেথ সার্টিফিকেট',
                'ওয়ারিশগণের এনআইডি / জন্ম নিবন্ধন কপি',
                'সকল ওয়ারিশের সম্মতিপত্র',
                'তালাকনামা / বিবাহ বিচ্ছেদ সনদ',
            ],
            'জমি ও সম্পত্তি' => [
                'জমির দলিলের কপি',
                'খতিয়ান / পর্চা (আরএস / বিএস / এসএ)',
                'খারিজ / নামজারি খতিয়ান ও ডিসিআর',
                'ভূমি উন্নয়ন কর (খাজনা) রশিদ',
                'হোল্ডিং ট্যাক্স পরিশোধের রশিদ',
                'জমির নকশা / মৌজা ম্যাপ / সাইট প্ল্যান',
            ],
            'শিক্ষা ও চাকরি' => [
                'এসএসসি / এইচএসসি / সমমান সনদপত্র',
                'একাডেমিক ট্রান্সক্রিপ্ট / মার্কশিট',
                'প্রবেশপত্র / রেজিস্ট্রেশন কার্ড',
                'শিক্ষা প্রতিষ্ঠানের প্রত্যয়নপত্র',
                'অভিভাবকের এনআইডি কপি',
            ],
            'ব্যবসা ও লাইসেন্স' => [
                'ট্রেড লাইসেন্সের কপি',
                'দোকান / প্রতিষ্ঠান ভাড়ার চুক্তিপত্র',
                'টিআইএন (TIN) / বিন (BIN) সনদ',
                'ব্যাংক স্টেটমেন্ট / সলভেন্সি সনদ',
                'পরিবেশ / ফায়ার সার্ভিস ছাড়পত্র',
            ],
            'বিশেষ প্রমাণ' => [
                'নোটারি পাবলিক / বিজ্ঞ আদালতের এফিডেভিট',
                'থানার সাধারণ ডায়েরি (GD) কপি',
                'মেডিকেল / হাসপাতাল সনদপত্র',
                'ওজোপাডিকো / বিদ্যুৎ বিলের কপি',
                'ব্যাংক ঋণ বা হিসাব সংক্রান্ত কাগজ',
                'ওয়ার্ড কাউন্সিলর / দায়িত্বপ্রাপ্ত কর্মকর্তার সুপারিশ',
            ],
        ];
    }

    /**
     * Process uploaded proof attachments from request and merge with existing ones.
     */
    public static function processUploads(Request $r, array $existing = []): array
    {
        $items = array_values($existing);

        // Remove any deleted attachments if requested via delete_attachments[]
        if (is_array($r->input('delete_attachments'))) {
            $toDelete = $r->input('delete_attachments');
            $items = array_values(array_filter($items, function ($item, $idx) use ($toDelete) {
                return !in_array((string) $idx, array_map('strval', $toDelete), true);
            }, ARRAY_FILTER_USE_BOTH));
        }

        // 1. Core slots: core_attachments[nid], core_attachments[birth], etc.
        $coreLabels = self::coreSlots();
        if ($r->hasFile('core_attachments')) {
            foreach ($r->file('core_attachments') as $slotKey => $file) {
                if ($file instanceof UploadedFile && $file->isValid()) {
                    $stored = self::storeFile($file, $coreLabels[$slotKey] ?? $slotKey, $slotKey);
                    if ($stored) {
                        $items[] = $stored;
                    }
                }
            }
        }

        // 2. Extra categorized rows: extra_attachments_label[], extra_attachments_file[]
        if ($r->hasFile('extra_attachments_file')) {
            $labels = $r->input('extra_attachments_label', []);
            $custom = $r->input('extra_attachments_custom', []);
            foreach ($r->file('extra_attachments_file') as $idx => $file) {
                if ($file instanceof UploadedFile && $file->isValid()) {
                    $label = trim((string) ($custom[$idx] ?? ''));
                    if ($label === '') {
                        $label = trim((string) ($labels[$idx] ?? 'অন্যান্য প্রমাণক কাগজ'));
                    }
                    $stored = self::storeFile($file, $label ?: 'অন্যান্য প্রমাণক কাগজ', 'extra');
                    if ($stored) {
                        $items[] = $stored;
                    }
                }
            }
        }

        return $items;
    }

    protected static function storeFile(UploadedFile $file, string $label, string $slot): ?array
    {
        $ext = strtolower($file->getClientOriginalExtension() ?: 'dat');
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'pdf'];
        if (!in_array($ext, $allowed, true)) {
            return null;
        }

        $origName = $file->getClientOriginalName();
        $size     = $file->getSize();
        $mime     = $file->getClientMimeType();

        $subDir   = 'uploads/attestation/attachments/' . date('Y/m');
        $destDir  = public_path($subDir);
        if (!is_dir($destDir)) {
            @mkdir($destDir, 0775, true);
        }

        $filename = date('Ymd_His') . '_' . Str::random(8) . '.' . $ext;
        $file->move($destDir, $filename);

        return [
            'slot'        => $slot,
            'label'       => $label,
            'name'        => $origName,
            'path'        => $subDir . '/' . $filename,
            'mime'        => $mime,
            'size'        => $size,
            'uploaded_at' => now()->toDateTimeString(),
        ];
    }
}
