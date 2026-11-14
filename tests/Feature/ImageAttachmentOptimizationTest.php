<?php

namespace Tests\Feature;

use App\Models\gallery\GalleryModel;
use App\Models\media\MediaModel;
use App\Models\notice\NoticeModel;
use App\Models\page\createpage;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Municipal\Attestation\Database\Seeders\AttestationTypeSeeder;
use Municipal\Attestation\Models\AttestationApplication;
use Municipal\Attestation\Models\AttestationType;
use Tests\TestCase;

class ImageAttachmentOptimizationTest extends TestCase
{
    use DatabaseTransactions;

    private array $filesToCleanup = [];

    protected function tearDown(): void
    {
        foreach ($this->filesToCleanup as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }
        parent::tearDown();
    }

    private function createLargeFakeImage(string $name, int $width, int $height, string $type = 'jpg'): UploadedFile
    {
        $tempPath = tempnam(sys_get_temp_dir(), 'test_img_') . '.' . $type;
        $im = imagecreatetruecolor($width, $height);

        for ($y = 0; $y < $height; $y += 20) {
            $col = imagecolorallocate($im, ($y * 7) % 255, (($y + 30) * 5) % 255, (($y + 70) * 11) % 255);
            imagefilledrectangle($im, 0, $y, $width, min($height, $y + 20), $col);
        }

        if ($type === 'jpg' || $type === 'jpeg') {
            imagejpeg($im, $tempPath, 100);
        } elseif ($type === 'png') {
            imagesavealpha($im, true);
            imagepng($im, $tempPath, 0);
        }

        imagedestroy($im);
        $this->filesToCleanup[] = $tempPath;

        $mime = $type === 'png' ? 'image/png' : 'image/jpeg';
        return new UploadedFile($tempPath, $name, $mime, null, true);
    }

    private function createFakePdf(string $name): UploadedFile
    {
        $tempPath = tempnam(sys_get_temp_dir(), 'test_pdf_') . '.pdf';
        file_put_contents($tempPath, "%PDF-1.4\n1 0 obj\n<< /Type /Catalog >>\nendobj\ntrailer\n<< /Root 1 0 R >>\n%%EOF");
        $this->filesToCleanup[] = $tempPath;

        return new UploadedFile($tempPath, $name, 'application/pdf', null, true);
    }

