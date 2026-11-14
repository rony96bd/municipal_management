<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use App\Services\ImageOptimizer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EditorImageController extends Controller
{
    /**
     * Handle direct image uploads and clipboard copy-paste uploads from TinyMCE editor.
     */
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|image|mimes:jpg,jpeg,png,gif,webp|max:25600',
        ]);

        $file = $request->file('file');
        $ext  = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
            $ext = 'jpg';
        }

        $subDir   = 'uploads/editor/' . date('Y/m');
        $destDir  = public_path($subDir);
        if (!is_dir($destDir)) {
            @mkdir($destDir, 0775, true);
        }

        $fileName   = 'editor_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        $targetPath = $destDir . DIRECTORY_SEPARATOR . $fileName;

        $optimizer = new ImageOptimizer();
        $result    = $optimizer->optimizeUploadedFile($file, $targetPath);
        ImageOptimizer::freeMemory();

        $relativePath = $subDir . '/' . $fileName;
        $finalSize    = file_exists($targetPath) ? filesize($targetPath) : ($result['size'] ?? 0);

        return response()->json([
            'location'  => asset($relativePath),
            'path'      => $relativePath,
            'size'      => $finalSize,
            'width'     => $result['width'] ?? null,
            'height'    => $result['height'] ?? null,
            'optimized' => !empty($result['optimized']),
        ]);
    }
}
