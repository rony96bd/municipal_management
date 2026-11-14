<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Image Optimization Configuration
    |--------------------------------------------------------------------------
    |
    | Defines optimization parameters for user-uploaded image attachments,
    | citizen proof documents, media gallery, banners, and posts.
    |
    */

    // Maximum dimension (width or height) in pixels.
    // 2048px preserves sharp print quality (200-300 DPI on A4 paper) while drastically reducing file size.
    'max_dimension' => (int) env('IMAGE_OPTIMIZER_MAX_DIMENSION', 2048),

    // JPEG quality level (1-100). 82 is the industry sweet-spot for crisp visual clarity and small size.
    'jpeg_quality' => (int) env('IMAGE_OPTIMIZER_JPEG_QUALITY', 82),

    // WebP quality level (1-100).
    'webp_quality' => (int) env('IMAGE_OPTIMIZER_WEBP_QUALITY', 82),

    // PNG compression level (0 = none, 9 = max compression).
    'png_compression' => (int) env('IMAGE_OPTIMIZER_PNG_COMPRESSION', 7),

    // Automatically correct orientation based on EXIF tag (critical for smartphone photos).
    'auto_orient' => (bool) env('IMAGE_OPTIMIZER_AUTO_ORIENT', true),

    // Strip redundant metadata (EXIF/GPS/device info) to save space and protect citizen privacy.
    'strip_metadata' => (bool) env('IMAGE_OPTIMIZER_STRIP_METADATA', true),

    // Maximum total pixel count allowed for decompression (e.g. 36 MP = 6000x6000). Protects against memory exhaustion bombs.
    'max_pixel_count' => (int) env('IMAGE_OPTIMIZER_MAX_PIXEL_COUNT', 36000000),

    // Minimum runtime memory limit to ensure during image processing.
    'memory_limit' => env('IMAGE_OPTIMIZER_MEMORY_LIMIT', '256M'),

    // Per-request memory ceiling defense percentage (e.g. 80% of allowed memory_limit).
    // Prevents fatal "Allowed memory size exhausted" crashes under high concurrency or huge batches.
    'memory_ceiling_percentage' => (int) env('IMAGE_OPTIMIZER_MEMORY_CEILING_PERCENTAGE', 80),

    // Optional hard ceiling in bytes (if set, overrides percentage).
    'memory_ceiling_bytes' => env('IMAGE_OPTIMIZER_MEMORY_CEILING_BYTES') ? (int) env('IMAGE_OPTIMIZER_MEMORY_CEILING_BYTES') : null,

    // Client-side canvas pre-compression settings for browser forms.
    'client_compression' => [
        'enabled'        => (bool) env('IMAGE_OPTIMIZER_CLIENT_COMPRESSION', true),
        'max_dimension'  => (int) env('IMAGE_OPTIMIZER_CLIENT_MAX_DIM', 2048),
        'quality'        => (float) env('IMAGE_OPTIMIZER_CLIENT_QUALITY', 0.82),
        'min_size_bytes' => (int) env('IMAGE_OPTIMIZER_CLIENT_MIN_SIZE', 256000), // Skip files < 250KB
    ],
];