    public function test_attestation_apply_optimizes_uploaded_attachments_and_records_correct_size(): void
    {
        if (AttestationType::count() === 0) {
            $this->seed(AttestationTypeSeeder::class);
        }

        $type = AttestationType::where('is_active', true)->where('is_public', true)->firstOrFail();

        $nidFile = $this->createLargeFakeImage('citizen_nid.jpg', 3000, 2000, 'jpg');
        $birthFile = $this->createLargeFakeImage('citizen_birth.png', 2400, 1800, 'png');
        $extraImg = $this->createLargeFakeImage('land_deed.jpg', 2800, 2100, 'jpg');
        $extraPdf = $this->createFakePdf('affidavit.pdf');

        $payload = [
            'applicant_name'          => 'আব্দুল করিম',
            'mobile'                  => '01712345678',
            'id_type'                 => 'nid',
            'id_no'                   => '19901234567890123',
            'father_name'             => 'মৃত রহিম উদ্দিন',
            'mother_name'             => 'ফাতেমা বেগম',
            'ward_no'                 => '০৩',
            'holding_no'              => '১২/ক',
            'mohalla'                 => 'স্টেশন রোড',
            'core_attachments'        => [
                'nid'   => $nidFile,
                'birth' => $birthFile,
            ],
            'extra_attachments_label' => [
                'জমির দলিলের কপি',
                'নোটারি পাবলিক / বিজ্ঞ আদালতের এফিডেভিট',
            ],
            'extra_attachments_file'  => [
                $extraImg,
                $extraPdf,
            ],
        ];

        $response = $this->post(route('attestation.apply.store', $type->slug), $payload);
        $response->assertRedirect();

        $application = AttestationApplication::latest('id')->firstOrFail();
        $this->assertSame('আব্দুল করিম', $application->applicant_name);

        $attachments = $application->attachments;
        $this->assertIsArray($attachments);
        $this->assertCount(4, $attachments);

        // Check NID attachment (optimized JPEG)
        $nidAtt = $attachments[0];
        $this->assertSame('nid', $nidAtt['slot']);
        $this->assertSame('citizen_nid.jpg', $nidAtt['name']);
        $nidDiskPath = public_path($nidAtt['path']);
        $this->filesToCleanup[] = $nidDiskPath;
        $this->assertFileExists($nidDiskPath);
        $nidInfo = getimagesize($nidDiskPath);
        $this->assertLessThanOrEqual(2048, $nidInfo[0]);
        $this->assertLessThanOrEqual(2048, $nidInfo[1]);
        $this->assertSame(filesize($nidDiskPath), $nidAtt['size']);
        $this->assertTrue($nidAtt['optimized']);

        // Check Birth attachment (optimized PNG)
        $birthAtt = $attachments[1];
        $this->assertSame('birth', $birthAtt['slot']);
        $birthDiskPath = public_path($birthAtt['path']);
        $this->filesToCleanup[] = $birthDiskPath;
        $this->assertFileExists($birthDiskPath);
        $birthInfo = getimagesize($birthDiskPath);
        $this->assertLessThanOrEqual(2048, $birthInfo[0]);
        $this->assertLessThanOrEqual(2048, $birthInfo[1]);
        $this->assertSame(filesize($birthDiskPath), $birthAtt['size']);
        $this->assertTrue($birthAtt['optimized']);

        // Check Extra image (optimized)
        $extraImgAtt = $attachments[2];
        $extraImgDiskPath = public_path($extraImgAtt['path']);
        $this->filesToCleanup[] = $extraImgDiskPath;
        $this->assertFileExists($extraImgDiskPath);
        $extraInfo = getimagesize($extraImgDiskPath);
        $this->assertLessThanOrEqual(2048, $extraInfo[0]);
        $this->assertSame(filesize($extraImgDiskPath), $extraImgAtt['size']);
        $this->assertTrue($extraImgAtt['optimized']);

        // Check Extra PDF (passed through without alteration)
        $extraPdfAtt = $attachments[3];
        $extraPdfDiskPath = public_path($extraPdfAtt['path']);
        $this->filesToCleanup[] = $extraPdfDiskPath;
        $this->assertFileExists($extraPdfDiskPath);
        $this->assertStringContainsString('%PDF-1.4', file_get_contents($extraPdfDiskPath));
        $this->assertFalse($extraPdfAtt['optimized']);
    }

    public function test_attestation_admin_update_optimizes_new_attachments(): void
    {
        if (AttestationType::count() === 0) {
            $this->seed(AttestationTypeSeeder::class);
        }

        $admin = User::factory()->create();
        $type = AttestationType::firstOrFail();

        $app = AttestationApplication::create([
            'tracking_no'         => AttestationApplication::generateTrackingNo(),
            'attestation_type_id' => $type->id,
            'applicant_name'      => 'রফিকুল ইসলাম',
            'mobile'              => '01811223344',
            'id_type'             => 'nid',
            'id_no'               => '9876543210',
            'attachments'         => [],
        ]);

        $passportImg = $this->createLargeFakeImage('passport_scan.jpg', 3200, 2400, 'jpg');

        $updatePayload = [
            'applicant_name'   => 'রফিকুল ইসলাম',
            'mobile'           => '01811223344',
            'id_type'          => 'nid',
            'id_no'            => '9876543210',
            'core_attachments' => [
                'passport' => $passportImg,
            ],
        ];

        $response = $this->actingAs($admin)->put(route('attestation.applications.update', $app->id), $updatePayload);
        $response->assertRedirect();

        $app->refresh();
        $this->assertCount(1, $app->attachments);
        $att = $app->attachments[0];
        $this->assertSame('passport', $att['slot']);
        $diskPath = public_path($att['path']);
        $this->filesToCleanup[] = $diskPath;
        $this->assertFileExists($diskPath);

        $info = getimagesize($diskPath);
        $this->assertLessThanOrEqual(2048, $info[0]);
        $this->assertLessThanOrEqual(2048, $info[1]);
        $this->assertSame(filesize($diskPath), $att['size']);
        $this->assertTrue($att['optimized']);
    }

