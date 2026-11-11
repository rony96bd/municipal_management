<?php

namespace Municipal\Attestation\Support;

class BengaliHelper
{
    private const BENGALI_DIGITS = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
    private const ENGLISH_DIGITS = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    /**
     * Convert ASCII digits (0-9) in a string/number to Bengali digits (০-৯).
     */
    public static function toBengaliDigits(string|int $n): string
    {
        return str_replace(self::ENGLISH_DIGITS, self::BENGALI_DIGITS, (string) $n);
    }

    /**
     * Convert Bengali digits (০-৯) in a string to ASCII digits (0-9).
     */
    public static function toEnglishDigits(string $n): string
    {
        return str_replace(self::BENGALI_DIGITS, self::ENGLISH_DIGITS, $n);
    }

    /**
     * Convert an integer to its Bengali word representation.
     * Supports up to crore level (1,00,00,000).
     */
    public static function numberToWords(int $n): string
    {
        if ($n < 0) {
            return 'ঋণাত্মক ' . self::numberToWords(abs($n));
        }

        if ($n === 0) {
            return 'শূন্য';
        }

        $ones = [
            '', 'এক', 'দুই', 'তিন', 'চার', 'পাঁচ', 'ছয়', 'সাত', 'আট', 'নয়',
            'দশ', 'এগারো', 'বারো', 'তেরো', 'চৌদ্দ', 'পনেরো', 'ষোলো', 'সতেরো', 'আঠারো', 'উনিশ',
        ];

        $tens = [
            '', 'দশ', 'বিশ', 'ত্রিশ', 'চল্লিশ', 'পঞ্চাশ', 'ষাট', 'সত্তর', 'আশি', 'নব্বই',
        ];

        // Special Bengali compound tens (21-99 have unique forms in some dialects;
        // we use the standard additive form for clarity)
        $words = '';

        // Crore (1,00,00,000)
        if ($n >= 10000000) {
            $words .= self::numberToWords((int) ($n / 10000000)) . ' কোটি ';
            $n %= 10000000;
        }

        // Lakh (1,00,000)
        if ($n >= 100000) {
            $words .= self::numberToWords((int) ($n / 100000)) . ' লক্ষ ';
            $n %= 100000;
        }

        // Thousand (1,000)
        if ($n >= 1000) {
            $words .= self::numberToWords((int) ($n / 1000)) . ' হাজার ';
            $n %= 1000;
        }

        // Hundred
        if ($n >= 100) {
            $words .= $ones[(int) ($n / 100)] . ' শত ';
            $n %= 100;
        }

        // Tens and ones
        if ($n > 0) {
            if ($n < 20) {
                $words .= $ones[$n];
            } else {
                $words .= $tens[(int) ($n / 10)];
                if ($n % 10 !== 0) {
                    $words .= ' ' . $ones[$n % 10];
                }
            }
        }

        return rtrim($words);
    }
}
