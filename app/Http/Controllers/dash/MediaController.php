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
        // Validation rules
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx|max:2048',
        ]);

        $file = $request->file('file');
        $size = $file->getSize() ?: 0;
        $mimeType = $file->getMimeType() ?: $file->getClientMimeType();
        $timestamp = now()->format('YmdHis') . '_' . bin2hex(random_bytes(4));
        $fileName = $timestamp . '.' . strtolower($file->getClientOriginalExtension());
        $file->move(public_path('uploads/media/'), $fileName);

        // Save the new media data
        $media = new MediaModel();
        $media->file_name = $fileName;
        $media->file_path = 'uploads/media/' . $fileName;
        $media->size = $size;
        $media->mime_type = $mimeType;
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