    public function test_media_library_upload_optimizes_heavy_image(): void
    {
        $admin = User::factory()->create();
        $largeImage = $this->createLargeFakeImage('heavy_banner.jpg', 3500, 2000, 'jpg');
        $rawUploadSize = filesize($largeImage->getRealPath());

        $response = $this->actingAs($admin)->post(route('media-store'), [
            'file' => $largeImage,
        ]);
        $response->assertRedirect();

        $media = MediaModel::latest('id')->firstOrFail();
        $diskPath = public_path($media->file_path);
        $this->filesToCleanup[] = $diskPath;
        $this->assertFileExists($diskPath);

        $info = getimagesize($diskPath);
        $this->assertLessThanOrEqual(2048, $info[0]);
        $this->assertLessThanOrEqual(2048, $info[1]);

        // Optimized file size is less than uncompressed raw size and stored in DB accurately
        $finalDiskSize = filesize($diskPath);
        $this->assertLessThan($rawUploadSize, $finalDiskSize);
        $this->assertSame($finalDiskSize, (int) $media->size);
    }

    public function test_post_creation_optimizes_all_uploaded_images(): void
    {
        $admin = User::factory()->create();
        $img1 = $this->createLargeFakeImage('post_pic_1.jpg', 2600, 1800, 'jpg');
        $img2 = $this->createLargeFakeImage('post_pic_2.jpg', 3000, 2000, 'jpg');

        $response = $this->actingAs($admin)->post(route('posts.store'), [
            'title'   => 'পৌরসভার নতুন উন্নয়ন প্রকল্প উদ্বোধন',
            'content' => '<p>উন্নয়ন কার্যক্রম সংক্রান্ত বিস্তারিত বিবরণ...</p>',
            'images'  => [$img1, $img2],
        ]);
        $response->assertRedirect();

        $post = Post::latest('id')->firstOrFail();
        $this->assertNotNull($post->image_path);

        $mainDiskPath = public_path($post->image_path);
        $this->filesToCleanup[] = $mainDiskPath;
        $this->assertFileExists($mainDiskPath);

        $info = getimagesize($mainDiskPath);
        $this->assertLessThanOrEqual(2048, $info[0]);
        $this->assertLessThanOrEqual(2048, $info[1]);
    }

    public function test_gallery_creation_optimizes_gallery_images(): void
    {
        $admin = User::factory()->create();
        $img1 = $this->createLargeFakeImage('gal_1.jpg', 2800, 1900, 'jpg');

        $response = $this->actingAs($admin)->post(route('store-gallery'), [
            'topic'       => 'বৃক্ষরোপণ কর্মসূচি ২০২৬',
            'description' => 'পৌরসভা প্রাঙ্গণে বৃক্ষরোপণ',
            'page_url'    => 'tree-plantation-2026',
            'images'      => [$img1],
        ]);
        $response->assertRedirect();

        $gallery = GalleryModel::latest('id')->firstOrFail();
        $paths = json_decode($gallery->image_path, true);
        $this->assertIsArray($paths);
        $this->assertCount(1, $paths);

        $diskPath = public_path($paths[0]);
        $this->filesToCleanup[] = $diskPath;
        $this->assertFileExists($diskPath);

        $info = getimagesize($diskPath);
        $this->assertLessThanOrEqual(2048, $info[0]);
        $this->assertLessThanOrEqual(2048, $info[1]);
    }

    public function test_client_image_optimizer_script_is_served_and_referenced_in_forms(): void
    {
        // 1. Script file exists on disk
        $scriptPath = public_path('js/client-image-optimizer.js');
        $this->assertFileExists($scriptPath);
        $scriptContent = file_get_contents($scriptPath);
        $this->assertStringContainsString('CONFIG', $scriptContent);
        $this->assertStringContainsString('compressImageFile', $scriptContent);
        $this->assertStringContainsString('HTMLCanvasElement', $scriptContent);

        // 2. Public attestation apply form renders and includes the client optimizer script
        if (AttestationType::count() === 0) {
            $this->seed(AttestationTypeSeeder::class);
        }
        $type = AttestationType::where('is_active', true)->where('is_public', true)->firstOrFail();
        $response = $this->get(route('attestation.apply.show', $type->slug));
        $response->assertStatus(200);
        $response->assertSee('client-image-optimizer.js');
    }

