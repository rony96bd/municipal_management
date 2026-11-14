<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use App\Models\media\MediaModel;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        $page_title = 'মিডিয়া লাইব্রেরী';
        $medias = MediaModel::latest()->get();
        return view('dashboard.media.media', compact('page_title', 'medias'));
    }

    public function store(Request $request)
    {
        // Validation rules (allows up to 15MB which will be optimized to lightweight print quality)
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx|max:15360',
        ]);

        $file = $request->file('file');
        $timestamp = now()->format('YmdHis') . '_' . bin2hex(random_bytes(4));
        $ext = strtolower($file->getClientOriginalExtension());
        $fileName = $timestamp . '.' . $ext;
        $destPath = public_path('uploads/media/' . $fileName);

        $optimizer = new \App\Services\ImageOptimizer();
        $optResult = $optimizer->optimizeUploadedFile($file, $destPath);

        $finalSize = file_exists($destPath) ? filesize($destPath) : ($optResult['size'] ?: 0);
        $finalMime = $optResult['mime_type'] ?: ($file->getMimeType() ?: $file->getClientMimeType());

        // Save the new media data
        $media = new MediaModel();
        $media->file_name = $fileName;
        $media->file_path = 'uploads/media/' . $fileName;
        $media->size = $finalSize;
        $media->mime_type = $finalMime;
        $media->save();

        // Redirect back with success message
        return redirect()->back()->with('success', "ফাইল আপলোড হয়েছে");
    }

    public function destroy($id)
    {
        $media = MediaModel::findOrFail($id); // Find the media by ID

        $media_name = $media->file_name; // Store file name for feedback
        $relativePath = $media->file_path;
        $media->delete(); // Delete the database entry first

        // Safely resolve and delete only if inside public/uploads/media
        $baseDir = realpath(public_path('uploads/media'));
        $filePath = realpath(public_path($relativePath));

        if ($baseDir && $filePath && str_starts_with($filePath, $baseDir . DIRECTORY_SEPARATOR) && is_file($filePath)) {
            unlink($filePath);
        }

        return redirect()->back()->with('success', "{$media_name} সফলভাবে ডিলিট হয়েছে।");
    }
}
