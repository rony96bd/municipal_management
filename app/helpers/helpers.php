<?php

if (!function_exists('ctbn')) {
    function convertToBanglaNumber($number)
    {
        $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ','];
        $banglaDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', ','];
        return str_replace($englishDigits, $banglaDigits, $number);
    }
}

if (!function_exists('ctbd')) {
    function convertDaystoBangla($days)
    {
        $englishdays = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $bangladays = ['শনিবারের', 'রবিবারের', 'সোমবারের', 'মঙ্গলবারের', 'বুধবারের', 'বৃহস্পতিবারের', 'শুক্রবারের'];
        return str_replace($englishdays, $bangladays, $days);
    }
}

function convertMonthToBangla($month)
{
    $months = [
        1 => 'জানুয়ারি',
        2 => 'ফেব্রুয়ারি',
        3 => 'মার্চ',
        4 => 'এপ্রিল',
        5 => 'মে',
        6 => 'জুন',
        7 => 'জুলাই',
        8 => 'আগস্ট',
        9 => 'সেপ্টেম্বর',
        10 => 'অক্টোবর',
        11 => 'নভেম্বর',
        12 => 'ডিসেম্বর',
    ];

    return $months[$month] ?? ''; // Return the Bangla month name
}

if (!function_exists('formatBanglaCurrency')) {
    function formatBanglaCurrency($number)
    {
        $formatted = number_format($number, 0, '.', ',');
        return convertToBanglaNumber($formatted);
    }
}

if (!function_exists('englishToBanglaNumber')) {
    function englishToBanglaNumber($number)
    {
        $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $banglaDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];

        return str_replace($englishDigits, $banglaDigits, $number);
    }
}
