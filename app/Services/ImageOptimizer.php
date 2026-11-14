<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Throwable;

class ImageOptimizer
{
    protected array $config;

    public function __construct(array $config = [])
    {
        $defaults = [
            'max_dimension'   => 2048,
            'jpeg_quality'    => 82,
            'webp_quality'    => 82,
            'png_compression' => 7,
            'auto_orient'     => true,
            'strip_metadata'  => true,
            'max_pixel_count' => 36000000,
            'memory_limit'    => '256M',
        ];

        // Merge with config('image_optimizer') if available and bound in Laravel container
        $appConfig = [];
        try {
            if (function_exists('app') && app()->bound('config')) {
                $appConfig = config('image_optimizer') ?: [];
            }
        } catch (Throwable) {
            $appConfig = [];
        }

        $this->config = array_merge($defaults, $appConfig, $config);
    }

    /**
     * Optimize an UploadedFile and write to the target destination path.
     */
    public function optimizeUploadedFile(UploadedFile $file, string $targetPath, array $options = []): array
    {
        $dir = dirname($targetPath);
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }

        $origPath = $file->getRealPath();
        $origName = $file->getClientOriginalName();
        $ext = strtolower($file->getClientOriginalExtension() ?: pathinfo($targetPath, PATHINFO_EXTENSION) ?: 'jpg');

        $result = $this->optimizeFile($origPath, $targetPath, $options);
        $result['original_name'] = $origName;
        $result['extension']     = $ext;

