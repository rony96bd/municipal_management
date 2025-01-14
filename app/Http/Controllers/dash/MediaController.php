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

        $imagePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $timestamp = now()->format('YmdHis');
            $fileName = $timestamp . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->move(public_path('uploads/media/'), $fileName);
        }
        // Save the new stuff's data
        $media = new MediaModel();
        $media->file_name = $fileName;
        $media->file_path = 'uploads/media/' . $fileName;
        $media->size = isset($size) ? $size : 0;
        $media->mime_type = $file->getClientMimeType();
        $media->save();

        // Redirect back with success message
        return redirect()->back()->with('success', "ফাইল আপলোড হয়েছে");
    }

    public function destroy($id)
    {
        $media = MediaModel::findOrFail($id); // Find the media by ID

        // Get the file path
        $filePath = public_path($media->file_path);

        // Check if the file exists on the server and delete it
        if (file_exists($filePath)) {
            unlink($filePath); // Delete the file
        }

        $media_name = $media->file_name; // Store file name for feedback
        $media->delete(); // Delete the database entry

        return redirect()->back()->with('success', "{$media_name} সফলভাবে ডিলিট হয়েছে।");
    }
}
