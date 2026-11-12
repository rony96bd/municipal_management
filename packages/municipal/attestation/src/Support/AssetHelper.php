<?php

namespace Municipal\Attestation\Support;

class AssetHelper
{
    /** Contents of the packaged qrcode.js so pages work without `vendor:publish`. */
    public static function qrcodeJs(): string
    {
        $path = dirname(__DIR__, 2) . '/resources/assets/qrcode.js';
        return file_exists($path) ? file_get_contents($path) : '';
    }
}