        return $result;
    }

    /**
     * Optimize an image file from a source path to a destination path (or in-place).
     */
    public function optimizeFile(string $sourcePath, ?string $destinationPath = null, array $options = []): array
    {
        $destinationPath = $destinationPath ?: $sourcePath;
        $config = array_merge($this->config, $options);

        $dir = dirname($destinationPath);
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }

        // Determine MIME and dimensions safely
        $imageInfo = @getimagesize($sourcePath);
        if (!$imageInfo) {
            // Not a recognized image by GD (e.g. PDF, doc, corrupt image)
            return $this->safeFallback($sourcePath, $destinationPath, false);
        }

        $origWidth  = (int) ($imageInfo[0] ?? 0);
        $origHeight = (int) ($imageInfo[1] ?? 0);
        $mimeType   = $imageInfo['mime'] ?? 'application/octet-stream';

        // Check if supported raster image
        $supportedMimes = [
            'image/jpeg' => 'jpeg',
            'image/jpg'  => 'jpeg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
            'image/gif'  => 'gif',
        ];

        if (!isset($supportedMimes[$mimeType])) {
            return $this->safeFallback($sourcePath, $destinationPath, false, $mimeType, $origWidth, $origHeight);
        }

        $format = $supportedMimes[$mimeType];

        // Decompression bomb check: total pixel count
        $pixelCount = $origWidth * $origHeight;
        $maxPixelCount = (int) ($config['max_pixel_count'] ?? 36000000);
        if ($pixelCount > $maxPixelCount) {
            return $this->safeFallback($sourcePath, $destinationPath, false, $mimeType, $origWidth, $origHeight);
        }

        // Boost memory limit if needed
        $this->ensureMemoryLimit($config['memory_limit'] ?? '256M');

        // Per-request memory ceiling defense check
        if (!$this->canSafelyProcessImage($origWidth, $origHeight, $config)) {
            return $this->safeFallback($sourcePath, $destinationPath, false, $mimeType, $origWidth, $origHeight, true);
        }

        try {
            // Load source image resource
            $src = $this->createImageResource($sourcePath, $format);
            if (!$src) {
                return $this->safeFallback($sourcePath, $destinationPath, false, $mimeType, $origWidth, $origHeight);
            }

            // EXIF Orientation check for JPEG
            if (!empty($config['auto_orient']) && $format === 'jpeg' && function_exists('exif_read_data')) {
                $exif = @exif_read_data($sourcePath);
                $orientation = (int) ($exif['Orientation'] ?? 1);
                if (in_array($orientation, [3, 6, 8], true)) {
                    $angle = match ($orientation) {
                        3 => 180,
                        6 => 270, // In GD, anticlockwise 270 = clockwise 90
                        8 => 90,  // In GD, anticlockwise 90 = clockwise 270
                        default => 0,
                    };
                    if ($angle !== 0) {
                        $rotated = imagerotate($src, $angle, 0);
                        if ($rotated) {
                            imagedestroy($src);
                            $src = $rotated;
                            $origWidth  = imagesx($src);
                            $origHeight = imagesy($src);
                        }
                    }
                }
            }

            // Calculate new dimensions
            $maxDim = (int) ($config['max_dimension'] ?? 2048);
            if ($origWidth > $maxDim || $origHeight > $maxDim) {
                if ($origWidth >= $origHeight) {
                    $newWidth  = $maxDim;
                    $newHeight = (int) max(1, round(($origHeight * $maxDim) / $origWidth));
                } else {
                    $newHeight = $maxDim;
                    $newWidth  = (int) max(1, round(($origWidth * $maxDim) / $origHeight));
                }
            } else {
                $newWidth  = $origWidth;
                $newHeight = $origHeight;
            }

            // Create target canvas
            $dst = imagecreatetruecolor($newWidth, $newHeight);

            // Handle transparency for PNG and WebP
            if ($format === 'png' || $format === 'webp') {
                imagealphablending($dst, false);
                imagesavealpha($dst, true);
                $transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
                imagefilledrectangle($dst, 0, 0, $newWidth, $newHeight, $transparent);
            } elseif ($format === 'gif') {
                $transIndex = imagecolortransparent($src);
                if ($transIndex >= 0) {
                    $transColor = imagecolorsforindex($src, $transIndex);
                    $transIndex = imagecolorallocate($dst, $transColor['red'], $transColor['green'], $transColor['blue']);
                    imagefill($dst, 0, 0, $transIndex);
                    imagecolortransparent($dst, $transIndex);
                }
            }

            // Resample
            imagecopyresampled(
                $dst,
                $src,
                0, 0, 0, 0,
                $newWidth, $newHeight,
                imagesx($src), imagesy($src)
            );

            // Save to temp file first to ensure atomic write
            $tempDest = $destinationPath . '.tmp.' . bin2hex(random_bytes(4));
            $saved = $this->writeImageResource($dst, $tempDest, $format, $config);

            imagedestroy($src);
            imagedestroy($dst);
            unset($src, $dst);
            self::freeMemory();

            if ($saved && file_exists($tempDest) && filesize($tempDest) > 0) {
                // If destination exists, unlink before rename on Windows
                if (file_exists($destinationPath)) {
                    @unlink($destinationPath);
                }
                rename($tempDest, $destinationPath);

                $finalSize = filesize($destinationPath);
                return [
                    'path'                 => $destinationPath,
                    'mime_type'            => $mimeType,
                    'size'                 => $finalSize,
                    'width'                => $newWidth,
                    'height'               => $newHeight,
                    'optimized'            => true,
                    'memory_ceiling_hit'   => false,
                ];
            }

            if (file_exists($tempDest)) {
                @unlink($tempDest);
            }

            return $this->safeFallback($sourcePath, $destinationPath, false, $mimeType, $origWidth, $origHeight);
        } catch (Throwable) {
            if (isset($src) && is_object($src)) {
                imagedestroy($src);
                unset($src);
            }
            if (isset($dst) && is_object($dst)) {
                imagedestroy($dst);
                unset($dst);
            }
            self::freeMemory();
            return $this->safeFallback($sourcePath, $destinationPath, false, $mimeType, $origWidth, $origHeight);
        }
    }

    /**
     * Check whether a given file path is an optimizable image.
     */
    public function isOptimizableImage(string $path): bool
    {
        if (!is_file($path) || !is_readable($path)) {
            return false;
        }

        $info = @getimagesize($path);
        if (!$info) {
            return false;
        }

        return in_array($info['mime'] ?? '', [
            'image/jpeg',
            'image/jpg',
            'image/png',
            'image/webp',
            'image/gif',
        ], true);
    }

    protected function createImageResource(string $path, string $format)
    {
        return match ($format) {
            'jpeg' => @imagecreatefromjpeg($path),
            'png'  => @imagecreatefrompng($path),
            'webp' => @imagecreatefromwebp($path),
            'gif'  => @imagecreatefromgif($path),
            default => null,
        };
    }

    protected function writeImageResource($resource, string $targetPath, string $format, array $config): bool
    {
        return match ($format) {
            'jpeg' => imagejpeg($resource, $targetPath, (int) ($config['jpeg_quality'] ?? 82)),
            'png'  => imagepng($resource, $targetPath, (int) ($config['png_compression'] ?? 7)),
            'webp' => imagewebp($resource, $targetPath, (int) ($config['webp_quality'] ?? 82)),
            'gif'  => imagegif($resource, $targetPath),
            default => false,
        };
    }

    /**
     * Explicit garbage collection helper to clean unreferenced memory buffers.
     */
    public static function freeMemory(): int
    {
        return function_exists('gc_collect_cycles') ? gc_collect_cycles() : 0;
    }

    /**
     * Check if current memory allows decompression without triggering OOM crashes.
     */
    public function canSafelyProcessImage(int $width, int $height, array $config = []): bool
    {
        $mergedConfig = array_merge($this->config, $config);

        // 1. Hard ceiling in bytes if specified
        $ceilingBytes = $mergedConfig['memory_ceiling_bytes'] ?? null;

        if ($ceilingBytes === null) {
            $memLimit = ini_get('memory_limit');
            if ($memLimit === false || $memLimit === '-1') {
                return true;
            }
            $totalBytes = $this->parseBytes($memLimit);
            $percentage = (int) ($mergedConfig['memory_ceiling_percentage'] ?? 80);
            $ceilingBytes = (int) ($totalBytes * ($percentage / 100));
        }

        // Estimated memory for truecolor RGBA canvas (4 bytes) + GD internal buffers (~5x)
        $estimatedBytes = $width * $height * 5;
        $currentUsage   = memory_get_usage(true);

        if (($currentUsage + $estimatedBytes) > $ceilingBytes) {
            // Run immediate garbage collection and test once more
            self::freeMemory();
            $currentUsage = memory_get_usage(true);
            if (($currentUsage + $estimatedBytes) > $ceilingBytes) {
                return false;
            }
        }

        return true;
    }

    protected function safeFallback(
        string $sourcePath,
        string $destinationPath,
        bool $optimized = false,
        ?string $mimeType = null,
        ?int $width = null,
        ?int $height = null,
        bool $memoryCeilingHit = false
    ): array {
        if ($sourcePath !== $destinationPath && file_exists($sourcePath)) {
            @copy($sourcePath, $destinationPath);
        }

        $finalSize = file_exists($destinationPath) ? filesize($destinationPath) : 0;
        $finalMime = $mimeType ?: (function_exists('mime_content_type') && file_exists($destinationPath) ? @mime_content_type($destinationPath) : 'application/octet-stream');

        return [
            'path'               => $destinationPath,
            'mime_type'          => $finalMime,
            'size'               => $finalSize,
            'width'              => $width,
            'height'             => $height,
            'optimized'          => $optimized,
            'memory_ceiling_hit' => $memoryCeilingHit,
        ];
    }

    protected function ensureMemoryLimit(string $limit): void
    {
        $current = ini_get('memory_limit');
        if ($current === false || $current === '-1') {
            return;
        }

        $currentBytes = $this->parseBytes($current);
        $targetBytes  = $this->parseBytes($limit);

        if ($currentBytes < $targetBytes) {
            @ini_set('memory_limit', $limit);
        }
    }

    protected function parseBytes(string $val): int
    {
        $val = trim($val);
        $last = strtolower($val[strlen($val) - 1]);
        $num = (int) $val;

        return match ($last) {
            'g' => $num * 1024 * 1024 * 1024,
            'm' => $num * 1024 * 1024,
            'k' => $num * 1024,
            default => (int) $val,
        };
    }
}