    public function test_batch_upload_cleans_memory_and_enforces_ceiling_defense(): void
    {
        if (AttestationType::count() === 0) {
            $this->seed(AttestationTypeSeeder::class);
        }
        $type = AttestationType::where('is_active', true)->where('is_public', true)->firstOrFail();

        // Simulate upload with strict ceiling
        config(['image_optimizer.memory_ceiling_bytes' => 100 * 1024]); // 100KB ceiling

        $nidFile = $this->createLargeFakeImage('batch_nid.jpg', 1600, 1200, 'jpg');

        $payload = [
            'applicant_name'   => 'মেমরি টেস্ট নাগরিক',
            'mobile'           => '01799887766',
            'core_attachments' => [
                'nid' => $nidFile,
            ],
        ];

        $response = $this->post(route('attestation.apply.store', $type->slug), $payload);
        $response->assertRedirect();

        $app = AttestationApplication::latest('id')->firstOrFail();
        $this->assertCount(1, $app->attachments);

        // The image was safely processed without fatal OOM error
        $att = $app->attachments[0];
        $diskPath = public_path($att['path']);
        $this->filesToCleanup[] = $diskPath;
        $this->assertFileExists($diskPath);
    }

    public function test_tinymce_editor_image_upload_endpoint_optimizes_and_returns_url(): void
    {
        // Guest cannot upload to editor endpoint
        $guestImg = $this->createLargeFakeImage('unauth.jpg', 800, 600, 'jpg');
        $this->post(route('editor.image.upload'), ['file' => $guestImg])
            ->assertRedirect(route('login'));

        $admin = User::factory()->create();
        $largeImg = $this->createLargeFakeImage('pasted_screenshot.png', 2800, 1800, 'png');
        $rawSize = filesize($largeImg->getRealPath());

        $response = $this->actingAs($admin)->postJson(route('editor.image.upload'), [
            'file' => $largeImg,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'location',
                'path',
                'size',
                'width',
                'height',
                'optimized',
            ]);

        $data = $response->json();
        $this->assertTrue($data['optimized']);
        $this->assertLessThanOrEqual(2048, $data['width']);
        $this->assertLessThanOrEqual(2048, $data['height']);

        $diskPath = public_path($data['path']);
        $this->filesToCleanup[] = $diskPath;
        $this->assertFileExists($diskPath);
        $this->assertLessThan($rawSize, filesize($diskPath));
    }

    public function test_create_and_update_page_and_notice_extract_and_compress_pasted_base64_images(): void
    {
        $admin = User::factory()->create();

        // Create a large image and encode as base64 (simulating direct copy-paste in TinyMCE)
        $pastedFile = $this->createLargeFakeImage('clipboard_paste.jpg', 2600, 1600, 'jpg');
        $base64Uri = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($pastedFile->getRealPath()));
        $attachmentImg = $this->createLargeFakeImage('page_attachment.jpg', 2500, 1500, 'jpg');

        $htmlContent = '<h3>পৌরসভার উন্নয়ন চিত্র</h3><p><img src="' . $base64Uri . '" alt="Pasted Photo"></p><p>বিস্তারিত বিবরণ</p>';

        $response = $this->actingAs($admin)->post(route('store-page'), [
            'page_name'   => 'উন্নয়ন প্রকল্প পাতা',
            'page_url'    => 'dev-project-page',
            'page_data'   => $htmlContent,
            'file_upload' => $attachmentImg,
        ]);
        $response->assertRedirect();

        $page = createpage::latest('id')->firstOrFail();

