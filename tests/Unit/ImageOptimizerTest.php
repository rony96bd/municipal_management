<?php

namespace Tests\Unit;

use App\Services\ImageOptimizer;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\TestCase;

class ImageOptimizerTest extends TestCase
{
    private string $tempDir;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tempDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'image_optimizer_tests_' . bin2hex(random_bytes(4));
        if (!is_dir($this->tempDir)) {
            mkdir($this->tempDir, 0777, true);
        }
    }

    protected function tearDown(): void
    {
        if (is_dir($this->tempDir)) {
            $files = glob($this->tempDir . DIRECTORY_SEPARATOR . '*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
            @rmdir($this->tempDir);
        }
        parent::tearDown();
    }

    private function createTestImage(int $width, int $height, string $type = 'jpeg'): string
    {
        $im = imagecreatetruecolor($width, $height);
        // Fill with gradient or colors to simulate real image data
        for ($y = 0; $y < $height; $y += 10) {
            $col = imagecolorallocate($im, ($y * 5) % 255, (($y + 50) * 3) % 255, (($y + 100) * 7) % 255);
            imagefilledrectangle($im, 0, $y, $width, min($height, $y + 10), $col);
        }

        $filename = $this->tempDir . DIRECTORY_SEPARATOR . 'test_' . bin2hex(random_bytes(4)) . '.' . ($type === 'jpeg' ? 'jpg' : $type);

        if ($type === 'jpeg') {
            imagejpeg($im, $filename, 100); // uncompressed high quality
        } elseif ($type === 'png') {
            imagesavealpha($im, true);
            imagepng($im, $filename, 0); // uncompressed
        } elseif ($type === 'webp') {
            imagewebp($im, $filename, 100);
        }

        imagedestroy($im);
        return $filename;
    }

    public function test_large_jpeg_is_resized_and_optimized(): void
    {
        $optimizer = new ImageOptimizer([
            'max_dimension' => 1200,
            'jpeg_quality'  => 80,
        ]);

        // Create a 2400x1600 image (2:1 aspect ratio)
        $sourcePath = $this->createTestImage(2400, 1600, 'jpeg');
        $originalSize = filesize($sourcePath);

        $destPath = $this->tempDir . DIRECTORY_SEPARATOR . 'optimized_large.jpg';
        $result = $optimizer->optimizeFile($sourcePath, $destPath);

        $this->assertTrue($result['optimized']);
        $this->assertFileExists($destPath);

        // Check new dimensions: width should be 1200, height should be 800
        $sizeInfo = getimagesize($destPath);
        $this->assertSame(1200, $sizeInfo[0]);
        $this->assertSame(800, $sizeInfo[1]);

        // Check file size reduction
        $optimizedSize = filesize($destPath);
        $this->assertLessThan($originalSize, $optimizedSize);
        $this->assertSame($optimizedSize, $result['size']);
    }

    public function test_small_image_is_not_upscaled(): void
    {
        $optimizer = new ImageOptimizer([
            'max_dimension' => 2048,
            'jpeg_quality'  => 85,
        ]);

        $sourcePath = $this->createTestImage(400, 300, 'jpeg');
        $destPath = $this->tempDir . DIRECTORY_SEPARATOR . 'optimized_small.jpg';

        $result = $optimizer->optimizeFile($sourcePath, $destPath);

        $this->assertTrue($result['optimized']);
        $sizeInfo = getimagesize($destPath);
        $this->assertSame(400, $sizeInfo[0]);
        $this->assertSame(300, $sizeInfo[1]);
    }

    public function test_png_transparency_is_preserved(): void
    {
        $optimizer = new ImageOptimizer([
            'max_dimension'   => 1000,
            'png_compression' => 8,
        ]);

        // Create transparent PNG (1200x600)
        $im = imagecreatetruecolor(1200, 600);
        imagesavealpha($im, true);
        $transparent = imagecolorallocatealpha($im, 0, 0, 0, 127);
        imagefill($im, 0, 0, $transparent);
        $red = imagecolorallocatealpha($im, 255, 0, 0, 0); // solid red rectangle
        imagefilledrectangle($im, 100, 100, 500, 400, $red);

        $sourcePath = $this->tempDir . DIRECTORY_SEPARATOR . 'transparent_orig.png';
        imagepng($im, $sourcePath, 0);
        imagedestroy($im);

        $destPath = $this->tempDir . DIRECTORY_SEPARATOR . 'transparent_opt.png';
        $result = $optimizer->optimizeFile($sourcePath, $destPath);

        $this->assertTrue($result['optimized']);
        $this->assertFileExists($destPath);

        $sizeInfo = getimagesize($destPath);
        $this->assertSame(1000, $sizeInfo[0]);
        $this->assertSame(500, $sizeInfo[1]);

        // Verify transparency is preserved by checking pixel (0,0)
        $readIm = imagecreatefrompng($destPath);
        $rgb = imagecolorat($readIm, 0, 0);
        $colors = imagecolorsforindex($readIm, $rgb);
        $this->assertSame(127, $colors['alpha']);
        imagedestroy($readIm);
    }

    public function test_webp_image_optimization(): void
    {
        $optimizer = new ImageOptimizer([
            'max_dimension' => 800,
            'webp_quality'  => 75,
        ]);

        $sourcePath = $this->createTestImage(1600, 1200, 'webp');
        $destPath = $this->tempDir . DIRECTORY_SEPARATOR . 'optimized.webp';

        $result = $optimizer->optimizeFile($sourcePath, $destPath);

        $this->assertTrue($result['optimized']);
        $this->assertFileExists($destPath);

        $sizeInfo = getimagesize($destPath);
        $this->assertSame(800, $sizeInfo[0]);
        $this->assertSame(600, $sizeInfo[1]);
    }

    public function test_non_image_file_passes_through_unaltered(): void
    {
        $optimizer = new ImageOptimizer();

        $pdfContent = "%PDF-1.4\n1 0 obj\n<< /Type /Catalog >>\nendobj\ntrailer\n<< /Root 1 0 R >>\n%%EOF";
        $sourcePath = $this->tempDir . DIRECTORY_SEPARATOR . 'sample.pdf';
        file_put_contents($sourcePath, $pdfContent);

        $destPath = $this->tempDir . DIRECTORY_SEPARATOR . 'output.pdf';
        $result = $optimizer->optimizeFile($sourcePath, $destPath);

        $this->assertFalse($result['optimized']);
        $this->assertFileExists($destPath);
        $this->assertSame($pdfContent, file_get_contents($destPath));
        $this->assertSame('application/pdf', $result['mime_type']);
    }

    public function test_corrupted_image_falls_back_safely_without_crashing(): void
    {
        $optimizer = new ImageOptimizer();

        // Create corrupt file with .jpg extension
        $sourcePath = $this->tempDir . DIRECTORY_SEPARATOR . 'corrupt.jpg';
        file_put_contents($sourcePath, 'NOT_A_VALID_IMAGE_BYTES_1234567890');

        $destPath = $this->tempDir . DIRECTORY_SEPARATOR . 'corrupt_out.jpg';
        $result = $optimizer->optimizeFile($sourcePath, $destPath);

        $this->assertFalse($result['optimized']);
        $this->assertFileExists($destPath);
        $this->assertSame('NOT_A_VALID_IMAGE_BYTES_1234567890', file_get_contents($destPath));
    }

    public function test_optimize_uploaded_file_method(): void
    {
        $optimizer = new ImageOptimizer([
            'max_dimension' => 1500,
            'jpeg_quality'  => 82,
        ]);

        $sourcePath = $this->createTestImage(2000, 1000, 'jpeg');
        $uploadedFile = new UploadedFile(
            $sourcePath,
            'nid_front_photo.jpg',
            'image/jpeg',
            null,
            true
        );

        $destPath = $this->tempDir . DIRECTORY_SEPARATOR . 'saved_nid.jpg';
        $result = $optimizer->optimizeUploadedFile($uploadedFile, $destPath);

        $this->assertTrue($result['optimized']);
        $this->assertSame('nid_front_photo.jpg', $result['original_name']);
        $this->assertSame('image/jpeg', $result['mime_type']);
        $this->assertSame('jpg', $result['extension']);
        $this->assertSame(1500, $result['width']);
        $this->assertSame(750, $result['height']);
        $this->assertFileExists($destPath);
        $this->assertSame(filesize($destPath), $result['size']);
    }

    public function test_decompression_bomb_safety_check(): void
    {
        // Safe limit of 5 million pixels in test
        $optimizer = new ImageOptimizer([
            'max_pixel_count' => 1000000, // 1 megapixel limit for test
        ]);

        // 1200x1000 = 1,200,000 pixels (exceeds 1MP limit)
        $sourcePath = $this->createTestImage(1200, 1000, 'jpeg');
        $destPath = $this->tempDir . DIRECTORY_SEPARATOR . 'bomb_out.jpg';

        $result = $optimizer->optimizeFile($sourcePath, $destPath);

        // When pixel count exceeds safety threshold, it safely falls back to copy without running memory-heavy GD resampling
        $this->assertFalse($result['optimized']);
        $this->assertFileExists($destPath);
    }

    public function test_is_optimizable_image(): void
    {
        $optimizer = new ImageOptimizer();

        $jpeg = $this->createTestImage(100, 100, 'jpeg');
        $png = $this->createTestImage(100, 100, 'png');
        $webp = $this->createTestImage(100, 100, 'webp');

        $text = $this->tempDir . DIRECTORY_SEPARATOR . 'test.txt';
        file_put_contents($text, 'plain text');

        $this->assertTrue($optimizer->isOptimizableImage($jpeg));
        $this->assertTrue($optimizer->isOptimizableImage($png));
        $this->assertTrue($optimizer->isOptimizableImage($webp));
        $this->assertFalse($optimizer->isOptimizableImage($text));
        $this->assertFalse($optimizer->isOptimizableImage($this->tempDir . DIRECTORY_SEPARATOR . 'non_existent.jpg'));
    }

    public function test_memory_ceiling_defense_prevents_oom_and_falls_back_safely(): void
    {
        // Set a very low ceiling of 200KB for test to trigger defense
        $optimizer = new ImageOptimizer([
            'memory_ceiling_bytes' => 200 * 1024,
        ]);

        // A 1000x1000 image requires ~5MB RAM in GD
        $sourcePath = $this->createTestImage(1000, 1000, 'jpeg');
        $destPath = $this->tempDir . DIRECTORY_SEPARATOR . 'ceiling_out.jpg';

        $result = $optimizer->optimizeFile($sourcePath, $destPath);

        // Should safely avoid GD decompression to prevent OOM
        $this->assertFalse($result['optimized']);
        $this->assertTrue($result['memory_ceiling_hit'] ?? false);
        $this->assertFileExists($destPath);
        $this->assertSame(filesize($sourcePath), filesize($destPath));
    }

    public function test_explicit_memory_cleanup_frees_resources(): void
    {
        $optimizer = new ImageOptimizer();

        // Create and optimize multiple images in loop
        $sourcePath = $this->createTestImage(800, 600, 'jpeg');

        for ($i = 0; $i < 3; $i++) {
            $destPath = $this->tempDir . DIRECTORY_SEPARATOR . "loop_opt_{$i}.jpg";
            $res = $optimizer->optimizeFile($sourcePath, $destPath);
            $this->assertTrue($res['optimized']);
        }

        // Calling cleanMemory manually or verifying optimizer releases cycles
        $cleaned = ImageOptimizer::freeMemory();
        $this->assertIsInt($cleaned);
    }
}