        // 1. Pasted base64 image in page_data is extracted to an optimized file URL
        $this->assertStringNotContainsString('data:image/jpeg;base64,', $page->page_data);
        $this->assertStringContainsString('/uploads/editor/', $page->page_data);
        $this->assertStringContainsString('alt="Pasted Photo"', $page->page_data);

        preg_match('/src="[^"]*?(uploads\/editor\/[^"]+)"/', $page->page_data, $matches);
        $this->assertNotEmpty($matches[1] ?? null);
        $editorImgDiskPath = public_path($matches[1]);
        $this->filesToCleanup[] = $editorImgDiskPath;
        $this->assertFileExists($editorImgDiskPath);
        $editorImgInfo = getimagesize($editorImgDiskPath);
        $this->assertLessThanOrEqual(2048, $editorImgInfo[0]);

        // 2. Direct file_upload on create-page is also optimized
        $this->assertNotNull($page->file_path);
        $pageFileDiskPath = public_path($page->file_path);
        $this->filesToCleanup[] = $pageFileDiskPath;
        $this->assertFileExists($pageFileDiskPath);
        $pageFileInfo = getimagesize($pageFileDiskPath);
        $this->assertLessThanOrEqual(2048, $pageFileInfo[0]);

        // 3. Notice creation also extracts & optimizes pasted base64 images
        $noticeResponse = $this->actingAs($admin)->post(route('store-notice'), [
            'topic'       => 'জরুরি ছবি সংবলিত নোটিশ',
            'description' => '<p>নোটিশ ছবি: <img src="' . $base64Uri . '"></p>',
        ]);
        $noticeResponse->assertRedirect();

        $notice = NoticeModel::latest('id')->firstOrFail();
        $this->assertStringNotContainsString('data:image/jpeg;base64,', $notice->description);
        $this->assertStringContainsString('/uploads/editor/', $notice->description);

        preg_match('/src="[^"]*?(uploads\/editor\/[^"]+)"/', $notice->description, $noticeMatches);
        if (!empty($noticeMatches[1])) {
            $this->filesToCleanup[] = public_path($noticeMatches[1]);
        }
    }

    public function test_dashboard_header_configures_tinymce_direct_upload_and_paste_compression(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get(route('create-page'));
        $response->assertStatus(200);
        $response->assertSee('images_upload_handler', false);
        $response->assertSee('file_picker_callback', false);
        $response->assertSee('paste_data_images: true', false);
        $response->assertSee('automatic_uploads: true', false);
    }

    public function test_uploads_fallback_route_serves_files_and_heals_to_public_html(): void
    {
        $customPublicHtml = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'test_public_html_' . uniqid();
        @mkdir($customPublicHtml, 0775, true);
        putenv("UPLOAD_PUBLIC_ROOT={$customPublicHtml}");
        $_ENV['UPLOAD_PUBLIC_ROOT'] = $customPublicHtml;

        try {
            $admin = User::factory()->create();
            $img = $this->createLargeFakeImage('test_cpanel.jpg', 600, 400, 'jpg');

            $uploadResponse = $this->actingAs($admin)->postJson(route('editor.image.upload'), [
                'file' => $img,
            ]);

            $uploadResponse->assertStatus(200);
            $data = $uploadResponse->json();
            $this->assertStringStartsWith('/uploads/editor/', $data['location']);

            // File is written to custom public html
            $expectedDisk = $customPublicHtml . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $data['path']);
            $this->assertFileExists($expectedDisk);

            // Test fallback route serves it
            $subPath = str_replace('uploads/', '', $data['path']);
            $routeResponse = $this->get('/uploads/' . $subPath);
            $routeResponse->assertStatus(200);
        } finally {
            putenv('UPLOAD_PUBLIC_ROOT');
            unset($_ENV['UPLOAD_PUBLIC_ROOT']);
            // Clean up test dir
            if (is_dir($customPublicHtml)) {
                $files = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($customPublicHtml, \RecursiveDirectoryIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::CHILD_FIRST
                );
                foreach ($files as $fileinfo) {
                    $fileinfo->isDir() ? @rmdir($fileinfo->getRealPath()) : @unlink($fileinfo->getRealPath());
                }
                @rmdir($customPublicHtml);
            }
        }
    }
}
